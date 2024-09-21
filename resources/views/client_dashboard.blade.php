@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Client Dashboard: ') }}{{ now()->toFormattedDateString() }}</div>

                <div class="card-body">
                    @if ($invoices->isEmpty())
                        <p>No invoices found.</p>
                    @else
                        @foreach ($invoices as $invoice)
                            <div class="invoice card mb-4 p-3">
                                <h3>{{ $invoice->client->name }}</h3>
                                <p>Billing Address: {{ $invoice->billing_address }}</p>

                                <h4>Services:</h4>
                                <ul>
                                    @foreach ($invoice->services as $service)
                                        <li id="service-{{ $service->id }}">
                                            {{ $service->description }} - {{ $service->hours_worked }} hours 
                                            <form action="{{ route('delete-service', $service->id) }}" method="POST" class="d-inline delete-service-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </li>
                                    @endforeach
                                </ul>

                                <h4>Total: ${{ $invoice->total_amount }}</h4>

                                <!-- Delete Client Button -->
                                <form action="{{ route('delete-client', $invoice->client->id) }}" method="POST" class="d-inline delete-client-form">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-danger btn-sm">Delete Client</button>
                                </form>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log('Script loaded'); 
        document.querySelectorAll('.delete-client-form').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                if (!confirm('Are you sure you want to delete this client? This will also remove their invoices and services.')) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endsection
