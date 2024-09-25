<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord; 
use PhpOffice\PhpWord\TemplateProcessor;
use App\Models\Client;
use Carbon\Carbon; 


class DocumentController extends Controller
{
    public function generateDocx(Request $request, $clientId)
    {
        $templatePath = storage_path('app/public/AAA-invoice.docx');
        $templateProcessor = new TemplateProcessor($templatePath);

        $client = Client::with('invoices.services')->findOrFail($clientId);

        $templateProcessor->setValue('name', $client->name);
        $templateProcessor->setValue('email', $client->email);


        $currentDate = Carbon::now()->format('m-d-y'); 
        $templateProcessor->setValue('curr_date', $currentDate);

        $totalAmount = $request->input('gttl');
        $templateProcessor->setValue('gttl', number_format($totalAmount, 2));

        $invoice = $client->invoices->first(); 

        if ($invoice) {
            foreach ($invoice->services as $index => $service) {
                $placeholderIndex = $index + 1;
                $templateProcessor->setValue("desc_{$placeholderIndex}", $service->description);
                $templateProcessor->setValue("ttl_{$placeholderIndex}", number_format($service->service_amount, 2));
                $templateProcessor->setValue("hrs_{$placeholderIndex}", $service->hours_worked . ' hours');
            }
        }

        $serviceCount = $invoice->services->count();
        $maxServices = 4; 
        for ($i = $serviceCount + 1; $i <= $maxServices; $i++) {
            $templateProcessor->setValue("desc_{$i}", '');
            $templateProcessor->setValue("ttl_{$i}", '');
            $templateProcessor->setValue("hrs_{$i}", '');
        }

        $fileName = 'Invoice-' . $client->name . '-' . date('Y-m-d') . '.docx';
        $filePath = storage_path('app/public/' . $fileName);

        $templateProcessor->saveAs($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
