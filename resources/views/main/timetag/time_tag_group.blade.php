@extends('layouts.app')

@section('style')
<style>
    .time_tags_groups .select2-container--default .select2-selection--single .select2-selection__arrow{
        top: 5px !important;
    }
    .time_tags_groups .select2-container .select2-selection--single {
        height: 38px !important;
    }

    .time_tags_groups .select2-container--default .select2-selection--single .select2-selection__rendered{
        line-height: 35px;
    }
</style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card card-malle">
                @include('main.timetag.time_menu')
                <div class="card-body">
                    <form method="POST" action="{{route('timetaggroup.tags.store')}}" id="addTimeTagGroup">
                    <div class="row time_tags_groups">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select id="time_tag_select" name="time_tag">
                                    @if(!empty($time_tags))
                                        @foreach($time_tags as $time_tag)
                                            <option value="{{ $time_tag->tt_id }}">{{ $time_tag->tt_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select id="time_group_select" name="time_group">
                                    @if(!empty($time_groups))
                                        @foreach($time_groups as $time_group)
                                            <option value="{{ $time_group->time_id }}">{{ $time_group->time_name }}</option>
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

                    @if(isset($time_tag_groups))
                        <br/>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped" id="time-tag-group-table"
                                       data-sourceurl="{{ route('timetag.tags.group') }}">
                                    <thead>
                                    <th>Time Tag</th>
                                    <th>Time Group</th>
                                    <th>Action</th>
                                    </thead>
                                    <tbody>
                                    @foreach($time_tag_groups as $time_tag_group)
                                    <tr class="row-location tgshow_{{@$time_tag_group->time_tag->tt_id}} tghide" data-id="{{@$time_tag_group->tg_id}}">
                                        <td>{{ @$time_tag_group->time_tag->tt_name }}</td>
                                        <td>{{ @$time_tag_group->time_group->time_name }}</td>

                                        <td>
                                            <a href="javascript:;"
                                               data-href="{{route('timetags.tags.destroy',[$time_tag_group->tg_id])}}"
                                               data-method="DELETE" class="btn-delete"
                                               data-id="{{$time_tag_group->tg_id}}">
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


        $('#time_tag_select').val('');
        $('#time_tag_select').select2({
            placeholder: 'Select Time Tag',
            allowClear: true,
            width:200,
            //height:100
        });
        $('#time_tag_select').on('select2:select', function (e) {
            //$("#sub_category_id").val(e.params.data.id);
            $('.tghide').hide();
            $('.tgshow_'+e.params.data.id).show();
        });

        $('#time_group_select').val('');
        $('#time_group_select').select2({
            placeholder: 'Select Time Group',
            allowClear: true,
            width:200,
            //height:50
        });

       /* $('#time_group_select').on('select2:select', function (e) {
            $("#sub_category_id").val(e.params.data.id);
        });*/


        $(document).on('submit','#addTimeTagGroup', function(e){
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
                        $("#time-tag-group-table").load( $('#time-tag-group-table').attr('data-sourceurl') +" #time-tag-group-table");
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