<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>

<body>

    <h2>Reset Password</h2>

    <p>Halo {{ $name }},</p>

    <p>
        Kami menerima permintaan untuk mengatur ulang password akun
        Asteriia Kinderhaus Anda.
    </p>

    <p>
        Silakan klik tombol di bawah untuk membuat password baru:
    </p>

    <p>
        <a
            href="{{ $resetUrl }}"
            style="
                display:inline-block;
                padding:10px 20px;
                background:#4f46e5;
                color:white;
                text-decoration:none;
                border-radius:5px;
            ">
            Reset Password
        </a>
    </p>

    <p>
        Link ini hanya berlaku selama {{ $expiresIn }} menit.
    </p>

    <p>
        Jika Anda tidak meminta reset password, abaikan email ini.
    </p>

    <p>
        Salam,<br>
        <strong>Asteriia Kinderhaus</strong>
    </p>

</body>

</html>