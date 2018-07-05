@extends('frontend.master')
@section('content')
<div class="container">
    <div class="page">
        <div class="page-header">
            Checkout
        </div>

        <div class="shopping_cart">
            <form class="form-horizontal" role="form" action="" method="post" id="payment-form">
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">

                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <b>Barang Belanja</b>
                            </h4>
                        </div>
                        
                        <div class="panel-body">
                            <div class="items">
                                <div class="col-md-9">
                   	 		     	@foreach (Cart::content() as $item)
                                    <table class="table table-striped">
                                        <tr>
                                            <td width="50%">
                                                <b> {{ $item->name }}</b>
                                            </td>
                                            <td width="30%">
                                                <b> {{ $item->subtotal }} IDR</b>
                                            </td>
                                            <td width="20%">
                                                <b> {{ $item->qty }}</b>
                                            </td>
                                            <td>
                                                <div class="pull-right">
                                                    <form action="{{ url('user/cart', [$item->rowId]) }}" method="POST" style="display: inline-block;">
                                                        {!! csrf_field() !!}
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="submit" class="btn btn-danger btn-sm" value="Hapus">
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
    				                @endforeach
                                </div>
                                
                                <div class="col-md-3">
                                    <div style="text-align: center;">
                                    	<div class="panel panel-default">
		                                    <div class="panel-heading">
		                                        <h4 class="panel-title">
		                                            <h3>total</h3>
		                                        </h4>
                        						<div class="panel-body">
                                        		<h4><span style="color:#B71C1C;">{{ Cart::total() }} IDR</span></h4>
                                        		</div>
		                                    </div>
		                                </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>		  
    </div>
</div>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<style type="text/css">
	.box{
		margin: 5px;
	}
</style>
@endsection