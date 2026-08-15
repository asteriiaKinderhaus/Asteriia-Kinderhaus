@extends('adminlte::auth.auth-page')

@section('auth_header', 'Reset Password')

@section('auth_body')

<form action="{{ $resetUrl }}" method="POST">

    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="form-group">
        <label for="password">Password Baru</label>

        <input
            type="password"
            name="password"
            id="password"
            class="form-control @error('password') is-invalid @enderror"
            placeholder="Masukkan password baru"
            required>

        @error('password')
        <span class="invalid-feedback">
            {{ $message }}
        </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="password_confirmation">
            Konfirmasi Password
        </label>

        <input
            type="password"
            name="password_confirmation"
            id="password_confirmation"
            class="form-control"
            placeholder="Ulangi password baru"
            required>
    </div>

    <button type="submit" class="btn btn-primary btn-block">
        Reset Password
    </button>

</form>

@endsection