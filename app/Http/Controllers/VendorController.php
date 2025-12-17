<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Vendor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function create()
    {
        if (auth()->user()->vendor) {
            abort(403);
        }

        return view('vendor.apply');
    }
    public function store(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
        ]);

        $vendor = Vendor::create([
            'user_id' => auth()->id(),
            'status' => 'pending',
        ]);

        Store::create([
            'vendor_id' => $vendor->id,
            'name' => $request->store_name,
            'slug' => Str::slug($request->store_name),
            'description' => $request->description,
        ]);

        return redirect('/vendor/dashboard')->with('message', 'Application submitted');
    }

}
