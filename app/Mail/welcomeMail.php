<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class welcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $userEmail;
    protected $userPassword;
    protected $userName;
    protected $userRole;

  
    public function __construct($userEmail,$userName,$userPassword,$userRole)
    {
        $this->userEmail = $userEmail;
        $this->userName = $userName;
        $this->userPassword = $userPassword;
        $this->userRole = $userRole;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to CMS',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'welcome',with:([
                'userEmail'=> $this->userEmail,
                'userName'=> $this->userName,
                'userPassword'=> $this->userPassword,
                'userRole'=> $this->userRole])
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
