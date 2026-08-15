<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StimulationItem;
use App\Models\StimulationCategory;

class StimulationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stimulations = StimulationItem::with('category')
            ->orderBy('category_id')
            ->orderBy('name')
            ->get();

        return view('admin.stimulation.index', compact('stimulations'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $categories = StimulationCategory::orderBy('name')->get();

        return view(
            'admin.stimulation.create',
            compact('categories')
        );
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:stimulation_categories,id',
            'name' => 'required|max:100',
        ]);

        $last = StimulationItem::orderByDesc('id')->first();

        if ($last) {
            $number = (int) substr($last->id, 2) + 1;
        } else {
            $number = 1;
        }

        $id = 'SM' . str_pad($number, 3, '0', STR_PAD_LEFT);

        StimulationItem::create([
            'id' => $id,
            'category_id' => $request->category_id,
            'name' => $request->name,
        ]);

        return redirect()
            ->route('admin.stimulation.index')
            ->with('success', 'Stimulasi berhasil ditambahkan.');
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
    public function edit(StimulationItem $stimulation)
    {
        $categories = StimulationCategory::orderBy('name')->get();

        return view(
            'admin.stimulation.edit',
            compact('stimulation', 'categories')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StimulationItem $stimulation)
    {
        $request->validate([
            'category_id' => 'required|exists:stimulation_categories,id',
            'name' => 'required|max:100',
        ]);

        $stimulation->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
        ]);

        return redirect()
            ->route('admin.stimulation.index')
            ->with('success', 'Data stimulasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
