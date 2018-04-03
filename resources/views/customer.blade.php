@extends('layout')
<?php /** @var $customer \App\Customer  */ ?>
@section('content')
    <h2>{{$customer->name}} </h2>
    <div>DKK{{$customer->agreement->amount}} {{$customer->agreement->type}} </div>
    <div class="row">
        <div class="col-xs-6">
            <form method="post" action="/customer/changetype/{{$customer->id}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="submit" value="Change type" />
            </form>
        </div>
        <div class="col-xs-6">
            <form method="get" action="/customer/invoice/{{$customer->id}}">
                <input type="submit" value="Invoice customer" />
            </form>
        </div>        
    </div>
    @include('invoicestable')    
@endsection