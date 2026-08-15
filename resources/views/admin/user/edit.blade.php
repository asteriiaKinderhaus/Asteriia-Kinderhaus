@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
<h1>Edit User</h1>
@stop

@section('content')

<div class="card card-primary">

    <div class="card-header">
        <h3 class="card-title">Form Edit User</h3>
    </div>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card-body">

            {{-- Nama --}}
            <div class="form-group mb-3 row">
                <label class="col-sm-2 col-form=label">Nama</label>
                <div class="col-sm-8">
                    <input type="text"
                        class="form-control"
                        value="{{ $user->name }}"
                        readonly>
                </div>
            </div>

            {{-- Username --}}
            <div class="form-group mb-3 row">
                <label class="col-sm-2 col-form=label">Username</label>
                <div class="col-sm-8">
                    <input type="text"
                        name="username"
                        class="form-control @error('username') is-invalid @enderror"
                        value="{{ old('username', $user->username) }}"
                        required>

                    @error('username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            {{-- Password --}}
            <div class="form-group mb-3 row">
                <label class="col-sm-2 col-form-label">Password Baru</label>
                <div class="col-sm-8">
                    <input type="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Kosongkan jika tidak diubah">

                    <small class="text-muted">
                        Kosongkan apabila password tidak ingin diubah.
                    </small>

                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            {{-- Konfirmasi Password --}}
            <div class="form-group mb-3 row">
                <label class="col-sm-2 col-form-label">Konfirmasi Password</label>
                <div class="col-sm-8">
                    <input type="password"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="Konfirmasi Password Baru">
                </div>
            </div>

            {{-- Role --}}
            <div class="form-group mb-3 row">
                <label class="col-sm-2 col-form-label">Role</label>
                <div class="col-sm-8">
                    <input type="text"
                        class="form-control"
                        value="{{ $user->role->nama }}"
                        readonly>
                </div>
            </div>

            {{-- Email --}}
            <div class="form-group mb-3 row">
                <label class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-8">
                    <input type="text"
                        class="form-control"
                        name="email"
                        value="{{ old('email', $user->email) }}">
                </div>
            </div>


            {{-- Status --}}
            <div class="form-group mb-3 row">
                <label class="col-sm-2 col-form-label">Status User</label>
                <div class="col-sm-2 col-form-label">
                    <select name="status"
                        class="form-control @error('status') is-invalid @enderror">

                        <option value="1"
                            {{ old('status', $user->status) == 1 ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="0"
                            {{ old('status', $user->status) == 0 ? 'selected' : '' }}>
                            Non Aktif
                        </option>

                    </select>

                    @error('status')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

        </div>

        <div class="card-footer">

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Simpan
            </button>

            <a href="{{ route('admin.users.index') }}"
                class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>

        </div>

    </form>

</div>

@stop