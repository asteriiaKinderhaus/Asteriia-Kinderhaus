@extends('adminlte::page')

@section('title', 'Facilitator Dashboard')

@section('content_header')
<h1>Dashboard Fasilitator</h1>
@stop

@section('content')

<div class="row">

    <div class="col-md-4">

        <div class="small-box bg-info">

            <div class="inner">

                <h4>{{ $facilitator->name }}</h4>

                <p>Facilitator</p>

            </div>

            <div class="icon">
                <i class="fas fa-user"></i>
            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="small-box bg-success">

            <div class="inner">

                <h4>
                    {{ $facilitator->schoolClasses->count() }}
                </h4>

                <p>Assigned Classes</p>

            </div>

            <div class="icon">
                <i class="fas fa-school"></i>
            </div>

        </div>

    </div>

</div>

<div class="card">

    <div class="card-header">

        <h3 class="card-title">
            My Classes
        </h3>

    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <thead>

                <tr>

                    <th>No</th>

                    <th>Class ID</th>

                    <th>Class Name</th>

                </tr>

            </thead>

            <tbody>

                @foreach($facilitator->schoolClasses as $class)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $class->id }}</td>

                    <td>{{ $class->name }}</td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@stop