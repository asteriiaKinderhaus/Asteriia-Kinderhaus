@extends('adminlte::page')

@section('title', 'Edit Fasilitator')

@section('content_header')
<h1>Edit Fasilitator</h1>
@endsection

@section('content')

<div class="card">

    <div class="card-header">
        <h3 class="card-title">
            Form Edit Fasilitator
        </h3>
    </div>


    <form action="{{ route('admin.facilitators.update', $facilitator->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Nama Fasilitator</label>
                <div class="col-sm-9">
                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $facilitator->name) }}"
                        required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
                <div class="col-sm-9">
                    <input
                        type="date"
                        name="birth_date"
                        class="form-control"
                        value="{{ old('birth_date', $facilitator->birth_date?->format('Y-m-d')) }}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email', $facilitator->email) }}">
                </div>
            </div>


            <div class="form-group row">
                <label class="col-sm-3 col-form-label">No HP</label>
                <div class="col-sm-9">
                    <input
                        type="text"
                        name="telephone"
                        class="form-control"
                        value="{{ old('no_hp', $facilitator->telephone) }}">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                <div class="col-sm-3 col-form-label">

                    <select name="gender_id"
                        class="form-control @error('gender_id') is-invalid @enderror">

                        <option value="">-- Pilih Jenis Kelamin --</option>

                        @foreach($genders as $gender)
                        <option value="{{ $gender->id }}"
                            {{ old('gender_id', $facilitator->gender_id) == $gender->id ? 'selected' : '' }}>
                            {{ $gender->gender }}
                        </option>
                        @endforeach

                    </select>
                </div>

                @error('gender_id')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror

            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Alamat</label>
                <div class="col-sm-9">
                    <textarea name="address"
                        rows="4"
                        class="form-control @error('address') is-invalid @enderror">{{ old('address', $facilitator->address) }}</textarea>

                    @error('address')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>


        </div>


        <div class="card-footer">

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Simpan
            </button>


            <a href="{{ route('admin.facilitators.index') }}"
                class="btn btn-secondary">

                Kembali

            </a>

        </div>


    </form>

</div>

@endsection