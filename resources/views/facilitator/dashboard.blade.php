@extends('adminlte::page')

@section('title', 'Dashboard Fasilitator')

@section('content_header') <h1>Dashboard Fasilitator</h1>
@stop

@section('content')

<div class="row">

    {{-- Profil Fasilitator --}}
    <div class="col-md-4">
        <div class="small-box bg-info">
            <div class="inner">
                <h4>{{ $facilitator->name }}</h4>
                <p>Fasilitator</p>
            </div>

            <div class="icon">
                <i class="fas fa-user"></i>
            </div>
        </div>
    </div>

    {{-- Jumlah Peserta Didik --}}
    <div class="col-md-4">
        <div class="small-box bg-success">
            <div class="inner">
                <h4>{{ $facilitator->facilitatorStudents->count() }}</h4>
                <p>Peserta Didik</p>
            </div>

            <div class="icon">
                <i class="fas fa-child"></i>
            </div>
        </div>
    </div>


</div>

{{-- Daftar Peserta Didik --}}

<div class="card">

    <div class="card-header">
        <h3 class="card-title">
            Peserta Didik
        </h3>
    </div>

    <div class="card-body">

        @if($facilitator->facilitatorStudents->count() > 0)

        <table class="table table-bordered table-hover">

            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th>Nama Peserta Didik</th>
                    <th>Tanggal lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Mulai Penugasan</th>
                    <th>Akhir Penugasan</th>
                </tr>
            </thead>

            <tbody>

                @foreach($facilitator->facilitatorStudents as $assignment)

                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $assignment->student->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($assignment->student->birth_date)->format('d-m-Y') }}</td>
                    <td>{{ $assignment->student->gender->gender ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($assignment->start_date)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($assignment->end_date)->format('d-m-Y') }}</td>
                </tr>

                @endforeach

            </tbody>

        </table>

        @else

        <div class="alert alert-info">
            Belum ada peserta didik yang menjadi tanggung jawab Anda.
        </div>

        @endif

    </div>

</div>

@stop