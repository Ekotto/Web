@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="payment-area">
            <h4 class="my-4 bg-dark p-3 text-white">Make your payment</h4>

            <div class="cart-summary my-3">
                <div class="card">
                    <div class="card-header">
                        <h4>Order summary</h4>
                    </div>
                    <div class="card-body">
                        <p>Total products = {{Cart::content()->count()}}</p>
                        <p>Product Cost = {{Cart::total()}} FCFA</p>
                        {{-- <p>Shipping cost = 0.00 FCFA</p> --}}
                        <p><strong>Total cost = {{Cart::total()}} FCFA</strong></p>
                    </div>
                </div>
            </div>

            <div class="bg-light p-3 my-4">
                <form action="{{route('cart.checkout')}}" method="post">
                    @csrf
                    <input type="hidden" name="cart_total" value="{{Cart::total()}}">
                    <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                            data-key="pk_test_51J8Zv4C8ln52AfWo9EF7XCCFRUgKsP08BgevfXUxtiDp19ggmqkc9U6Nlw8hgUeIjhVibnkSW8JFrjSjVDuVJTqm00QoScjKit"
                            data-amount=""
                            data-name="Bookify"
                            data-description="Bookify payment"
                            data-locale="auto">
                    </script>
                </form>
            </div>
            {{-- <div class="bg-light p-3 my-4">
                <button class="btn btn-success btn-sm"><strong>Cash on delivery</strong></button>
            </div> --}}
        </div>
    </div>
@endsection
