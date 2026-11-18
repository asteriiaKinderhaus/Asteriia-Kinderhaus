<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ParentModel;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data orang tua berdasarkan akun yang sedang login
        $parent = ParentModel::with('students')
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Ambil ID seluruh anak milik orang tua tersebut
        $studentIds = $parent->students->pluck('id');

        // Validasi filter
        $filters = $request->validate([
            'student_id' => ['nullable', 'string'],
            'month' => [
                'nullable',
                'regex:/^\d{4}-(0[1-9]|1[0-2])$/'
            ],
        ]);
        // Query dasar: hanya absensi anak milik orang tua yang login
        $query = Attendance::with(['student', 'facilitator'])
            ->whereIn('student_id', $studentIds);

        // Filter berdasarkan anak
        if (!empty($filters['student_id'])) {
            $query->where('student_id', $filters['student_id']);
        }

        // Filter berdasarkan bulan dan tahun
        if (!empty($filters['month'])) {
            [$year, $month] = explode('-', $filters['month']);

            $query->whereYear('attendance_date', $year)
                ->whereMonth('attendance_date', $month);
        }

        // Hitung ringkasan status sesuai filter
        $statusCounts = (clone $query)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $summary = [
            'H' => $statusCounts->get('H', 0),
            'S' => $statusCounts->get('S', 0),
            'I' => $statusCounts->get('I', 0),
            'A' => $statusCounts->get('A', 0),
        ];

        // Ambil data absensi dengan pagination
        $attendances = $query
            ->orderByDesc('attendance_date')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        // Daftar anak untuk pilihan filter
        $students = Student::whereIn('id', $studentIds)
            ->orderBy('name')
            ->get();

        return view('parent.attendances.index', compact(
            'parent',
            'attendances',
            'students',
            'filters',
            'summary'
        ));
    }
}
