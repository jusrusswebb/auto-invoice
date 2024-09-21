<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Invoice; 

class ClientController extends Controller
{
    public function create()
    {
        return view('add_client');
    }

    
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'payroll_fee' => 'nullable|numeric',
            'book_rate' => 'nullable|numeric',
            'is_book_flat_rate' => 'nullable|boolean',
        ]);

        
        $client = Client::create([
            'name' => $request->name,
            'email' => $request->email,
            'payroll_fee' => $request->payroll_fee,
            'book_rate' => $request->book_rate,
            'is_book_flat_rate' => $request->has('is_book_flat_rate'),
        ]);

        Invoice::create([
            'client_id' => $client->id, 
            'billing_address' => $client->email,  
            'total_amount' => 0,  
            'invoice_date' => null,
            'invoice_number' => null, 
        ]);

        
        return redirect()->route('add-client')->with('success', 'Client added successfully.');
    }

    public function destroy($id)
    {
        
        $client = Client::findOrFail($id);

        
        foreach ($client->invoices as $invoice) {
            $invoice->services()->delete(); 
            $invoice->delete();             
        }

        
        $client->delete();

        return redirect()->route('client-dashboard')->with('success', 'Client and associated data deleted successfully.');
    }
}