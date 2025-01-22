<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-muted">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col text-end">
                                    <a href="{{ route('orders.create') }}" class="btn btn-primary">
                                        {{ __('Create New Order') }}
                                    </a>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>{{ __('Order ID') }}</th>
                                            <th>{{ __('Customer') }}</th>
                                            <th>{{ __('Total Price') }}</th>
                                            <th class="text-center">{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($orders as $order)
                                            <tr>
                                                <td>{{ $order->order_id }}</td>
                                                <td>{{ $order->customer->name }}</td>
                                                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#orderDetailsModal{{ $order->order_id }}">
                                                        <i class="bi bi-eye"></i> {{ __('View') }}
                                                    </button>
                                                    <a href="{{ route('orders.edit', $order->order_id) }}" class="btn btn-warning btn-sm">
                                                        <i class="bi bi-pencil"></i> {{ __('Edit') }}
                                                    </a>
                                                    <form action="{{ route('orders.destroy', $order->order_id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('Are you sure?') }}');">
                                                            {{ __('Delete') }}
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                            <!-- Modal for Order Details -->
                                            <div class="modal fade" id="orderDetailsModal{{ $order->order_id }}" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="orderDetailsModalLabel">{{ __('Order Items for Order #') }}{{ $order->order_id }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <ul>
                                                                @foreach ($order->orderItems as $item)
                                                                    <li>
                                                                        {{ __('Product:') }} {{ $item->product->name }} | {{ __('Quantity:') }} {{ $item->quantity }} | {{ __('Price:') }} Rp {{ number_format($item->price, 0, ',', '.') }}
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">{{ __('No orders found.') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <div>{{ $orders->links('vendor.pagination.bootstrap-5') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
