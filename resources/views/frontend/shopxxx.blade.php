@extends('frontend.master')

@section('content')

<div class="container">

    @if (session()->has('success_message'))
    <div class="alert alert-success">
        {{ session()->get('success_message') }}
    </div>
    @endif

    @if (session()->has('error_message'))
    <div class="alert alert-danger">
        {{ session()->get('error_message') }}
    </div>
    @endif

    <div class="jumbotron text-center clearfix">
        <p>
            <a href="http://andremadarang.com/implementing-a-shopping-cart-in-laravel/" class="btn btn-primary btn-lg" target="_blank">Blog Post</a>
            <a href="https://github.com/drehimself/laravel-shopping-cart-example" class="btn btn-success btn-lg" target="_blank">GitHub Repo</a>
        </p>
    </div> <!-- end jumbotron -->

    <div class="col-md-8">
        <div class="shopping_cart">
            <form class="form-horizontal" role="form" action="" method="post" id="payment-form">
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><b>Makanan</b></a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <div class="items">

                                    @foreach ($products->chunk(4) as $items)
                                    <div class="row">
                                        @foreach ($items as $product)
                                        <div class="col-md-3">
                                            <div class="thumbnail">
                                                <div class="caption text-center">
                                                    <h3>{{ $product->name }}</h3>
                                                    <p>{{ $product->price }}</p>
                                                    <form action="{{ url('/cart') }}" method="POST" class="side-by-side">
                                                        {!! csrf_field() !!}
                                                        <input type="hidden" name="id" value="{{ $product->id }}">
                                                        <input type="hidden" name="name" value="{{ $product->name }}">
                                                        <input type="hidden" name="price" value="{{ $product->price }}">
                                                        <input type="submit" class="btn btn-success btn-lg" value="Add to Cart">
                                                    </form>
                                                </div> <!-- end caption -->
                                            </div> <!-- end thumbnail -->
                                        </div> <!-- end col-md-3 -->
                                        @endforeach
                                    </div> <!-- end row -->
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
<div class="col-md-4">
    <div class="shopping_cart">
        <form class="form-horizontal" role="form" action="" method="post" id="payment-form">
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><b>review</b>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <div class="items">
                                @if (sizeof(Cart::content()) > 0)

            <table class="table">
                <thead>
                    <tr>
                        <th class="table-image"></th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th class="column-spacer"></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach (Cart::content() as $item)
                    <tr>
                        <td class="table-image"><a href="{{ url('shop', [$item->model->slug]) }}"><img src="{{ asset('img/' . $item->model->image) }}" alt="product" class="img-responsive cart-image"></a></td>
                        <td><a href="{{ url('shop', [$item->model->slug]) }}">{{ $item->name }}</a></td>
                        <td>
                            <select class="quantity" data-id="{{ $item->rowId }}">
                                <option {{ $item->qty == 1 ? 'selected' : '' }}>1</option>
                                <option {{ $item->qty == 2 ? 'selected' : '' }}>2</option>
                                <option {{ $item->qty == 3 ? 'selected' : '' }}>3</option>
                                <option {{ $item->qty == 4 ? 'selected' : '' }}>4</option>
                                <option {{ $item->qty == 5 ? 'selected' : '' }}>5</option>
                            </select>
                        </td>
                        <td>${{ $item->subtotal }}</td>
                        <td class=""></td>
                        <td>
                            <form action="{{ url('cart', [$item->rowId]) }}" method="POST" class="side-by-side">
                                {!! csrf_field() !!}
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="submit" class="btn btn-danger btn-sm" value="Remove">
                            </form>
                        </td>
                    </tr>

                    @endforeach
                    <tr>
                        <td class="table-image"></td>
                        <td></td>
                        <td class="small-caps table-bg" style="text-align: right">Subtotal</td>
                        <td>${{ Cart::instance('default')->subtotal() }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="table-image"></td>
                        <td></td>
                        <td class="small-caps table-bg" style="text-align: right">Tax</td>
                        <td>${{ Cart::instance('default')->tax() }}</td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr class="border-bottom">
                        <td class="table-image"></td>
                        <td style="padding: 40px;"></td>
                        <td class="small-caps table-bg" style="text-align: right">Your Total</td>
                        <td class="table-bg">${{ Cart::total() }}</td>
                        <td class="column-spacer"></td>
                        <td></td>
                    </tr>

                </tbody>
            </table>

            <a href="{{ url('/shop') }}" class="btn btn-primary btn-lg">Continue Shopping</a> &nbsp;
            <a href="{{ url('/checkout') }}" class="btn btn-success btn-lg">Proceed to Checkout</a>

            <div style="float:right">
                <form action="{{ url('/emptyCart') }}" method="POST">
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="submit" class="btn btn-danger btn-lg" value="Empty Cart">
                </form>
            </div>

        @else

            <h3>You have no items in your shopping cart</h3>
            <a href="{{ url('/shop') }}" class="btn btn-primary btn-lg">Continue Shopping</a>

        @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form></div></div></div>

    </div> <!-- end container -->

    @endsection