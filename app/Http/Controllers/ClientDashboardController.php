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
}