<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Order;
use App\Menu;
use App\OrderDetail;
use Carbon\Carbon;
use DB;
use PDF;
use Auth;
use \Cart as Cart;

use Yajra\Datatables\Datatables;

class OrderController extends Controller
{
    public function postCheckout(Request $request){
        
        $id = Auth::id();

        $now = Carbon::now();
        $status = 'paid';
        $parsed_price = (float) str_replace(',', '', $request->total_price);
        $cash = $request->cash;

        $return = $request->return;

        $order =  new Order();
        $order->status = $status;
        $order->transaction_no = $this->getUniqueID();
        $order->order_date = $now;
        $order->total_price = $parsed_price;
        $order->cash = $cash;
        $order->return = $return;
        $order->user_id = $id;
        $order->save();

        // $menus = $request->id;
        // $qty = $request->qty;
        //     foreach($menus as $menu){
        //         $menu_id = Menu::find($menu);
        //         $order_detail =  new OrderDetail();
        //         $order_detail->menu_id = $menu;
        //         $order_detail->qty = $qty;
        //         $order_detail->order_id = $order->id;
        //         $order_detail->save();
        //     }
        foreach (Cart::content() as $item){
            $menu_id = Menu::find($item->id);
                $order_detail =  new OrderDetail();
                $order_detail->menu_id = $item->id;
                $order_detail->qty = $item->qty;
                $order_detail->subtotal = $item->subtotal;
                $order_detail->order_id = $order->id;
                $order_detail->save();
        }
        

            Cart::destroy();

       return view('frontend.receipt', ['order_id'=>$order->id]);
    }

    public static function getUniqueID()
    {
      $q = Order::count();

        $kd = "";
        if($q>0)
        {
                $tmp = ((int)$q)+1;
                $kd = sprintf("%03s", $tmp);   
        }
        else
        {
            $kd = "001";
        }
        return "TRC-".$kd;
    }

    public function index()
    {
        return view('backend.transaction.index');
    }

    public function dataTransactions()
    {
        // $orders = Order::select(['id', 'transaction_no', 'total_price', 'user_id', 'status', 'order_date', 'created_at', 'updated_at']);

        $orders = DB::table('orders')
        ->join('users','users.id', '=','orders.user_id')
        ->select('orders.*', 'users.name as user_name')
        ->orderBy('orders.id', 'desc');
        

        
          return Datatables::of($orders)
          ->addColumn('action', function ($orders) {
                return '<a href="'.url('admin/transaction/'. $orders->id).'" class="btn-sm  btn-primary"> Detail</a>';
            }
            )
            ->make(true);
    }

    public function show($id)
    {
        $orders = DB::table('orders')
        ->join('users', 'users.id', '=','orders.user_id')
        ->where('orders.id', $id)
        ->select('orders.*', 'users.name as user_name')
        ->first();

        $order_detail = DB::table('order_detail')
        ->where('order_detail.order_id', $id)
        ->join('menus', 'menus.id', '=','order_detail.menu_id')
        ->select('order_detail.*', 'menus.name as menu_name', 'menus.price as menu_price')
        ->get();

        return view('backend.transaction.detail', ['orders'=>$orders, 'order_detail'=>$order_detail]);
    }

    public function printReceipt($id)
    {
        $orders = DB::table('orders')
        ->where('orders.id', $id)
        ->select('orders.*')
        ->first();


        $order_detail = DB::table('order_detail')
        ->where('order_detail.order_id', $id)
        ->join('menus', 'menus.id', '=','order_detail.menu_id')
        ->select('order_detail.*', 'menus.name as menu_name', 'menus.price as menu_price')
        ->get();

        $customPaper = array(0,0,280,400);

        $pdf = PDF::loadView('backend/pdf/receipt', ['orders' => $orders, 'order_detail' => $order_detail])->setPaper($customPaper);
        return $pdf->stream('Receipt_'.$orders->transaction_no.'_'.$orders->order_date.'.pdf');

        // $pdf = PDF::loadView('backend/pdf/newreceipt', ['orders' => $orders, 'order_detail' => $order_detail]);
        // return $pdf->stream('Receipt_'.$orders->transaction_no.'_'.$orders->order_date.'.pdf');
    }



  public function getList()
    {
        $transaction = DB::table('orders')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->select('orders.*', 'users.*', 'users.name as user_name', DB::raw('sum(orders.total_price) as total_all'), DB::raw('YEAR(orders.order_date) year, MONTH(orders.order_date) month'))
            ->groupby('year','month')
            ->get();
        
        $total_transaction = DB::table('orders')
        ->select(DB::raw('sum(orders.total_price) as total_all'),DB::raw('YEAR(orders.order_date) year, MONTH(orders.order_date) month'),DB::raw('count(orders.transaction_no) as total_trans'))
        ->groupby('year','month')
        ->first();

        // $order_detail = DB::table('order_detail')
        // ->where('order_detail.order_id', $id)
        // ->join('menus', 'menus.id', '=','order_detail.menu_id')
        // ->select('order_detail.*', 'menus.name as menu_name', 'menus.price as menu_price')
        // ->get();
            // ->whereMonth('presences.date', '=', $dt->month);
        
        // return view('backend.transaction.history', ['transaction'=>$transaction]);

        return view('backend.transaction.history', ['transaction'=>$transaction, 'total_transaction'=>$total_transaction]);  
    }

    public function searchTransaction(Request $request)
    {
        $month = $request->month;
        $year = $request->years;

        if($month==0){
            $transaction = Order::select('*', DB::raw('sum(orders.total_price) as total_all'))
            ->where(DB::raw('YEAR(orders.order_date)'), $year)
            ->groupby(DB::raw('YEAR(orders.order_date)'),DB::raw('MONTH(orders.order_date)'))
            ->get();
        }
        elseif($year==0){
            $transaction = Order::select('*', DB::raw('sum(orders.total_price) as total_all'))
            ->where(DB::raw('MONTH(orders.order_date)'), $month)
            ->groupby(DB::raw('YEAR(orders.order_date)'),DB::raw('MONTH(orders.order_date)'))
            ->get();
      }
        else{
        $transaction = Order::select('*', DB::raw('sum(orders.total_price) as total_all'))
            ->where(DB::raw('MONTH(orders.order_date)'), $month)
            ->where(DB::raw('YEAR(orders.order_date)'), $year)
            ->groupby(DB::raw('YEAR(orders.order_date)'),DB::raw('MONTH(orders.order_date)'))
            ->get();
      }
        if ($transaction){
          session()->flash('transaction_found', true);
        }
        else{
          session()->flash('transaction_not_found', true);
        }

        $total_transaction = DB::table('orders')
        ->select(DB::raw('sum(orders.total_price) as total_all'),DB::raw('YEAR(orders.order_date) year, MONTH(orders.order_date) month'),DB::raw('count(orders.transaction_no) as total_trans'))
        ->groupby('year','month')
        ->first();
        
        return view('backend.transaction.history', ['transaction'=>$transaction, 'total_transaction'=>$total_transaction]);  
    }

    public function printHistoryTransaction($history)
    { 
      // $salary = Salary::where('history', $history)->get();

      $orders = DB::table('orders')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->select('orders.*', 'users.*', 'users.name as user_name', DB::raw('YEAR(orders.order_date) year, MONTH(orders.order_date) month'))
            ->where(DB::raw("DATE_FORMAT(orders.order_date, '%m-%Y')"), '=', $history)
            ->get();

      $total = DB::table('orders')
            ->select( DB::raw('sum(orders.total_price) as total_all'), DB::raw('count(orders.transaction_no) as total_trans'), 'orders.*', DB::raw('YEAR(orders.order_date) year, MONTH(orders.order_date) month'))
            ->groupby('year','month')
            ->where(DB::raw("DATE_FORMAT(orders.order_date, '%m-%Y')"), '=', $history)
            ->first();

        $pdf = PDF::loadView('backend/pdf/transaction', ['orders' => $orders, 'total' => $total]);
        return $pdf->stream('Transaction_'.$total->month.'_'.$total->year.'.pdf');
    }
}


