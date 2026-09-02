@extends('adminlte::page')
@section('title','Tambah Siswa')

@section('content_header')
<h3>
    <i class="fas fa-chalkboard-teacher"></i>
    Tambah Peserta didik
</h3>
@stop

@section('content')
<div class="card">
    <div class="card-header bg-primary">
        <h3 class="card-title ">Form Peserta didik</h3>
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
    <form action="{{ route('admin.students.store') }}" method="POST">
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

                            <div class="form-group">
                                <label>NIS</label>

                                <input
                                    type="text"
                                    name="nis"
                                    value="{{ old('nis') }}"
                                    class="form-control">
                            </div>
                            <div class="form-group">

                                <label>Status</label>

                                <select name="status"
                                    class="form-control">

                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>

                                </select>

                            </div>

                        </div>

                    </div>

                </div>-->

                {{-- PERSONAL INFORMASI --}}
                <div class="col-md-12">

                    <div class="card card-outline card-success">

                        <div class="card-header">
                            <strong>Data peserta didik</strong>
                        </div>

                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nama Siswa</label>
                                <div class="col-sm-4">
                                    <input
                                        type="text"
                                        name="name"
                                        value="{{ old('name') }}"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nama panggilan</label>
                                <div class="col-sm-4">
                                    <input
                                        type="text"
                                        name="nickname"
                                        value="{{ old('nickname') }}"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Tempat Lahir</label>
                                <div class="col-sm-4">
                                    <input
                                        type="text"
                                        name="birth_place"
                                        value="{{ old('birth_place') }}"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Tanggal lahir</label>
                                <div class="col-sm-4"> <input
                                        type="date"
                                        name="birth_date"
                                        value="{{ old('birth_date') }}"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                <div class="col-sm-4">
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

                                <label class="col-sm-2 col-form-label">Orang Tua</label>
                                <div class="col-sm-4">
                                    <select
                                        name="parent_id"
                                        class="form-control @error('parent_id') is-invalid @enderror">

                                        <option value="">-- Pilih Orang Tua --</option>

                                        @foreach($parents as $parent)

                                        <option
                                            value="{{ $parent->id }}"
                                            @selected(old('parent_id')==$parent->id)>

                                            {{ $parent->name }}

                                        </option>

                                        @endforeach

                                    </select>

                                </div>
                            </div>

                            <!--<div class="form-group row">

                                <label class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-8">
                                    <select
                                        name="status"
                                        class="form-control">

                                        <option value="1">Aktif</option>

                                        <option value="0">Tidak Aktif</option>

                                    </select>
                                </div>
                            </div>-->
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

            <a href="{{ route('admin.parents.index') }}"
                class="btn btn-secondary">

                Kembali

            </a>

        </div>

    </form>

</div>

@stop