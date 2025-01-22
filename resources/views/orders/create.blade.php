<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-muted">
            {{ __('Create New Order') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('orders.store') }}" method="POST">
                                @csrf

                                <!-- Customer Selection -->
                                <div class="mb-3">
                                    <label for="customer_id" class="form-label">{{ __('Customer') }}</label>
                                    <select name="customer_id" id="customer_id" class="form-select @error('customer_id') is-invalid @enderror" required>
                                        <option value="" selected disabled>{{ __('-- Select Customer --') }}</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->customer_id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Product Selection -->
                                <div id="products">
                                    <div class="product mb-3">
                                        <label for="products[0][product_id]" class="form-label">{{ __('Product') }}</label>
                                        <select name="products[0][product_id]" class="form-select">
                                            @foreach ($products as $product)
                                                <option value="{{ $product->product_id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="products[0][quantity]" class="form-label mt-2">{{ __('Quantity') }}</label>
                                        <input type="number" name="products[0][quantity]" class="form-control" required>
                                        <button type="button" class="btn btn-danger btn-sm mt-2 remove-product" style="display: none;">{{ __('Remove') }}</button>
                                    </div>
                                </div>

                                <!-- Add Product Button -->
                                <div class="d-flex justify-content-between">
                                    <button type="button" id="add-product" class="btn btn-secondary mb-3">
                                        {{ __('Add Another Product') }}
                                    </button>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-success">
                                        {{ __('Create Order') }}
                                    </button>
                                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">
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

    <script>
        let productIndex = 1;

        document.getElementById('add-product').addEventListener('click', () => {
            const productsDiv = document.getElementById('products');
            const newProductDiv = document.createElement('div');
            newProductDiv.classList.add('product', 'mb-3');
            newProductDiv.innerHTML = `
                <label for="products[${productIndex}][product_id]" class="form-label">Product</label>
                <select name="products[${productIndex}][product_id]" class="form-select">
                    @foreach ($products as $product)
                        <option value="{{ $product->product_id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                <label for="products[${productIndex}][quantity]" class="form-label mt-2">Quantity</label>
                <input type="number" name="products[${productIndex}][quantity]" class="form-control" required>
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
</x-app-layout>
