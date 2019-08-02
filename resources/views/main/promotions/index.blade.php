@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle">{{__('Manage Promotions')}}</div>
            <div class="card-body">

            <div class="row">
                <div class="col-md-3">
                    <label class="mb-2 font-12">{{__('Merchant')}}</label>
                    <input type="text" name="merchant_name" placeholder="Type Merchant Name" id="merchant_name" class="form-control" required="" value="{{@$current_merchant->merchant_name}}"  data-autocompleturl="{{route('merchants.search')}}"/>

                </div>
            </div>

            @if(isset($promotions))
            <br />
            <div class="row">
                <div class="col-md-12"> 

                    <form method="POST" action="{{route('promotions.store')}}" id="frm-add-promotion">
                        <input type="hidden" name="merchant_id" id="mall_id" value="{{$current_merchant->merchant_id}}">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="mb-2 font-12">{{__('Promotion Name')}}</label>
                                    <input type="text" name="promo_name" placeholder="Promotion Name" id="promo_name" class="form-control" required="">
                                </div>
                            </div>
 
 
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary col-md-12 top-t" id="btnMerchantPromotion">{{__('Add Promotion')}}</button>
                            </div>
                        </div>
                    </form>
                    <table class="table table-striped malle-table " id="promotion-table" data-sourceurl="{{route('promotions.show',['promotions'=>$id])}}">
                        <thead>
                            <tr>
                                <th>{{__('Promotion Name')}}</th>
                                <th>{{__('Merchant Name')}}</th>
                                <th>{{__('Created By')}}</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                         @foreach($promotions as $promotions)
                            <tr class="row-promotion" data-id="{{$promotions->promo_id}}">
                                <td>{{$promotions->promo_name}}</td> 
                                <td>{{$promotions->merchant->merchant_name}}</td> 
                                <td>{{$promotions->creator->short_name}}</td> 
                                <td>
                                    <a  href="javascript:;" data-href="{{route('promotions.destroy',['promotions'=>$promotions->promo_id])}}" data-method="DELETE" class="btn-delete" data-id="{{$promotions->promo_id}}">
                                        <span class="text-danger">Delete</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deletepromotionmodal" tabindex="-1" role="dialog" aria-labelledby="deletemodalpromotionlabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="deletemodalpromotionlabel">Delete Confirmation</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body ">
      <p class="font-12">Are you sure you want to delete this promotion?</p>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
      <button type="button" class="btn btn-danger" id="btnDeletePromotion">Yes</button>
    </div>
  </div>
</div>
</div>
@endsection


@section('script')
<script>
  $( function() {

    // malls
    $( "#merchant_name" ).autocomplete({
        source: function (request, response) {
            $.getJSON($("#merchant_name").attr('data-autocompleturl') +'/' + request.term, function (data) {
                response($.map(data, function (value, key) {
                    return {
                        label: value,
                        value: key
                    };
                }));
            });
        },
          select: function(event, ui) {
            $("#merchant_name").val(ui.item.label); 
            window.location.href = '{{route("promotions")}}/'+ui.item.value;

            return false;
          }
    });

 

    // store
    $(document).on('submit','#frm-add-promotion', function(e){
        e.preventDefault();
        var data = $(this).serialize();
        var url = $(this).attr('action');
        var type =  $(this).attr('method');

        $.ajax({
            url: url,
            type: type,       
            dataType:'json',
            data:data,
            success:function(data){
                if(data.status==='error'){
                    alert(data.message);
                }else{  
                    $('#promotion-table tbody').remove();
                    $("#promotion-table").load( $('#promotion-table').attr('data-sourceurl') +" #promotion-table tbody");
                    toastr.success("Successfully Added!");
                }   
            }
        });
 
    });   

    // delete
    $(document).on('click', '.btn-delete', function(e){
        e.preventDefault();
        var btndelete = $(this); 
 
        $('#deletepromotionmodal').modal('show');

        $('#btnDeletePromotion').unbind().click(function(){

            $.ajax({
                url: btndelete.attr('data-href'),
                type: btndelete.attr('data-method'),       
                dataType:'json',
                success:function(data){
                    if(data.status==='error'){
                        toastr.error(data.message);
                    }else{  
                        $('#deletepromotionmodal').modal('hide');
                        $('.row-promotion[data-id="'+btndelete.attr('data-id')+'"]').remove();
                        toastr.success(data.message);
                    }   
                }
            });
                 
        });
    });


  });
  </script>
@endsection