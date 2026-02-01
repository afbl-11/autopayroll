<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeaveMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public $leave
    )
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Leave Status',
        );
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {
        $subject = $this->leave->status === 'approved'
            ? 'Leave Request Approved'
            : 'Leave Request Update';

        return $this
            ->subject($subject)
            ->view('emails.leave-status');
    }
}
