@extends('adminlte::page')
@section('title', 'Absensi Peserta Didik')
@section('content_header')
<h1>
    <i class="fas fa-calendar-check"></i>
    Absensi Peserta Didik
</h1>
@stop
@section('content')

<div class="card card-primary">

    <div class="card-header">
        <h3 class="card-title">
            Form Absensi Harian
        </h3>
    </div>

    <div class="card-body">

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- FILTER TANGGAL --}}
        <form method="GET"
            action="{{ route('facilitator.attendances.index') }}">

            <div class="form-group">
                <label>Tanggal Absensi</label>

                <div class="input-group">

                    <input
                        type="date"
                        name="date"
                        class="form-control"
                        value="{{ $date }}"
                        max="{{ now()->toDateString() }}"
                        required>

                    <div class="input-group-append">
                        <button class="btn btn-info">
                            <i class="fas fa-search"></i>
                            Tampilkan
                        </button>
                    </div>

                </div>
            </div>

        </form>

        <hr>

        {{-- FORM ABSENSI --}}
        <form method="POST"
            action="{{ route('facilitator.attendances.store') }}">

            @csrf

            <input
                type="hidden"
                name="attendance_date"
                value="{{ $date }}">

            <div class="table-responsive">

                <table class="table table-bordered table-striped">

                    <thead class="bg-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Peserta Didik</th>
                            <th width="22%">Status Kehadiran</th>
                            <th width="30%">Keterangan</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($students as $index => $student)

                        @php

                        $attendance = $attendances->get(
                        $student->id
                        );

                        $selectedStatus = old(
                        'attendance.' . $student->id,
                        $attendance->status ?? ''
                        );

                        $selectedNotes = old(
                        'notes.' . $student->id,
                        $attendance->notes ?? ''
                        );

                        @endphp

                        <tr>

                            <td>
                                {{ $index + 1 }}
                            </td>

                            <td>
                                {{ $student->name }}
                            </td>

                            <td>

                                <select
                                    name="attendance[{{ $student->id }}]"
                                    class="form-control"
                                    required>

                                    <option value="" disabled
                                        {{ $selectedStatus == '' ? 'selected' : '' }}>
                                        -- Pilih Kehadiran --
                                    </option>

                                    <option value="H"
                                        {{ $selectedStatus == 'H' ? 'selected' : '' }}>
                                        Hadir
                                    </option>

                                    <option value="S"
                                        {{ $selectedStatus == 'S' ? 'selected' : '' }}>
                                        Sakit
                                    </option>

                                    <option value="I"
                                        {{ $selectedStatus == 'I' ? 'selected' : '' }}>
                                        Izin
                                    </option>

                                    <option value="A"
                                        {{ $selectedStatus == 'A' ? 'selected' : '' }}>
                                        Alpa
                                    </option>

                                </select>

                            </td>

                            <td>

                                <input
                                    type="text"
                                    name="notes[{{ $student->id }}]"
                                    class="form-control"
                                    placeholder="Keterangan (opsional)"
                                    value="{{ $selectedNotes }}">

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="4"
                                class="text-center text-muted">

                                Belum ada peserta didik
                                dengan penugasan aktif.

                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            @if($students->isNotEmpty())

            <div class="text-right">

                <button type="submit"
                    class="btn btn-primary">

                    <i class="fas fa-save"></i>
                    Simpan Absensi

                </button>

            </div>

            @endif

        </form>

    </div>

</div>

@stop
