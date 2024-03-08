<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class DeliveryTicket extends Mailable
{
    use Queueable, SerializesModels;

    
    public $resume,$file,$name;
    /**
     * Create a new message instance.
     */
    public function __construct($resume,$file,$name)
    {
        $this->resume = $resume;
        $this->file = $file;
        $this->name = $name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Blue Star Packing customer ".$this->resume['customer']." Shipping Receipt #".$this->resume['ticketNumber'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.delivery.ticket',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->file, $this->resume['ticketNumber']."DeliveryTicket.pdf")->withMime('application/pdf'),
        ];
    }
}
