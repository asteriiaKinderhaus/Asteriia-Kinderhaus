@extends('adminlte::page')

@section('title', 'Dashboard Orang Tua')

@section('content_header')
<h1>Dashboard Orang Tua</h1>
@stop

@section('content')

<div class="row">

    <div class="col-md-4">

        <div class="small-box bg-info">

            <div class="inner">
                <p>Orang Tua</p>

                <h4>{{ $parent->name }}</h4>


            </div>

            <div class="icon">
                <i class="fas fa-user"></i>
            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="small-box bg-success">

            <div class="inner">
                <p>Jumlah anak</p>
                <h4>
                    {{ $parent->students->count() }}
                </h4>

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
            Data Anak
        </h3>

    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <thead>

                <tr>

                    <th>No</th>
                    <th>Nama Anak</th>
                    <th>Nama Kelas</th>
                    <th>Nama Fasilitator</th>

                </tr>

            </thead>

            <tbody>
                @foreach($parent->students as $student)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $student->name }} </td>
                    <td>{{ $student->schoolClass->name }} </td>
                    <td> @foreach($student->schoolClass->facilitators as $facilitator)

                        {{ $facilitator->name }}

                        @unless($loop->last),
                        @endunless

                        @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>

</div>

@stop