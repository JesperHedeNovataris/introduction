@extends('layout')
<?php /** @var $customer \App\Customer  */ ?>
@section('content')
    <h2>{{$customer->name}}</h2>
    <div>DKK{{$customer->agreement->amount}} {{$customer->agreement->type}}</div>
    <form method="post" action="/customer/invoice/{{$customer->id}}}">
        <input type="submit" value="Invoice customer" />
    </form>

    <?php /* TODO: show list of invoices for customer */ ?>
@endsection