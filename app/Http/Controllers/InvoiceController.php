<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMailable; // Pastikan Anda sudah membuat Mailable ini

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with('order')->paginate(10);
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $orders = Order::all();
        return view('invoices.create', compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,order_id',
            'status' => 'required|integer|in:0,1',
            'due_date' => 'required|date',
        ]);

        // Buat Invoice baru
        $invoice = Invoice::create($validated);

        // Ambil informasi customer dari order terkait
        $order = $invoice->order;
        $customer = $order->customer;
        // Generate PDF Invoice
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
        $pdfContent = $pdf->output();

        // Kirim email dengan lampiran PDF
        Mail::to($customer->email)->send(new InvoiceMailable($invoice));

        return redirect()->route('invoices.index')->with('success', 'Invoice created and email sent successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $orders = Order::all();
        $invoice = Invoice::findOrFail($id);
        return view('invoices.edit', compact('invoice', 'orders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,order_id',
            'status' => 'required|integer|in:0,1',
            'due_date' => 'required|date',
        ]);

        $invoice = Invoice::findOrFail($id);
        $invoice->update($validated);

        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }

    /**
     * Toggle invoice status.
     */
    public function toggleStatus(Invoice $invoice)
    {
        $invoice->status = !$invoice->status;
        $invoice->save();

        return redirect()->route('invoices.index')->with('success', 'Invoice status updated.');
    }

    /**
     * Download invoice as PDF.
     */
    public function downloadInvoice(Invoice $invoice)
    {
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));

        return $pdf->download("Invoice_{$invoice->id}.pdf");
    }
}
