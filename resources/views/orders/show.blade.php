@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
  <div class="bg-white shadow-lg rounded-lg p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ __('Order Details') }}</h2>

    <div class="mb-6">
      <p class="mb-2"><strong>{{ __('Order ID:') }}</strong> {{ $order->order_id }}</p>
      <p class="mb-2"><strong>{{ __('Customer:') }}</strong> {{ $order->customer->name }}</p>
      <p class="mb-2"><strong>{{ __('Total Price:') }}</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
    </div>

    <h3 class="text-xl font-bold text-gray-800 mb-4">{{ __('Order Items') }}</h3>
    <div class="bg-gray-50 rounded-lg p-4">
      @if($order->orderItems->isNotEmpty())
        <ul class="space-y-3">
          @foreach ($order->orderItems as $item)
            <li class="border-b pb-2">
              <span class="font-medium">{{ __('Product:') }}</span> {{ $item->product->name }} <br>
              <span class="font-medium">{{ __('Quantity:') }}</span> {{ $item->quantity }} <br>
              <span class="font-medium">{{ __('Price:') }}</span> Rp {{ number_format($item->price, 0, ',', '.') }}
            </li>
          @endforeach
        </ul>
      @else
        <p class="text-gray-500">{{ __('No order items found.') }}</p>
      @endif
    </div>

    <div class="mt-6">
      <a href="{{ route('orders.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition-colors">
        {{ __('Back to Orders') }}
      </a>
    </div>
  </div>
</div>
@endsection
