@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ __('Edit Order') }}</h2>

        <form action="{{ route('orders.update', $order->order_id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Customer Selection -->
            <div class="mb-4">
                <label for="customer_id" class="block text-gray-700 font-semibold mb-1">{{ __('Customer') }}</label>
                <select name="customer_id" id="customer_id" class="w-full border rounded-lg px-4 py-2 @error('customer_id') border-red-500 @enderror" required>
                    <option value="" disabled>{{ __('-- Pilih Customer --') }}</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->customer_id }}" {{ $customer->customer_id == $order->customer_id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
                @error('customer_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Order Items -->
            <div id="products">
                @foreach ($order->orderItems as $index => $item)
                    <div class="product mb-4" id="product-{{ $index }}">
                        <label for="products[{{ $index }}][product_id]" class="block text-gray-700 font-semibold mb-1">{{ __('Product') }}</label>
                        <select name="products[{{ $index }}][product_id]" class="w-full border rounded-lg px-4 py-2">
                            <option value="" disabled>{{ __('-- Pilih Product --') }}</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->product_id }}" {{ $product->product_id == $item->product_id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                        <label for="products[{{ $index }}][quantity]" class="block text-gray-700 font-semibold mb-1 mt-2">{{ __('Quantity') }}</label>
                        <input type="number" name="products[{{ $index }}][quantity]" class="w-full border rounded-lg px-4 py-2" value="{{ $item->quantity }}" required>
                        <button type="button" class="btn btn-danger btn-sm mt-2 remove-product" onclick="removeItem({{ $index }})">{{ __('Remove') }}</button>
                    </div>
                @endforeach
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
                    {{ __('Update Order') }}
                </button>
                <a href="{{ route('orders.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    let productIndex = {{ count($order->orderItems) }};

    document.getElementById('add-product').addEventListener('click', () => {
        const productsDiv = document.getElementById('products');
        const newProductDiv = document.createElement('div');
        newProductDiv.classList.add('product', 'mb-4');
        newProductDiv.id = `product-${productIndex}`;
        newProductDiv.innerHTML = `
            <label for="products[${productIndex}][product_id]" class="block text-gray-700 font-semibold mb-1">{{ __('Product') }}</label>
            <select name="products[${productIndex}][product_id]" class="w-full border rounded-lg px-4 py-2">
                @foreach ($products as $product)
                    <option value="{{ $product->product_id }}">{{ $product->name }}</option>
                @endforeach
            </select>
            <label for="products[${productIndex}][quantity]" class="block text-gray-700 font-semibold mb-1 mt-2">{{ __('Quantity') }}</label>
            <input type="number" name="products[${productIndex}][quantity]" class="w-full border rounded-lg px-4 py-2" required>
            <button type="button" class="btn btn-danger btn-sm mt-2 remove-product" onclick="removeItem(${productIndex})">{{ __('Remove') }}</button>
        `;
        productsDiv.appendChild(newProductDiv);
        productIndex++;
    });

    function removeItem(index) {
        document.getElementById(`product-${index}`).remove();
    }
</script>
@endsection
