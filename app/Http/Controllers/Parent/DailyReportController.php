<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\DailyReport;
use App\Models\ParentModel;
use Illuminate\Support\Facades\Auth;
use App\Models\StimulationCategory;

class DailyReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $parent = ParentModel::with('students')
            ->where('user_id', $user->id)
            ->first();

        $reports = DailyReport::with([
            'student',
            'facilitator'
        ])
            ->whereIn(
                'student_id',
                $parent->students->pluck('id')
            )
            ->latest()
            ->paginate(10);

        return view(
            'parent.daily_reports.index',
            compact(
                'parent',
                'reports'
            )
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
