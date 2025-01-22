<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receipt;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $receipts = Receipt::with(['invoice.order.orderItems.product'])->paginate(10);
        return view('receipts.index', compact('receipts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $invoices = Invoice::all();
        return view('receipts.create', compact('invoices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,invoice_id',
            'payment_date' => 'required|date',
        ]);

        $invoice = Invoice::with('order')->findOrFail($request->invoice_id);

        // Use total_price from the related order
        $receipt = Receipt::create([
            'invoice_id' => $validated['invoice_id'],
            'payment_date' => $validated['payment_date'],
            'amount' => $invoice->order->total_price,
        ]);

        return redirect()->route('receipts.index')->with('success', 'Receipt created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $invoices = Invoice::all();
        return view('receipts.edit', compact('receipt', 'invoices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,invoice_id',
            'payment_date' => 'required|date',
            'amount' => 'required|integer|min:0',
        ]);

        $receipt->update($validated);

        return redirect()->route('receipts.index')->with('success', 'Receipt updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $receipt->delete();
        return redirect()->route('receipts.index')->with('success', 'Receipt deleted successfully.');
    }

    public function download(Receipt $receipt)
    {
        $invoice = $receipt->invoice->load('order.orderItems.product');
        $pdf = Pdf::loadView('receipts.pdf', compact('receipt'));
        return $pdf->download("Receipt_{$receipt->id}.pdf");
    }
}
