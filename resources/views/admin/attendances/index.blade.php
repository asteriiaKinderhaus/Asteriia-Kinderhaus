
@extends('adminlte::page')

@section('title', 'Rekap Absensi Peserta Didik')

@section('content_header')
    <h1>
        <i class="fas fa-calendar-check"></i>
        Rekap Absensi Peserta Didik
    </h1>
@stop

@section('content')

<div class="container-fluid">

    {{-- Ringkasan Absensi --}}
    <div class="row">

        <div class="col-md-3">
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

        <div class="col-md-3">
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

        <div class="col-md-3">
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

        <div class="col-md-3">
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

    {{-- Filter Absensi --}}
    <div class="card card-primary card-outline">

        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-filter"></i>
                Filter Data Absensi
            </h3>
        </div>

        <div class="card-body">

            <form method="GET"
                action="{{ route('admin.attendances.index') }}">

                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tanggal Awal</label>
                            <input type="date"
                                name="date_from"
                                class="form-control"
                                value="{{ $filters['date_from'] ?? '' }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tanggal Akhir</label>
                            <input type="date"
                                name="date_to"
                                class="form-control"
                                value="{{ $filters['date_to'] ?? '' }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Peserta Didik</label>
                            <select name="student_id"
                                class="form-control select2">
                                <option value="">Semua Peserta Didik</option>

                                @foreach($students as $student)
                                    <option value="{{ $student->id }}"
                                        {{ ($filters['student_id'] ?? '') == $student->id ? 'selected' : '' }}>
                                        {{ $student->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Fasilitator</label>
                            <select name="facilitator_id"
                                class="form-control select2">
                                <option value="">Semua Fasilitator</option>

                                @foreach($facilitators as $facilitator)
                                    <option value="{{ $facilitator->id }}"
                                        {{ ($filters['facilitator_id'] ?? '') == $facilitator->id ? 'selected' : '' }}>
                                        {{ $facilitator->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                    Tampilkan
                </button>

                <a href="{{ route('admin.attendances.index') }}"
                    class="btn btn-secondary">
                    <i class="fas fa-sync"></i>
                    Reset
                </a>

            </form>

        </div>
    </div>

    {{-- Tabel Absensi --}}
    <div class="card">

        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-table"></i>
                Data Absensi
            </h3>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-striped table-hover">

                <thead class="thead-light">
                    <tr>
                        <th width="50">No.</th>
                        <th>ID Absensi</th>
                        <th>Tanggal</th>
                        <th>Peserta Didik</th>
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

                            <td>{{ $attendance->id }}</td>

                            <td>
                                {{ \Carbon\Carbon::parse($attendance->attendance_date)->format('d-m-Y') }}
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
                                @endif
                            </td>

                            <td>
                                {{ $attendance->notes ?? '-' }}
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center">
                                Belum ada data absensi.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="card-footer clearfix">
            {{ $attendances->links() }}
        </div>

    </div>

</div>

@stop
