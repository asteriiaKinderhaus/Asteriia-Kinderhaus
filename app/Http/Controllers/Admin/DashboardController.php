<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Facilitator;
use App\Models\ParentModel;   // atau Parent jika model Anda bernama Parent
use App\Models\SchoolClass;

class DashboardController extends Controller
{
    public function index()
    {
        $studentCount      = Student::count();
        $facilitatorCount  = Facilitator::count();
        $parentCount       = ParentModel::count();   // sesuaikan nama model
        $classCount        = SchoolClass::count();

        return view('admin.dashboard', compact(
            'studentCount',
            'facilitatorCount',
            'parentCount',
            'classCount'
        ));
    }
}
