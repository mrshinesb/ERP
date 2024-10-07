@extends('layouts.stock')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add New Sale</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary btn-sm" href="{{ route('sales.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
            <a class="btn btn-warning btn-sm" href="{{ route('sales.index') }}" data-bs-toggle="modal" data-bs-target="#savingSaleModal"><i class="fa fa-save"></i> Save </a>
        </div>
        
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


   

    <table class="table table-borderless">
      <tr>
            <td>Item Code</td>
            <td>Description</td>
            <td>Sale Qty</td>
            <td>Sale Price</td>
            <td></td>
            <td></td>
           
            <td>Action</td>
        </tr>
    
        @if(count($carts)>0)
          
           @foreach($carts as $cart)
            <tr>
            <td>
            <input type="text" name="code" value="{{$cart->code}}" class="form-control stockcode">
           
            </td>
            <td>
            <input type="text" name="desc" value="{{$cart->desc}}" class="form-control stockdesc">
          
            </td>
            <td>
            <input type="text" name="sqty" value="{{$cart->sqty}}" class="form-control stocksqty">
            
            </td>
            
            <td>
            <input type="text" name="wprice" value="{{$cart->wprice}}" class="form-control stockwprice">
           
            </td>
           



            <td class="d-flex flex-row justify-content-end gap-2">

            <a href="#" data-id="{{$cart->id}}" class="btn btn-primary mt-2 editBtn" data-bs-toggle="modal" data-bs-target="#updateSaleModal">
                <i class="fa fa-refresh"></i>
           </a>
            <a href="{{route('salecart.remove',$cart->id)}}" class="btn btn-danger mt-2">
                <i class="fa fa-trash"></i>
           </a>

            </td>
          </tr>





           @endforeach

           @endif 


           <form action="{{ route('salecart.add') }}" method="POST">

           @csrf 

           <tr>
            <td>
            <input type="text" name="code" class="form-control" required>
            </td>
            <td>
            <input type="text" name="desc" class="form-control" required>
            </td>
            <td>
            <input type="text" name="sqty" class="form-control" required>
            </td>
            <td>
            <input type="text" name="wprice" class="form-control b-price" required>
            </td>
            
           
            <td>
            <button type="submit" class="btn btn-success mt-2">
                <i class="fa fa-plus"></i>  </button>
            </td>
        </tr>      
    </table>
</form>

<!-- saving popup Modal--> 

<div class="modal" id="savingSaleModal" tabindex="-1">
  <div class="modal-dialog">
    <form action="{{route('salecart.save')}}" method="post">
      @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Saving Sale Items</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="text" class="form-control" name="sinv" placeholder="Type Invoice No">
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Continue to save </button>
      </div>
     </form>
    </div>
  </div>
</div>


<!-- end of saving pop up modal --> 


<!-- update popup Modal--> 

<div class="modal" id="updateSaleModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Edit Sale Items</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
     <form action="#" method="post">
        @csrf 
        @method('PATCH')
      <div class="modal-body">
        <input type="text" name="code" class="form-control editcode mb-3" >
        <input type="text" name="desc" class="form-control editdesc mb-3" >
        <input type="text" name="sqty" class="form-control editsqty mb-3" >
        <input type="text" name="wprice" class="form-control editdprice mb-3" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Continue to update </button>
      </div>
     </form>
    </div>
  </div>
</div>


<!-- end of update pop up modal --> 





<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>



$(".editBtn").click(function (e){
        var id = $(this).data('id');
        $.ajax({
            type: 'GET',
            url: "{{url('sale-cart-edit')}}/"+id,
            cache: false,
            success: function(data){  
               
                $(".editcode").val(data['code']);
                $(".editdesc").val(data['desc']);
                $(".editsqty").val(data['sqty']);
                $(".editwprice").val(data['wprice']);
            },
            error:
                   console.log('unknown error....')

        });

   
});


$("#saveBtn").click(function (e){
    
    if(e.keyCode==13){

        alert('flag 1...');
        let formData = new FormData(this);
        //console.log('saving purchased data now...');
        
        $.ajax({
            type: 'POST',
            url: "{{route('sales.store')}}",
            data: formData,
            cache: false,
            success: function(res){  
                console.log(res);
            },
            error:
                   console.log('unknown error....')
        });
   }
});

$(".stock").click(function (e){
    
    if(e.keyCode==13){

        alert('flag 1...');
        let formData = new FormData(this);
        //console.log('saving purchased data now...');
        
        $.ajax({
            type: 'POST',
            url: "{{route('sales.store')}}",
            data: formData,
            cache: false,
            success: function(res){  
                console.log(res);
            },
            error:
                   console.log('unknown error....')
        });
   }
});
</script>



@endsection
