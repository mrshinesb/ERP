@extends('layouts.stock')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Sale</h2>
        </div>
        <div class="pull-right">
          
            <a class="btn btn-success btn-sm mb-2" href="{{ route('sales.create') }}"><i class="fa fa-plus"></i> Enter New Sale</a>
          
        </div>
    </div>
</div>




<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th>Serial</th>
        <th>Code</th>
        <th>Items Description</th>
        <th>Sale Quantity</th>       
        <th>Wholesale Price</th>
        <th>Current Quantity</th>
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
    
    @foreach ($sales as $sale)

        @php

        $curr_qty=getStockQty($sale->code);

        $totalCQty=$totalCQty+$curr_qty;
        @endphp

   
   
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $sale->serial}}</td>
        <td>{{ $sale->code}}</td>
        <td>{{ $sale->desc }}</td>
        <td>{{ $sale->sqty }}</td>
        <td>{{ $sale->wprice }}</td>
        <td>{{ getStockQty($sale->code) }}</td>
       
        <td>
            <form action="{{ route('sales.destroy',$sale->id) }}" method="POST">
                <a class="btn btn-info btn-sm" href="{{ route('sales.show',$sale->id) }}"><i class="fa-solid fa-list"></i> Show</a>
              
                <a class="btn btn-primary btn-sm" href="{{ route('sales.edit',$sale->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
               

                @csrf
                @method('DELETE')

               
                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
              
            </form>
        </td>
    </tr>

   
    @endforeach
    <tr>
        <td colspan="6" class="bg-secondary text-white text-center"> Total Stock Current Qty </td>
        <td> @php echo $totalCQty; @endphp </td>
        <td></td>
    </tr>

</table>

{!! $sales->links() !!} </p> </td>
@endsection
