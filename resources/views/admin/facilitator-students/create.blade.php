@extends('adminlte::page')
@section('title', 'Tambah Fasilitator - Peserta Didik')
@section('content_header') <h1>Tambah Fasilitator - Peserta Didik</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            Tambah Hubungan
        </h3>
    </div>

    <form
        action="{{ route('admin.facilitator-students.store') }}"
        method="POST">
        @csrf
        <div class="card-body">
            {{-- FASILITATOR --}}
            <div class="form-group row">
                <label class="col-md-3 col-form-label">
                    Fasilitator
                </label>
                <div class="col-md-9">
                    <select
                        name="facilitator_id"
                        class="form-control @error('facilitator_id') is-invalid @enderror"
                        required>
                        <option value="">
                            -- Pilih Fasilitator --
                        </option>
                        @foreach($facilitators as $facilitator)
                        <option
                            value="{{ $facilitator->id }}"
                            @selected(old('facilitator_id')==$facilitator->id)>
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

            {{-- PESERTA DIDIK --}}
            <div class="form-group row">
                <label class="col-md-3 col-form-label">
                    Peserta Didik
                </label>
                <div class="col-md-9">
                    <select
                        name="student_id"
                        class="form-control @error('student_id') is-invalid @enderror"
                        required>
                        <option value="">
                            -- Pilih Peserta Didik --
                        </option>
                        @foreach($students as $student)
                        <option value="{{ $student->id }}" @selected(old('student_id')==$student->id)>
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
        </div>

        <div class="card-footer">
            <a href="{{ route('admin.facilitator-students.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
            <button
                type="submit"
                class="btn btn-primary">
                <i class="fas fa-save"></i>
                Simpan
            </button>
        </div>
    </form>
</div>

@stop