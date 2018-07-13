<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\Http\Requests;
use \Cart as Cart;
use Validator;
use App\Menu;
use DB;

class CartController extends Controller
{
    public function index()
    {
        $foods = DB::table('menus')
        ->where('menus.type', 'Makanan')
        ->where('menus.status', 'Aktif')
        ->select('menus.*')
        ->get();

        $drinks = DB::table('menus')
        ->where('menus.type', 'Minuman')
        ->where('menus.status', 'Aktif')
        ->select('menus.*')
        ->get();

        $menus = Menu::all();

        // dd($menus);
        return view('frontend.cart', ['foods'=>$foods, 'drinks'=>$drinks]);
    }

    public function indexx()
    {
        return view('frontend.receipt');
    }
    
    public function store(Request $request)
    {
        $duplicates = Cart::search(function ($cartItem, $rowId) use ($request) {
            return $cartItem->id === $request->id;
        });

        if (!$duplicates->isEmpty()) {
            return redirect('/employee/shop')->withSuccessMessage('Item is already in your cart!');
        }

        Cart::add($request->id, $request->name, 1, $request->price)->associate('App\Product');
        return redirect('/employee/shop')->withSuccessMessage('Item was added to your cart!');
    }

    public function update(Request $request, $id)
    {
        // Validation on max quantity
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|between:1,5'
        ]);

         if ($validator->fails()) {
            session()->flash('error_message', 'Quantity must be between 1 and 5.');
            return response()->json(['success' => false]);
         }

        Cart::update($id, $request->quantity);
        session()->flash('success_message', 'Quantity was updated successfully!');

        return response()->json(['success' => true]);

    }

    public function destroy($id)
    {
        Cart::remove($id);
        return redirect('/employee/shop')->withSuccessMessage('Item has been removed!');
    }

    public function emptyCart()
    {
        Cart::destroy();
        return redirect('/employee/shop')->withSuccessMessage('Your cart has been cleared!');
    }
}
