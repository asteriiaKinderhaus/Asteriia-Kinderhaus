<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Gender;
use App\Models\ParentModel;
use App\Http\Requests\Admin\StudentRequest;
use App\Helpers\GenerateId;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with([
            'gender',
            'parent'
        ])
            ->orderBy('name')
            ->get();

        return view('admin.student.index', compact('students'));
    }

    public function create()
    {
        $genders = Gender::orderBy('gender')->get();
        //$classes = SchoolClass::orderBy('name')->get();
        $parents = ParentModel::orderBy('name')->get();

        return view('admin.student.create', compact(
            'genders',
            //'classes',
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
                'class_id'    => /*$request->class_id*/ 'CLS000003',
                'parent_id'   => $request->parent_id,
                'status'      => /*$request->status*/ 1,

            ]);
        });

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Student successfully added.');
    }

    public function edit(string $id)
    {
        $student = Student::findOrFail($id);
        $parents = ParentModel::orderBy('id')->get();
        $genders = Gender::orderBy('gender')->get();

        return view('admin.student.edit', compact('student', 'parents', 'genders'));
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

    public function update(StudentRequest $request, string $id)
    {
        $student = Student::findOrFail($id);
        $student->update([
            'name'        => $request->name,
            'nickname'    => $request->nickname,
            'birth_place' => $request->birth_place,
            'birth_date'  => $request->birth_date,
            'gender_id'   => $request->gender_id,
            'parent_id'   => $request->parent_id,
            //'status'      => $request->status,
        ]);

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Data peserta didik berhasil diperbarui.');
    }
}
