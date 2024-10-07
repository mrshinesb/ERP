@extends('layouts.stock')

@section('content')
<div class="container "> 
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Stocks</h2>
        </div>
        <div class="pull-right">
          
            <a class="btn btn-success btn-sm mb-2" href="{{ route('stocks.create') }}"><i class="fa fa-plus"></i> Add New Stock</a>
          
        </div>
    </div>
</div>

</div>

<div class="container"> 



<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th>Serial</th>
        <th>Code</th>
        <th>Items Description</th>
        <th>Purchase Quantity</th>
        <th>Sale Quantity</th>
        <th>Current Quantity</th>
        <th>Dealer Price</th>
        <th>Wholesale Price</th>
        <th>Balance Amound</th>
        <th width="280px">Action</th>
    </tr>
  
    
    @php $i=0
    @endphp,

    
    @foreach ($stocks as $stock)
   
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $stock->serial}}</td>
        <td>{{ $stock->code}}</td>
        <td>{{ $stock->desc }}</td>
        <td>{{ $stock->pqty }}</td>
        <td>{{ $stock->sqty }}</td>
        <td>{{ ($stock->pqty)-($stock->sqty)}}</td>
        <td>{{ $stock->dprice }}</td>
        <td>{{ $stock->wprice }}</td>
        <td>{{($stock->wprice)* ($stock->pqty - $stock->sqty)}}</td>
        <td>
            <form action="{{ route('stocks.destroy',$stock->id) }}" method="POST">
                <a class="btn btn-info btn-sm" href="{{ route('stocks.show',$stock->id) }}"><i class="fa-solid fa-list"></i> Show</a>
              
                <a class="btn btn-primary btn-sm" href="{{ route('stocks.edit',$stock->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
               

                @csrf
                @method('DELETE')

               
                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
              
            </form>
        </td>
    </tr>
    @endforeach


    <tr>
        <td colspan="10"> Total Purchse Value </td>
        <td> 

        @if(isset($stock))
            
        <p>{{($stock->sum('pqty'))* ($stock->sum('dprice'))}}</p> 

        @endif
    
       </td>

    </tr>
    
    <tr>
        <td colspan="10"> Total Sale Value  </td>
        <td> 
        @if(isset($stock))
            <p> {{($stock->sum('sqty'))* ($stock->sum('wprice'))}}</p> 
        @endif

        </td>
        
    </tr>
    <tr>
        <td colspan="10">Total Profit  </td>
        <td>
        @if(isset($stock))
             <p>  {{(($stock->sum('sqty')) * ($stock->sum('wprice'))-(($stock->sum('sqty')*($stock->sum('dprice')))))}}</p>


        @endif

        {!! $stocks->links() !!} </p> </td>
        
    </tr>

</table>



</div>

@endsection
