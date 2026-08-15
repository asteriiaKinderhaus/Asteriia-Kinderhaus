@extends('adminlte::page')

@section('title', 'Edit Siswa')

@section('content_header')
<h1>Edit Siswa</h1>
@endsection

@section('content')

<div class="card">

    <div class="card-header">
        <h3 class="card-title">
            Form Edit Siswa
        </h3>
    </div>


    <form action="{{ route('admin.students.update', $student->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Nama Siswa</label>
                <div class="col-sm-9">
                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $student->name) }}"
                        required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Nama Orang Tua</label>
                <div class="col-sm-9">
                    <input
                        type="text"
                        name="parent"
                        class="form-control"
                        value="{{ old('name', $student->parent->name) }}">
                </div>
            </div>


            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
                <div class="col-sm-9">
                    <input
                        type="date"
                        name="birth_date"
                        class="form-control"
                        value="{{ old('birth_date', $student->birth_date?->format('Y-m-d')) }}">
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
                            {{ old('gender_id', $student->gender_id) == $gender->id ? 'selected' : '' }}>
                            {{ $gender->gender }}
                        </option>
                        @endforeach

                    </select>
                </div>

                @error('gender_id')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror

            </div>

            <!--<div class="form-group row">
                <label class="col-sm-3 col-form-label">Alamat</label>
                <div class="col-sm-9">
                    <textarea name="address"
                        rows="4"
                        class="form-control @error('address') is-invalid @enderror">{{ old('address', $student->address) }}</textarea>

                    @error('address')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>-->


        </div>


        <div class="card-footer">

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Simpan
            </button>


            <a href="{{ route('admin.students.index') }}"
                class="btn btn-secondary">

                Kembali

            </a>

        </div>


    </form>

</div>

@endsection