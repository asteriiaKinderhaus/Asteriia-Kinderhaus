<?php

namespace App\Http\Controllers\Facilitator;

use App\Helpers\Generate_ID;
use App\Helpers\GenerateDailyReportId;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Facilitator;
use Illuminate\Support\Facades\Auth;
use App\Models\Meal;
use Illuminate\Support\Facades\DB;
use App\Models\DailyReport;
use App\Models\DailyReportMeal;
use App\Helpers\GenerateMealReportID;
use App\Models\SelfHelp;
use App\Helpers\GenerateSelfHelpReportID;
use App\Models\DailyReportSelfHelp;
use App\Models\StimulationCategory;
use App\Models\DailyReportStimulation;
use App\Models\Student;

class DailyReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $facilitator = Facilitator::where('user_id', Auth::id())
            ->firstOrFail();

        $reports = DailyReport::with('student')
            ->where('facilitator_id', $facilitator->id)
            ->orderByDesc('report_date')
            ->get();

        return view(
            'facilitator.daily-report.index',
            compact('reports')
        );
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $facilitator = Facilitator::where('user_id', Auth::id())
            ->firstOrFail();

        // Peserta didik yang saat ini aktif menjadi tanggung jawab fasilitator
        $students = $facilitator->facilitatorStudents()
            ->whereNull('end_date')
            ->with('student')
            ->get()
            ->sortBy(fn($relation) => $relation->student?->name);

        // Jika tidak ada peserta didik yang terhubung
        if ($students->isEmpty()) {
            return redirect()
                ->route('facilitator.daily-reports.index')
                ->with('error', 'Anda belum memiliki peserta didik yang ditugaskan.');
        }

        $meals = Meal::where('status', 1)
            ->orderBy('order_no')
            ->get();

        $selfHelps = SelfHelp::where('status', 1)
            ->orderBy('order_no')
            ->get();

        $stimulationCategories = StimulationCategory::with('items')
            ->orderBy('name')
            ->get();

        return view(
            'facilitator.daily-report.create',
            compact(
                'facilitator',
                'students',
                'meals',
                'selfHelps',
                'stimulationCategories'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'report_date' => 'required|date',
            'student_id' => 'required|exists:students,id',
            'additional_note' => 'nullable|string|max:1000',
            'stimulations' => 'nullable|array',
            'stimulations.*' => 'exists:stimulation_items,id',
        ]);

        /*
    |--------------------------------------------------------------------------
    | Ambil fasilitator berdasarkan user yang sedang login
    |--------------------------------------------------------------------------
    */
        $facilitator = Facilitator::where('user_id', Auth::id())
            ->firstOrFail();

        /*
    |--------------------------------------------------------------------------
    | Pastikan peserta didik memang ditugaskan kepada fasilitator
    | pada tanggal laporan
    |--------------------------------------------------------------------------
    */
        $assignmentExists = $facilitator->facilitatorStudents()
            ->where('student_id', $request->student_id)
            ->whereDate('start_date', '<=', $request->report_date)
            ->where(function ($query) use ($request) {
                $query->whereNull('end_date')
                    ->orWhereDate('end_date', '>=', $request->report_date);
            })
            ->exists();

        if (!$assignmentExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'student_id' => 'Peserta didik tersebut tidak ditugaskan kepada Anda pada tanggal laporan.'
                ]);
        }

        /*
    |--------------------------------------------------------------------------
    | Cegah laporan ganda untuk anak pada tanggal yang sama
    |--------------------------------------------------------------------------
    */
        $exists = DailyReport::where('student_id', $request->student_id)
            ->whereDate('report_date', $request->report_date)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'student_id' => 'Laporan harian untuk anak ini pada tanggal tersebut sudah ada.'
                ]);
        }

        /*
    |--------------------------------------------------------------------------
    | Simpan laporan
    |--------------------------------------------------------------------------
    */
        DB::transaction(function () use ($request, $facilitator) {

            // Simpan Daily Report
            $dailyReport = DailyReport::create([
                'id'              => GenerateDailyReportId::dailyReportID(),
                'report_date'     => $request->report_date,
                'student_id'      => $request->student_id,
                'facilitator_id'  => $facilitator->id,
                'additional_note' => $request->additional_note,
                'status'          => 0,
            ]);

            // Simpan meal
            foreach ($request->meal ?? [] as $mealId => $meal) {

                if (
                    empty($meal['food_status']) &&
                    empty($meal['assistance'])
                ) {
                    continue;
                }

                DailyReportMeal::create([
                    'id'              => GenerateMealReportID::mealReport(),
                    'daily_report_id' => $dailyReport->id,
                    'meal_id'         => $mealId,
                    'food_status'     => $meal['food_status'] ?? null,
                    'assistance'      => $meal['assistance'] ?? null,
                ]);
            }

            // Simpan self help
            foreach ($request->self_help ?? [] as $selfHelpId => $selfHelp) {

                if (empty($selfHelp['assistance'])) {
                    continue;
                }

                DailyReportSelfHelp::create([
                    'id'              => GenerateSelfHelpReportID::selfHelpReport(),
                    'daily_report_id' => $dailyReport->id,
                    'self_help_id'    => $selfHelpId,
                    'assistance'      => $selfHelp['assistance'],
                ]);
            }

            // Simpan stimulation
            if ($request->filled('stimulations')) {

                foreach ($request->stimulations as $itemId) {

                    DailyReportStimulation::create([
                        'id'                  => Generate_ID::generateReportStimulationID(),
                        'daily_report_id'     => $dailyReport->id,
                        'stimulation_item_id' => $itemId,
                    ]);
                }
            }
        });

        return redirect()
            ->route('facilitator.daily-reports.index')
            ->with('success', 'Laporan berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DailyReport $dailyReport)
    {
        $dailyReport->load([
            'student',
            'facilitator',
            'meals.meal',
            'selfHelps.selfHelp',
            'stimulations.stimulationItem.category'
        ]);

        $stimulationCategories = StimulationCategory::with('items')
            ->orderBy('name')
            ->get();

        //dd($stimulationCategories);
        return view(
            'facilitator.daily-report.show',
            compact(
                'dailyReport',
                'stimulationCategories'
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $facilitator = Facilitator::where(
            'user_id',
            Auth::id(),
        )->firstOrFail();

        $dailyReport = DailyReport::with([
            'student',
            'student.schoolClass',
            'meals',
            'selfHelps',
            'stimulations',
        ])
            ->where('facilitator_id', $facilitator->id)
            ->findOrFail($id);

        // Laporan yang sudah final tidak boleh diedit
        if ($dailyReport->status) {
            return redirect()
                ->route('facilitator.daily-reports.index')
                ->with('error', 'Laporan yang sudah final tidak dapat diedit.');
        }

        $students = Student::where('status', 1)
            ->orderBy('name')
            ->get();

        $meals = Meal::orderBy('name')->get();

        $selfHelps = SelfHelp::orderBy('name')->get();

        $stimulationCategories = StimulationCategory::with('items')
            ->orderBy('name')
            ->get();

        return view(
            'facilitator.daily-report.edit',
            compact(
                'dailyReport',
                'students',
                'meals',
                'selfHelps',
                'stimulationCategories'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $facilitator = Facilitator::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        $dailyReport = DailyReport::with([
            'meals',
            'selfHelps',
            'stimulations',
        ])
            ->where('facilitator_id', $facilitator->id)
            ->findOrFail($id);

        // Laporan yang sudah final tidak boleh diedit
        if ($dailyReport->status) {
            return redirect()
                ->route('facilitator.daily-reports.index')
                ->with(
                    'error',
                    'Laporan yang sudah final tidak dapat diedit.'
                );
        }

        $request->validate([
            'additional_note' => 'nullable|string|max:1000',

            'meal' => 'nullable|array',

            'meal.*.food_status' => [
                'nullable',
                'in:HABIS,SISA_SEDIKIT,TIDAK_HABIS',
            ],

            'meal.*.assistance' => [
                'nullable',
                'in:MANDIRI,BANTUAN',
            ],

            'self_help' => 'nullable|array',

            'self_help.*.assistance' => [
                'nullable',
                'in:MANDIRI,BANTUAN',
            ],

            'stimulations' => 'nullable|array',

            'stimulations.*' => [
                'exists:stimulation_items,id',
            ],
        ]);

        DB::transaction(function () use ($request, $dailyReport) {

            /*
        |--------------------------------------------------------------------------
        | UPDATE DAILY REPORT
        |--------------------------------------------------------------------------
        */

            $dailyReport->update([
                'additional_note' => $request->additional_note,
            ]);


            /*
        |--------------------------------------------------------------------------
        | UPDATE MEALS
        |--------------------------------------------------------------------------
        */

            foreach ($request->meals ?? [] as $mealId => $meal) {

                $reportMeal = DailyReportMeal::where(
                    'daily_report_id',
                    $dailyReport->id
                )
                    ->where(
                        'meal_id',
                        $mealId
                    )
                    ->first();

                if (!$reportMeal) {
                    continue;
                }

                $reportMeal->update([
                    'food_status' => $meal['food_status'] ?? null,
                    'assistance'  => $meal['assistance'] ?? null,
                ]);
            }


            /*
        |--------------------------------------------------------------------------
        | UPDATE SELF HELP
        |--------------------------------------------------------------------------
        */

            foreach ($request->self_help ?? [] as $selfHelpId => $selfHelp) {

                $reportSelfHelp = DailyReportSelfHelp::where(
                    'daily_report_id',
                    $dailyReport->id
                )
                    ->where(
                        'self_help_id',
                        $selfHelpId
                    )
                    ->first();

                if (!$reportSelfHelp) {
                    continue;
                }

                $reportSelfHelp->update([
                    'assistance' => $selfHelp['assistance'] ?? null,
                ]);
            }


            /*
        |--------------------------------------------------------------------------
        | UPDATE STIMULATIONS
        |--------------------------------------------------------------------------
        */

            $selectedStimulations = $request->stimulations ?? [];

            /*
        |--------------------------------------------------------------------------
        | Ambil data stimulasi yang sudah ada dari DATABASE
        |--------------------------------------------------------------------------
        */

            $existingStimulations = DailyReportStimulation::where(
                'daily_report_id',
                $dailyReport->id
            )->get();


            /*
        |--------------------------------------------------------------------------
        | Hapus stimulasi yang sudah tidak dipilih
        |--------------------------------------------------------------------------
        */

            foreach ($existingStimulations as $existing) {

                if (!in_array(
                    $existing->stimulation_item_id,
                    $selectedStimulations
                )) {
                    $existing->delete();
                }
            }


            /*
        |--------------------------------------------------------------------------
        | Tambahkan stimulasi yang benar-benar baru
        |--------------------------------------------------------------------------
        */

            foreach ($selectedStimulations as $itemId) {

                $exists = DailyReportStimulation::where(
                    'daily_report_id',
                    $dailyReport->id
                )
                    ->where(
                        'stimulation_item_id',
                        $itemId
                    )
                    ->exists();

                if (!$exists) {

                    DailyReportStimulation::create([
                        'id' => Generate_ID::generateReportStimulationID(),

                        'daily_report_id' => $dailyReport->id,

                        'stimulation_item_id' => $itemId,
                    ]);
                }
            }
        });

        return redirect()
            ->route('facilitator.daily-reports.index')
            ->with(
                'success',
                'Laporan berhasil diperbarui.'
            );
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
