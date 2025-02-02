<!DOCTYPE html>
<html>
<head>
    <title>Receipt #{{ $receipt->receipts_id }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .receipt-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .receipt-header {
            text-align: center;
            border-bottom: 2px solid #4a90e2;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .receipt-header h1 {
            margin: 0;
            font-size: 2rem;
            letter-spacing: 2px;
        }
        .company-details {
            text-align: center;
            margin-top: 5px;
            font-size: 0.9rem;
            line-height: 1.4;
        }
        .receipt-info {
            margin-bottom: 20px;
        }
        .receipt-info p {
            margin: 5px 0;
        }
        h3 {
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
        .total-amount {
            text-align: right;
            font-size: 1.2rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- Kop Tanda Terima -->
        <div class="receipt-header">
            <h1>RECEIPT</h1>
            <div class="company-details">
                <p>Your Company Name</p>
                <p>1234 Street Address, City, Country</p>
                <p>Phone: (123) 456-7890 | Email: info@company.com</p>
            </div>
        </div>

        <!-- Informasi Tanda Terima -->
        <div class="receipt-info">
            <p><strong>Receipt #:</strong> {{ $receipt->receipts_id }}</p>
            <p><strong>Order ID:</strong> {{ $receipt->invoice->order_id }}</p>
            <p><strong>Payment Date:</strong> {{ \Carbon\Carbon::parse($receipt->payment_date)->format('d-m-Y') }}</p>
            <p><strong>Total Amount:</strong> Rp {{ number_format($receipt->amount, 0, ',', '.') }}</p>
        </div>

        <!-- Detail Order -->
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
    </div>
</body>
</html>
