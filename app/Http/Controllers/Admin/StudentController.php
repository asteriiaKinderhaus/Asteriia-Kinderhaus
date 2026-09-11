<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Gender;
use App\Models\ParentModel;
use App\Http\Requests\Admin\StudentRequest;
use App\Http\Requests\Admin\StudentRegistrationRequest;
use App\Helpers\GenerateId;
use App\Services\AccountService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountCreatedMail;

class StudentController extends Controller
{
    protected AccountService $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    /*
    |--------------------------------------------------------------------------
    | Index
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $students = Student::with([
            'gender',
            'parent'
        ])
            ->orderBy('name')
            ->get();

        return view(
            'admin.student.index',
            compact('students')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $genders = Gender::orderBy('gender')->get();

        return view(
            'admin.student.create',
            compact('genders')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store(StudentRegistrationRequest $request)
    {
        $registration = DB::transaction(function () use ($request) {

            /*
             * Jika parent_id diisi,
             * gunakan data orang tua yang sudah ada.
             */
            if ($request->filled('parent_id')) {

                $parent = ParentModel::findOrFail(
                    $request->parent_id
                );

                $account = null;
            } else {

                /*
                 * Jika parent_id kosong,
                 * buat akun dan data orang tua baru.
                 */
                $account = $this->accountService->createUser(
                    $request->parent_name,
                    'PAR'
                );

                $user = $account['user'];

                $parent = ParentModel::create([
                    'id' => GenerateId::make(
                        ParentModel::class,
                        'PAR'
                    ),

                    'name' => $request->parent_name,

                    'address' => $request->parent_address,

                    'telephone' => $request->parent_telephone,

                    'email' => $request->parent_email,

                    'gender_id' => $request->parent_gender_id,

                    'user_id' => $user->id,
                ]);
            }

            /*
             * Buat ID peserta didik.
             */
            $studentId = GenerateId::make(
                Student::class,
                'STU'
            );

            /*
             * Buat peserta didik.
             */
            $student = Student::create([
                'id' => $studentId,

                'nis' => $studentId,

                'name' => $request->student_name,

                'nickname' => $request->student_nickname,

                'birth_place' => $request->student_birth_place,

                'birth_date' => $request->student_birth_date,

                'gender_id' => $request->student_gender_id,

                'class_id' => 'CLS000003',

                'parent_id' => $parent->id,

                'status' => 1,
            ]);

            return [
                'student' => $student,

                'parent' => $parent,

                'account' => $account,
            ];
        });

        /*
         * Kirim informasi akun hanya jika
         * orang tua tersebut merupakan orang tua baru.
         */
        if (
            !empty($registration['account'])
            && !empty($registration['parent']->email)
        ) {

            Mail::to(
                $registration['parent']->email
            )->send(
                new AccountCreatedMail(
                    $registration['parent']->name,

                    $registration['account']['username'],

                    $registration['account']['password'],

                    'Parent'
                )
            );
        }

        return redirect()
            ->route('admin.students.index')
            ->with(
                'success',
                'Peserta didik berhasil didaftarkan.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit(string $id)
    {
        $student = Student::findOrFail($id);

        $parents = ParentModel::orderBy('name')->get();

        $genders = Gender::orderBy('gender')->get();

        return view(
            'admin.student.edit',
            compact(
                'student',
                'parents',
                'genders'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Toggle Status
    |--------------------------------------------------------------------------
    */

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

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(
        StudentRequest $request,
        string $id
    ) {
        $student = Student::findOrFail($id);

        $student->update([
            'name' => $request->name,

            'nickname' => $request->nickname,

            'birth_place' => $request->birth_place,

            'birth_date' => $request->birth_date,

            'gender_id' => $request->gender_id,

            'parent_id' => $request->parent_id,
        ]);

        return redirect()
            ->route('admin.students.index')
            ->with(
                'success',
                'Data peserta didik berhasil diperbarui.'
            );
    }
}
