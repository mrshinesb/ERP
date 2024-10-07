<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseCart;
use App\Models\Purchase;
use App\Models\Stock;
use Illuminate\Support\Collection;

class PurchaseCartController extends Controller
{

    /*
      update item using id
      return back to active page
    */

    public function index(){

        $carts=PurchaseCart::all();
        return view('purchase.create',compact('carts'));
    }

    public function update(Request $request,$id){



        $cart=PurchaseCart::find($id);

      
       

    
        return redirect()->back();
    
        
       }



    /*
      remove item using id
      return back to active page
    */



   public function remove(Request $request,$id){

    $cart=PurchaseCart::find($id);
    $cart->delete();

    return redirect()->back();

    
   }


    /*
      add new item
      return back to active page
    */


    public function add(Request $request){

      

         PurchaseCart::create([
            'code'=>$request->code,
            'desc'=>$request->desc,
            'pqty'=>$request->pqty,
            'dprice'=>$request->dprice,
            'wprice'=>$request->wprice,
           
         ]);

     

         return redirect()->route('purchases.create');
     
    }

    public function edit(Request $request,$id){
        $cart=PurchaseCart::find($id);
        return response()->json($cart);
    }


    public function save(Request $request){

      $carts=PurchaseCart::all();
  

      foreach($carts as $cart){


          //update pqty at stock controller

          $stock=Stock::where('code','=',$cart->code)->get();
          $curr_pqty=$stock[0]['pqty'];
          $update_pqty=$curr_pqty + $cart->pqty;
 
          //update qty
    
          Stock::where('code',$cart->code)->update(['pqty'=>$update_pqty]);

          //save new bunch of purchases
     
        Purchase::create([
          'code'=>$cart->code,
          'desc'=>$cart->desc,
          'dprice'=>$cart->dprice,
          'pqty'=>$cart->pqty,
         
          'invoice_no'=>$request->invoice_no,
        ]);

      }

    
      


    
      //clear all purchase cart
      PurchaseCart::truncate();

      return redirect()->back();


    }
}
