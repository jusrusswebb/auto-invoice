@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card-header "><h1 class="addtitle logtitle">{{ __('Client Dashboard: ') }}{{ now()->toFormattedDateString() }}</h1></div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card wcard">
                

                <div class="card-body ">
                    @if ($invoices->isEmpty())
                        <p>No invoices found.</p>
                    @else
                        @foreach ($invoices as $invoice)
                            <div class="invoice card mb-4 p-3 clientcard wtitles droptry2">

                            <div class="d-flex justify-content-between align-items-center">
                                <h1 class="clientname">{{ $invoice->client->name }}</h1>
                                <form action="{{ route('delete-client', $invoice->client->id) }}" method="POST" class="delete-client-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete Client</button>
                                </form>
                            </div>


                                <h4 class="servicetitle">Billing Address: {{ $invoice->billing_address }}</h4>

                                <h4 class="servicetitle">Services:</h4>
                                <ul>
                                    @foreach ($invoice->services as $service)
                                        <li class="serviceitem" id="service-{{ $service->id }}">
                                            {{ $service->description }} - {{ $service->hours_worked }} hours 
                                            <form action="{{ route('delete-service', $service->id) }}" method="POST" class="d-inline delete-service-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </li>
                                    @endforeach
                                </ul>

                                <!-- Payroll Fee Checkbox -->
                                @if (!is_null($invoice->client->payroll_fee))
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input payroll-checkbox pinkcheck" id="payroll-{{ $invoice->id }}" data-payroll="{{ $invoice->client->payroll_fee }}">
                                        <label class="form-check-label" for="payroll-{{ $invoice->id }}">
                                            <h4 class="servicetitle">Add Payroll Fee (${{ $invoice->client->payroll_fee }})</h4>
                                        </label>
                                    </div>
                                @endif

                                <!-- Bookkeeping Flat Rate Checkbox -->
                                @if ($invoice->client->is_book_flat_rate)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input book-rate-checkbox pinkcheck" id="book-rate-{{ $invoice->id }}" data-bookrate="{{ $invoice->client->book_rate }}">
                                        <label class="form-check-label" for="book-rate-{{ $invoice->id }}">
                                            <h4 class="servicetitle">Add Bookkeeping Flat Rate (${{ $invoice->client->book_rate }})</h4>
                                        </label>
                                    </div>
                                @endif

                                <h4 class="total">Total: $<span class="invoice-total" id="total-{{ $invoice->id }}">{{ $invoice->total_amount }}</span></h4>

                                <!-- Delete Client Button -->

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

        // Confirm deletetion
        document.querySelectorAll('.delete-client-form').forEach(function (form) {
            form.addEventListener('submit', function (e) {
                if (!confirm('Are you sure you want to delete this client? This will also remove their invoices and services.')) {
                    e.preventDefault();
                }
            });
        });

        // Updates total for checkboxes
        document.querySelectorAll('.payroll-checkbox, .book-rate-checkbox').forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                const invoiceId = this.id.split('-').pop(); 
                let totalElem = document.getElementById(`total-${invoiceId}`);
                let currentTotal = parseFloat(totalElem.textContent);

                if (this.classList.contains('payroll-checkbox')) {
                    let payrollFee = parseFloat(this.dataset.payroll);
                    currentTotal = this.checked ? currentTotal + payrollFee : currentTotal - payrollFee;
                }
        
                if (this.classList.contains('book-rate-checkbox')) {
                    let bookRate = parseFloat(this.dataset.bookrate);
                    currentTotal = this.checked ? currentTotal + bookRate : currentTotal - bookRate;
                }

                totalElem.textContent = currentTotal;
            });
        });
    });
</script>
@endsection

