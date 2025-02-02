<?php

namespace App\Mail;

use App\Models\Receipt;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReceiptMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $receipt;

    /**
     * Create a new message instance.
     */
    public function __construct(Receipt $receipt)
    {
        $this->receipt = $receipt;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        // Generate PDF
        $pdf = Pdf::loadView('receipts.pdf', ['receipt' => $this->receipt]);
        $pdfContent = $pdf->output();

        // Attach PDF to email
        return $this->subject('Your Payment Receipt')
                    ->view('emails.receipt')
                    ->with([
                        'receipt' => $this->receipt,
                    ])
                    ->attachData($pdfContent, "Receipt_{$this->receipt->id}.pdf", [
                        'mime' => 'application/pdf',
                    ]);
    }
}
