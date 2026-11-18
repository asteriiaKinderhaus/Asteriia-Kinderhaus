<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Facilitator;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        // Validasi filter
        $filters = $request->validate([
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
            'student_id' => ['nullable', 'exists:students,id'],
            'facilitator_id' => ['nullable', 'exists:facilitators,id'],
        ]);

        // Query dasar absensi
        $query = Attendance::with(['student', 'facilitator']);

        // Filter tanggal awal
        if (!empty($filters['date_from'])) {
            $query->whereDate(
                'attendance_date',
                '>=',
                $filters['date_from']
            );
        }

        // Filter tanggal akhir
        if (!empty($filters['date_to'])) {
            $query->whereDate(
                'attendance_date',
                '<=',
                $filters['date_to']
            );
        }

        // Filter peserta didik
        if (!empty($filters['student_id'])) {
            $query->where(
                'student_id',
                $filters['student_id']
            );
        }

        // Filter fasilitator
        if (!empty($filters['facilitator_id'])) {
            $query->where(
                'facilitator_id',
                $filters['facilitator_id']
            );
        }

        // Hitung ringkasan berdasarkan filter yang dipilih
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

        // Data dropdown filter
        $students = Student::orderBy('name')->get();

        $facilitators = Facilitator::orderBy('name')->get();

        return view('admin.attendances.index', compact(
            'attendances',
            'students',
            'facilitators',
            'filters',
            'summary'
        ));
    }
}
