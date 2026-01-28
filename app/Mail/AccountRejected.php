<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Registration;

class AccountRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;
    public $reason;

    public function __construct(Registration $registration, $reason)
    {
        $this->registration = $registration;
        $this->reason = $reason;
    }

    public function build()
    {
        return $this->subject('Status Pendaftaran Sekolah - Perlu Perbaikan')
            ->view('emails.account_rejected');
    }
}
