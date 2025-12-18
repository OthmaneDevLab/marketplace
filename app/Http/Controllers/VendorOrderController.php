<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;

class VendorOrderController extends Controller
{
    public function index()
    {
        $vendor = auth()->user()->vendor;

        $orderItems = OrderItem::where('vendor_id', $vendor->id)
            ->with('order.user', 'product')
            ->latest()
            ->get();

        return view('vendor.orders.index', compact('orderItems'));
    }
   
}
