@extends('layouts.app')

@section('content')
<h1>My Orders</h1>

@if($orderItems->isEmpty())
    <p>No orders yet</p>
@else
@foreach($orderItems as $item)
    <div style="border:1px solid #ccc; margin:10px; padding:10px">
        {{-- <h3>Order #{{ $item->order->id }}</h3> --}}

        <p>Customer: {{ $item->order->user->name }}</p>
        <p>Product: {{ $item->product->name }}</p>
        <p>Quantity: {{ $item->quantity }}</p>
        <p>Price: ${{ $item->price }}</p>
        <p>Status: {{ $item->order->status }}</p>
    </div>
@endforeach
@endif
@endsection
