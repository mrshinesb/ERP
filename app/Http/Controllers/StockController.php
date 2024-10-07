<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        //update current stock qty
       
        $stock_list=Stock::all();
        foreach($stock_list as $s){
            $update_cqty=$s->pqty - $s->sqty ;
            Stock::where('code',$s->code)->update(['cqty'=>$update_cqty]);
        }


        $stocks=Stock::paginate(8);
        return view('stock.index',compact('stocks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('stock.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required',
            'desc' => 'required',           
            'pqty' => 'nullable',
            'cqty'=> 'nullable',
            'sqty' => 'nullable'
        ]);
        
        
  
        //dd( 'pqty = '.$request->pqty.' , sqty = '.$request->sqty);

        $update_cqty=$request->pqty -$request->sqty ;

 
       
        $rand_serial="CM"."_".rand(1000,9999);
        
        Stock::create([            
            'code'=>$request->code,
            'desc'=>$request->desc,
            'pqty'=>$request->pqty,
            'sqty'=>$request->sqty,
            'cqty'=>$update_cqty,
            'dprice' =>$request->dprice,
            'wprice' => $request-> wprice,           
            
        
        ]);

        return redirect()->route('stocks.index')->with('success','Saving Success...');
    }

    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $stocks=Stock::find($id);
        return view('stock.show',compact('stocks'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $stock=Stock::findOrFail($id);
        return view('stock.edit',compact('stock'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'serial' => 'request->serial',
            'code' => 'required',
            'desc' => 'required',            
            'dprice' => 'nullable',
            'sqty' => 'nullable',
            'pqty' => 'nullable',
            'wprice' => 'nullable',
        ]);

        $stock=Stock::find($id);
        $stock->code=$request->code;
        $stock->desc=$request->desc;
        $stock->dprice=$request->dprice;
        $stock->pqty=$request->pqty;
        $stock->sqty=$request->sqty;
        $stock->wprice=$request->wprice;
        $stock->save();

        return redirect()->route('stocks.index')->with('success','Update Success...');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $stock=Stock::find($id);
        $stock->delete();
        return redirect()->route('stocks.index')->with('success','Deltete Success...');
    }

    /*
    * param: code
    * return wprice 
    */

    public function getWPrice($code){

        $stock=Stock::where('code','=',$code)->get();
        return response()->json($stock);


    }
}
