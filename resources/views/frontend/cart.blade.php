@extends('frontend.master')

@section('content')

<style>
.panel.with-nav-tabs .panel-heading{
    padding: 5px 5px 0 5px;
}
.panel.with-nav-tabs .nav-tabs{
    border-bottom: none;
}
.panel.with-nav-tabs .nav-justified{
    margin-bottom: -1px;
}
/********************************************************************/
/*** PANEL DEFAULT ***/
.with-nav-tabs.panel-default .nav-tabs > li > a,
.with-nav-tabs.panel-default .nav-tabs > li > a:hover,
.with-nav-tabs.panel-default .nav-tabs > li > a:focus {
    color: #777;
}
.with-nav-tabs.panel-default .nav-tabs > .open > a,
.with-nav-tabs.panel-default .nav-tabs > .open > a:hover,
.with-nav-tabs.panel-default .nav-tabs > .open > a:focus,
.with-nav-tabs.panel-default .nav-tabs > li > a:hover,
.with-nav-tabs.panel-default .nav-tabs > li > a:focus {
    color: #777;
    background-color: #ddd;
    border-color: transparent;
}
.with-nav-tabs.panel-default .nav-tabs > li.active > a,
.with-nav-tabs.panel-default .nav-tabs > li.active > a:hover,
.with-nav-tabs.panel-default .nav-tabs > li.active > a:focus {
    color: #555;
    background-color: #fff;
    border-color: #ddd;
    border-bottom-color: transparent;
}
.with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu {
    background-color: #f5f5f5;
    border-color: #ddd;
}
.with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > li > a {
    color: #777;   
}
.with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
.with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
    background-color: #ddd;
}
.with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > .active > a,
.with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
.with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
    color: #fff;
    background-color: #555;
}   

</style>

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

    @if ($flash = session('message'))
        <div id="flash-message" class="alert alert-success" role="alert">
           {{ $flash }}
        </div>
       @endif


    <div class="col-md-7" style="margin-left:-10px">

            <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1default" data-toggle="tab"><b>Makanan</b></a></li>
                            <li><a href="#tab2default" data-toggle="tab"><b>Minuman</b></a></li>
                        
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1default">

                    <table class="table table-striped" >
                            @foreach ($foods as $items)

                        <tr>
                            <td><b>{{ $items->name }}</b></td>
                            <td align="right">{{ number_format($items->price ,2, ',' , '.')  }}</td>
                            <td align="right">
                                <form action="{{ url('/employee/shop') }}" method="POST" class="side-by-side">
                                                        {!! csrf_field() !!}
                                                        <input type="hidden" name="id" value="{{ $items->id }}">
                                                        <input type="hidden" name="name" value="{{ $items->name }}">
                                                        <input type="hidden" name="price" value="{{ $items->price }}">
                                                        <input type="submit" class="btn btn-success btn-lg" value="Beli">
                                                    </form>
                            </td>
                        </tr>
                                    @endforeach
                    </table>

                        </div>
                        <div class="tab-pane fade" id="tab2default">

                    <table class="table table-striped">
@foreach ($drinks as $items)
                            

                        <tr>
                            <td><b>{{ $items->name }}</b></td>
                            <td align="right">{{ number_format($items->price ,2, ',' , '.')  }}</td>
                            <td align="right">
                                <form action="{{ url('/employee/shop') }}" method="POST" class="side-by-side">
                                                        {!! csrf_field() !!}
                                                        <input type="hidden" name="id" value="{{ $items->id }}">
                                                        <input type="hidden" name="name" value="{{ $items->name }}">
                                                        <input type="hidden" name="price" value="{{ $items->price }}">
                                                        <input type="submit" class="btn btn-success btn-lg" value="Beli">
                                                    </form>
                            </td>
                        </tr>
                                    @endforeach
                    </table>
                        </div>
                    </div>
                </div>
            </div>


    </div>

    <div class="col-md-5" style="border: 2px solid #dddddd;">
        <h4><b>Daftar Pesanan</b></h4>

        @if (sizeof(Cart::content()) > 0)

        <table class="table">
            <thead>
                <tr>
                    <th width="55%">Nama</th>
                    <th width="5%">Jumlah</th>
                    <th width="30%">Harga</th>
                    <th class="column-spacer" width="10%"></th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach (Cart::content() as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>
                        <select class="quantity" data-id="{{ $item->rowId }}" name="quantity">
                            <option {{ $item->qty == 1 ? 'selected' : '' }}>1</option>
                            <option {{ $item->qty == 2 ? 'selected' : '' }}>2</option>
                            <option {{ $item->qty == 3 ? 'selected' : '' }}>3</option>
                            <option {{ $item->qty == 4 ? 'selected' : '' }}>4</option>
                            <option {{ $item->qty == 5 ? 'selected' : '' }}>5</option><!-- 
                            <option {{ $item->qty == 6 ? 'selected' : '' }}>6</option>
                            <option {{ $item->qty == 7 ? 'selected' : '' }}>7</option>
                            <option {{ $item->qty == 8 ? 'selected' : '' }}>8</option>
                            <option {{ $item->qty == 9 ? 'selected' : '' }}>9</option>
                            <option {{ $item->qty == 10 ? 'selected' : '' }}>10</option> -->
                        </select>
                    </td>
                    <td>{{ number_format($item->subtotal ,2, '.' , ',')  }}</td>
                    <td>
                        <form action="{{ url('/employee/shop', [$item->rowId]) }}" method="POST" class="side-by-side">
                            {!! csrf_field() !!}
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="submit" class="btn btn-danger btn-sm" value="Hapus">
                        </form>
                    </td>
                </tr>

                @endforeach
                <tr>
                    <td colspan="2" class="small-caps table-bg" style="text-align: right">Total Harga</td>
                    <td colspan="2" >{{ Cart::subtotal() }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2" class="small-caps table-bg" style="text-align: right">Jumlah Dibayar</td>
                    <td colspan="2" >
                        <form action="{{ url('/employee/checkout') }}" method="GET">
                            {!! csrf_field() !!}
                            <!-- <input type="text" class="form-control" placeholder="" name="cash" required=""> -->
                            <input type="text" class="form-control" id="userinput">
                            <br>
                            <input type="hidden" id="number" name="cash">
                            <input type="hidden" class="form-control" placeholder="Penerimaan" name="total" value="{{ Cart::subtotal(0,'','') }}">
                        
                             <!-- <input type="submit" class="btn btn-danger btn-lg" value="Checkout"> -->
                    </td>
                    <td></td>
                </tr>

            </tbody>
        </table>

        <input type="submit" class="btn btn-success btn-lg" value="Checkout">
        </form>

        <div style="float:right">
            <form action="{{ url('/employee/emptyCart') }}" method="POST">
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="DELETE">
                <input type="submit" class="btn btn-danger btn-lg" value="Kosongkan Daftar Pesanan">
            </form>
        </div>
        <br><br>

        @else

        <br><br>
        <div style="text-align: center;">Tidak ada produk dalam daftar pesanan</div>
        <br><br>

        @endif
    </div>
</div>

@endsection

@section('extra-js')
<script>
(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.quantity').on('change', function() {
        var id = $(this).attr('data-id')
        $.ajax({
          type: "PATCH",
          url: '{{ url("/employee/shop") }}' + '/' + id,
          data: {
            'quantity': this.value,
        },
        success: function(data) {
            window.location.href = '{{ url('/employee/shop') }}';
        }
    });

    });

})();

</script>

<script type="text/javascript">
    document.getElementById("userinput").onblur =function (){    

    //number-format the user input
    this.value = parseFloat(this.value.replace(/,/g, ""))
                    .toFixed(2)
                    .toString()
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    //set the numeric value to a number input
    document.getElementById("number").value = this.value.replace(/,/g, "")

}
</script>
@endsection
