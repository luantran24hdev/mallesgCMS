@extends('layouts.app')

<style>
    .mall_out .select2-container--default .select2-selection--single .select2-selection__arrow{
        top: 5px !important;
    }
    .mall_out .select2-container .select2-selection--single {
        height: 38px !important;
    }

    .mall_out .select2-container--default .select2-selection--single .select2-selection__rendered{
        line-height: 35px;
    }

    .btn-default{
        color: #fff !important;
        background-color: #ccc !important;
        border-color: #ccc !important;
    }
    .active{
        background-color: #007bff !important;
        border-color: #007bff !important;
    }
    .pic {
        width: 100%;
        height: 100%;
    }

</style>

@section('content')
<div class="row">
    <div class="col-md-10">
        @include('partials.flash_message')
        <div class="row">

            <div class="col-md-12">
                <div class="card card-malle">
                    <div class="card-header-malle">{{ $merchant_location->merchant->merchant_name }}
                    <a href="{{ route('merchants.show',[$merchant_location->merchant_id]) }}" style="float: right">Back</a>
                    </div>
                    <div class="card-body">
                        <form  method="post" action="{{ route('locations.update',[$merchant_location->merchantlocation_id]) }}">

                            @csrf
                            {{ method_field('PATCH') }}

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="hidden" name="mall_id" id="mall_id" value="{{ $merchant_location->mall_id }}">
                                        <label class="mb-2 font-12">Outlet Location Name</label>
                                        <input type="text" placeholder="Mall Name" id="mallname" class="form-control col-md-12" value="{{  $merchant_location->mall->mall_name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Unit No.</label>
                                        <input type="text" name="merchant_location" placeholder="Unit No" id="merchant_location" class="form-control col-md-12" value="{{  $merchant_location->merchant_location }}">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="mb-2 font-12">Level</label><br>
                                    <div class="dropdown">
                                        <select name="level_id" class="form-control col-md-12" >
                                            @foreach($levels as $level)
                                                <option value="{{ $level->level_id }}" @if($merchant_location->level_id == $level->level_id) selected @endif>{{$level->level }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary col-md-6 mt-4" id="btnUpdateMall">Update</button>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-md-3">
                                    <label class="mb-2 font-12">Country</label><br>
                                    <div class="dropdown">
                                        <select name="country_id" class="form-control col-md-12" id="country_select">
                                            @foreach($countries as $country)
                                                <option value="{{ $country->country_id }}" @if($merchant_location->country_id == $country->country_id) selected @endif>{{$country->country_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="mb-2 font-12">City</label><br>
                                    <div class="dropdown">
                                        <select name="city_id" class="form-control col-md-12" id="city_control">
                                            @foreach($cities as $city)
                                                <option value="{{ $city->city_id }}" @if($city->city_id == $merchant_location->city_id) selected @endif>{{$city->city_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="mb-2 font-12">Town</label><br>
                                    <div class="dropdown">
                                        <select name="town_id" class="form-control col-md-12" id="town_control">
                                            @foreach($towns as $town)
                                                <option value="{{ $town->town_id }}" @if($town->town_id == $merchant_location->town_id) selected @endif>{{$town->town_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Address</label><br>
                                        <textarea rows="4" class="form-control" name="loc_address">{{ $merchant_location->loc_address}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="mb-2 font-12">Postal Code</label><br>
                                            <input type="text" name="postal_code" class="form-control" placeholder="Postal Code" value="{{ $merchant_location->postal_code }}">

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="mb-2 font-12">Opening Hours</label>
                                            <input type="time" name="op_hours" id="op_hours" placeholder="Opening Hours" class="form-control" value="{{ $merchant_location->op_hours }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="mb-2 font-12">Telephone #</label><br>
                                            <input type="text" name="loc_telephone" class="form-control" placeholder="Telephone" value="{{ $merchant_location->loc_telephone }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="mb-2 font-12">Closing Hours</label>
                                            <input type="time" name="cls_hours" id="cls_hours" placeholder="Closing Hours" class="form-control" value="{{ $merchant_location->cls_hours }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">GPS Street</label><br>
                                        <input type="text" name="gps_street" class="form-control" placeholder="GPS Street" value="{{ $merchant_location->gps_street }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">

                                        <label class="mb-2 font-12">Latitude</label>
                                        <input type="text" name="latitude" id="latitude" placeholder="Latitude" class="form-control" value="{{ $merchant_location->latitude }}" >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Longitude</label><br>
                                        <input type="text" name="longitude" class="form-control" placeholder="Longitude" value="{{ $merchant_location->longtitude }}">
                                    </div>
                                </div>


                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>



    </div>
</div>

@endsection


@section('script')
<script>



    $(document).on('submit','#editmallform', function(e){
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
                    toastr.error(data.message, 'Error');
                }else{
                    //$("#discount-tag-table").load( $('#discount-tag-table').attr('data-sourceurl') +" #discount-tag-table");
                    toastr.success(data.message);
                }
            },
            error: function(data){
                exeptionReturn(data);
            }
        });
    });


    $(".column_update").change(function(){

        var value = $(this).val();
        var attrName = $(this).attr("name");
        var mall_id = $('#mall_id_main').val();

        $.ajax({
            type : 'ajax',
            method : 'post',
            url : '{{ route('malls.column-update') }}/'+mall_id,
            data : {name:attrName,
                    value : value},
            async : false,
            dataType : 'json',
            success : function(data){

                // /toastr.success(data.message);
                toastr['info'](data.message);

            },
            error : function(){
                toastr['error']('Could not update.');
            }
        });
    });

    $('#country_select').on('change', function (e) {

      /*  var id= $(this).children("option:selected").val();

        $.ajax({
            url: '{{ route('malls.getcitymall') }}',
            type: 'POST',
            dataType:'json',
            data : {'id':id},
            success:function(data){
                // /console.log(data);
                $('#city_control').html(data.city);
                $('#town_control').html('<option value="">--- Select ----</option>');
            }
        });*/

    });

    $('#city_control').on('change', function (e) {

       /* var id= $(this).children("option:selected").val();

        $.ajax({
            url: '{{ route('malls.gettownmall') }}',
            type: 'POST',
            dataType:'json',
            data : {'id':id},
            success:function(data){
                // /console.log(data);
                $('#town_control').html(data.town);

            }
        });
*/
    });



   /* $(document).ready(function() {
         var dataTables = $('.mall_info_table').DataTable();
         dataTables.columns(2).search("Restaurant").draw();
    });
*/
  </script>
@endsection
