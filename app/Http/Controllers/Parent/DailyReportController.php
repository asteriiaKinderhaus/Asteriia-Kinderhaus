<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyReport;
use App\Models\ParentModel;
use Illuminate\Support\Facades\Auth;
use App\Models\StimulationCategory;

class DailyReportController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();

        $parent = ParentModel::with('students')
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Ambil ID anak yang terhubung dengan akun orang tua
        $studentIds = $parent->students->pluck('id');

        // Query dasar: laporan hanya untuk anak milik orang tua ini
        $query = DailyReport::with([
            'student',
            'facilitator',
        ])->whereIn('student_id', $studentIds);

        // Filter berdasarkan anak
        if ($request->filled('student_id')) {
            $request->validate([
                'student_id' => 'required|string',
            ]);

            // Pastikan anak yang dipilih memang milik orang tua ini
            abort_unless(
                $studentIds->contains($request->student_id),
                403,
                'Anda tidak memiliki akses ke laporan anak ini.'
            );

            $query->where('student_id', $request->student_id);
        }

        // Filter berdasarkan bulan
        if ($request->filled('month')) {
            $validated = $request->validate([
                'month' => ['required', 'date_format:Y-m'],
            ]);

            $month = $validated['month'];

            $startDate = \Carbon\Carbon::createFromFormat(
                '!Y-m',
                $month
            )->startOfMonth();

            $endDate = $startDate->copy()->endOfMonth();

            $query->whereBetween('report_date', [
                $startDate->toDateString(),
                $endDate->toDateString(),
            ]);
        }

        // Urutkan dan paginasi sambil mempertahankan filter
        $reports = $query
            ->orderByDesc('report_date')
            ->paginate(10)
            ->withQueryString();

        return view(
            'parent.daily_reports.index',
            compact('parent', 'reports')
        );
    }


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
            'parent.daily_reports.show',
            compact(
                'dailyReport',
                'stimulationCategories'
            )
        );
    }
}
