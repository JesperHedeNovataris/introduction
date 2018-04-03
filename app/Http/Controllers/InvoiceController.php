<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Invoice;
use Illuminate\Support\Facades\View;

class InvoiceController
{
    public function index()
    {
        $invoices = Invoice::all();

        // $customer_numbers = Invoice::select('agreement_id')->distinct()->get();
        // echo $customer_numbers;

        foreach($invoices as $invoice) {
            $customer = Customer::where('agreement_id', $invoice->agreement_id)->first();

            $invoice->customer_id = $customer->agreement_id;
            $invoice->customer_name = $customer->name;            
        }

        return View::make('invoices', compact('invoices'));
    }
}