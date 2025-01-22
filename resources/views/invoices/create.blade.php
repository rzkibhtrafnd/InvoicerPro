<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-muted">
            {{ __('Create Invoice') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('invoices.store') }}" method="POST">
                                @csrf

                                <!-- Order Selection -->
                                <div class="mb-3">
                                    <label for="order_id" class="form-label">{{ __('Order') }}</label>
                                    <select name="order_id" id="order_id" class="form-select @error('order_id') is-invalid @enderror" required>
                                        <option value="">{{ __('Select an order') }}</option>
                                        @foreach ($orders as $order)
                                            <option value="{{ $order->order_id }}" {{ old('order_id') == $order->order_id ? 'selected' : '' }}>
                                                Order #{{ $order->order_id }} - Total: {{ number_format($order->total_price, 2) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('order_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="mb-3">
                                    <label for="status" class="form-label">{{ __('Status') }}</label>
                                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>{{ __('Unpaid') }}</option>
                                        <option value="1" {{ old('status') === '1' ? 'selected' : '' }}>{{ __('Paid') }}</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Due Date -->
                                <div class="mb-3">
                                    <label for="due_date" class="form-label">{{ __('Due Date') }}</label>
                                    <input type="date" name="due_date" id="due_date" class="form-control @error('due_date') is-invalid @enderror" value="{{ old('due_date') }}" required>
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-success">
                                        {{ __('Save Invoice') }}
                                    </button>
                                    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
                                        {{ __('Cancel') }}
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
