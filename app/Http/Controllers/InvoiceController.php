<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function updateTotal(Request $request, $invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);

        // Extract parameters from request
        $payrollFee = $request->input('payroll_fee') ?? 0;
        $bookRate = $request->input('book_rate') ?? 0;
        $payrollFeeChecked = $request->input('payroll_fee_checked');
        $bookRateChecked = $request->input('book_rate_checked');
        
        // Calculate total
        $total = $request->input('total_amount');
        if ($payrollFeeChecked) {
            $total += $payrollFee;
        }
        if ($bookRateChecked) {
            $total += $bookRate;
        }
        $invoice->total_amount = $total;
        $invoice->save();

        return response()->json(['success' => true, 'total' => $total]);
    }
}

