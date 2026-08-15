@extends('adminlte::page')

@section('title','Tambah User')

@section('content_header')
<h1>Tambah User</h1>
@stop

@section('content')

<div class="card">

    <div class="card-header">
        <h3 class="card-title">
            Form Tambah User
        </h3>
    </div>

    <form action="{{ route('admin.users.store') }}"
          method="POST">

        @csrf

        <div class="card-body">

            <div class="form-group">
                <label>Username</label>

                <input
                    type="text"
                    name="username"
                    value="{{ old('username') }}"
                    class="form-control @error('username') is-invalid @enderror">

                @error('username')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

            </div>

            <div class="form-group">
                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror">

                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

            </div>

            <div class="form-group">
                <label>Role</label>

                <select
                    name="role_id"
                    class="form-control">

                    <option value="">-- Pilih Role --</option>

                    @foreach($roles as $role)

                    <option
                        value="{{ $role->id }}"
                        {{ old('role_id')==$role->id?'selected':'' }}>

                        {{ $role->nama }}

                    </option>

                    @endforeach

                </select>

            </div>

            <div class="form-group">
                <label>Status</label>

                <select
                    name="status"
                    class="form-control">

                    <option value="1">Aktif</option>
                    <option value="0">Non Aktif</option>

                </select>

            </div>

        </div>

        <div class="card-footer">

            <button class="btn btn-primary">

                <i class="fas fa-save"></i>

                Simpan

            </button>

            <a href="{{ route('admin.users.index') }}"
               class="btn btn-secondary">

                Kembali

            </a>

        </div>

    </form>

</div>

@stop