<!DOCTYPE html>
<html>

<head>
    <title>Marketplace</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">




</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">

            {{-- Brand --}}
            <a class="navbar-brand" href="/">Marketplace</a>

            {{-- Toggle (Mobile) --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Navbar Content --}}
            <div class="collapse navbar-collapse" id="mainNavbar">

                {{-- Left Links --}}
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    @guest
                        <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="/products">Products</a></li>
                        <li class="nav-item"><a class="nav-link" href="/cart">Cart</a></li>
                    @endguest

                    @auth
                        @if (auth()->user()->role === 'customer')
                            <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="/products">Products</a></li>
                            <li class="nav-item"><a class="nav-link" href="/cart">Cart</a></li>
                            <li class="nav-item"><a class="nav-link" href="/orders">My Orders</a></li>
                        @endif

                        @if (auth()->user()->role === 'vendor')
                            <li class="nav-item"><a class="nav-link" href="/vendor/store">My Store</a></li>
                            <li class="nav-item"><a class="nav-link" href="/vendor/products">My Products</a></li>
                            <li class="nav-item"><a class="nav-link" href="/vendor/orders">Orders</a></li>
                        @endif
                    @endauth

                </ul>

                {{-- Right Side --}}
                <ul class="navbar-nav ms-auto align-items-center">

                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @endguest

                    @auth
                        {{-- Notifications (Vendor Example) --}}
                        @if (auth()->user()->role === 'vendor')
                            <li class="nav-item dropdown dropdown-notifications me-3">
                                <a class="nav-link dropdown-toggle position-relative" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false" data-toggle="notifications">

                                    <i class="fas fa-bell"></i>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notif-count"
                                        data-count="0">
                                        0
                                    </span>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end p-2" style="width:300px">
                                    <li class="scrollable-container">
                                        <span class="dropdown-item text-muted">No notifications</span>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        {{-- User Dropdown --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth

                </ul>

            </div>
        </div>
    </nav>


    <hr>

    @if (session('message'))
        <p style="color:green">{{ session('message') }}</p>
    @endif

    @yield('content')


</body>
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');

    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>

<script>
    Pusher.logToConsole = true;

   var pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
    cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
    forceTLS: true
});
</script>

<script src="{{ asset('js/pusherNotification.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</html>
