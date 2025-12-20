@extends('layouts.app')

@section('content')
<h1>All Stores</h1>

@foreach($stores as $store)
    <div style="border:1px solid #ccc; padding:10px; margin:10px">
        <h3>{{ $store->name }}</h3>
        <p>Vendor: {{ $store->vendor->user->name }}</p>

        {{-- <a href="{{ route('stores.show', $store->id) }}"> --}}
            <button>Show Products</button>
        </a>
    </div>
@endforeach

@endsection