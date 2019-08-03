@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> 
    <style type="text/css">
        .card{
            margin-bottom: 0px;
        }
        .btn-default{
            color: #fff;
            background-color: #ccc;
            border-color: #ccc;
        }
        .active{
            background-color: #007bff !important; 
        }
        .pic {
            width: 100%;
            height: 100%;
        }
    </style>
@endsection

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

            @if(isset($promotions) && empty($promo_id))
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
                                    <a href="{{route('promotions.show',['promotions'=>$id, 'promo_id'=>$promotions->promo_id])}}" data="2" class="btn-edit"><span class="text-success">Edit</span></a>
                                    |
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

            @if(isset($promo_id))
            <div class="row">
                <div class="col-md-12"> 
                    <form method="PUT" action="{{route('promotions.update',['promotions' => $promo_id])}}" id="editPromoform" autocomplete="off">
                        <div class="row">
                             <div class="col-md-5">
                             <div class="form-group">
                                <input type="hidden" name="promo_id" id="promo_id" value="{{$promo_id}}">
                                <input type="hidden" name="merchant_id" id="merchant_id" value="{{$id}}">
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label class="mb-2 font-12">{{__('Promotion Name')}}</label>
                                    <input type="text" name="promo_name" id="promo_name" placeholder="Promotion Name" value="{{$current_promo->promo_name}}" required="" class="form-control">

                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="mb-2 font-12">{{__('Amount')}}</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-primary font-weight-bold" id="basic-addon1">S$</span>
                                            </div>
                                             <input type="text" name="amount" id="promo_amount" value="{{$current_promo->amount}}" aria-describedby="basic-addon1" class="form-control text-primary text-right font-weight-bold" onkeypress="return isNumber(event)">

                                        </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="mb-2 font-12">Other Offer</label>
                                        <div class="input-group mb-2">
                                             <input type="text" name="other_offer" id="other_offer" value="{{$current_promo->other_offer}}" class="form-control" maxlength="15">

                                        </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">

                                <div class="form-group">
                                    <label class="mb-2 font-12">Description</label>
                                    <textarea style="height: 200px;" type="text" name="description" id="description" required="" value="" class="form-control">{{$current_promo->description}}</textarea>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <label class="mb-2 font-12">Active</label><br>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                            <label class="btn btn-default @if($current_promo->active=="Y") active @endif" id="yes_active">
                                                <input type="radio" name="options" autocomplete="off"> Yes
                                            </label>
                                            <label class="btn btn-default @if($current_promo->active!="Y") active @endif" id="no_active">
                                                <input type="radio" name="options" autocomplete="off"> No
                                            </label>

                                        </div>

                                        <input type="hidden" name="active_txt" id="active_txt" @if($current_promo->active) value="Y" @else value="N" @endif>

                                        <br><br>

                                        <label class="mb-2 font-12">Redeemable</label><br>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                            <label class="btn btn-default @if($current_promo->redeemable=="Y") active @endif" id="yes_redeemable">
                                                <input type="radio" name="redeemable" autocomplete="off"> Yes
                                            </label>
                                            <label class="btn btn-default @if($current_promo->redeemable!="Y") active @endif" id="no_redeemable">
                                                <input type="radio" name="redeemable" autocomplete="off"> No
                                            </label>

                                        </div>

                                        <input type="hidden" name="redeemable_txt" id="redeemable_txt" value="{{$current_promo->redeemable}}">
                            </div>

                            <div class="col-md-3">
                                <label class="mb-2 font-12">Promotion Starts on</label>
                                <div class="input-group">
                                    <input type="text" name="start_on" id="start_date" placeholder="Start Date" class="form-control py-2 border-right-0 border hasDatepicker" value="{{$current_promo->start_on}}">

                                                <span class="input-group-append">
                                                        <button class="btn btn-outline-secondary border-left-0 border" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                        </button>
                                                    </span>
                                        </div>
                            <br>
                                <div class="checkbox">
                                                <label class="mb-2 font-12">
                                                    <input type="checkbox" value="Y" name="no_end_date" id="no_end_date" @if($current_promo->no_end_date) checked @endif> 
                                                No End Date</label>
                                            </div>

                                <label class="mb-2 font-12">Promotion Ends on </label>
                                <div class="input-group">
                                    <input type="text" name="ends_on" id="end_date" placeholder="End Date" value="{{$current_promo->ends_on}}" class="form-control py-2 border-right-0 border hasDatepicker" @if($current_promo->no_end_date) disabled @endif>
                                                <span class="input-group-append">
                                                        <button class="btn btn-outline-secondary border-left-0 border" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                        </button>
                                                    </span>
                                        </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary" id="btnEditPromo">Update</button>
                            </div>
                        </div>
                    </form>
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

      $('#start_date, #end_date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
          format: 'MM/DD/YYYY'
        }
      });

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

    // update
    $(document).on('submit','#editPromoform', function(e){
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


    //
    $('#no_end_date').click(function() {
        if ($(this). prop("checked") == true) {
                $("#end_date").attr('disabled', true).val("");
        }
        else {
                $("#end_date").attr('disabled', false);
        }
    });

    $('#yes_redeemable').click(function(){
            $('#redeemable_txt').val('Y');
        });

        $('#no_redeemable').click(function(){
            $('#redeemable_txt').val('N');
        });

    $('#yes_active').click(function(){
            $('#active_txt').val('Y');
        });

        $('#no_active').click(function(){
            $('#active_txt').val('N');
        });
   });
  function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 46 || charCode > 57) ) {
                    return false;
            }

            return true;
    }
  </script>
@endsection