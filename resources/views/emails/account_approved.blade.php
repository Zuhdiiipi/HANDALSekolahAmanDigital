<!DOCTYPE html>
<html>
<head>
    <title>Akun Disetujui</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
        <h2 style="color: #0d6efd;">Selamat Datang di Handal Sekolah!</h2>
        <p>Halo <strong>{{ $user->name }}</strong>,</p>
        
        <p>Permohonan pendaftaran akun sekolah Anda telah disetujui oleh validator kami.</p>
        <p>Berikut adalah kredensial untuk login ke dalam sistem:</p>
        
        <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <p style="margin: 5px 0;"><strong>Email:</strong> {{ $user->email }}</p>
            <p style="margin: 5px 0;"><strong>Password:</strong> {{ $password }}</p>
        </div>

        <p>Silakan login melalui tautan berikut:</p>
        <a href="{{ route('login') }}" style="background-color: #0d6efd; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">Login Sekarang</a>

        <p style="margin-top: 30px; font-size: 12px; color: #777;">
            Harap segera ganti password Anda setelah berhasil login demi keamanan akun.
        </p>
    </div>
</body>
</html>