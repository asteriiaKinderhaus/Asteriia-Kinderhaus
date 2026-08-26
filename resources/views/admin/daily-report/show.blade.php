@extends('adminlte::page')
@section('title', 'Show Daily Report')
@section('css')
<style>
    .content-wrapper {
        overflow-x: hidden;
    }

    .sticky-report {
        position: sticky;
        top: 60px;
        /* sesuaikan tinggi navbar */
        z-index: 1040;
        background: #f4f6f9;
    }

    .report-body {
        margin-top: 15px;
    }
</style>
@stop

@section('content_header')
<h1>Laporan Harian Anak</h1>
@stop

@section('content')
<div class="sticky-report">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Informasi Laporan</h3>
        </div>

        <div class="card-body">

            <div class="row">

                {{-- Baris 1 --}}
                <div class="col-md-6 mb-4">
                    <div class="row">
                        <div class="col-sm-4 font-weight-bold">Tanggal</div>
                        <div class="col-sm-8">
                            {{ $dailyReport->report_date->format('d F Y') }}
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="row">
                        <div class="col-sm-4 font-weight-bold">Nama Anak</div>
                        <div class="col-sm-8">
                            {{ $dailyReport->student->name }}
                        </div>
                    </div>
                </div>

                {{-- Baris 2 --}}
                <div class="col-md-6 mb-4">
                    <div class="row">
                        <div class="col-sm-4 font-weight-bold">Kelas</div>
                        <div class="col-sm-8">
                            {{ $dailyReport->student->schoolClass->name }}
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="row">
                        <div class="col-sm-4 font-weight-bold">Fasilitator</div>
                        <div class="col-sm-8">
                            {{ $dailyReport->facilitator->name }}
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<div class="report-body">
    <div class="card card-success">

        <div class="card-header">

            <h3 class="card-title">

                <i class="fas fa-utensils"></i>

                Catatan Makan & Minum

            </h3>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="text-center">

                        <tr class="bg-light">

                            <th width="25%">Jenis Makanan</th>
                            <th>Habis</th>
                            <th>Tidak Habis</th>
                            <th>Sisa Sedikit</th>
                            <th>Mandiri</th>
                            <th>Bantuan</th>
                            <!--<th width="25%">Catatan</th>-->

                        </tr>

                    </thead>

                    <tbody>
                        @foreach($dailyReport->meals as $reportMeal)

                        <tr>
                            <td>{{ $reportMeal->meal->name }}</td>
                            <td class="text-center">
                                <input type="radio"
                                    onclick="return false;"
                                    {{ $reportMeal->food_status == 'HABIS' ? 'checked' : '' }}>
                            </td>

                            <td class="text-center">
                                <input type="radio"
                                    onclick="return false;"
                                    {{ $reportMeal->food_status == 'SISA_SEDIKIT' ? 'checked' : '' }}>
                            </td>

                            <td class="text-center">
                                <input type="radio"
                                    onclick="return false;"
                                    {{ $reportMeal->food_status == 'TIDAK_HABIS' ? 'checked' : '' }}>
                            </td>

                            <td class="text-center">
                                <input type="radio"
                                    onclick="return false;"
                                    {{ $reportMeal->assistance == 'MANDIRI' ? 'checked' : '' }}>
                            </td>

                            <td class="text-center">
                                <input type="radio"
                                    onclick="return false;"
                                    {{ $reportMeal->assistance == 'BANTUAN' ? 'checked' : '' }}>
                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-info">

                <div class="card-header">

                    @php
                    $selectedStimulations = $dailyReport->stimulations
                    ->pluck('stimulation_item_id')
                    ->toArray();
                    @endphp

                    <h3 class="card-title">

                        <i class="fas fa-brain"></i>

                        Stimulasi

                    </h3>

                </div>

                <div class="card-body">

                    @foreach($stimulationCategories as $category)
                    <div class="card mb-3">
                        <div class="card-header bg-success text-white">
                            {{ $category->name }}
                        </div>

                        <div class="card-body">
                            <div class="row">

                                @foreach($category->items as $item)

                                <div class="col-md-4 mb-2">

                                    <div class="form-check">

                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            onclick="return false;"
                                            @checked(in_array($item->id, $selectedStimulations))
                                        >

                                        <label class="form-check-label">
                                            {{ $item->name }}
                                        </label>

                                    </div>

                                </div>

                                @endforeach

                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>


        <div class="col-md-6">

            <div class="card card-success">

                <div class="card-header">
                    <h3 class="card-title">
                        Self Help
                    </h3>
                </div>

                <div class="card-body">

                    <table class="table table-bordered">

                        <thead>

                            <tr>
                                <th>Aktivitas</th>
                                <th class="text-center">Mandiri</th>
                                <th class="text-center">Bantuan</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($dailyReport->selfHelps as $item)

                            <tr>

                                <td>{{ $item->selfHelp->name }}</td>

                                <td class="text-center">
                                    <input
                                        type="radio"
                                        onclick="return false;"
                                        {{ $item->assistance == 'MANDIRI' ? 'checked' : '' }}>
                                </td>

                                <td class="text-center">
                                    <input
                                        type="radio"
                                        onclick="return false;"
                                        {{ $item->assistance == 'BANTUAN' ? 'checked' : '' }}>
                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>
        </div>
    </div>
</div>

<div class="card card-success">

    <div class="card-header">

        <h3 class="card-title">

            Catatan Fasilitator
        </h3>

    </div>

    <div class="card-body">

        <textarea
            class="form-control"
            rows="3"
            name="additional_note"
            placeholder="Catatan tambahan fasilitator" disabled>
        {{ $dailyReport-> additional_note }}
        </textarea>

    </div>

</div>

@stop
