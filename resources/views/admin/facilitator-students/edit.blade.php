@extends('adminlte::page')

@section('title', 'Edit Hubungan Fasilitator - Peserta Didik')

@section('content_header')
<h1>Edit Hubungan Fasilitator - Peserta Didik</h1>
@endsection

@section('content')

<div class="card">

    <div class="card-header">
        <h3 class="card-title">
            Form Edit Hubungan Fasilitator - Peserta Didik
        </h3>
    </div>

    <form action="{{ route('admin.facilitator-students.update', [$relation->facilitator_id, $relation->student_id]) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="card-body">

            {{-- Error --}}
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Fasilitator --}}
            <div class="form-group row">
                <label for="facilitator_id" class="col-md-3 col-form-label">Fasilitator</label>
                <div class="col-md-9">
                    <select
                        name="facilitator_id"
                        id="facilitator_id"
                        class="form-control @error('facilitator_id') is-invalid @enderror"
                        required>

                        <option value="">
                            -- Pilih Fasilitator --
                        </option>

                        @foreach ($facilitators as $facilitator)

                        <option
                            value="{{ $facilitator->id }}"
                            {{ old('facilitator_id', $relation->facilitator_id) == $facilitator->id ? 'selected' : '' }}>
                            {{ $facilitator->name }}
                        </option>

                        @endforeach

                    </select>

                    @error('facilitator_id')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            {{-- Peserta Didik --}}
            <div class="form-group row">
                <label for="student_id" class="col-md-3 col-form-label">Peserta Didik</label>
                <div class="col-md-9">
                    <select
                        name="student_id"
                        id="student_id"
                        class="form-control @error('student_id') is-invalid @enderror"
                        required>

                        <option value="">
                            -- Pilih Peserta Didik --
                        </option>

                        @foreach ($students as $student)

                        <option
                            value="{{ $student->id }}"
                            {{ old('student_id', $relation->student_id) == $student->id ? 'selected' : '' }}>
                            {{ $student->name }}
                        </option>

                        @endforeach

                    </select>

                    @error('student_id')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>


            <div class="form-group row">
                <label for="start_date" class="col-md-3 col-form-label">Tanggal Mulai</label>
                <div class="col-md-9">
                    <input
                        type="date"
                        name="start_date"
                        id="start_date"
                        class="form-control @error('start_date') is-invalid @enderror"
                        value="{{ old('start_date', $relation->start_date?->format('Y-m-d')) }}"
                        required>

                    @error('start_date')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="end_date" class="col-md-3 col-form-label">Tanggal Selesai</label>

                <div class="col-md-9">
                    <input
                        type="date"
                        name="end_date"
                        id="end_date"
                        class="form-control @error('end_date') is-invalid @enderror"
                        value="{{ old('end_date', $relation->end_date?->format('Y-m-d')) }}">

                    @error('end_date')
                    <span class="invalid-feedback">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>

        </div>


        <div class="card-footer">

            <a
                href="{{ route('admin.facilitator-students.index') }}"
                class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>

            <button
                type="submit"
                class="btn btn-primary">
                <i class="fas fa-save"></i>
                Update
            </button>

        </div>

    </form>

</div>

@endsection
