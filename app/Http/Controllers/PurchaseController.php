<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseCart;
use App\Models\Stock;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    
    {
        $purchases=Purchase::paginate(8);
        return view('purchase.index',compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $carts=PurchaseCart::all();
        return view('purchase.create',compact('carts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable',
            'desc' => 'required',           
            'dprice' => 'required',
            'wprice' => 'required',
            'pqty' => 'required',
         
        ]);


      




        //$rand_serial="PR"."_".rand(1000,9999);


        
        Purchase::create([
           
            'code'=>$request->code,
            'desc'=>$request->desc,
            'pqty'=>$request->pqty,     
            'dprice'=>$request->dprice,
            'wprice'=>$request->wprice,
           
        
        ]);

        return response()->json(['success'=>'Product saved successfully.']);
       // return redirect()->route('purchases.index')->with('success','Saving Success...');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        $purchase=Purchase::find($id);
        return view('purchase.show',compact('purchases'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        $purchase=Purchase::findOrFail($id);
        return view('purchase.edit',compact('purchase'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        
        $validated = $request->validate([
            'serial' => 'request->serial',
            'code' => 'required',
            'desc' => 'required',            
            'dprice' => 'required',
            'pqty' => 'required',
            'wprice' => 'required',
           
        ]);

        $purchase=Purchase::find($id);
        $purchase->code=$request->code;
        $purchase->desc=$request->desc;
        $purchase->dprice=$request->dprice;
        $purchase->wprice=$request->wprice;
        $purchase->save();

        return redirect()->route('purchase.index')->with('success','Update Success...');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $purchase=Purchase::find($id);
        $purchase->delete();
        return redirect()->route('purchases.index')->with('success','Deltete Success...');
    }


    public function saveData(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable',
            'desc' => 'required',           
            'dprice' => 'required',
            'wprice' => 'required',
            'pqty' => 'required',
            
        ]);



          //update pqty at stock controller

          $stock=Stock::where('code',$request->code)->get();
          //dd($stock);
          
          $curr_pqty=$stock[0]['pqty'];
          $update_pqty=$curr_pqty + $request->pqty;
          //$stock[0]['pqty']=$update_pqty;
          //dd($update_pqty);

          $stock->update(['pqty'=>$update_pqty]);
  


        //$rand_serial="PR"."_".rand(1000,9999);
        Purchase::create([
            'code'=>$request->code,
            'desc'=>$request->desc,
            'pqty'=>$request->pqty,        
            'dprice'=>$request->dprice,
            'wprice'=>$request->wprice,
          
        
        ]);

        return response()->json(['message'=>'saving success...']);
    
    }
}
