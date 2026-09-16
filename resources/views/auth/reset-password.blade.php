@extends('adminlte::auth.auth-page')

@section('auth_header', 'Reset Password')

@section('auth_body')

<form action="{{ $resetUrl }}" method="POST">

    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="form-group">
        <label for="password">Password Baru</label>
        <div class="input-group">
            <input
                type="password"
                name="password"
                id="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="Masukkan password baru"
                required>

            <div class="input-group-append">
                <button type="button"
                    class="btn btn-outline-secondary toggle-password"
                    data-target="#password">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            @error('password')
            <span class="invalid-feedback">
                {{ $message }}
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="password_confirmation">
            Konfirmasi Password
        </label>
        <div class="input-group">
            <input
                type="password"
                name="password_confirmation"
                id="password_confirmation"
                class="form-control"
                placeholder="Ulangi password baru"
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

    <button type="submit" class="btn btn-primary btn-block">
        Reset Password
    </button>

</form>

@endsection

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
