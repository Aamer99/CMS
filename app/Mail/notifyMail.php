<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class notifyMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $senderEmail;
    protected $senderName;
    protected $message;

    public function __construct($senderName,$senderEmail,$message)
    {
        $this->senderEmail = $senderEmail;
        $this->senderName = $senderName;
        $this->message = $message;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Message from '. $this->senderName,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
           
            view:'NotifyMail',with:["senderMessage"=>$this->message,"senderName"=> $this->senderName,"senderEmail"=> $this->senderEmail],
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
