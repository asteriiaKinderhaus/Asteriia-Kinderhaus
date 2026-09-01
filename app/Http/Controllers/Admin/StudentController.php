<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Gender;
use App\Models\ParentModel;
use App\Models\SchoolClass;
use App\Http\Requests\Admin\StudentRequest;
use App\Helpers\GenerateId;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with([
            'gender',
            'parent',
            'schoolClass'
        ])
            ->orderBy('name')
            ->get();

        return view('admin.student.index', compact('students'));
    }

    public function create()
    {
        $genders = Gender::orderBy('gender')->get();
        $classes = SchoolClass::orderBy('name')->get();
        $parents = ParentModel::orderBy('name')->get();

        return view('admin.student.create', compact(
            'genders',
            'classes',
            'parents'
        ));
    }

    public function store(StudentRequest $request)
    {
        DB::transaction(function () use ($request) {
            $id = GenerateId::make(Student::class, 'STU');

            Student::create([
                'id'          => $id,
                'nis'         => $id,
                'name'        => $request->name,
                'nickname'    => $request->nickname,
                'birth_place' => $request->birth_place,
                'birth_date'  => $request->birth_date,
                'gender_id'   => $request->gender_id,
                'class_id'    => $request->class_id,
                'parent_id'   => $request->parent_id,
                'status'      => $request->status,

            ]);
        });

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Student successfully added.');
    }

    public function edit(string $id)
    {
        $student = Student::findOrFail($id);
        $parent = ParentModel::orderBy('id')->get();
        $genders = Gender::orderBy('gender')->get();

        return view('admin.student.edit', compact('student', 'parent', 'genders'));
    }

    // Function to toggle student status
    public function toggleStatus(string $id)
    {
        $student = Student::findOrFail($id);
        $student->update([
            'status' => !$student->status,
        ]);

        return redirect()
            ->route('admin.students.index')
            ->with(
                'success',
                $student->status
                    ? 'Siswa berhasil diaktifkan.'
                    : 'Siswa berhasil dinonaktifkan.'
            );
    }
}
