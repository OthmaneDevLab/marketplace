<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function show($slug)
{
    $store = Store::where('slug', $slug)
        ->whereHas('vendor', fn($q) =>
            $q->where('status', 'approved')
        )
        ->firstOrFail();

    return view('store.show', compact('store'));
}
}
