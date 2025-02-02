@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">{{ __('Invoices') }}</h2>
            <a href="{{ route('invoices.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                {{ __('Add New Invoice') }}
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="px-4 py-2">{{ __('Invoice ID') }}</th>
                        <th class="px-4 py-2">{{ __('Order ID') }}</th>
                        <th class="px-4 py-2">{{ __('Status') }}</th>
                        <th class="px-4 py-2">{{ __('Due Date') }}</th>
                        <th class="px-4 py-2 text-center">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($invoices as $invoice)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border-t">{{ $invoice->invoice_id }}</td>
                            <td class="px-4 py-2 border-t">{{ $invoice->order_id }}</td>
                            <td class="px-4 py-2 border-t">
                                <form action="{{ route('invoices.toggle-status', $invoice) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 rounded-lg text-sm font-semibold {{ $invoice->status ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                        {{ $invoice->status ? __('Paid') : __('Unpaid') }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-4 py-2 border-t">{{ \Carbon\Carbon::parse($invoice->due_date)->format('d-m-Y') }}</td>
                            <td class="px-4 py-2 border-t text-center">
                                <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600" onclick="return confirm('{{ __('Are you sure?') }}');">
                                        {{ __('Delete') }}
                                    </button>
                                </form>
                                <a href="{{ route('invoices.download', $invoice) }}" class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 ml-2">
                                    {{ __('Download Receipt') }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center px-4 py-2 border-t text-gray-500">{{ __('No invoices found.') }}</td>
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
                    <span class="font-medium">{{ $invoices->firstItem() }}</span>
                    {{ __('to') }}
                    <span class="font-medium">{{ $invoices->lastItem() }}</span>
                    {{ __('of') }}
                    <span class="font-medium">{{ $invoices->total() }}</span>
                    {{ __('entries') }}
                </p>
                <div>
                    {{ $invoices->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
