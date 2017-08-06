<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;

class CartController extends Controller {

    public function addCart(Request $request) {
        //add shopping list to database
        $cart_product = Cart::where('product_id', '=', $request->product_id)->first();
        if ($cart_product == NULL) {
            $cart = new Cart();
            $cart->user_id = $request->user_id;
            $cart->product_id = $request->product_id;
            $cart->quantity = $request->quantity;
            $cart->unit_id = $request->unit_id;
            $cart->price_min = $request->price_min;
            $cart->price_max = $request->price_max;
            $cart->is_priority = $request->is_priority;
            $cart->save();    
        } else {
            $total_quantity = $cart_product->quantity + $request->quantity;
            $price_min = $cart_product->price_min + $request->price_min;
            $price_max = $cart_product->price_max + $request->price_max;
            Cart::where('product_id', $request->product_id)
                ->update(array(
                            'quantity' => $total_quantity,
                            'price_min' => $price_min,
                            'price_max' => $price_max)
                        );
        }
        
        return "Pesanan Anda berhasil dimasukkan";
    }

    public function editCartByID(Request $request) {
        Cart::where('id', $request->id)
            ->update(array(
                        'quantity' => $request->quantity,
                        'unit_id' => $request->unit_id,
                        'price_min' => $request->price_min,
                        'price_max' => $request->price_max)
                    );

        return "Produk berhasil diubah";
    }

    public function editPriorityByID(Request $request) {
        Cart::where('id', $request->id)
            ->update(['is_priority' =>$request->is_priority]);

        return "Prioritas berhasil diubah";
    }

    public function getCartByUserID(Request $request) {
        //retrieve all shopping list from datbase based on user id
        $user_id = $request->user_id;
        $shopping_list = Cart::where('user_id', $user_id)->get();
        foreach ($shopping_list as $item) {
            $item = $item->product;
        }
        foreach ($shopping_list as $item) {
            $item = $item->unit;
        }
        $subMin = Cart::where('user_id', $user_id)->sum('price_min');
        $subMax = Cart::where('user_id', $user_id)->sum('price_max');
        
        return Response::json(array(
            'subTotalMin'=>$subMin,
            'subTotalMax'=>$subMax,
            'shopping_list'=>$shopping_list->toArray()),
            200
        );
    }

    public function deleteCartByID(Request $request) {
        //delete selected producy in cart
        $id = $request->id;
        $cart = Cart::find($id)->delete();

        return "Produk berhasil dihapus";
    }

    public function deleteCartByUserID(Request $request) {
        //delete all shopping list from database after checkout
        $id = $request->user_id;
        $cart = Cart::where('user_id', $id)->delete();

        return "Daftar belanja berhasil dihapus";
    }

    
}
