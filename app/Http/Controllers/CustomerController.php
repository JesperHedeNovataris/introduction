<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Invoice;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return View::make('customers', compact('customers'));
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return View::make('customer', compact('customer'));
    }

    public function invoice($id)
    {
        $customer = Customer::findOrFail($id);

        // //'agreement_id', 'invoice_no', 'invoice_due_at', 'amount'
        $invoice = new Invoice;

        // // Get invoice count

        $invoice->agreement_id = 100;
        $invoice->invoice_no = 100;
        $invoice->invoice_due_at = date(DATE_RFC2822);
        $invoice->amount = 1000000; // One million!

        $invoice->save();
        
        
        return Redirect::action('CustomerController@show',['id' => $id]);
    }
}
