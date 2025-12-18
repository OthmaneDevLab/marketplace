<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{

   public function index()
    {
        $vendor = auth()->user()->vendor;

        if (!$vendor) {
            abort(403, 'You are not a vendor');
        }

        $stores = $vendor->store ? collect([$vendor->store]) : collect();

        return view('stores.index', compact('stores'));
    }

    public function show(Store $store)
    {
        $vendor = auth()->user()->vendor;

        if ($store->vendor_id !== $vendor->id) {
            abort(403, 'You are not authorized to view this store');
        }

        $products = $store->products()->get();
        return view('stores.show', compact('store', 'products'));
    }
}
