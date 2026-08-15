@extends('adminlte::page')

@section('title', 'Dashboard Administrator')

@section('content_header')
<h1>Dashboard Administrator</h1>
@stop

@section('content')

<div class="row">

    <div class="col-lg-3 col-md-6">

        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $studentCount }}</h3>
                <p>Jumlah Siswa</p>
            </div>

            <div class="icon">
                <i class="fas fa-child"></i>
            </div>
        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $facilitatorCount }}</h3>
                <p>Fasilitator</p>
            </div>

            <div class="icon">
                <i class="fas fa-user-tie"></i>
            </div>
        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $parentCount }}</h3>
                <p>Orang Tua</p>
            </div>

            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
        </div>

    </div>

    <div class="col-lg-3 col-md-6">

        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $classCount }}</h3>
                <p>Kelas</p>
            </div>

            <div class="icon">
                <i class="fas fa-school"></i>
            </div>
        </div>

    </div>

</div>

@stop