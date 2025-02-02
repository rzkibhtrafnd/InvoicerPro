<!DOCTYPE html>
<html>
<head>
    <title>Payment Receipt</title>
</head>
<body>
    <h2>Hello, {{ $receipt->invoice->order->customer->name }}</h2>
    <p>Thank you for your payment.</p>

    <p><strong>Receipt ID:</strong> {{ $receipt->id }}</p>
    <p><strong>Order ID:</strong> {{ $receipt->invoice->order_id }}</p>
    <p><strong>Payment Date:</strong> {{ \Carbon\Carbon::parse($receipt->payment_date)->format('d-m-Y') }}</p>
    <p><strong>Total Amount:</strong> Rp {{ number_format($receipt->amount, 0, ',', '.') }}</p>

    <p>Please find the attached receipt.</p>
    <p>Thank you for your business!</p>
</body>
</html>
