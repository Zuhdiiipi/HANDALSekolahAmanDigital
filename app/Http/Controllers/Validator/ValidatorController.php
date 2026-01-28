<?php

namespace App\Http\Controllers\Validator;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountRejected;

class ValidatorController extends Controller
{
    public function index()
    {
        // Validator hanya melihat yang statusnya 'pending'
        $registrations = Registration::where('status', 'pending')->latest()->get();
        return view('validator.dashboard', compact('registrations'));
    }

    public function show($id)
    {
        $registration = Registration::findOrFail($id);
        return view('validator.show', compact('registration'));
    }

    // --- LOGIKA BARU: APPROVE HANYA VERIFIKASI ---
    public function approve($id)
    {
        $reg = Registration::findOrFail($id);

        // Ubah status jadi 'verified' agar masuk ke dashboard Admin
        $reg->update(['status' => 'verified']);

        return redirect()->route('validator.dashboard')
            ->with('success', 'Data telah diverifikasi dan diteruskan ke Admin untuk pembuatan akun.');
    }

    // --- LOGIKA REJECT (TETAP SAMA) ---
    public function reject(Request $request, $id)
    {
        $request->validate(['reason' => 'required|string']);
        $reg = Registration::findOrFail($id);

        $reg->update([
            'status' => 'rejected',
            'admin_notes' => $request->reason
        ]);

        // Kirim Email Penolakan
        try {
            Mail::to($reg->email)->send(new AccountRejected($reg, $request->reason));
        } catch (\Exception $e) {
            return redirect()->route('validator.dashboard')
                ->with('warning', 'Ditolak, tapi email gagal terkirim.');
        }

        return redirect()->route('validator.dashboard')->with('success', 'Pendaftaran ditolak.');
    }
}
