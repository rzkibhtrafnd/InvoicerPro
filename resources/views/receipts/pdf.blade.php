<!DOCTYPE html>
<html>
<head>
    <title>Receipt #{{ $receipt->id }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        h1, h3 { margin: 0; }
        p { margin: 5px 0; }
    </style>
</head>
<body>
    <h1>Receipt #{{ $receipt->receipts_id }}</h1>
    <p><strong>Order ID:</strong> {{ $receipt->invoice->order_id }}</p>
    <p><strong>Payment Date:</strong> {{ \Carbon\Carbon::parse($receipt->payment_date)->format('d-m-Y') }}</p>
    <p><strong>Total Amount:</strong> Rp {{ number_format($receipt->amount, 0, ',', '.') }}</p>

    <h3>Order Details</h3>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($receipt->invoice->order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
