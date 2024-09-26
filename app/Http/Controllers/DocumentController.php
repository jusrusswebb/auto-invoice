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
        $serviceCount = $invoice->services->count();
        /*
        if($serviceCount == 0){
            if($client->is_book_flat_rate){
                $serviceDescription = "Monthly Bookkeeping Service";
                $totalDue = $client->book_rate; 
                $templateProcessor->setValue("hrs_1", '');
                $serviceCount == 1;
            } 
            if (!is_null($client->payroll_fee)) {
                $serviceDescription .= " + Payroll Fee";
                $totalDue += $client->payroll_fee; 
            }
            $templateProcessor->setValue("desc_1", $serviceDescription);
            $templateProcessor->setValue("ttl_1", number_format($totalDue,2));
        
        }
        */

        $isPayrollChecked = $request->input('isPayrollChecked') === 'true';
        $isBookRateChecked = $request->input('isBookRateChecked') === 'true';

        if ($invoice) {
            foreach ($invoice->services as $index => $service) {
                $placeholderIndex = $index + 1;
                $templateProcessor->setValue("desc_{$placeholderIndex}", $service->description);
                if($client->is_book_flat_rate){
                    $templateProcessor->setValue("ttl_{$placeholderIndex}", '');
                }
                else{
                    $templateProcessor->setValue("ttl_{$placeholderIndex}", number_format($service->service_amount, 2));
                }
                $templateProcessor->setValue("hrs_{$placeholderIndex}", $service->hours_worked . ' hours');
            }
        }

        if($isBookRateChecked && $isPayrollChecked){
            $serviceCount += 1; 
            $templateProcessor->setValue("desc_{$serviceCount}", "Monthly Bookkeeping Service + Payroll Fee");
            $templateProcessor->setValue("hrs_{$serviceCount}", '');
            $templateProcessor->setValue("ttl_{$serviceCount}", number_format($totalAmount, 2));
        }
        if($isBookRateChecked && !$isPayrollChecked){
            $serviceCount += 1; 
            $templateProcessor->setValue("desc_{$serviceCount}", "Monthly Bookkeeping Service");
            $templateProcessor->setValue("hrs_{$serviceCount}", '');
            $templateProcessor->setValue("ttl_{$serviceCount}", number_format($totalAmount, 2));
        }
        if($isPayrollChecked && !$isBookRateChecked){
            $serviceCount += 1; 
            $templateProcessor->setValue("desc_{$serviceCount}", "Payroll fee");
            $templateProcessor->setValue("hrs_{$serviceCount}", '');
            $templateProcessor->setValue("ttl_{$serviceCount}", number_format($client->payroll_fee, 2));
        }

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
