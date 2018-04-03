@extends('layout')
<?php /** @var $invoices \App\Invoice[]  */ ?>
@section('content')
    <h2>Invoices</h2>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>Due</th>
                <th>Amount</th>
                <th>Customer</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoices as $invoice)
            <tr>
                <td>{{ $invoice->invoice_no}}</td>
                <td>{{ $invoice->invoice_due_at }}</td>
                <td>{{ $invoice->amount}}</td>
                <td><a href="/customer/{{ $invoice->customer_id }}">{{ $invoice->customer_name }}</a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection