<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice; 

class ClientDashboardController extends Controller
{
    public function index()
    {
        
        $invoices = Invoice::with('services')->get();
        return view('client_dashboard', compact('invoices'));
    }

    public function search(Request $request)
    {
    $query = $request->input('query');

    // Search clients by name
    $invoices = Invoice::whereHas('client', function($q) use ($query) {
        $q->where('name', 'LIKE', "%{$query}%");
    })->get();

    return view('client_dashboard', compact('invoices'));
    }

}