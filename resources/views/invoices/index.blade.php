<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-muted">
            {{ __('Invoices') }}
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
                                    <a href="{{ route('invoices.create') }}" class="btn btn-primary">
                                        {{ __('Add New Invoice') }}
                                    </a>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>{{ __('Invoice ID') }}</th>
                                            <th>{{ __('Order ID') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Due Date') }}</th>
                                            <th class="text-center">{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($invoices as $invoice)
                                            <tr>
                                                <td>{{ $invoice->invoice_id }}</td>
                                                <td>{{ $invoice->order_id }}</td>
                                                <td>
                                                    <form action="{{ route('invoices.toggle-status', $invoice) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm {{ $invoice->status ? 'btn-success' : 'btn-danger' }}">
                                                            {{ $invoice->status ? __('Paid') : __('Unpaid') }}
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($invoice->due_date)->format('d-m-Y') }}</td>
                                                <td class="text-center">
                                                    <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('Are you sure?') }}');">
                                                            {{ __('Delete') }}
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('invoices.download', $invoice) }}" class="btn btn-info btn-sm">
                                                        {{ __('Download Receipt') }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">{{ __('No invoices found.') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <div>{{ $invoices->links('vendor.pagination.bootstrap-5') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
