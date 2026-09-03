<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FacilitatorStudent;
use App\Models\Facilitator;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class FacilitatorStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $facilitatorStudents = FacilitatorStudent::with([
            'facilitator',
            'student',
        ])->get();

        return view(
            'admin.facilitator-students.index',
            compact('facilitatorStudents')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $facilitators = Facilitator::whereHas('user', function ($query) {
            $query->where('status', 1);
        })
            ->orderBy('name')
            ->get();

        $students = Student::where('status', 1)
            ->orderBy('name')
            ->get();

        return view(
            'admin.facilitator-students.create',
            compact('facilitators', 'students')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'facilitator_id' => [
                'required',
                'exists:facilitators,id',
            ],

            'student_id' => [
                'required',
                'exists:students,id',
            ],
        ]);

        // Cek apakah fasilitator sudah memiliki peserta didik
        $facilitatorExists = FacilitatorStudent::where(
            'facilitator_id',
            $request->facilitator_id
        )->exists();

        if ($facilitatorExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'facilitator_id' =>
                    'Fasilitator tersebut sudah memiliki peserta didik.'
                ]);
        }

        // Cek apakah peserta didik sudah memiliki fasilitator
        $studentExists = FacilitatorStudent::where(
            'student_id',
            $request->student_id
        )->exists();

        if ($studentExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'student_id' =>
                    'Peserta didik tersebut sudah memiliki fasilitator.'
                ]);
        }

        DB::transaction(function () use ($request) {

            FacilitatorStudent::create([
                'facilitator_id' => $request->facilitator_id,
                'student_id'     => $request->student_id,
            ]);
        });

        return redirect()
            ->route('admin.facilitator-students.index')
            ->with(
                'sukses',
                'Hubungan fasilitator dan peserta didik berhasil ditambahkan.'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $facilitator_id, string $student_id)
    {
        // Ambil hubungan yang akan diedit
        $relation = FacilitatorStudent::where('facilitator_id', $facilitator_id)
            ->where('student_id', $student_id)
            ->first();

        if (!$relation) {
            return redirect()
                ->route('admin.facilitator-students.index')
                ->with('error', 'Hubungan fasilitator dan peserta didik tidak ditemukan.');
        }

        // Fasilitator aktif
        $facilitators = Facilitator::whereHas('user', function ($query) {
            $query->where('status', 1);
        })
            ->orderBy('name')
            ->get();

        // Peserta didik aktif
        $students = Student::where('status', 1)
            ->orderBy('name')
            ->get();

        return view(
            'admin.facilitator-students.edit',
            compact(
                'relation',
                'facilitators',
                'students'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
        string $facilitator_id,
        string $student_id
    ) {
        $request->validate([
            'facilitator_id' => [
                'required',
                'exists:facilitators,id',
            ],

            'student_id' => [
                'required',
                'exists:students,id',
            ],
        ]);

        // Cari hubungan yang sedang diedit
        $relation = FacilitatorStudent::where('facilitator_id', $facilitator_id)
            ->where('student_id', $student_id)
            ->first();

        if (!$relation) {
            return redirect()
                ->route('admin.facilitator-students.index')
                ->with('error', 'Hubungan fasilitator dan peserta didik tidak ditemukan.');
        }

        // Cek apakah fasilitator baru sudah memiliki peserta didik lain
        $facilitatorExists = FacilitatorStudent::where(
            'facilitator_id',
            $request->facilitator_id
        )
            ->where(function ($query) use ($relation) {
                $query->where('student_id', '!=', $relation->student_id);
            })
            ->exists();

        if ($facilitatorExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'facilitator_id' =>
                    'Fasilitator tersebut sudah memiliki peserta didik.'
                ]);
        }

        // Cek apakah peserta didik baru sudah memiliki fasilitator lain
        $studentExists = FacilitatorStudent::where(
            'student_id',
            $request->student_id
        )
            ->where(function ($query) use ($relation) {
                $query->where('facilitator_id', '!=', $relation->facilitator_id);
            })
            ->exists();

        if ($studentExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'student_id' =>
                    'Peserta didik tersebut sudah memiliki fasilitator.'
                ]);
        }

        DB::transaction(function () use ($relation, $request) {
            $relation->update([
                'facilitator_id' => $request->facilitator_id,
                'student_id'     => $request->student_id,
            ]);
        });

        return redirect()
            ->route('admin.facilitator-students.index')
            ->with(
                'success',
                'Hubungan fasilitator dan peserta didik berhasil diperbarui.'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $facilitator_id, string $student_id)
    {
        $deleted = DB::table('facilitator_student')
            ->where('facilitator_id', $facilitator_id)
            ->where('student_id', $student_id)
            ->delete();

        if (!$deleted) {
            return back()
                ->with('error', 'Hubungan fasilitator dan peserta didik tidak ditemukan.');
        }

        return redirect()
            ->route('admin.facilitator-students.index')
            ->with('success', 'Hubungan fasilitator dan peserta didik berhasil dihapus.');
    }
}
