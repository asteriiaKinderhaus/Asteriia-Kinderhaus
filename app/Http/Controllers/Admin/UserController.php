<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Helpers\GenerateId;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['role', 'admin', 'facilitator', 'parentData'])
            ->orderBy('id')
            ->get();
        //dd(request()->all());

        return view('admin.user.index', compact('users'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::orderBy('nama')->get();

        return view('admin.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(UserRequest $request)
    {


        User::create([
            'id'       => GenerateId::make(User::class, 'USR'),
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id'  => $request->role_id,
            'status'   => $request->status,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
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
    public function edit(string $id)
    {
        $user = User::with(['role', 'admin', 'facilitator', 'parentData'])
            ->findOrFail($id);

        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|unique:users,username,' . $user->id,
            'status'   => 'required|boolean',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->username = $request->username;
        $user->status   = $request->status;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Cegah admin menonaktifkan akunnya sendiri
        if ($user->id === Auth::id() && $request->status == 0) {
            return back()
                ->withInput()
                ->withErrors([
                    'status' => 'Anda tidak dapat menonaktifkan akun Administrator.'
                ]);
        }

        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Data user berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
