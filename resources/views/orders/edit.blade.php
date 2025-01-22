<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-muted">{{ __('Edit Order') }}</h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary mb-3">{{ __('Back to Orders') }}</a>

                    <form action="{{ route('orders.update', $order->order_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="customer_id" class="form-label">Customer</label>
                            <select name="customer_id" id="customer_id" class="form-select" required>
                                <option value="">Select Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->customer_id }}" {{ $customer->customer_id == $order->customer_id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <h5 class="mt-3">Order Items</h5>
                        <div id="order-items">
                            @foreach ($order->orderItems as $index => $item)
                                <div class="order-item mb-3" id="order-item-{{ $index }}">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="products[{{ $index }}][product_id]" class="form-label">Product</label>
                                            <select name="products[{{ $index }}][product_id]" class="form-select" required>
                                                <option value="">Select Product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->product_id }}" {{ $product->product_id == $item->product_id ? 'selected' : '' }}>
                                                        {{ $product->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="products[{{ $index }}][quantity]" class="form-label">Quantity</label>
                                            <input type="number" name="products[{{ $index }}][quantity]" class="form-control" value="{{ $item->quantity }}" required min="1">
                                        </div>
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-danger remove-item-btn" onclick="removeItem({{ $index }})">
                                                <i class="bi bi-trash"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" class="btn btn-success mb-3" id="add-product-btn">Add Product</button>

                        <button type="submit" class="btn btn-primary">{{ __('Update Order') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let productIndex = {{ count($order->orderItems) }};

        // Function to remove product item
        function removeItem(index) {
            document.getElementById('order-item-' + index).remove();
        }

        // Function to add new product
        document.getElementById('add-product-btn').addEventListener('click', function() {
            const newProductHTML = `
                <div class="order-item mb-3" id="order-item-${productIndex}">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="products[${productIndex}][product_id]" class="form-label">Product</label>
                            <select name="products[${productIndex}][product_id]" class="form-select" required>
                                <option value="">Select Product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->product_id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="products[${productIndex}][quantity]" class="form-label">Quantity</label>
                            <input type="number" name="products[${productIndex}][quantity]" class="form-control" required min="1">
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-danger remove-item-btn" onclick="removeItem(${productIndex})">
                                <i class="bi bi-trash"></i> Remove
                            </button>
                        </div>
                    </div>
                </div>
            `;
            document.getElementById('order-items').insertAdjacentHTML('beforeend', newProductHTML);
            productIndex++;
        });
    </script>
</x-app-layout>
