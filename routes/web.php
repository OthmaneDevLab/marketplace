<?php

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\VendorOrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/', fn() => view('home'));






Route::middleware('auth')->group(function () {
    Route::get('/become-vendor', [VendorController::class, 'create']);
    Route::post('/become-vendor', [VendorController::class, 'store']);




    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'show']);




    Route::get('/cart', [CartController::class, 'index'])
        ->name('cart.index');

    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');

    Route::post('/cart/remove/{product}', [CartController::class, 'remove'])
        ->name('cart.remove');



    Route::post('/checkout', [CheckoutController::class, 'store'])->name('stripe_payment');

    //  Route::get('/checkout', [CheckoutController::class, 'checkout'])
    //     ->name('checkout');

    // Route::get('/checkout/success', [CheckoutController::class, 'success'])
    //     ->name('checkout.success');




     Route::get('/orders', [OrderController::class, 'index'])
        ->name('orders.index');


});

Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('/vendor/dashboard', fn() => view('vendor.dashboard'));

    Route::get('/vendor/orders', [VendorOrderController::class, 'index']);
    Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
    Route::get('/stores/{store}', [StoreController::class, 'show'])->name('stores.show');

});


// Route::middleware('auth')->group(function () {
//     Route::get('/cart', [CartController::class, 'index']);
//     Route::post('/cart/add/{product}', [CartController::class, 'add']);
//     Route::post('/cart/remove/{product}', [CartController::class, 'remove']);
// });

// Route::middleware('auth')->group(function () {
//     Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
//     Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
// });



require __DIR__ . '/auth.php';
