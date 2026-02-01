<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdjustmentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $adjustment;

    /**
     * Create a new message instance.
     */
    public function __construct($adjustment)
    {
        $this->adjustment = $adjustment;
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Adjustment Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {
        $subject = $this->adjustment->status === 'approved'
            ? '✅ Adjustment Approved'
            : '❌ Adjustment Request Update';

        return $this
            ->subject($subject)
            ->view('emails.adjustment-status');
    }
}
