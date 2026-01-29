<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\User;
use App\Models\School;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request; // Jangan lupa import Request
use App\Mail\AccountApproved;

class RegistrationController extends Controller
{
    public function index()
    {
        $registrations = Registration::where('status', 'verified')->latest()->get();
        return view('admin.registrations.index', compact('registrations'));
    }

    public function createAccount($id)
    {
        $reg = Registration::findOrFail($id);

        if ($reg->status !== 'verified') {
            return back()->with('error', 'Data status tidak valid.');
        }

        $password = Str::random(10);

        $user = User::create([
            'name' => $reg->school_name,
            'email' => $reg->email,
            'password' => Hash::make($password),
            'role' => 'school',
        ]);

        School::create([
            'user_id' => $user->id,
            'name' => $reg->school_name,
            'address' => $reg->address,
            'jenjang' => $reg->jenjang,
            'npsn' => $reg->npsn,
        ]);

        $reg->update(['status' => 'approved']);

        try {
            Mail::to($user->email)->send(new AccountApproved($user, $password));
        } catch (\Exception $e) {
            return back()->with('warning', 'Akun dibuat tapi email gagal. Password: ' . $password);
        }

        return back()->with('success', 'Akun sekolah berhasil diterbitkan!');
    }

    // Kembalikan ke Validator 
    public function rejectToValidator(Request $request, $id)
    {
        $request->validate(['admin_note' => 'required|string']);

        $reg = Registration::findOrFail($id);

        // Simpan catatan admin 
        $reg->update([
            'status' => 'pending',
            'admin_notes' => 'Catatan Admin: ' . $request->admin_note . ' (Mohon dicek ulang)'
        ]);

        return back()->with('success', 'Berkas dikembalikan ke Validator untuk pengecekan ulang.');
    }
}
