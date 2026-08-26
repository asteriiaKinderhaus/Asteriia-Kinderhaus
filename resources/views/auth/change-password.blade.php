@extends('adminlte::page')

@section('title', 'Change Password')

@section('content_header')
<h1>Ubah Password</h1>
@stop

@section('content')

<div class="row">
    <div class="col-md-6">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Ubah Password</h3>
            </div>

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">

                    @if (session('status') === 'password-updated')
                    <div class="alert alert-success">
                        Password berhasil diubah.
                    </div>
                    @endif

                    <div class="form-group">
                        <label for="current_password">Password Saat Ini</label>

                        <div class="input-group">
                            <input type="password"
                                name="current_password"
                                id="current_password"
                                class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                placeholder="Masukkan password saat ini">

                            <div class="input-group-append">
                                <button type="button"
                                    class="btn btn-outline-secondary toggle-password"
                                    data-target="#current_password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('current_password', 'updatePassword')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">
                            Password Baru
                        </label>
                        <div class="input-group">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control
                                    @error('password', 'updatePassword')
                                        is-invalid
                                    @enderror"
                                autocomplete="new-password"
                                required>

                            <div class="input-group-append">
                                <button type="button"
                                    class="btn btn-outline-secondary toggle-password"
                                    data-target="#password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>

                            @error('password', 'updatePassword')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">
                            Konfirmasi Password Baru
                        </label>
                        <div class="input-group">
                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                class="form-control"
                                autocomplete="new-password"
                                required>

                            <div class="input-group-append">
                                <button type="button"
                                    class="btn btn-outline-secondary toggle-password"
                                    data-target="#password_confirmation">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>
                        Simpan Password
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

@stop
@section('js')

<script>
    $(document).on('click', '.toggle-password', function() {

        const button = $(this);
        const target = $(button.data('target'));
        const icon = button.find('i');

        if (target.attr('type') === 'password') {

            target.attr('type', 'text');

            icon.removeClass('fa-eye')
                .addClass('fa-eye-slash');

        } else {

            target.attr('type', 'password');

            icon.removeClass('fa-eye-slash')
                .addClass('fa-eye');
        }
    });
</script>

@stop