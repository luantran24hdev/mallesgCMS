@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card card-malle">
                <div class="card-header-malle">
                    <a href="{{route('merchants.list')}}">{{__('Manage Malls')}} ({{ @$merchants }})</a>
                    <a style="margin-left: 50px" href="{{route('merchant-type')}}">{{__('Merchant Types')}}</a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('merchant-type.store')}}" id="addMalltype">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" name="type" placeholder="Enter merchant type" id="type_name"
                                       class="form-control" required="" list="datalist1">
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" id="out-form">Update</button>
                                </div>
                            </div>

                        </div>
                    </form>

                    @if(isset($merchant_types))
                        <br/>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped malle-table"  id="mall_type-table"
                                       data-sourceurl="{{ route('merchant-type') }}">
                                    <thead>
                                    <th>Merchant Type</th>
                                    <th>Action</th>
                                    </thead>
                                    <tbody>
                                    @foreach($merchant_types as $merchant_type)
                                        <tr class="row-location" data-id="{{@$merchant_type->mt_id}}">
                                            <td>{{ @$merchant_type->type }}</td>

                                            <td>
                                                <a href="{{route('merchant-type.edit',[$merchant_type->mt_id])}}"><span class="text-info">Edit</span></a>
                                                |
                                                <a href="javascript:;"
                                                   data-href="{{route('merchant-type.destroy',[$merchant_type->mt_id])}}"
                                                   data-method="DELETE" class="btn-delete"
                                                   data-id="{{$merchant_type->mt_id}}">
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

    </script>
@endsection
