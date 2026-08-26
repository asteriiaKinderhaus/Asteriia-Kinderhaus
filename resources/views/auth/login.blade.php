<x-guest-layout>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Username -->
        <div>
            <x-input-label for="username" :value="__('Username')" />

            <x-text-input
                id="username"
                class="block mt-1 w-full"
                type="text"
                name="username"
                :value="old('username')"
                required
                autofocus
                autocomplete="username" />

            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">

            <x-input-label
                for="password"
                :value="__('Password')" />

            <div style="position: relative; margin-top: 4px;">

                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    style="
                width: 100%;
                height: 42px;
                padding: 8px 45px 8px 12px;
                border: 1px solid #d1d5db;
                border-radius: 6px;
                box-sizing: border-box;
            ">

                <button
                    type="button"
                    id="togglePassword"
                    aria-label="Tampilkan password"
                    style="
                position: absolute;
                right: 8px;
                top: 50%;
                transform: translateY(-50%);
                width: 32px;
                height: 32px;
                padding: 0;
                border: none;
                background: transparent;
                color: #6b7280;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
            ">
                    <i class="fas fa-eye"></i>
                </button>

            </div>

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2" />

        </div>


        <!-- Forgot Password -->
        <!--<div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>-->
        <div class="col-md-6 text-left">
            <br>
            <a href="{{route('password.request') }}">
                Lupa Password?
            </a>
        </div>
        <!--</div>-->

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const password = document.getElementById('password');
            const toggle = document.getElementById('togglePassword');
            const icon = toggle.querySelector('i');

            toggle.addEventListener('click', function() {

                if (password.type === 'password') {

                    password.type = 'text';

                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');

                } else {

                    password.type = 'password';

                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');

                }

            });

        });
    </script>
</x-guest-layout>