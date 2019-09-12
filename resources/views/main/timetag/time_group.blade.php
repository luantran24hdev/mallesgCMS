@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card card-malle">
                @include('main.timetag.time_menu')
                <div class="card-body">
                    <form method="POST" action="{{route('time-tags.store')}}" id="addTimeMaster">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="time_name" placeholder="Enter Time Name" id="time_name"
                                   class="form-control" required="" list="datalist1">
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="out-form">Update</button>
                            </div>
                        </div>

                    </div>
                    </form>

                    @if(isset($time_groups))
                        <br/>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped" id="timegroup-tag-table"
                                       data-sourceurl="{{ route('time-tags') }}">
                                    <thead>
                                    <th>Time Name</th>
                                    <th>Action</th>
                                    </thead>
                                    <tbody>
                                    @foreach($time_groups as $timegroup)
                                    <tr class="row-location" data-id="{{@$timegroup->time_id}}">
                                        <td>{{ @$timegroup->time_name }}</td>

                                        <td>
                                            <a href="javascript:;"
                                               data-href="{{route('time-tags.destroy',['time_id'=>$timegroup->time_id])}}"
                                               data-method="DELETE" class="btn-delete"
                                               data-id="{{$timegroup->time_id}}">
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

        $(document).on('submit','#addTimeMaster', function(e){
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
                        $("#timegroup-tag-table").load( $('#timegroup-tag-table').attr('data-sourceurl') +" #timegroup-tag-table");
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
                            //window.location.href = '{{ route('time-tags') }}';
                        }
                    }
                });

            });
        });

    </script>
@endsection