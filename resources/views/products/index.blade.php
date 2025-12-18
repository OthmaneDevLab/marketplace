@extends('layouts.app')

@section('content')
<h1>All Products</h1>

@foreach($products as $product)
    <div style="border:1px solid #ccc; margin:10px; padding:10px">
        <h3>{{ $product->name }}</h3>
        <p>Price: ${{ $product->price }}</p>

        <a href="/products/{{ $product->id }}">View</a>
    </div>
@endforeach
@endsection
