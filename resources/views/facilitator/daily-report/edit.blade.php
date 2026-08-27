@extends('adminlte::page')

@section('title', 'Edit Daily Report')



@section('content_header')
<h1>Edit Laporan Harian Anak</h1>
@stop

@section('content')

<form
    action="{{ route('facilitator.daily-reports.update', $dailyReport->id) }}"
    method="POST">
    @csrf
    @method('PUT')

    {{-- ========================================================= --}}
    {{-- INFORMASI LAPORAN                                         --}}
    {{-- ========================================================= --}}

    <div class="sticky-report">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i>
                    Informasi Laporan
                </h3>
            </div>

            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-3 font-weight-bold">
                        Tanggal
                    </div>

                    <div class="col-md-9">
                        {{ $dailyReport->report_date->format('d F Y') }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3 font-weight-bold">
                        Nama Anak
                    </div>

                    <div class="col-md-9">
                        {{ $dailyReport->student->name }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3 font-weight-bold">
                        Kelas
                    </div>

                    <div class="col-md-9">
                        {{ $dailyReport->student->schoolClass->name ?? '-' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3 font-weight-bold">
                        Fasilitator
                    </div>

                    <div class="col-md-9">
                        {{ $dailyReport->facilitator->name }}
                    </div>
                </div>

            </div>
        </div>
    </div>


    {{-- ========================================================= --}}
    {{-- CATATAN MAKAN & MINUM                                    --}}
    {{-- ========================================================= --}}

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
                                <th width="25%">
                                    Jenis Makanan
                                </th>

                                <th>
                                    Habis
                                </th>

                                <th>
                                    Sisa Sedikit
                                </th>

                                <th>
                                    Tidak Habis
                                </th>

                                <th>
                                    Mandiri
                                </th>

                                <th>
                                    Bantuan
                                </th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($dailyReport->meals as $reportMeal)

                            <tr>

                                <td>
                                    {{ $reportMeal->meal->name }}
                                </td>

                                {{-- FOOD STATUS --}}

                                <td class="text-center">

                                    <input
                                        type="radio"
                                        class="meal-radio"
                                        name="meals[{{ $reportMeal->meal_id }}][food_status]"
                                        value="HABIS"

                                        @checked(
                                        $reportMeal->food_status === 'HABIS'
                                    )
                                    >

                                </td>

                                <td class="text-center">

                                    <input
                                        type="radio"
                                        class="meal-radio"
                                        name="meals[{{ $reportMeal->meal_id }}][food_status]"
                                        value="SISA_SEDIKIT"

                                        @checked(
                                        $reportMeal->food_status === 'SISA_SEDIKIT'
                                    )
                                    >

                                </td>

                                <td class="text-center">

                                    <input
                                        type="radio"
                                        class="meal-radio"
                                        name="meals[{{ $reportMeal->meal_id }}][food_status]"
                                        value="TIDAK_HABIS"

                                        @checked(
                                        $reportMeal->food_status === 'TIDAK_HABIS'
                                    )
                                    >

                                </td>

                                {{-- ASSISTANCE --}}

                                <td class="text-center">

                                    <input
                                        type="radio"
                                        class="assistance-radio"
                                        name="meals[{{ $reportMeal->meal_id }}][assistance]"
                                        value="MANDIRI"

                                        @checked(
                                        $reportMeal->assistance === 'MANDIRI'
                                    )
                                    >

                                </td>

                                <td class="text-center">

                                    <input
                                        type="radio"
                                        class="assistance-radio"
                                        name="meals[{{ $reportMeal->meal_id }}][assistance]"
                                        value="BANTUAN"

                                        @checked(
                                        $reportMeal->assistance === 'BANTUAN'
                                    )
                                    >

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- STIMULASI & SELF HELP                                --}}
        {{-- ===================================================== --}}

        <div class="row">

            {{-- ================= STIMULASI ====================== --}}

            <div class="col-md-6">

                <div class="card card-info">

                    <div class="card-header">

                        <h3 class="card-title">
                            <i class="fas fa-brain"></i>
                            Stimulasi
                        </h3>

                    </div>

                    <div class="card-body">

                        @php

                        $selectedStimulations =
                        $dailyReport->stimulations
                        ->pluck('stimulation_item_id')
                        ->toArray();

                        @endphp


                        @foreach($stimulationCategories as $category)

                        <div class="card mb-3">

                            <div class="card-header bg-success text-white">
                                {{ $category->name }}
                            </div>

                            <div class="card-body">

                                <div class="row">

                                    @foreach($category->items as $item)

                                    <div class="col-md-6 mb-2">

                                        <div class="form-check">

                                            <input
                                                class="form-check-input stimulation-checkbox"
                                                type="checkbox"

                                                name="stimulations[]"

                                                value="{{ $item->id }}"

                                                id="stimulation_{{ $item->id }}"

                                                @checked(
                                                in_array(
                                                $item->id,
                                            $selectedStimulations
                                            )
                                            )
                                            >

                                            <label
                                                class="form-check-label"
                                                for="stimulation_{{ $item->id }}">
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


            {{-- ================= SELF HELP ==================== --}}

            <div class="col-md-6">

                <div class="card card-success">

                    <div class="card-header">

                        <h3 class="card-title">
                            <i class="fas fa-hands-helping"></i>
                            Self Help
                        </h3>

                    </div>

                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table table-bordered">

                                <thead>

                                    <tr>
                                        <th>
                                            Aktivitas
                                        </th>

                                        <th class="text-center">
                                            Mandiri
                                        </th>

                                        <th class="text-center">
                                            Bantuan
                                        </th>
                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach($dailyReport->selfHelps as $reportSelfHelp)

                                    <tr>

                                        <td>
                                            {{ $reportSelfHelp->selfHelp->name }}
                                        </td>

                                        <td class="text-center">

                                            <input
                                                type="radio"

                                                name="self_helps[{{ $reportSelfHelp->self_help_id }}][assistance]"

                                                value="MANDIRI"

                                                @checked(
                                                $reportSelfHelp->assistance === 'MANDIRI'
                                            )
                                            >

                                        </td>

                                        <td class="text-center">

                                            <input
                                                type="radio"

                                                name="self_helps[{{ $reportSelfHelp->self_help_id }}][assistance]"

                                                value="BANTUAN"

                                                @checked(
                                                $reportSelfHelp->assistance === 'BANTUAN'
                                            )
                                            >

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


        {{-- ===================================================== --}}
        {{-- CATATAN FASILITATOR                                  --}}
        {{-- ===================================================== --}}

        <div class="card card-success">

            <div class="card-header">

                <h3 class="card-title">
                    <i class="fas fa-sticky-note"></i>
                    Catatan Fasilitator
                </h3>

            </div>

            <div class="card-body">

                <textarea
                    class="form-control"
                    rows="4"
                    name="additional_note"
                    placeholder="Catatan tambahan fasilitator">{{ old('additional_note', $dailyReport->additional_note) }}</textarea>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- BUTTON                                                --}}
        {{-- ===================================================== --}}

        <div class="card">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <a
                        href="{{ route('facilitator.daily-reports.index') }}"
                        class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Batal
                    </a>


                    <button
                        type="submit"
                        class="btn btn-success">
                        <i class="fas fa-save"></i>
                        Simpan Perubahan
                    </button>

                </div>

            </div>

        </div>

    </div>

</form>

@stop
