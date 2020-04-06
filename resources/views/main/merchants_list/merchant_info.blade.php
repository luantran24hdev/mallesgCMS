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
        <div class="row">
            <div class="col-md-12">
                <div class="card card-malle">
                    <div class="card-header-malle">Merchant Info
                        <a href="{{ route('merchants.list') }}" style="float: right">Back</a>
                    </div>
                    <div class="card-body">
                        <form method="patch" action="{{ route('merchants.update',[$merchant->merchant_id ]) }}" id="editmerchantform" autocomplete="off">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="hidden" name="merchant_id_main" id="merchant_id_main" value="{{ $merchant->merchant_id }}">
                                        <label class="mb-2 font-12">Merchant Name</label>
                                        <input type="text" name="merchant_name" id="merchantname" placeholder="Merchant Name" class="form-control col-md-12" value="{{ $merchant->merchant_name }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="mb-2 font-12">Type</label>

                                                <select name="mt_id" class="form-control col-md-12" >
                                                    @foreach($merchantTypes as $type)
                                                    <option value="{{ $type->mt_id }}" @if($type->mt_id == $merchant->mt_id) selected @endif>{{ $type->type }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary col-md-8" id="btnUpdateMerchant">Update</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Short Name</label>
                                        <input type="text" name="short_name" id="short_name" placeholder="Short Name" class="form-control" value=" {{ $merchant->short_name }} ">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="mb-2 font-12">City</label><br>
                                    <div class="dropdown">
                                        <select name="city_id" class="form-control col-md-12" id="city_control">
                                            @foreach($cities as $city)
                                                <option value="{{ $city->city_id }}" @if($city->city_id == $merchant->city_id) selected @endif>{{$city->city_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Address</label>
                                        <textarea rows="4" class="form-control" name="merchant_address" placeholder="Address">{{ $merchant->merchant_address }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Country</label>
                                        <select name="country_id" class="form-control col-md-12" >
                                            @foreach($countries as $country)
                                                <option value="{{ $country->country_id }}" @if($merchant->country_id == $country->country_id) selected @endif>{{$country->country_name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Postal Code</label>
                                        <input type="text" name="postal_code" id="postalcode" placeholder="Postal Code" class="form-control" value="{{$merchant->postal_code }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Telephone #</label>
                                        <input type="text" name="telephone" id="telephone" placeholder="Telephone" class="form-control" value="{{$merchant->telephone }}">
                                    </div>
                                    <div class="col-md-12">

                                    </div>
                                    <div class="col-md-12">

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Website</label>
                                        <input type="text" name="website" id="website" placeholder="Website" class="form-control" value="{{$merchant->website }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Facebook</label>
                                        <input type="text" name="facebook" id="facebook" placeholder="Facebook" class="form-control" value="{{$merchant->facebook }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Instagram</label>
                                        <input type="text" name="instagram" id="instagram" placeholder="Instagram" class="form-control" value="{{$merchant->instagram }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Twitter</label>
                                        <input type="text" name="twitter" id="twitter" placeholder="Twitter" class="form-control" value="{{$merchant->twitter }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-2 font-12">YouTube</label>
                                        <input type="text" name="youtube" id="youtube" placeholder="YouTube" class="form-control" value="{{$merchant->youtube }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="mb-2 font-12">Merchant Active</label><br>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">

                                        <label class="btn btn-default @if($merchant->merchant_active == 'Y') active @endif"  id="yes_merchantactive">
                                            <input type="radio" name="merchant_active" autocomplete="off" value="Y" class="column_update"> Yes
                                        </label>
                                        <label class="btn btn-default @if($merchant->merchant_active == 'N') active @endif" id="no_merchantactive">
                                            <input type="radio" name="merchant_active"  autocomplete="off" value="N" class="column_update"> No
                                        </label>

                                    </div>
                                    <br>
                                    <label class="mb-2 font-12">Featured</label><br>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-default @if($merchant->featured == 'Y') active @endif"  id="yes_featured_merchant">
                                            <input type="radio" name="featured" autocomplete="off" value="Y" class="column_update"> Yes
                                        </label>
                                        <label class="btn btn-default @if($merchant->featured == 'N') active @endif" id="no_featured_merchant">
                                            <input type="radio" name="featured"  autocomplete="off" value="N" class="column_update"> No
                                        </label>

                                    </div>

                                    <div class="form-group">
                                        <label class="mb-2 font-12">Opening Hours</label>
                                        <textarea type="text" name="opening_hour" id="opening_hour" placeholder="Opening Hours" class="form-control" rows="3">{{ $merchant->opening_hour }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Latitude</label>
                                        <input type="text" name="latitude" id="latitude" placeholder="Latitude" class="form-control" >
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Longitude</label>
                                        <input type="text" name="longitude" id="longitude" placeholder="Longitude" class="form-control">
                                    </div>


                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Parent Company</label>
                                        <select name="company_id" class="form-control col-md-12" >
                                            <option value="0">----  Select ------</option>
                                            @foreach($companys as $company)
                                                <option value="{{ $company->company_id }}" @if($company->company_id == $merchant->company_id) selected @endif>{{$company->company_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Deliver Charges</label>
                                        <input type="text" name="delivery_charge" id="delivery_charge" placeholder="Deliver Charges" class="form-control" value="{{$merchant->delivery_charge }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">About Us</label>
                                        <textarea type="text" name="about_us" id="about_us" placeholder="About Us" class="form-control" rows="5">{{ $merchant->about_us}}</textarea>
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


    $('#country_select,#level_select').select2({
        width:200
    });

    $('#country_select').on('select2:select', function (e) {
        var id= e.params.data.id;

        if(id == 'all'){
            $('.hide').show();
        }else{
            $('.hide').hide();
            $('.show_'+id).show();
        }

    });

    $('#level_select').on('select2:select', function (e) {
        var id= e.params.data.id;

        if(id == 'all'){
            $('.levelhide').show();
        }else{
            $('.levelhide').hide();
            $('.level_'+id).show();
        }

    });

    $(document).on('submit','#editmerchantform', function(e){
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
        var merchant_id = $('#merchant_id_main').val();

        $.ajax({
            type : 'ajax',
            method : 'post',
            url : '{{ route('merchants.column-update') }}/'+merchant_id,
            data : {name:attrName,
                    value : value},
            async : false,
            dataType : 'json',
            success : function(data){

                // /toastr.success(data.message);
                toastr['info'](data.message);

            },
            error : function(){
                toastr['error']('Could not update featured.');
            }
        });
    });



   /* $(document).ready(function() {
         var dataTables = $('.mall_info_table').DataTable();
         dataTables.columns(2).search("Restaurant").draw();
    });
*/
  </script>
@endsection
