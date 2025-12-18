
@extends('layouts.app')

@section('content')
<h1>{{ $store->name }} - Products</h1>
<p>Vendor: {{ $store->vendor->user->name }}</p>

@if($products->isEmpty())
    <p>No products in this store yet.</p>
@else
    @foreach($products as $product)
        <div style="border:1px solid #ccc; padding:10px; margin:10px">
            <h3>{{ $product->name }}</h3>
            <p>Price: ${{ $product->price }}</p>
            <a href="/products/{{ $product->slug }}">
                <button>View Product</button>
            </a>
        </div>
    @endforeach
@endif

<a href="{{ route('stores.index') }}">Back to Stores</a>
@endsection
