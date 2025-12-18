<!DOCTYPE html>
<html>
<head>
    <title>Marketplace</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>
<body>

<nav>

    
     @guest
        <a href="/">Home</a>
        <a href="/products">Products</a>
        <a href="/cart">Cart</a>
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}">Register</a>
    @endguest

     @if(auth()->user()->role === 'customer')
      <a href="/">Home</a>
        <a href="/products">Products</a>
       <a href="/cart">Cart</a>
        <a href="/orders">My Orders</a>
        <span>{{ auth()->user()->name }}</span>


    @endif

    @if(auth()->user()->role === 'vendor')
        <a href="/vendor/store">My Store</a>
        <a href="/vendor/products">My Products</a>
        <a href="/vendor/orders">Orders</a>
        <span>{{ auth()->user()->name }}</span>

    @endif
</nav>

<hr>

@if(session('message'))
    <p style="color:green">{{ session('message') }}</p>
@endif

@yield('content')


</body>
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ env("# STRIPE_KEY") }}');
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');
</script>
</html>
