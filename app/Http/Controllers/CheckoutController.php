<?php
namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Stripe\Checkout\Session as StripeSession;

class CheckoutController extends Controller
{


    public function  store(Request $request)
    {
        $cart = session()->get('cart');

        $stripe = new \Stripe\StripeClient(env("STRIPE_SECRET"));
       $charge = $stripe->charges->create([
        'amount' => (int) round($request->price * 100),
        'currency' => 'usd',
        'source' => $request->stripeToken,
        'description' => 'Payment From Here',
    ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'total' => collect($cart)->sum(fn ($i) => $i['price'] * $i['quantity']),
            'status' => 'paid',
        ]);

        foreach ($cart as $productId => $item) {
            $product = Product::findOrFail($productId);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'vendor_id' => $product->store->vendor->id,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        session()->forget('cart');

        return redirect('/orders')
            ->with('message', 'Order placed successfully');
    }
}
