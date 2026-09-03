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
            <div class="form-group">
                <label for="facilitator_id">
                    Fasilitator
                </label>

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
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

            </div>


            {{-- Peserta Didik --}}
            <div class="form-group">
                <label for="student_id">
                    Peserta Didik
                </label>

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
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

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