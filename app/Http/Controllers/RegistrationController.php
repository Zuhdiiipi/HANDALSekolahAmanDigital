<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\User;
use App\Models\School;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    public function approve($id)
    {
        $reg = Registration::findOrFail($id);
        $password = Str::random(10); // Generate password acak

        // 1. Buat User
        $user = User::create([
            'name' => $reg->school_name,
            'email' => $reg->email,
            'password' => Hash::make($password),
            'role' => 'school',
        ]);

        // 2. Buat Profil Sekolah
        School::create([
            'user_id' => $user->id,
            'name' => $reg->school_name,
            'address' => $reg->address,
        ]);

        // 3. Update Status Registrasi
        $reg->update(['status' => 'approved']);

        // TODO: Pemicu Queue Email di sini (SendAccountInfoJob::dispatch($user, $password))

        return back()->with('success', 'Akun berhasil dibuat dan email telah dijadwalkan untuk dikirim.');
    }
}