<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class AccountApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;

    // Kita terima data user dan password mentah dari Controller
    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Selamat! Akun Sekolah Anda Telah Disetujui')
            ->view('emails.account_approved');
    }
}   
