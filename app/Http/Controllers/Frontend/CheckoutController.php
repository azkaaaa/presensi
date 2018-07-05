<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
    	$cash = $request->cash;

    	$total = $request->total;

    	$result = $cash - $total;

    	if($result < 0){

    		session()->flash('message', 'Uang yang anda masukan kurang dari jumlah belanja.');
    		return redirect()->back();
    	}
    else{

        return view('frontend.checkout',['result'=>$result, 'cash'=>$cash]);
    }
    }
}
