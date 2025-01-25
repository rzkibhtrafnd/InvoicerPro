<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
</head>
<body>
    <h1>Invoice #{{ $invoice->invoice_id }}</h1>
    <p>Order ID: {{ $invoice->order_id }}</p>
    <p>Status: {{ $invoice->status == 1 ? 'Paid' : 'Unpaid' }}</p>
    <p>Due Date: {{ $invoice->due_date }}</p>
    <p>Thank you for your purchase!</p>
</body>
</html>
