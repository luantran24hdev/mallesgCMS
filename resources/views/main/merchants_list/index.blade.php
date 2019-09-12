@extends('layouts.app')
@section('style')
    <style>
        .merch_out .select2-container--default .select2-selection--single .select2-selection__arrow{
            top: 5px !important;
        }
        .merch_out .select2-container .select2-selection--single {
            height: 38px !important;
        }

        .merch_out .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height: 35px;
        }

    </style>
    @endsection
@section('content')
<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle">{{__('Manage Merchants')}} ({{@$total_merchant}})</div>
            <div class="card-body">

            <div class="row merch_out">
                <div class="col-md-3">
                    <label class="mb-2 font-12">{{__('Merchant')}}</label>
                    <input type="text" name="merchant_name" placeholder="Type Merchant Name" id="merchant_name" class="form-control" required="" value="{{@$current_merchant->merchant_name}}"  data-autocompleturl="{{route('merchants.search')}}"/>

                </div>
                @if(!isset($id))
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="mb-2 font-12">{{__('Country')}}</label>
                        <br>
                        <select id="country_select">
                            @if(!empty($countrys))
                                @foreach($countrys as $country)
                                    <?php $country_total = \App\CountryMaster::totalCountryMerchant($country->country_id);?>
                                    <option value="{{ $country->country_name }}">{{ $country->country_name }} ({{ $country_total }})</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="mb-2 font-12">{{__('Merchant Type')}}</label>
                        <select id="merchant_type">
                            @if(!empty($merchant_types))
                                <option value="all">All ({{ @$total_merchant }})</option>
                                @foreach($merchant_types as $merchant_type)
                                    <?php $type_total = \App\MerchantType::totalTypeMerchant($merchant_type->mt_id);?>
                                    <option value="{{ $merchant_type->type }}">{{ $merchant_type->type }} ({{ $type_total }})</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                @endif
            </div>

            @if(isset($current_merchants))
            <br />
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped malle-table" id="merchant-list-table" @if(isset($id))  data-sourceurl="{{route('merchants.show',['merchant'=>@$id])}}" @else data-sourceurl="{{route('merchants.list')}}" @endif>
                        <thead>
                        <th>Merchant Name</th>
                        <th>City</th>
                        <th>Country</th>
                        <th>Type</th>
                        <th>Beta</th>
                        <th>Active</th>
                        <th>Featured</th>
                        <th>Outlet</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        @if(!empty($current_merchants))
                        @foreach($current_merchants as $current_merchant)
                            <tr class="row-location" data-id="{{$current_merchant->merchant_id}}">
                                <td>{{$current_merchant->merchant_name}}</td>
                                <td>{{ @$current_merchant->city->city_name }}</td>
                                <td>{{ $current_merchant->country->country_name }}</td>
                                <td>{{ $current_merchant->merchanttype->type }}</td>
                                <td>
                                    <select name="beta" id="" class="merchant_column_update dd-orange" data-href="{{route('merchants.column-update',[$current_merchant->merchant_id])}}" data-method="POST">
                                        <option value="Y" @if($current_merchant->beta=='Y') selected @endif>Yes</option>
                                        <option value="N" @if($current_merchant->beta=='N') selected @endif>No</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="merchant_active" id="" class="merchant_column_update dd-orange" data-href="{{route('merchants.column-update',[$current_merchant->merchant_id])}}" data-method="POST">
                                        <option value="Y" @if($current_merchant->merchant_active=='Y') selected @endif>Yes</option>
                                        <option value="N" @if($current_merchant->merchant_active=='N') selected @endif>No</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="featured" id="" class="merchant_column_update dd-orange" data-href="{{route('merchants.column-update',[$current_merchant->merchant_id])}}" data-method="POST">
                                        <option value="Y" @if($current_merchant->featured=='Y') selected @endif>Yes</option>
                                        <option value="N" @if($current_merchant->featured=='N') selected @endif>No</option>
                                    </select>
                                </td>

                                <td> {{ $outlate_totel  = \App\PromotionOutlet::totalOutlate($current_merchant->merchant_id) }}</td>
                                <td>
                                    <a href="javascript:;">
                                        <span class="text-info">Edit</span>
                                    </a>
                                    |
                                    <a  href="javascript:;" data-href="{{route('merchants.destroy',['merchants'=>$current_merchant->merchant_id])}}" data-method="DELETE" class="btn-delete" data-id="{{$current_merchant->merchant_id}}">
                                        <span class="text-danger">Delete</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deletelocationmodal" tabindex="-1" role="dialog" aria-labelledby="deletemodallocationlabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="deletemodallocationlabel">Delete Confirmation</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body ">
      <p class="font-12">Are you sure you want to delete this location?</p>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
      <button type="button" class="btn btn-danger" id="btnDeleteLocation">Yes</button>
    </div>
  </div>
</div>
</div>
@endsection


@section('script')
<script>

    $(document).ready(function() {
        var dataTables =  $('#merchant-list-table').DataTable({
            responsive: true,
            aaSorting: [],
         }
        );
        dataTables.columns(2).search("Singapore").draw();

        $('#country_select').on('select2:select', function (e) {
            var val = e.params.data.id;
            dataTables.columns(2).search(val).draw();


        });

        $('#merchant_type').on('select2:select', function (e) {
            // $("#time_dow_id").val(e.params.data.id);
            var val = e.params.data.id;

            //console.log(e.params.data.text);
            if(val=='all'){
                dataTables.columns(3).search("").draw();
            }else{
            dataTables.columns(3).search(val).draw();
            }
        });


    });

  $( function() {


     //$('#country_select').val('');
      $('#country_select,#merchant_type').select2({
          width:200
      });

    $("#start_date").datepicker({dateFormat: 'dd/mm/yy'});
            $("#end_date").datepicker({dateFormat: 'dd/mm/yy'});

    // malls
    $( "#merchant_name" ).autocomplete({
        source: function (request, response) {
            $.getJSON($("#merchant_name").attr('data-autocompleturl') +'/' + request.term , function (data) {
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
            window.location.href = '{{route("merchants.list.show")}}/'+ui.item.value;

            return false;
          }
    });

    // malls
    $( "#mall_name" ).autocomplete({
        source: function (request, response) {
            $.getJSON($("#mall_name").attr('data-autocompleturl') +'/' + request.term, function (data) {
                response($.map(data, function (value, key) {
                    return {
                        label: value,
                        value: key
                    };
                }));
            });
        },
          select: function(event, ui) {
             $("#mall_name").val(ui.item.label); 
             $("#mall_id").val(ui.item.value); 
             return false;
          }
    });

    // store
    $(document).on('submit','#frm-add-location', function(e){
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
                    $('#location-table tbody').remove();
                    $("#location-table").load( $('#location-table').attr('data-sourceurl') +" #location-table tbody");
                    toastr.success("Successfully Added!");
                }   
            }
        });
 
    });   

    // delete
    $(document).on('click', '.btn-delete', function(e){
        e.preventDefault();
        var btndelete = $(this); 
 
        $('#deletelocationmodal').modal('show');

        $('#btnDeleteLocation').unbind().click(function(){

            $.ajax({
                url: btndelete.attr('data-href'),
                type: btndelete.attr('data-method'),       
                dataType:'json',
                success:function(data){
                    if(data.status==='error'){
                        toastr.error(data.message);
                    }else{  
                        $('#deletelocationmodal').modal('hide');
                        $('.row-location[data-id="'+btndelete.attr('data-id')+'"]').remove();
                        toastr.success(data.message);
                    }   
                }
            });
                 
        });
    });




      // change promo outlate live, featured and redeem status
      $(document).on('change', '.merchant_column_update', function(e){
          e.preventDefault();
          //debugger;
          var selectOp = $(this);
          var attrName = selectOp.attr("name");

          $.ajax({
              url: selectOp.attr('data-href'),
              type: selectOp.attr('data-method'),
              dataType:'json',
              data: {
                  name : selectOp.attr('name'),
                  value : selectOp.find('option:selected').val()
              },
              success:function(data){
                  console.log(data);
                  if(data.status==='error'){
                      errorReturn(data)
                  }else{
                      //$('#merchant-list-table tbody').remove();
                      //$("#merchant-list-table").load( $('#merchant-list-table').attr('data-sourceurl') +" #merchant-list-table");
                      toastr.success(data.message);
                  }
              },
              error: function(data){
                  console.log(data);
                  exeptionReturn(data);
              }
          });

      });


  });
  </script>
@endsection