@extends('adminlte::page')

@section('title', 'Create Daily Report')

@section('content')

@error('student_id')
<div class="alert alert-danger">
    {{ $message }}
</div>

@enderror

<form method="POST"
    action="{{ route('facilitator.daily-reports.store') }}">

    @csrf

    @include('facilitator.daily-report.partials.student-info')

    @include('facilitator.daily-report.partials.meal')
    <div class="row">

        <div class="col-md-6">

            @include('facilitator.daily-report.partials.simulation')

        </div>

        <div class="col-md-6">

            @include('facilitator.daily-report.partials.self-help')

        </div>

    </div>

    {{--@include('facilitator.daily-report.partials.activity') --}}

    <div class="row">

        <div class="col-md-6">

            @include('facilitator.daily-report.partials.facilitator-note')

        </div>

    </div>


    {{--@include('facilitator.daily-report.partials.photo') --}}

    <div class="card">
        <div class="card-body text-right">
            <!--<button class="btn btn-secondary">
                Simpan Draft
            </button>-->

            <button class="btn btn-primary">
                Kirim Laporan
            </button>
        </div>
    </div>

</form>

@stop
