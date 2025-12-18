@extends('layouts.app')

@section('content')
<h1>{{ $product->name }}</h1>

<p>{{ $product->description }}</p>
<p>Price: ${{ $product->price }}</p>

<form method="POST" action="/cart/add/{{ $product->id }}">
    @csrf
    <input type="number" name="quantity" value="1" min="1">
    <button type="submit">Add to Cart</button>
</form>
@endsection
