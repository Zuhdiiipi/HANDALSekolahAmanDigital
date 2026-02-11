<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $school = $user->school; 

        return view('school.profile', compact('user', 'school'));
    }
    public function update(Request $request)
    {
        $user = Auth::user();
        $school = $user->school;

        $request->validate([
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'jenjang' => 'required|in:SD,SMP,SMA,SMK', 
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
        ]);
        $user->update([
            'email' => $request->email
        ]);
        $school->update([
            'jenjang' => $request->jenjang,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
        ]);

        return back()->with('success', 'Profil sekolah berhasil diperbarui.');
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed', 
        ]);
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }
        Auth::user()->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil diubah.');
    }
}
