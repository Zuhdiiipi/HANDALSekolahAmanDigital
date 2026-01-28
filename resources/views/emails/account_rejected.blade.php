<!DOCTYPE html>
<html>
<head><title>Pendaftaran Ditolak</title></head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h3>Halo, {{ $registration->school_name }}</h3>
    <p>Terima kasih telah mengajukan pendaftaran akun di Handal Sekolah.</p>
    
    <p>Setelah dilakukan verifikasi data, mohon maaf pendaftaran Anda <strong>belum dapat kami setujui</strong> saat ini.</p>
    
    <div style="background-color: #fee2e2; padding: 15px; border-radius: 5px; border-left: 5px solid #dc2626; margin: 20px 0;">
        <strong>Alasan Penolakan:</strong><br>
        <p style="margin-top: 5px;">{{ $reason }}</p>
    </div>

    <p>Silakan perbaiki data/dokumen Anda dan lakukan pendaftaran ulang melalui portal kami.</p>
    
    <p>Salam,<br>Tim Validator Handal</p>
</body>
</html>