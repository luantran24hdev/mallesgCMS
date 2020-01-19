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

                                        <td>{{ @$shopper->Shopper_name }}</td>
                                        <td>{{ \App\User::getGender(@$shopper->Gender) }}</td>
                                        <td>{{ @$shopper->Mobile_number }} <br> <span style="color: green">Verified</span></td>
                                        <td>{{ @$shopper->Email_id }}  <br> <span style="color: red">Verify Now</span></td>
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

    </script>
@endsection
