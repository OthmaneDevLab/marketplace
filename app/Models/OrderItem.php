<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
        use HasFactory;

     protected $fillable = [
        'order_id',
        'product_id',
        'vendor_id',
        'product_variant_id',
        'quantity',
        'price',

    ];
     public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // OrderItem → Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // OrderItem → Vendor
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    // OrderItem → ProductVariant (اختياري)
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}
