<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleCart;
use App\Models\Stock;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales=Sale::paginate(8);
        return view('sale.index',compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $carts=SaleCart::all();
        return view('sale.create',compact('carts'));
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
            'sqty' => 'required',
            
        ]);


      




        //$rand_serial="PR"."_".rand(1000,9999);


        
        Sale::create([
           
            'code'=>$request->code,
            'desc'=>$request->desc,
            'sqty'=>$request->sqty,     
            'dprice'=>$request->dprice,
            'wprice'=>$request->wprice,
           
        
        ]);

        return response()->json(['success'=>'Sale saved successfully.']);
       // return redirect()->route('sales.index')->with('success','Saving Success...');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        $sale=Sale::find($id);
        return view('sale.show',compact('sales'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        $sale=Sale::findOrFail($id);
        return view('sale.edit',compact('sale'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        
        $validated = $request->validate([
            'serial' => 'request->serial',
            'code' => 'required',
            'desc' => 'required',            
            'sqty' => 'required',
            'wprice' => 'required',
          
        ]);

        $sale=Sale::find($id);
        $sale->code=$request->code;
        $sale->desc=$request->desc;
        $sale->sqty=$request->sqty;
        $sale->wprice=$request->wprice;
        $sale->save();

        return redirect()->route('sales.index')->with('success','Update Success...');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sale=Sale::find($id);
        $sale->delete();
        return redirect()->route('sales.index')->with('success','Deltete Success...');
    }


    public function saveData(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable',
            'desc' => 'required',           
            'sqty' => 'required',
            'wprice' => 'required',
            
           
        ]);



          //update sqty at stock controller

          $stock=Stock::where('code',$request->code)->get();
          //dd($stock);
          
          $curr_sqty=$stock[0]['sqty'];
          $update_sqty=$curr_sqty + $request->sqty;
          //$stock[0]['pqty']=$update_pqty;
          //dd($update_pqty);

          $stock->update(['sqty'=>$update_sqty]);
  


        //$rand_serial="PR"."_".rand(1000,9999);
        Sale::create([
            'code'=>$request->code,
            'desc'=>$request->desc,
            'sqty'=>$request->sqty,        
            
            'wprice'=>$request->wprice,
           
        ]);

        return response()->json(['message'=>'saving success...']);
    
    }
}
