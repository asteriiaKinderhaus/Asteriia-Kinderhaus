<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ParentModel;
use App\Models\DailyReport;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $parent = ParentModel::with('students')
            ->where('user_id', $user->id)
            ->first();
        $reports = DailyReport::with([
            'student'
        ])
            ->whereIn(
                'student_id',
                $parent->students->pluck('id')
            )
            ->latest('report_date')
            ->paginate(10);

        return view(
            'parent.dashboard',
            compact('parent', 'reports')
        );
    }
}
