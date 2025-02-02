@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('Create Invoice') }}</h2>

        <form action="{{ route('invoices.store') }}" method="POST">
            @csrf

            <!-- Order Selection -->
            <div class="mb-4">
                <label for="order_id" class="block text-gray-700 font-semibold mb-1">{{ __('Order') }}</label>
                <select name="order_id" id="order_id" class="w-full border rounded-lg px-4 py-2 @error('order_id') border-red-500 @enderror" required>
                    <option value="" selected disabled>{{ __('-- Select an Order --') }}</option>
                    @foreach ($orders as $order)
                        <option value="{{ $order->order_id }}" {{ old('order_id') == $order->order_id ? 'selected' : '' }}>
                            Order #{{ $order->order_id }} - Total: {{ number_format($order->total_price, 2) }}
                        </option>
                    @endforeach
                </select>
                @error('order_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label for="status" class="block text-gray-700 font-semibold mb-1">{{ __('Status') }}</label>
                <select name="status" id="status" class="w-full border rounded-lg px-4 py-2 @error('status') border-red-500 @enderror" required>
                    <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>{{ __('Unpaid') }}</option>
                    <option value="1" {{ old('status') === '1' ? 'selected' : '' }}>{{ __('Paid') }}</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Due Date -->
            <div class="mb-4">
                <label for="due_date" class="block text-gray-700 font-semibold mb-1">{{ __('Due Date') }}</label>
                <input type="date" name="due_date" id="due_date" class="w-full border rounded-lg px-4 py-2 @error('due_date') border-red-500 @enderror" value="{{ old('due_date') }}" required>
                @error('due_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    {{ __('Save Invoice') }}
                </button>
                <a href="{{ route('invoices.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
