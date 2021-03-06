<?php

namespace App\Http\Controllers;

use App\Agreement;
use App\Customer;
use App\Delivery;
use App\Invoice;
use Carbon\Carbon;
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
        $invoice = $this->CreateInvoice($id);

        $invoice->save();
        
        
        return Redirect::action('CustomerController@show',['id' => $id]);
    }

    public function CreateInvoice($id)
    {
        $customer = Customer::findOrFail($id);

        // Filter deliveries on last week or month.
        $deliveries = $customer->deliveries;
        if($customer->agreement->type == Agreement::TYPE_WEEKLY){
            $deliveries = $customer->deliveries->where('delivered_at', '>', Carbon::now()->subDays(7));
        }
        elseif($customer->agreement->type == Agreement::TYPE_MONTHLY){
            $deliveries = $customer->deliveries->where('delivered_at', '>', Carbon::now()->subMonth(1));
        }

        // Object to insert.
        $invoice = new Invoice;

        //Calculate price
        $price = 0;

        foreach($deliveries as $delivery) {
            $price += $delivery->count * $customer->agreement->unit_price;            
        }
 
        // Get invoice count
        $max_invoice_no = Invoice::max('invoice_no');

        $invoice->agreement_id = $customer->agreement->id;
        $invoice->invoice_no = ++$max_invoice_no; // Defaults to 1 if no invoices in DB.

        // Set due date 30 days ahead.        
        $invoice->invoice_due_at = Carbon::now()->addDays(30);
        $invoice->amount = $price;

        return $invoice;
    }

    public function changetype($id)
    {
        $customer = Customer::findOrFail($id);
        $agreement = $customer->agreement;

        if($agreement->type == Agreement::TYPE_WEEKLY)
            $agreement->type = Agreement::TYPE_MONTHLY;
        elseif($agreement->type == Agreement::TYPE_MONTHLY)
            $agreement->type = Agreement::TYPE_WEEKLY;
        
        $agreement->save();

        return Redirect::action('CustomerController@show',['id' => $id]);
    }
}
