@extends('adminlte::page')

@section('title', 'Laporan Harian')

@section('content_header')
<h1>Laporan Harian Anak</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Laporan Harian</h3>
    </div>

    <div class="card-body">

        {{-- Filter Anak dan Bulan --}}
        <form method="GET"
            action="{{ route('parent.daily_reports.index') }}">

            <div class="row mb-3">

                <div class="col-md-3">
                    <label for="student_id">Anak</label>

                    <select name="student_id"
                        id="student_id"
                        class="form-control">

                        <option value="">Semua Anak</option>

                        @foreach($parent->students as $student)
                        <option
                            value="{{ $student->id }}"
                            @selected(
                            (string) request('student_id')===(string) $student->id
                            )>
                            {{ $student->name }}
                        </option>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-3">
                    <label for="month">Bulan</label>

                    <input
                        type="month"
                        name="month"
                        id="month"
                        class="form-control"
                        value="{{ request('month', '') }}">
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary mr-2">
                        <i class="fas fa-search"></i> Cari
                    </button>

                    <a href="{{ route('parent.daily_reports.index') }}"
                        class="btn btn-secondary">
                        Reset
                    </a>
                </div>

            </div>
        </form>

        {{-- Tabel Laporan --}}
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Tanggal</th>
                        <th>Nama Anak</th>
                        <th>Fasilitator</th>
                        <th>Status</th>
                        <th width="12%">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($reports as $report)
                    <tr>
                        <td>
                            {{ $reports->firstItem() + $loop->index }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse(
                                    $report->report_date
                                )->format('d-m-Y') }}
                        </td>

                        <td>
                            {{ $report->student->name ?? '-' }}
                        </td>

                        <td>
                            {{ $report->facilitator->name ?? '-' }}
                        </td>

                        <td>
                            <span class="badge badge-success">
                                Selesai
                            </span>
                        </td>

                        <td>
                            <a href="{{ route(
                                    'parent.daily_reports.show',
                                    $report->id
                                ) }}"
                                class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            Belum ada laporan untuk filter yang dipilih.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <div class="card-footer">
        {{ $reports->withQueryString()->links() }}
    </div>
</div>
@stop
