<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\GenerateId;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ParentRequest;
use App\Models\Gender;
use App\Models\ParentModel;
use App\Services\AccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountCreatedMail;

class ParentController extends Controller
{
    protected AccountService $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parents = ParentModel::with([
            'user',
            'gender'
        ])
            ->orderBy('name')
            ->get();

        return view('admin.parent.index', compact('parents'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $genders = Gender::orderBy('gender')->get();

        return view('admin.parent.create', compact('genders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ParentRequest $request)
    {

        //dd($request->all());
        $account = DB::transaction(function () use ($request) {
            $account = $this->accountservice->createUser(
                $request->name,
                'PAR'
            );

            $user = $account['user'];

            // Simpan Parent
            $parent =  ParentModel::create([
                'id'         => GenerateId::make(ParentModel::class, 'PAR'),
                'name'       => $request->name,
                'address'    => $request->address,
                'telephone'  => $request->telephone,
                'email'      => $request->email,
                'gender_id'  => $request->gender_id,
                'user_id'    => $user->id,
            ]);

            return [
                'user'        => $user,
                'parent'      => $parent,
                'username'    => $account['username'],
                'password'    => $account['password'],
            ];
        });

        Mail::to($account['parent']->email)->send(
            new AccountCreatedMail(
                $account['parent']->name,
                $account['username'],
                $account['password'],
                'Parent'
            )
        );

        return redirect()
            ->route('admin.parents.index')
            ->with(
                'success',
                'Orang tua berhasil ditambahkan dan informasi akun telah dikirim melalui email.'
            );
    }

    /* |--------------------------------------------------------------------------
    |    Search |-------------------------------------------------------------------------- |
    | Digunakan oleh AJAX autocomplete pada form pendaftaran peserta didik. | */
    public function search(Request $request)
    {
        $keyword = trim($request->input('q', ''));
        /* * Jangan melakukan pencarian jika karakter kurang dari 2. */
        if (strlen($keyword) < 2) {
            return response()->json([]);
        }
        $parents = ParentModel::query()->where('name', 'like', '%' . $keyword . '%')
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name', 'address', 'telephone', 'email', 'gender_id',]);
        return response()->json($parents);
    }

    /**
     * Display the specified resource.
     */
    public function show(ParentModel $parent)
    {
        return view('admin.parent.show', compact('parent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ParentModel $parent)
    {
        $genders = Gender::orderBy('gender')->get();

        return view('admin.parent.edit', compact(
            'parent',
            'genders'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ParentRequest $request, string $id)
    {
        // dd($request->all());
        $parent = ParentModel::findOrFail($id);
        DB::transaction(function () use ($request, $parent) {

            $parent->update([
                'name'       => $request->name,
                'gender_id'  => $request->gender_id,
                'telephone'  => $request->telephone,
                'email'      => $request->email,
                'address'    => $request->address,
            ]);
        });

        return redirect()
            ->route('admin.parents.index')
            ->with('success', 'Data Orang tua berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ParentModel $parent)
    {
        //
    }
}
