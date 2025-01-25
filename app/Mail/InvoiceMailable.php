<?php

namespace App\Mail;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;

    /**
     * Create a new message instance.
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        // Generate PDF
        $pdf = Pdf::loadView('invoices.pdf', ['invoice' => $this->invoice]);
        $pdfContent = $pdf->output();

        // Attach PDF to email
        return $this->subject('Your Invoice')
                    ->view('emails.invoice')
                    ->with([
                        'invoice' => $this->invoice,
                    ])
                    ->attachData($pdfContent, "Invoice_{$this->invoice->invoice_id}.pdf", [
                        'mime' => 'application/pdf',
                    ]);
    }
}
