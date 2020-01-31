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
        .link_color{
            color: blue;}


    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card card-malle">
                @include('main.mall_list.mall_menu')
                <div class="card-body merch_out">
                    <form method="POST" action="{{route('mall-owner.store')}}" id="addMalltype">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="mall_owner_name" placeholder="Enter Company Name"
                                       class="form-control" id="sub_category_name" required="" list="datalist1" data-autocompleturl="{{route('mall-owner.search')}}">
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select id="main_category_select" name="city_id">
                                        @if(!empty($citys))
                                            <option value="">Select City</option>
                                            @foreach($citys as $city)
                                                <option value="{{ $city->city_id }}">{{$city->city_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" id="out-form">Update</button>
                                </div>
                            </div>

                        </div>
                    </form>

                    @if(isset($owners))
                        <br/>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped malle-table"  id="mall_type-table"
                                       data-sourceurl="{{ route('mall-owner') }}">
                                    <thead>
                                    <th>Company Name</th>
                                    <th>City</th>
                                    <th>Action</th>
                                    </thead>
                                    <tbody>
                                    @foreach($owners as $owner)
                                        <tr class="row-location" data-id="{{@$owner->mo_id}}">
                                            <td>{{ @$owner->mall_owner_name }}
                                                <br><br>
                                            <span style="float: left" class="link_color"><a href="{{route('mall-owner.edit',[$owner->mo_id])}}"><b>Main Info</b></a></span>
                                                <span style="margin-left: 20px" class="link_color"><a href="{{route('mall-owner.show',[$owner->mo_id])}}"><b>Malls Owned</b></a></span>
                                            </td>
                                            <td>{{ \App\CityMaster::getCityName(@$owner->city_id) }}</td>

                                            <td>
                                                <a href="javascript:;"
                                                   data-href="{{route('mall-owner.destroy',[$owner->mo_id])}}"
                                                   data-method="DELETE" class="btn-delete"
                                                   data-id="{{$owner->mo_id}}">
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
    @include('partials.delete_model')
@endsection


@section('script')
    <script>
        $('#main_category_select').select2({
            width:200
        });
        $(document).on('submit','#addMalltype', function(e){
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
                        $("#mall_type-table").load( $('#mall_type-table').attr('data-sourceurl') +" #mall_type-table");
                        toastr.success(data.message);
                    }
                },
                error: function(data){
                    exeptionReturn(data);
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

        $( "#sub_category_name" ).autocomplete({
            source: function (request, response) {
                $.getJSON($("#sub_category_name").attr('data-autocompleturl') +'/' + request.term, function (data) {
                    response($.map(data, function (value, key) {
                        return {
                            label: value,
                            value: key
                        };
                    }));
                });
            },
            select: function(event, ui) {
                $("#sub_category_name").val(ui.item.label);
                //$("#tag_id").val(ui.item.value);
                return false;
            }
        });

    </script>
@endsection
