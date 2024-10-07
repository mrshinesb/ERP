<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaleCart;
use App\Models\Sale;
use App\Models\Stock;
use Illuminate\Support\Collection;

class SaleCartController extends Controller
{

    /*
      update item using id
      return back to active page
    */

    public function index(){

        $carts=SaleCart::all();
        return view('sale.create',compact('carts'));
    }

    public function update(Request $request,$id){



        $cart=SaleCart::find($id);

      
       

    
        return redirect()->back();
    
        
       }



    /*
      remove item using id
      return back to active page
    */



   public function remove(Request $request,$id){

    $cart=SaleCart::find($id);
    $cart->delete();

    return redirect()->back();

    
   }


    /*
      add new item
      return back to active page
    */


    public function add(Request $request){

      

         SaleCart::create([
            'code'=>$request->code,
            'desc'=>$request->desc,
            'sqty'=>$request->sqty,           
            'wprice'=>$request->wprice,
            
         ]);

     

         return redirect()->route('sales.create');
     
    }

    public function edit(Request $request,$id){
        $cart=SaleCart::find($id);
        return response()->json($cart);
    }


    public function save(Request $request){

      $carts=SaleCart::all();
  

      foreach($carts as $cart){


          //update sqty at stock controller

          $stock=Stock::where('code','=',$cart->code)->get();
          $curr_sqty=$stock[0]['sqty'];
          $update_sqty=$curr_sqty + $cart->sqty;
 
          //update sqty
    
          Stock::where('code',$cart->code)->update(['sqty'=>$update_sqty]);

          //save new bunch of sales
     
        Sale::create([
          'code'=>$cart->code,
          'desc'=>$cart->desc,
          'wprice'=>$cart->wprice,
          'sqty'=>$cart->sqty,
          
          'sinv'=>$request->sinv,
        ]);



        

      }

    
      


    
      //clear all sales cart
      SaleCart::truncate();

      return redirect()->back();


    }
}
