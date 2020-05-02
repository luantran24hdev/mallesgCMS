@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card card-malle">
                <div class="card-header-malle">
                    {{__('Manage Shoppers')}}
                </div>

                @if(isset($shoppers))
                    <br/>
                    <div class="row container">
                        <div class="col-md-12">
                            <table class="table table-striped malle-table" id="preference-tag-table"
                                   data-sourceurl="{{ route('manage.inquiry') }}">
                                <thead>
                                    <th></th>
                                    <th>Full Name</th>
                                    <th>Gender</th>
                                    <th>Mobile #</th>
                                    <th>Email ID</th>
                                    <th>Registered On</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                @foreach($shoppers as $shopper)
                                    <tr class="row-location" data-id="{{@$shopper->Shopper_id}}">
                                        <td>
                                            @if(!empty($shopper->image))
                                                <img src="{{ $live_url.$shopper->image }}" width="50px" height="50px">
                                            @else
                                                <i class="fa fa-picture-o" aria-hidden="true" style="font-size: 50px;"></i>
                                            @endif
                                        </td>

                                        <td>{{ @$shopper->Shopper_name }}
                                            <br><br><br><span><b> Driver / Rider </b> </span> &nbsp;&nbsp;&nbsp;
                                            <select name="dr_id" id="" class="shopper_column_update dd-orange" data-href="{{route('shopper.column-update',[$shopper->Shopper_id])}}" data-method="POST">
                                                <option value="Y" @if($shopper->dr_id=='Y') selected @endif>Yes</option>
                                                <option value="N" @if($shopper->dr_id=='N') selected @endif>No</option>
                                            </select>
                                        </td>
                                        <td>{{ \App\User::getGender(@$shopper->Gender) }}
                                            <br><br><br><span><b> Merchant </b> </span> &nbsp;&nbsp;&nbsp;
                                            <select name="app_merchant" id="" class="shopper_column_update dd-orange" data-href="{{route('shopper.column-update',[$shopper->Shopper_id])}}" data-method="POST">
                                                <option value="Y" @if($shopper->app_merchant=='Y') selected @endif>Yes</option>
                                                <option value="N" @if($shopper->app_merchant=='N') selected @endif>No</option>
                                            </select>
                                        </td>
                                        <td>{{ @$shopper->Mobile_number }} <br> <span style="color: green">Verified</span>
                                            <br><br><span><b> App Admin </b> </span> &nbsp;&nbsp;&nbsp;
                                            <select name="app_admin" id="" class="shopper_column_update dd-orange" data-href="{{route('shopper.column-update',[$shopper->Shopper_id])}}" data-method="POST">
                                                <option value="Y" @if($shopper->app_admin=='Y') selected @endif>Yes</option>
                                                <option value="N" @if($shopper->app_admin=='N') selected @endif>No</option>
                                            </select>
                                        </td>
                                        <td>{{ @$shopper->Email_id }}  <br> <span style="color: red">Verify Now</span>
                                            <br><br><span><b> App User </b> </span> &nbsp;&nbsp;&nbsp;
                                            <select name="app_user" id="" class="shopper_column_update dd-orange" data-href="{{route('shopper.column-update',[$shopper->Shopper_id])}}" data-method="POST">
                                                <option value="Y" @if($shopper->app_user=='Y') selected @endif>Yes</option>
                                                <option value="N" @if($shopper->app_user=='N') selected @endif>No</option>
                                            </select>
                                        </td>
                                        <td>{{ @$shopper->Registered_on }}</td>
                                        <td><a href="{{ route('manage.edit.shoppers',$shopper->Shopper_id) }}"> Edit </a>
                                            |
                                            <a href="javascript:;"
                                               data-href="{{route('shopper.delete',$shopper->Shopper_id)}}"
                                               data-method="DELETE" class="btn-delete"
                                               data-id="{{$shopper->Shopper_id}}">
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

    @include('partials.delete_model')
@endsection

@section('script')
    <script>

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
        $(document).on('change', '.shopper_column_update', function(e){
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
                        //  $("#merchant-list-table").load( $('#merchant-list-table').attr('data-sourceurl') +" #merchant-list-table");
                        toastr.success(data.message);
                    }
                },
                error: function(data){
                    console.log(data);
                    exeptionReturn(data);
                }
            });

        });

    </script>
@endsection
