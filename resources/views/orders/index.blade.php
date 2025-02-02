@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">{{ __('Orders') }}</h2>
            <a href="{{ route('orders.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                <i class="fas fa-plus"></i> {{ __('Create New Order') }}
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="px-4 py-2">{{ __('Order ID') }}</th>
                        <th class="px-4 py-2">{{ __('Customer') }}</th>
                        <th class="px-4 py-2">{{ __('Total Price') }}</th>
                        <th class="px-4 py-2 text-center">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <!-- Order Row -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border-t">{{ $order->order_id }}</td>
                            <td class="px-4 py-2 border-t">{{ $order->customer->name }}</td>
                            <td class="px-4 py-2 border-t">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 border-t text-center">
                                <!-- Tombol View untuk Toggle Accordion -->
                                <button onclick="toggleAccordion('orderDetails{{ $order->order_id }}')" class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600">
                                    <i class="bi bi-eye"></i> {{ __('View') }}
                                </button>
                                <!-- Tombol Edit -->
                                <a href="{{ route('orders.edit', $order->order_id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600 ml-2">
                                    <i class="bi bi-pencil"></i> {{ __('Edit') }}
                                </a>
                                <!-- Tombol Delete -->
                                <form action="{{ route('orders.destroy', $order->order_id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}')" class="inline-block ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600">
                                        <i class="bi bi-trash"></i> {{ __('Delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Order Details Accordion -->
                        <tr id="orderDetails{{ $order->order_id }}" class="hidden">
                            <td colspan="4" class="px-4 py-2 border-t">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h3 class="text-lg font-bold text-gray-800 mb-2">{{ __('Order Items') }}</h3>
                                    <ul>
                                        @foreach ($order->orderItems as $item)
                                            <li class="mb-2">
                                                {{ __('Product:') }} {{ $item->product->name }} |
                                                {{ __('Quantity:') }} {{ $item->quantity }} |
                                                {{ __('Price:') }} Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <!-- Jika Tidak Ada Order -->
                        <tr>
                            <td colspan="4" class="text-center px-4 py-2 border-t text-muted">{{ __('No orders found.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6 mt-4">
            <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                <p class="text-sm text-gray-700">
                    {{ __('Showing') }}
                    <span class="font-medium">{{ $orders->firstItem() }}</span>
                    {{ __('to') }}
                    <span class="font-medium">{{ $orders->lastItem() }}</span>
                    {{ __('of') }}
                    <span class="font-medium">{{ $orders->total() }}</span>
                    {{ __('entries') }}
                </p>
                <div>
                    {{ $orders->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
