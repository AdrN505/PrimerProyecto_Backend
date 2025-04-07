<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Incidencia;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;
    public $subject;
    public $cuerpoMensaje;
    public $colorTitulo;
    /**
     * Create a new message instance.
     */
    public function __construct($subject,$cuerpoMensaje,$colorTitulo)
    {
        $this->subject = $subject;
        $this->cuerpoMensaje = $cuerpoMensaje;
        $this->colorTitulo = $colorTitulo;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.incidenciaMail',
            with: [
                'cuerpoMensaje' => $this->cuerpoMensaje,
                'colorTitulo' => $this->colorTitulo
            ],
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
