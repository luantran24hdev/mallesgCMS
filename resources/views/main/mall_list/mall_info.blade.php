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
                    <div class="card-header-malle">Mall Info</div>
                    <div class="card-body">
                        <form  method="patch" action="{{ route('malls.update',[$mall->mall_id]) }}" id="editmallform" autocomplete="off">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="hidden" name="mall_id_main" id="mall_id_main" value="{{ $mall->mall_id }}">
                                        <label class="mb-2 font-12">Mall Name</label>
                                        <input type="text" name="mall_name" placeholder="Mall Name" id="mallname" class="form-control col-md-12" value="{{  $mall->mall_name }}">
                                    </div>
                                </div>
                                <div class="col-md-3">

                                    <label class="mb-2 font-12">Mall Type</label><br>

                                            <select name="mt_id" class="form-control col-md-12">
                                                @foreach ($malltypes as $malltype)
                                                    <option value="{{ $malltype->mt_id }}" @if($malltype->mt_id == $mall->mt_id) selected @endif> {{ $malltype->type_name  }}</option>
                                                @endforeach
                                            </select>

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
                                                    <option value="{{ $country->country_id }}" @if($mall->country_id == $country->country_id) selected @endif>{{$country->country_name }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="mb-2 font-12">City</label><br>
                                    <div class="dropdown">
                                        <select name="city_id" class="form-control col-md-12" id="city_control">
                                            @foreach($cities as $city)
                                                <option value="{{ $city->city_id }}" @if($city->city_id == $mall->city_id) selected @endif>{{$city->city_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="mb-2 font-12">Town</label><br>
                                    <div class="dropdown">
                                        <select name="town_id" class="form-control col-md-12" id="town_control">
                                            @foreach($towns as $town)
                                                <option value="{{ $town->town_id }}" @if($town->town_id == $mall->town_id) selected @endif>{{$town->town_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="hidden" name="town_id" id="town_id" value="<?= $mall['town_id'] ?>">
                                </div>

                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Address</label><br>
                                        <textarea rows="4" class="form-control" name="business_address">{{ $mall->business_address}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="mb-2 font-12">Postal Code</label><br>
                                            <input type="text" name="postal_code" class="form-control" placeholder="Postal Code" value="{{ $mall->postal_code }}">

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="mb-2 font-12">Telephone #</label><br>
                                            <input type="text" name="telephone" class="form-control" placeholder="Telephone" value="{{ $mall->telephone }}">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="mb-2 font-12">Featured</label><br>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-default @if($mall->featured == 'Y') active @endif"  id="yes_featured_merchant">
                                            <input type="radio" name="featured" autocomplete="off" value="Y" class="column_update"> Yes
                                        </label>
                                        <label class="btn btn-default @if($mall->featured == 'N' || $mall->featured == '') active @endif" id="no_featured_merchant">
                                            <input type="radio" name="featured"  autocomplete="off" value="N" class="column_update"> No
                                        </label>


                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Website</label><br>
                                        <input type="text" name="website" class="form-control" placeholder="Website" value="{{ $mall->website }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Facebook</label>
                                        <input type="text" name="facebook" id="facebook" placeholder="Facebook" class="form-control" value="{{ $mall->facebook }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Instagram</label>
                                        <input type="text" name="instagram" id="instagram" placeholder="Instagram" class="form-control" value="{{ $mall->instagram }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Twitter</label>
                                        <input type="text" name="twitter" id="twitter" placeholder="Twitter" class="form-control" value="{{ $mall->twitter }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-2 font-12">YouTube</label>
                                        <input type="text" name="youtube" id="youtube" placeholder="YouTube" class="form-control" value="{{ $mall->youtube }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Mall Managed By</label><br>
                                        <input type="text" name="managed_by" class="form-control" placeholder="Mall Managed By" value="{{ $mall->managed_by }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-2 font-12">About Us</label>
                                        <textarea type="text" name="about_us" id="about_us" placeholder="About Us" class="form-control" rows="5">{{ $mall->about_us }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="mb-2 font-12">Latitude</label><br>
                                            <input type="text" name="lat" class="form-control" placeholder="Latitude" value="{{ $mall->lat }}">

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="mb-2 font-12">Longitude</label><br>
                                            <input type="text" name="long" class="form-control" placeholder="Longitude" value="{{ $mall->long }}">

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="mb-2 font-12">Opening Hours</label>
                                            <textarea type="text" name="opening_hour" id="opening_hour" placeholder="Opening Hours" class="form-control" rows="3">{{ $mall->opening_hour }}</textarea>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="mb-2 font-12">Mall Active</label><br>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">

                                        <label class="btn btn-default @if($mall->mall_active == 'Y') active @endif"  id="yes_merchantactive">
                                            <input type="radio" name="mall_active" autocomplete="off" value="Y" class="column_update"> Yes
                                        </label>
                                        <label class="btn btn-default @if($mall->mall_active == 'N') active @endif" id="no_merchantactive">
                                            <input type="radio" name="mall_active"  autocomplete="off" value="N" class="column_update"> No
                                        </label>

                                    </div>
                                    <input type="hidden" name="mallactive" id="mallactive" value="<?= $mall['mall_active'] ?>">
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

        var id= $(this).children("option:selected").val();

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
        });

    });

    $('#city_control').on('change', function (e) {

        var id= $(this).children("option:selected").val();

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

    });

   /* $(document).ready(function() {
         var dataTables = $('.mall_info_table').DataTable();
         dataTables.columns(2).search("Restaurant").draw();
    });
*/
  </script>
@endsection