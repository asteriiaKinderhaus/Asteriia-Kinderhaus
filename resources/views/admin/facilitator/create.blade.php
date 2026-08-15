@extends('adminlte::page')

@section('title','Form Tambah Fasilitator')

@section('content_header')
<h1>
    <i class="fas fa-chalkboard-teacher"></i>
    Tambah Fasilitator
</h1>
@stop

@section('content')

<div class="card">

    <div class="card-header bg-primary">
        <h3 class="card-title">Form Fasilitator</h3>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('admin.facilitators.store') }}"
        method="POST">
        @csrf

        <div class="card-body">

            <div class="row">
                {{-- LOGIN INFORMATION --}}
                <!--<div class="col-md-6">

                    <div class="card card-outline card-primary">

                        <div class="card-header">
                            <strong>Login Information</strong>
                        </div>

                        <div class="card-body">

                            <div class="form-group row">

                                <label class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-8">
                                    <input type="text"
                                        name="username"
                                        value="{{ old('username') }}"
                                        class="form-control">

                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-8">
                                    <input type="password"
                                        name="password"
                                        class="form-control">

                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-8">
                                    <select name="status"
                                        class="form-control">

                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>

                                    </select>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>-->

                {{-- INFORMASI PERSONAL --}}
                <div class="col-md-6">

                    <div class="card card-outline card-success">

                        <div class="card-header">
                            <strong>Informasi Personal</strong>
                        </div>

                        <div class="card-body">

                            <div class="form-group row">

                                <label class="col-sm-3 col-form-label">Nama</label>
                                <div class="col-sm-8">
                                    <input type="text"
                                        name="name"
                                        value="{{ old('name') }}"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tanggal lahir</label>
                                <div class="col-sm-8"> <input
                                        type="date"
                                        name="birth_date"
                                        value="{{ old('birth_date') }}"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                                <div class="col-sm-8">
                                    <select name="gender_id"
                                        class="form-control">

                                        <option value="">-- Pilih Jenis Kelamin --</option>

                                        @foreach($genders as $gender)

                                        <option value="{{ $gender->id }}">

                                            {{ $gender->gender }}

                                        </option>

                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-8">
                                    <input type="email"
                                        name="email"
                                        class="form-control">

                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Telephone</label>
                                <div class="col-sm-8">
                                    <input type="text"
                                        name="telephone"
                                        class="form-control">

                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-sm-3 col-form-label">Alamat</label>
                                <div class="col-sm-8">
                                    <textarea name="address"
                                        class="form-control"
                                        rows="3"></textarea>

                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="card-footer">

                <button class="btn btn-primary">

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

@stop