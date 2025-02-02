@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('Create Receipt') }}</h2>

        <form action="{{ route('receipts.store') }}" method="POST">
            @csrf

            <!-- Invoice Selection -->
            <div class="mb-4">
                <label for="invoice_id" class="block text-gray-700 font-semibold mb-1">{{ __('Invoice') }}</label>
                <select name="invoice_id" id="invoice_id" class="w-full border rounded-lg px-4 py-2 @error('invoice_id') border-red-500 @enderror" required>
                    <option value="" selected disabled>{{ __('-- Select an Invoice --') }}</option>
                    @foreach ($invoices as $invoice)
                        <option value="{{ $invoice->invoice_id }}" data-price="{{ $invoice->order->total_price }}">
                            Invoice #{{ $invoice->invoice_id }} - Rp {{ number_format($invoice->order->total_price, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
                @error('invoice_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Payment Date -->
            <div class="mb-4">
                <label for="payment_date" class="block text-gray-700 font-semibold mb-1">{{ __('Payment Date') }}</label>
                <input type="date" name="payment_date" id="payment_date" class="w-full border rounded-lg px-4 py-2 @error('payment_date') border-red-500 @enderror" value="{{ old('payment_date') }}" required>
                @error('payment_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex space-x-4">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                    {{ __('Save Receipt') }}
                </button>
                <a href="{{ route('receipts.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('invoice_id').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const price = selectedOption.getAttribute('data-price');
        document.getElementById('amount').value = price ? `Rp ${Number(price).toLocaleString('id-ID')}` : '';
    });
</script>
@endsection
