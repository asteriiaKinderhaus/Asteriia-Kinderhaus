<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyReport;
use App\Models\StimulationCategory;

class DailyReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil daftar tahun yang tersedia dari laporan
        $years = DailyReport::query()
            ->selectRaw('YEAR(report_date) as year')
            ->whereNotNull('report_date')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        // Query laporan
        $query = DailyReport::with([
            'student',
            'schoolClass',
            'facilitator'
        ]);

        // Filter tahun
        if ($request->filled('year')) {
            $query->whereYear('report_date', $request->year);
        }

        // Filter bulan
        if ($request->filled('month')) {
            $query->whereMonth('report_date', $request->month);
        }

        // Urutkan berdasarkan tanggal terbaru
        $reports = $query
            ->orderByDesc('report_date')
            ->get();

        return view(
            'admin.daily-report.index',
            compact('reports', 'years')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DailyReport $dailyReport)
    {
        $dailyReport->load([
            'student',
            'facilitator',
            'meals.meal',
            'selfHelps.selfHelp',
            'stimulations.stimulationItem.category'
        ]);

        $stimulationCategories = StimulationCategory::with('items')
            ->orderBy('name')
            ->get();

        return view(
            'admin.daily-report.show',
            compact(
                'dailyReport',
                'stimulationCategories'
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
