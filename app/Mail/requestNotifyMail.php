<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class requestNotifyMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $requestNumber;
    protected $userName;

    /**
     * Create a new message instance.
     */
    public function __construct($requestNumber,$userName)
    {
        $this->requestNumber = $requestNumber;
        $this->userName = $userName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Request '.  $this->requestNumber.' Closed',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'requestNotifyMail',with:["requestNumber"=> $this->requestNumber,"userName"=> $this->userName]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
