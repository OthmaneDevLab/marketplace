<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    // عرض طلبات الزبون
    public function index()
    {
        $orders = auth()->user()
            ->orders()
            ->with('orderItems.product')
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }
}

