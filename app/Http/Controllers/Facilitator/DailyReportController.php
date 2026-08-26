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
        $facilitator = Facilitator::with([
            'schoolClasses.students'
        ])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $class = $facilitator->schoolClasses->first();

        if (!$class) {
            return redirect()
                ->route('facilitator.daily-reports.index')
                ->with('error', 'Anda belum memiliki kelas.');
        }

        $students = $class->students()
            ->orderBy('name')
            ->get();

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
                'class',
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
            'additional_note' => 'nullable|string|max:1000',
            'stimulations' => 'nullable|array',
            'stimulations.*' => 'exists:stimulation_items,id',
        ]);

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
        //dd($request->all());
        DB::transaction(function () use ($request) {

            // Simpan Daily Report
            $dailyReport = DailyReport::create([
                'id'             => GenerateDailyReportId::dailyReportID(),
                'report_date'    => $request->report_date,
                'student_id'     => $request->student_id,
                'facilitator_id' => $request->facilitator_id,
                'additional_note' => $request->additional_note,
                'status'         => 0,
            ]);

            // Simpan meal
            foreach ($request->meal as $mealId => $meal) {
                if (empty($meal['food_status']) && empty($meal['assistance'])) {
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

            foreach ($request->self_help as $selfHelpId => $selfHelp) {
                if (empty($selfHelp['assistance'])) {
                    continue;
                }
                DailyReportSelfHelp::create([
                    'id'              => GenerateSelfHelpReportID::selfHelpReport(),
                    'daily_report_id' => $dailyReport->id,
                    'self_help_id'    => $selfHelpId,
                    'assistance'      => $selfHelp['assistance']
                ]);
            }

            if ($request->filled('stimulations')) {

                foreach ($request->stimulations as $itemId) {

                    DailyReportStimulation::create([
                        'id'                    => Generate_ID::generateReportStimulationID(),
                        'daily_report_id'       => $dailyReport->id,
                        'stimulation_item_id'   => $itemId,
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

        return view(
            'facilitator.daily_reports.show',
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

        /* dd(
            $dailyReport->id,
            $dailyReport->status
        );*/

        return view('facilitator.daily-report.edit', compact(
            'dailyReport'
        ));

        // Laporan yang sudah final tidak boleh diedit
        /* if ($dailyReport->status !== 'draft') {
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
            'facilitator.daily-reports.edit',
            compact(
                'dailyReport',
                'students',
                'meals',
                'selfHelps',
                'stimulationCategories'
            )
        );*/
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        FacilitatorDailyReportRequest $request,
        string $id
    ) {
        $facilitator = Facilitator::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        $dailyReport = DailyReport::where(
            'facilitator_id',
            $facilitator->id
        )->findOrFail($id);

        if ($dailyReport->status !== 'draft') {
            return redirect()
                ->route('facilitator.daily-reports.index')
                ->with('error', 'Laporan yang sudah final tidak dapat diedit.');
        }

        DB::transaction(function () use (
            $request,
            $dailyReport
        ) {

            $dailyReport->update([
                'report_date' => $request->report_date,
                'student_id'  => $request->student_id,
            ]);

            /*
         * Detail laporan akan kita update
         * pada tahap berikutnya.
         */
        });

        return redirect()
            ->route('facilitator.daily-reports.index')
            ->with(
                'success',
                'Laporan harian berhasil diperbarui.'
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
