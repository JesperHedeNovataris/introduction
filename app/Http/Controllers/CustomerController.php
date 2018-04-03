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
        return View::make('customer', compact('customer'));
    }

    public function invoice($id)
    {
        $customer = Customer::findOrFail($id);

        $agreement = Agreement::where('type', 'monthly')->first();
        $deliveries = Delivery::where('customer_id', $id)->get();

        // Object to insert.
        $invoice = new Invoice;

        //Calculate price
        $price = 0;

        foreach($deliveries as $delivery){
            $price += $delivery->count * $agreement->unit_price;            
        }        

 
        // //'agreement_id', 'invoice_no', 'invoice_due_at', 'amount'
        

        // // Get invoice count

        $invoice->agreement_id = 100;
        $invoice->invoice_no = 100;

        // Set due date 30 days ahead.
        $date = new DateTime();
        $invoice->invoice_due_at = $date->modify('+1 day');
        $invoice->amount = $price; 

        $invoice->save();
        
        
        // return Redirect::action('CustomerController@show',['id' => $id]);
    }
}
