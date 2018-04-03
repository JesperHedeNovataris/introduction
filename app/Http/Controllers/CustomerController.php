<?php

namespace App\Http\Controllers;

use App\Agreement;
use App\Customer;
use App\Delivery;
use App\Invoice;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

use \DateTime;

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
        $invoices = Invoice::where('agreement_id', $id)->get();
        return View::make('customer', compact('customer'))->with('invoices', $invoices);
    }

    public function invoice($id)
    {
        $customer = Customer::findOrFail($id);

        $agreement = Agreement::where('id', $customer->agreement_id)->first(); // TODO handle zero customer case.
        $deliveries = Delivery::where('customer_id', $id)->get();

        // Object to insert.
        $invoice = new Invoice;

        //Calculate price
        $price = 0;

        foreach($deliveries as $delivery) {
            $price += $delivery->count * $agreement->unit_price;            
        }        

 
        // Get invoice count
        $max_invoice_no = Invoice::max('invoice_no');

        $invoice->agreement_id = $agreement->id;
        $invoice->invoice_no = ++$max_invoice_no; // Defaults to 1 if not invoices in DB.

        // Set due date 30 days ahead.
        $date = new DateTime();
        $invoice->invoice_due_at = $date->modify('+30 day');
        $invoice->amount = $price; 

        $invoice->save();
        
        
        return Redirect::action('CustomerController@show',['id' => $id]);
    }
}
