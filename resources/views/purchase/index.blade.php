@extends('layouts.stock')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Purchase</h2>
        </div>
        <div class="pull-right">
          
            <a class="btn btn-success btn-sm mb-2" href="{{ route('purchases.create') }}"><i class="fa fa-plus"></i> Enter New Purchase</a>
          
        </div>
    </div>
<table class="table table-bordered">
    <tr>
        <th>No</th>
    
        <th>Code</th>
        <th>Items Description</th>
        <th>Purchase Quantity</th>
        <th>Dealer Price</th>
        <th>Current Quantity</th>
        <th>Wholesale Price</th>
        <th>Balance Amound</th>
        <th width="280px">Action</th>
    </tr>
  
    
    @php $i=0 @endphp 
    

    @php 

$totalCQty=0;

 function getStockQty($code){
    $obj=App\Models\Stock::where('code',$code)->get();
    return $obj[0]->cqty;
}

@endphp


    @foreach ($purchases as $purchase)

    @php

$curr_qty=getStockQty($purchase->code);

$totalCQty=$totalCQty+$curr_qty;
@endphp
   
    <tr>
        <td>{{ ++$i }}</td>        
        <td>{{ $purchase->code}}</td>
        <td>{{ $purchase->desc }}</td>
        <td>{{ $purchase->pqty }}</td>        
        <td>{{ $purchase->dprice }}</td>
        <td>{{ getStockQty($purchase->code)  }}</td>
        <td>{{ 'getWprice from StockController' }}</td>
        <td>{{'getCqty from StockController'}}</td>
      
       
        <td>
            <form action="{{ route('purchases.destroy',$purchase->id) }}" method="POST">
                <a class="btn btn-info btn-sm" href="{{ route('purchases.show',$purchase->id) }}"><i class="fa-solid fa-list"></i> Show</a>
              
                <a class="btn btn-primary btn-sm" href="{{ route('purchases.edit',$purchase->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
               

                @csrf
                @method('DELETE')

               
                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
              
            </form>
        </td>
    </tr>
    @endforeach
</table>

<p>
{!! $purchases->links() !!} </p> 

</div>


@endsection
