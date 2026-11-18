@extends('adminlte::page')

@section('title', 'Riwayat Absensi')

@section('content_header')
<h1>Riwayat Absensi Anak</h1>
@stop

@section('content')

{{-- Ringkasan Absensi --}}
<div class="row">

    <div class="col-md-3 col-sm-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $summary['H'] }}</h3>
                <p>Hadir</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $summary['S'] }}</h3>
                <p>Sakit</p>
            </div>
            <div class="icon">
                <i class="fas fa-notes-medical"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $summary['I'] }}</h3>
                <p>Izin</p>
            </div>
            <div class="icon">
                <i class="fas fa-envelope"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $summary['A'] }}</h3>
                <p>Alpa</p>
            </div>
            <div class="icon">
                <i class="fas fa-times-circle"></i>
            </div>
        </div>
    </div>

</div>

{{-- Data Riwayat Absensi --}}
<div class="card">

    <div class="card-header">
        <h3 class="card-title">Data Riwayat Absensi</h3>
    </div>

    <div class="card-body">

        {{-- Filter Anak dan Bulan --}}
        <form method="GET"
            action="{{ route('parent.attendances.index') }}">

            <div class="row mb-3">

                <div class="col-md-3">
                    <label for="student_id">Anak</label>

                    <select name="student_id"
                        id="student_id"
                        class="form-control">

                        <option value="">Semua Anak</option>

                        @foreach($students as $student)
                        <option value="{{ $student->id }}"
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

                <div class="col-md-3 d-flex align-items-end">

                    <button type="submit"
                        class="btn btn-primary mr-2">
                        <i class="fas fa-search"></i> Cari
                    </button>

                    <a href="{{ route('parent.attendances.index') }}"
                        class="btn btn-secondary">
                        Reset
                    </a>

                </div>

            </div>

        </form>

        {{-- Tabel Riwayat Absensi --}}
        <div class="table-responsive">

            <table class="table table-bordered table-striped">

                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Tanggal</th>
                        <th>Nama Anak</th>
                        <th>Fasilitator</th>
                        <th>Status</th>
                        <th>Catatan</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($attendances as $attendance)

                    <tr>

                        <td>
                            {{ $attendances->firstItem() + $loop->index }}
                        </td>

                        <td>
                            {{ $attendance->attendance_date->format('d-m-Y') }}
                        </td>

                        <td>
                            {{ $attendance->student->name ?? '-' }}
                        </td>

                        <td>
                            {{ $attendance->facilitator->name ?? '-' }}
                        </td>

                        <td>
                            @if($attendance->status == 'H')
                            <span class="badge badge-success">
                                Hadir
                            </span>

                            @elseif($attendance->status == 'S')
                            <span class="badge badge-warning">
                                Sakit
                            </span>

                            @elseif($attendance->status == 'I')
                            <span class="badge badge-info">
                                Izin
                            </span>

                            @elseif($attendance->status == 'A')
                            <span class="badge badge-danger">
                                Alpa
                            </span>

                            @else
                            <span class="badge badge-secondary">
                                -
                            </span>
                            @endif
                        </td>

                        <td>
                            {{ $attendance->notes ?? '-' }}
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="6" class="text-center">
                            Belum ada riwayat absensi untuk filter yang dipilih.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="card-footer">
        {{ $attendances->withQueryString()->links() }}
    </div>

</div>

@stop