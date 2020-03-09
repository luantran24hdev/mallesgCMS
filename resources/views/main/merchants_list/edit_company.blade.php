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
                    <div class="card-header-malle">{{  $company->company_name }}
                    <a href="{{route('merchant-company')}}" style="float:right;">Back</a>
                    </div>
                    <div class="card-body">
                        <form  method="post" action="{{ route('merchant-company.update',[$company->company_id]) }}">

                            @csrf
                            {{ method_field('PATCH') }}

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Company Name</label>
                                        <input type="text" name="company_name" placeholder="Mall Name" id="mallname" class="form-control col-md-12" value="{{  $company->company_name }}">
                                    </div>
                                </div>
                                <div class="col-md-3">

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
                                                    <option value="{{ $country->country_id }}" @if($company->country_id == $country->country_id) selected @endif>{{$country->country_name }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="mb-2 font-12">City</label><br>
                                    <div class="dropdown">
                                        <select name="city_id" class="form-control col-md-12" id="city_control">
                                            @foreach($cities as $city)
                                                <option value="{{ $city->city_id }}" @if($city->city_id == $company->city_id) selected @endif>{{$city->city_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Company Address</label><br>
                                        <textarea rows="4" class="form-control" name="company_address">{{ $company->company_address}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="mb-2 font-12">Postal Code</label><br>
                                            <input type="text" name="postal_code" class="form-control" placeholder="Postal Code" value="{{ $company->postal_code }}">

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="mb-2 font-12">Telephone #</label><br>
                                            <input type="text" name="telephone" class="form-control" placeholder="Telephone" value="{{ $company->telephone }}">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Website</label><br>
                                        <input type="text" name="website" class="form-control" placeholder="Website" value="{{ $company->website }}">
                                    </div>
                                    {{--<div class="form-group">
                                        <label class="mb-2 font-12">Facebook</label>
                                        <input type="text" name="facebook" id="facebook" placeholder="Facebook" class="form-control" value="{{ $company->facebook }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Instagram</label>
                                        <input type="text" name="instagram" id="instagram" placeholder="Instagram" class="form-control" value="{{ $company->instagram }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Twitter</label>
                                        <input type="text" name="twitter" id="twitter" placeholder="Twitter" class="form-control" value="{{ $company->twitter }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-2 font-12">YouTube</label>
                                        <input type="text" name="youtube" id="youtube" placeholder="YouTube" class="form-control" value="{{ $company->youtube }}">
                                    </div>--}}
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
