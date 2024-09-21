<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Service; 
use App\Models\Client; 

class ServiceController extends Controller
{
    public function create()
    {
        $clients = Client::all(); 
        return view('add_service', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'description' => 'required|string|max:255',
            'hours_worked' => 'required|numeric',
        ]);

        $client = Client::findOrFail($request->client_id);
    
        $invoice= Invoice::where('client_id', $client->id)->firstOrFail();

        
        if ($client->is_book_flat_rate) {
            $totalAmountForService = 0;
        } else {
            $totalAmountForService = $request->hours_worked * $client->book_rate;
            $invoice->total_amount += $totalAmountForService;
            $invoice->save();
        }

        Service::create([
            'invoice_id' => $invoice->id,
            'description' => $request->description,
            'hours_worked' => $request->hours_worked,
            'service_amount' => $totalAmountForService,
        ]);


        return redirect()->route('add-service')->with('success', 'Service added successfully.');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        $invoice = $service->invoice;

        $invoice->total_amount -= $service->service_amount;
        $invoice->save();
        $service->delete();

        return back()->with('success', 'Service deleted successfully.');
    }
}