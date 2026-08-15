<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lupa Password - Asteriia Kinderhaus</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <div class="min-h-screen flex items-center justify-center bg-gray-100">

        <div class="w-full max-w-md bg-white rounded-lg shadow p-6">

            <h2 class="text-xl font-bold text-center mb-2">
                Lupa Password
            </h2>

            <p class="text-sm text-gray-600 text-center mb-6">
                Masukkan email yang terdaftar pada akun Anda.
            </p>

            @if (session('status'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('status') }}
            </div>
            @endif

            @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">

                @csrf

                <div class="mb-4">

                    <label for="email" class="block text-sm font-medium mb-1">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full border rounded px-3 py-2">

                </div>

                <button
                    type="submit"
                    class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">
                    Kirim Link Reset Password
                </button>

            </form>

            <div class="text-center mt-4">

                <a href="{{ route('login') }}"
                    class="text-sm text-indigo-600 hover:underline">
                    Kembali ke Login
                </a>

            </div>

        </div>

    </div>

</body>

</html>