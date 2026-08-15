<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Akun Asteriia Kinderhaus</title>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; color:#333">

    <h2>Halo {{ $name }},</h2>

    <p>
        Selamat datang di <strong>Asteriia Kinderhaus</strong>.
    </p>

    <p>
        Akun Anda telah berhasil dibuat.
    </p>

    <table cellpadding="8" cellspacing="0" border="1" style="border-collapse:collapse">
        <tr>
            <td><strong>Role</strong></td>
            <td>{{ $role }}</td>
        </tr>

        <tr>
            <td><strong>Username</strong></td>
            <td>{{ $username }}</td>
        </tr>

        <tr>
            <td><strong>Password</strong></td>
            <td>{{ $password }}</td>
        </tr>
    </table>

    <br>

    <p>
        Silakan login menggunakan username dan password di atas.
    </p>

    <p>
        Demi keamanan, segera ubah password Anda melalui menu
        <strong>Change Password</strong> setelah berhasil login.
    </p>

    <br>

    <p>
        Terima kasih.
    </p>

    <p>
        <strong>Asteriia Kinderhaus</strong>
    </p>

</body>

</html>