<?php
namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Events\NewNotification;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session as StripeSession;

class CheckoutController extends Controller
{


    public function  store(Request $request)
    {
        $cart = session()->get('cart');

    if (!$cart || count($cart) === 0) {
        return redirect('/cart')->with('error', 'Your cart is empty');
    }

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
        'order_id'   => $order->id,
        'product_id' => $product->id,
        'vendor_id'  => $product->store->vendor->id,
        'quantity'   => $item['quantity'],
        'price'      => $item['price'],
    ]);

    event(new NewNotification([
        'user_id'      => $product->store->vendor->id,
        'product_name' => $product->name,
    
    ]));
}

//          $data = [
//     'user_id' =>  auth()->id(),
//     'product_name' => $product->name,
// ];

// event(new NewNotification($data));

        session()->forget('cart');

        return redirect('/orders')
            ->with('message', 'Order placed successfully');
    }
}
