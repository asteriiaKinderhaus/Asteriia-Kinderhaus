<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\Facilitator;
//use App\Http\Controllers\Admin\Faci

class SchoolClassController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::with('facilitators')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.school-classes.index', compact('classes'));
    }

    public function create()
    {
        return view('admin.school-class.create');
    }

    public function store(SchoolClassRequest $request)
    {
        SchoolClass::create([

            'id' => GenerateId::make(
                SchoolClass::class,
                'CLS'
            ),

            'name' => $request->name,

            'capacity' => $request->capacity,

            'status' => $request->status,

        ]);

        return redirect()
            ->route('admin.school-classes.index')
            ->with(
                'success',
                'School class successfully added.'
            );
    }

    public function edit(SchoolClass $schoolClass)
    {
        $schoolClass->load('facilitators');

        $facilitators = Facilitator::orderBy('name')->get();

        return view('admin.school-classes.edit', compact(
            'schoolClass',
            'facilitators'
        ));
    }

    public function update(Request $request, SchoolClass $schoolClass)
    {
        $request->validate([
            'name' => 'required|max:100',
            'capacity' => 'required|integer|min:1',
        ]);

        $schoolClass->update([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'status' => $request->status,
        ]);

        $schoolClass->facilitators()->sync(
            $request->facilitator_ids ?? []
        );

        return redirect()
            ->route('admin.school-classes.index')
            ->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(SchoolClass $schoolClass)
    {
        $schoolClass->delete();

        return redirect()
            ->route('admin.school-classes.index')
            ->with(
                'success',
                'School class deleted.'
            );
    }
}
