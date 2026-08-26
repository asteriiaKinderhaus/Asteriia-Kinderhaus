<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gender;
use Illuminate\Support\Facades\DB;
use App\Models\Facilitator;
use App\Helpers\GenerateId;
use App\Http\Requests\Admin\FacilitatorRequest;
use App\Services\AccountService;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountCreatedMail;

class FacilitatorController extends Controller
{
    protected AccountService $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountservice = $accountService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $facilitators = Facilitator::with([
            'user',
            'gender',
        ])
            ->orderBy('name')
            ->get();
        return view(
            'admin.facilitator.index',
            compact('facilitators')
        );
    }

    /**
     * Show the form for creating a new resource.
     */


    public function create()
    {
        $genders = Gender::orderBy('gender')->get();

        return view(
            'admin.facilitator.create',
            compact(
                'genders'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FacilitatorRequest $request)
    {

    $id = GenerateId::make(Facilitator::class, 'FAS');
        $account = DB::transaction(function () use ($request) {

            $account = $this->accountservice->createUser(
                $request->name,
                'FAS'
            );

            $user = $account['user'];
            $facilitator = Facilitator::create([
                'id'         => GenerateId::make(Facilitator::class, 'FAS'),
                'name'       => $request->name,
                'birth_date' => $request->birth_date,
                'address'    => $request->address,
                'email'      => $request->email,
                'telephone'  => $request->telephone,
                'gender_id'  => $request->gender_id,
                'user_id'    => $user->id,
            ]);

            return [
                'user'        => $user,
                'facilitator' => $facilitator,
                'username'    => $account['username'],
                'password'    => $account['password'],
            ];
        });

        Mail::to($account['facilitator']->email)->send(
            new AccountCreatedMail(
                $account['facilitator']->name,
                $account['username'],
                $account['password'],
                'Fasilitator'
            )
        );

        return redirect()
            ->route('admin.facilitators.index')
            ->with(
                'success',
                'Fasilitator berhasil ditambahkan dan informasi akun telah dikirim melalui email.'
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
    public function edit(string $id)
    {
        $facilitator = Facilitator::findOrFail($id);
        $genders = Gender::orderBy('gender')->get();

        return view('admin.facilitator.edit', compact('facilitator', 'genders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FacilitatorRequest $request, string $id)
    {

        $facilitator = Facilitator::findOrFail($id);
        DB::transaction(function () use ($request, $facilitator) {

            $facilitator->update([
                'name'       => $request->name,
                'birth_date' => $request->birth_date,
                'gender_id'  => $request->gender_id,
                'telephone'  => $request->telephone,
                'email'      => $request->email,
                'address'    => $request->address,
            ]);
        });

        return redirect()
            ->route('admin.facilitators.index')
            ->with('success', 'Data fasilitator berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
