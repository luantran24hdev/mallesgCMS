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
                <div class="card-header-malle">
                    {{ \App\MallMaster::getMallName($mall_id) }}
                    <span><a href="{{ route('malls') }}" style="float: right">Back</a></span>
                </div>
                <div class="card-body merch_out">
                    <form method="POST" action="{{route('malls.storeMallLevel')}}" id="addMalltype">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select id="level_master" name="level_id">
                                        @if(!empty($levels))
                                            <option value="">Select Level</option>
                                            @foreach($levels as $level)
                                                <option value="{{ $level->level_id }}">{{$level->level }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" value="{{ $mall_id }}" name="mall_id">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select id="level_activity" name="level_activity_id">
                                        @if(!empty($levels))
                                            <option value="">Select Level Activity</option>
                                            @foreach($level_activitys as $level_activity)
                                                <option value="{{ $level_activity->la_id }}">{{$level_activity->level_activity }}</option>
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

                    @if(isset($level_malls))
                        <br/>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped malle-table"  id="mall_type-table"
                                       data-sourceurl="{{ route('malls.level',[$mall_id]) }}">
                                    <thead>
                                    <th></th>
                                    <th>Level / Floor</th>
                                    <th>Level Activity</th>
                                    <th>Mall</th>
                                    <th>Created By</th>
                                    <th>Action</th>
                                    </thead>
                                    <tbody>
                                    @foreach($level_malls as $level_mall)
                                        <tr class="row-location" data-id="{{@$level_mall->lm_id}}">
                                            <td>
                                                @if(!empty($level_mall->level->level_image))
                                                    <img src="{{ $live_url.$level_mall->level->level_image }}" width="50px" height="50px">
                                                @else
                                                    <i class="fa fa-picture-o" aria-hidden="true" style="font-size: 50px;"></i>
                                                @endif
                                            </td>

                                            <td>{{ @$level_mall->level->level }}</td>
                                            <td>{{ @$level_mall->level_activity->level_activity }}</td>
                                            <td>{{ @$level_mall->mall->mall_name }}</td>
                                            <td>{{ \App\User::getUserName( @$level_mall->created_by )  }}</td>
                                            <td>
                                                <a href="javascript:;"
                                                   data-href="{{route('malls.level.destroy',[$level_mall->lm_id])}}"
                                                   data-method="DELETE" class="btn-delete"
                                                   data-id="{{$level_mall->lm_id}}">
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
        $('#level_master,#level_activity').select2({
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
