<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Service;

class InvoiceController extends Controller
{
    public function create()
    {
        return view('invoices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'invoice_number' => 'required|unique:invoices',
            'invoice_date' => 'required|date',
            'billing_address' => 'required|string',
            'services.*.description' => 'required|string',
            'services.*.amount' => 'required|numeric',
            'services.*.hours_worked' => 'required|numeric',
        ]);

        $invoice = Invoice::create([
            'client_id' => $request->client_id,
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'billing_address' => $request->billing_address,
        ]);

        foreach ($request->services as $service) {
            $invoice->services()->create($service);
        }

        // Update total amount in the invoice
        $invoice->update(['total_amount' => $invoice->calculateTotalAmount()]);

        return redirect()->route('invoices.create')->with('success', 'Invoice created successfully.');
    }
}
