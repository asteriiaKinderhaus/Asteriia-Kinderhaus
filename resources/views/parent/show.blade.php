@extends('adminlte::page')

@section('title', 'Laporan Harian')

@section('content_header')
<h1>Laporan Harian Anak</h1>
@stop

@section('content')
<div class="card">

    <div class="card-header bg-primary">

        <h4 class="mb-0">
            Laporan Harian Anak
        </h4>

    </div>

    <div class="card-body">

        <table class="table table-borderless">

            <tr>

                <th width="200">Tanggal</th>

                <td>
                    {{ $dailyReport->report_date }}
                </td>

            </tr>

            <tr>

                <th>Nama Anak</th>

                <td>

                    {{ $dailyReport->student->name }}

                </td>

            </tr>

            <tr>

                <th>Kelas</th>

                <td>

                    {{ $dailyReport->student->schoolClass->name }}

                </td>

            </tr>

            <tr>

                <th>Fasilitator</th>

                <td>

                    {{ $dailyReport->facilitator->name }}

                </td>

            </tr>

        </table>

    </div>



</div>

<div class="card">

    <div class="card-header bg-success">

        Catatan Makan & Minum

    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <thead>

                <tr>

                    <th>Makanan</th>
                    <th>Status</th>
                    <th>Cara Makan</th>

                </tr>

            </thead>

            <tbody>

                @foreach($dailyReport->meals as $meal)

                <tr>

                    <td>

                        {{ $meal->meal->name }}

                    </td>

                    <td>

                        {{ $meal->food_status }}

                    </td>

                    <td>

                        {{ $meal->assistance }}

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

<div class="card">

    <div class="card-header bg-info">

        Brain Body Activation

    </div>

    <div class="card-body">

        <ul>

            @foreach($dailyReport->simulations as $simulation)

            <li>

                {{ $simulation->simulation->name }}

            </li>

            @endforeach

        </ul>

    </div>

</div>

<div class="card">

    <div class="card-header bg-warning">

        Self Help

    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <thead>

                <tr>

                    <th>Aktivitas</th>

                    <th>Status</th>

                </tr>

            </thead>

            <tbody>

                @foreach($dailyReport->selfHelps as $item)

                <tr>

                    <td>

                        {{ $item->selfHelp->name }}

                    </td>

                    <td>

                        {{ $item->status }}

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

<div class="card">

    <div class="card-header">

        Aktivitas Hari Ini

    </div>

    <div class="card-body">

        @foreach($dailyReport->activities as $activity)

        <p>

            <strong>{{ $activity->activity->name }}</strong>

        </p>

        @endforeach

    </div>

</div>

<div class="card">

    <div class="card-header">

        Catatan Fasilitator

    </div>

    <div class="card-body">

        {{ $dailyReport->facilitator_note }}

    </div>

</div>

@stop
