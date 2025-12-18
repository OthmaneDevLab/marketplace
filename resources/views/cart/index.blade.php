@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <h1 class="mb-4">Your Cart</h1>

    {{-- Success Message --}}


    {{-- Empty Cart --}}
    @if(empty($cart))
        <p>Your cart is empty</p>
    @else

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @php $grandTotal = 0; @endphp

                @foreach($cart as $productId => $item)
                    @php
                        $total = $item['price'] * $item['quantity'];
                        $grandTotal += $total;
                    @endphp

                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>${{ number_format($item['price'], 2) }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>${{ number_format($total, 2) }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $productId) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h4 class="mt-3">Grand Total: ${{ number_format($grandTotal, 2) }}</h4>

        {{-- Checkout --}}


            <form method="post" action="{{ route('stripe_payment') }}" id="stripe-form" >
                @csrf

                <input type="hidden" value="{{ $grandTotal }}" name="price" >
                <input type="hidden" name="stripeToken" id="stripe-token">
                {{-- <input type="hidden"  id="stripeToken"> --}}

                <div id="card-element" class="form-control mb-3"></div>

                <button type="button" class="btn btn-primary" onclick="createToken()">
                    Proceed to Checkout
                </button>
            </form>




        @endif
    </div>

    {{-- Stripe --}}
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        const stripe = Stripe('{{ env("STRIPE_KEY")}}');
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

    function createToken(){
        stripe.createToken(cardElement).then(function(result) {
            console.log(result)
            if(result.token){
                document.getElementById("stripe-token").value=result.token.id;
                document.getElementById("stripe-form").submit()

            }
  // Handle result.error or result.token
});
    }

</script>
@endsection
