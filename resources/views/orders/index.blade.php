@extends('layouts.app')

@section('content')
<h1>My Orders</h1>

@if($orders->isEmpty())
    <p>No orders yet</p>
@else
@foreach($orders as $order)
    <div style="border:1px solid #000; margin:10px; padding:10px">
        <h3>Order #{{ $order->id }}</h3>
        <p>Status: {{ $order->status }}</p>
        <p>Total: ${{ $order->total }}</p>

        <ul>
            @foreach($order->orderItems as $item)
                <li>
                    {{ $item->product->name }}
                    x {{ $item->quantity }}
                </li>
            @endforeach
        </ul>
    </div>
@endforeach
@endif
@endsection
