<?php

namespace App\Http\Controllers\Facilitator;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Facilitator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


class AttendanceController extends Controller
{
    /**
     * Menampilkan halaman absensi.
     */
    public function index(Request $request)
    {
        $date = $request->input(
            'date',
            now()->toDateString()
        );

        $request->validate([
            'date' => ['nullable', 'date', 'before_or_equal:today'],
        ]);

        $facilitator = Facilitator::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        // Mengambil peserta didik yang masih aktif
        // dalam penugasan fasilitator.
        $assignments = $facilitator
            ->facilitatorStudents()
            ->whereDate('start_date', '<=', $date)
            ->where(function ($query) use ($date) {
                $query->whereNull('end_date')
                    ->orWhereDate('end_date', '>=', $date);
            })
            ->with('student')
            ->get();

        $students = $assignments
            ->pluck('student')
            ->filter()
            ->sortBy('name')
            ->values();

        // Mengambil data absensi berdasarkan tanggal.
        $attendances = Attendance::whereIn(
            'student_id',
            $students->pluck('id')
        )
            ->whereDate('attendance_date', $date)
            ->get()
            ->keyBy('student_id');

        return view(
            'facilitator.attendances.index',
            compact(
                'students',
                'attendances',
                'date',
                'facilitator'
            )
        );
    }

    /**
     * Menyimpan absensi peserta didik.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'attendance_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],

            'attendance' => [
                'required',
                'array',
            ],

            'attendance.*' => [
                'required',
                Rule::in(['H', 'S', 'I', 'A']),
            ],

            'notes' => [
                'nullable',
                'array',
            ],

            'notes.*' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $facilitator = Facilitator::where(
            'user_id',
            Auth::id()
        )->firstOrFail();

        // Memastikan peserta didik masih menjadi
        // tanggung jawab fasilitator.
        $studentIds = $facilitator
            ->facilitatorStudents()
            ->whereDate(
                'start_date',
                '<=',
                $validated['attendance_date']
            )
            ->where(function ($query) use ($validated) {
                $query->whereNull('end_date')
                    ->orWhereDate(
                        'end_date',
                        '>=',
                        $validated['attendance_date']
                    );
            })
            ->pluck('student_id')
            ->toArray();

        $submittedIds = array_keys(
            $validated['attendance']
        );

        // Menolak ID peserta didik yang tidak ditugaskan.
        if (array_diff($submittedIds, $studentIds)) {
            abort(403, 'Peserta didik tidak termasuk penugasan Anda.');
        }

        // Memastikan seluruh peserta didik yang aktif
        // mendapatkan status absensi.
        if (array_diff($studentIds, $submittedIds)) {
            return back()->withErrors([
                'attendance' => 'Semua peserta didik harus memiliki status kehadiran.'
            ])
                ->withInput();
        }

        DB::transaction(function () use (
            $validated,
            $facilitator
        ) {
            foreach (
                $validated['attendance'] as $studentId => $status
            ) {
                $attendance = Attendance::firstOrNew([
                    'student_id' => $studentId,
                    'attendance_date' => $validated['attendance_date'],
                ]);

                if (!$attendance->exists) {
                    $datePrefix = str_replace(
                        '-',
                        '',
                        $validated['attendance_date']
                    );

                    $lastAttendance = Attendance::whereDate(
                        'attendance_date',
                        $validated['attendance_date']
                    )
                        ->orderBy('id', 'desc')
                        ->lockForUpdate()
                        ->first();

                    $lastNumber = $lastAttendance
                        ? (int) substr($lastAttendance->id, 8, 2)
                        : 0;

                    if ($lastNumber >= 99) {
                        throw new \RuntimeException(
                            'Nomor urut absensi pada tanggal tersebut sudah mencapai batas.'
                        );
                    }

                    $attendance->id = $datePrefix . str_pad(
                        $lastNumber + 1,
                        2,
                        '0',
                        STR_PAD_LEFT
                    );
                }
                $attendance->facilitator_id = $facilitator->id;
                $attendance->status = $status;
                $attendance->notes =
                    $validated['notes'][$studentId] ?? null;

                $attendance->save();
            }
        });

        return redirect()
            ->route('facilitator.attendances.index', [
                'date' => $validated['attendance_date']
            ])
            ->with(
                'success',
                'Data absensi peserta didik berhasil disimpan.'
            );
    }
}
