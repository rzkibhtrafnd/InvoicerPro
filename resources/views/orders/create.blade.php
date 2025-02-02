@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('Create New Order') }}</h2>

        <form action="{{ route('orders.store') }}" method="POST">
            @csrf

            <!-- Customer Selection -->
            <div class="mb-4">
                <label for="customer_id" class="block text-gray-700 font-semibold mb-1">{{ __('Customer') }}</label>
                <select name="customer_id" id="customer_id" class="w-full border rounded-lg px-4 py-2 @error('customer_id') border-red-500 @enderror" required>
                    <option value="" selected disabled>{{ __('-- Pilih Customer --') }}</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->customer_id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
                @error('customer_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Product Selection -->
            <div id="products">
                <div class="product mb-4">
                    <label for="products[0][product_id]" class="block text-gray-700 font-semibold mb-1">{{ __('Product') }}</label>
                    <select name="products[0][product_id]" class="w-full border rounded-lg px-4 py-2">
                        <option value="" selected disabled>{{ __('-- Pilih Product --') }}</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->product_id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                    <label for="products[0][quantity]" class="block text-gray-700 font-semibold mb-1 mt-2">{{ __('Quantity') }}</label>
                    <input type="number" name="products[0][quantity]" class="w-full border rounded-lg px-4 py-2" required>
                    <button type="button" class="btn btn-danger btn-sm mt-2 remove-product">{{ __('Remove') }}</button>
                </div>
            </div>

            <!-- Add Product Button -->
            <div class="flex justify-between mb-4">
                <button type="button" id="add-product" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                    {{ __('Add Another Product') }}
                </button>
            </div>

            <!-- Submit Button -->
            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                    {{ __('Create Order') }}
                </button>
                <a href="{{ route('orders.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    let productIndex = 1;

    document.getElementById('add-product').addEventListener('click', () => {
        const productsDiv = document.getElementById('products');
        const newProductDiv = document.createElement('div');
        newProductDiv.classList.add('product', 'mb-4');
        newProductDiv.innerHTML = `
            <label for="products[${productIndex}][product_id]" class="block text-gray-700 font-semibold mb-1">{{ __('Product') }}</label>
            <select name="products[${productIndex}][product_id]" class="w-full border rounded-lg px-4 py-2">
                @foreach ($products as $product)
                    <option value="{{ $product->product_id }}">{{ $product->name }}</option>
                @endforeach
            </select>
            <label for="products[${productIndex}][quantity]" class="block text-gray-700 font-semibold mb-1 mt-2">{{ __('Quantity') }}</label>
            <input type="number" name="products[${productIndex}][quantity]" class="w-full border rounded-lg px-4 py-2" required>
            <button type="button" class="btn btn-danger btn-sm mt-2 remove-product">{{ __('Remove') }}</button>
        `;
        productsDiv.appendChild(newProductDiv);
        productIndex++;
    });

    document.getElementById('products').addEventListener('click', (event) => {
        if (event.target.classList.contains('remove-product')) {
            event.target.closest('.product').remove();
        }
    });
</script>
@endsection
