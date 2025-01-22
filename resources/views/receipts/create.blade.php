<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-muted">
            {{ __('Create Receipt') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('receipts.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="invoice_id" class="form-label">{{ __('Invoice') }}</label>
                                    <select name="invoice_id" id="invoice_id" class="form-select" required>
                                        <option value="">{{ __('Select an invoice') }}</option>
                                        @foreach ($invoices as $invoice)
                                            <option value="{{ $invoice->invoice_id }}" data-price="{{ $invoice->order->total_price }}">
                                                Invoice #{{ $invoice->invoice_id }} - Rp {{ number_format($invoice->order->total_price, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="payment_date" class="form-label">{{ __('Payment Date') }}</label>
                                    <input type="date" name="payment_date" id="payment_date" class="form-control" value="{{ old('payment_date') }}" required>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-success">{{ __('Save Receipt') }}</button>
                                    <a href="{{ route('receipts.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('invoice_id').addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            document.getElementById('amount').value = price ? `Rp ${Number(price).toLocaleString('id-ID')}` : '';
        });
    </script>
</x-app-layout>
