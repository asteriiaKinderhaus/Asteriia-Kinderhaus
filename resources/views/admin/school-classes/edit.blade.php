@extends('adminlte::page')

@section('title', 'Edit School Class')

@section('content_header')
<h1>
    <i class="fas fa-school"></i>
    Edit School Class
</h1>
@stop

@section('content')

<div class="card card-primary">

    <div class="card-header">
        <h3 class="card-title">Edit Data Kelas</h3>
    </div>

    <form action="{{ route('admin.school-classes.update', $schoolClass->id) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="card-body">

            <div class="form-group">
                <label>ID Kelas</label>
                <input type="text"
                    class="form-control"
                    value="{{ $schoolClass->id }}"
                    readonly>
            </div>

            <div class="form-group">
                <label>Nama Kelas</label>
                <input
                    type="text"
                    name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $schoolClass->name) }}">

                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Kapasitas</label>
                <input
                    type="number"
                    name="capacity"
                    class="form-control @error('capacity') is-invalid @enderror"
                    value="{{ old('capacity', $schoolClass->capacity) }}">

                @error('capacity')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">

                <label>Fasilitator</label>

                <div class="row">

                    @foreach($facilitators as $facilitator)

                    <div class="col-md-4">

                        <div class="form-check mb-2">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="facilitator_ids[]"
                                value="{{ $facilitator->id }}"
                                id="fac{{ $facilitator->id }}"
                                {{ $schoolClass->facilitators->contains('id', $facilitator->id) ? 'checked' : '' }}>

                            <label
                                class="form-check-label"
                                for="fac{{ $facilitator->id }}">

                                {{ $facilitator->name }}

                            </label>

                        </div>

                    </div>

                    @endforeach

                </div>

            </div>

            <div class="form-group">

                <label>Status</label>

                <select
                    name="status"
                    class="form-control">

                    <option value="1"
                        {{ $schoolClass->status ? 'selected' : '' }}>
                        Active
                    </option>

                    <option value="0"
                        {{ !$schoolClass->status ? 'selected' : '' }}>
                        Inactive
                    </option>

                </select>

            </div>

        </div>

        <div class="card-footer">

            <a href="{{ route('admin.school-classes.index') }}"
                class="btn btn-secondary">

                <i class="fas fa-arrow-left"></i>
                Back

            </a>

            <button
                type="submit"
                class="btn btn-primary float-right">

                <i class="fas fa-save"></i>
                Save

            </button>

        </div>

    </form>

</div>

@stop