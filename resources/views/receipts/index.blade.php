<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-muted">
            {{ __('Receipts') }}
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
                                    <a href="{{ route('receipts.create') }}" class="btn btn-primary">
                                        {{ __('Add New Receipt') }}
                                    </a>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>{{ __('Receipt ID') }}</th>
                                            <th>{{ __('Order ID') }}</th>
                                            <th>{{ __('Payment Date') }}</th>
                                            <th>{{ __('Total Amount') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($receipts as $receipt)
                                            <tr>
                                                <td>{{ $receipt->receipts_id }}</td>
                                                <td>{{ $receipt->invoice->order_id }}</td>
                                                <td>{{ \Carbon\Carbon::parse($receipt->payment_date)->format('d-m-Y') }}</td>
                                                <td>Rp {{ number_format($receipt->amount, 0, ',', '.') }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('receipts.download', $receipt) }}" class="btn btn-info btn-sm">
                                                        {{ __('Download PDF') }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">{{ __('No paid receipts found.') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="d-flex justify-content-between mt-4">
                                    {{ $receipts->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
