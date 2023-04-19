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

    protected $message;
    protected $senderName;
    protected $senderEmail;

    public function __construct($senderEmail,$senderName,$message)
    {
        $this->senderEmail = $senderEmail;
        $this->senderName = $senderName;
        $this->message = $message;
    }

    
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Notify Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'NotifyMail',with:["message"=> $this->message,"senderEmail"=> $this->senderEmail,"senderName"=>$this->senderName]
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
