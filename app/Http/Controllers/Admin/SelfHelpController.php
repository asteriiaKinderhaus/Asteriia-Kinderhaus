<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SelfHelp;
use App\Helpers\GenerateId;

class SelfHelpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $selfhelp = SelfHelp::orderBy('id', 'asc')->get();
        return view('admin.selfhelp.index', compact('selfhelp'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.selfhelp.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'status' => 'required|boolean',
        ]);

        SelfHelp::create([
            'id' => GenerateId::make(SelfHelp::class, 'SH'),
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.selfhelp.index')
            ->with('success', 'Self-help item berhasil ditambahkan.');
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
    public function edit(SelfHelp $selfhelp)
    {
        return view('admin.selfhelp.edit', compact('selfhelp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SelfHelp $selfhelp)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $selfhelp->update($validated);

        return redirect()
            ->route('admin.selfhelp.index')
            ->with('success', 'Data self-help berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
