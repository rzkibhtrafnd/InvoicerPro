@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">{{ __('Receipts') }}</h2>
            <a href="{{ route('receipts.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                {{ __('Add New Receipt') }}
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="px-4 py-2">{{ __('Receipt ID') }}</th>
                        <th class="px-4 py-2">{{ __('Order ID') }}</th>
                        <th class="px-4 py-2">{{ __('Payment Date') }}</th>
                        <th class="px-4 py-2">{{ __('Total Amount') }}</th>
                        <th class="px-4 py-2 text-center">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($receipts as $receipt)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border-t">{{ $receipt->receipts_id }}</td>
                            <td class="px-4 py-2 border-t">{{ $receipt->invoice->order_id }}</td>
                            <td class="px-4 py-2 border-t">{{ \Carbon\Carbon::parse($receipt->payment_date)->format('d-m-Y') }}</td>
                            <td class="px-4 py-2 border-t">Rp {{ number_format($receipt->amount, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 border-t text-center">
                                <a href="{{ route('receipts.download', $receipt) }}" class="bg-green-500 text-white px-3 py-1 rounded-lg hover:bg-green-600">
                                    {{ __('Download PDF') }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center px-4 py-2 border-t text-gray-500">{{ __('No paid receipts found.') }}</td>
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
                    <span class="font-medium">{{ $receipts->firstItem() }}</span>
                    {{ __('to') }}
                    <span class="font-medium">{{ $receipts->lastItem() }}</span>
                    {{ __('of') }}
                    <span class="font-medium">{{ $receipts->total() }}</span>
                    {{ __('entries') }}
                </p>
                <div>
                    {{ $receipts->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
