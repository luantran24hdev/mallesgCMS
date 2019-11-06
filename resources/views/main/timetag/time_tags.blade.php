@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card card-malle">
                @include('main.timetag.time_menu')
                <div class="card-body">
                    <form method="POST" action="{{route('time-tags.tags.store')}}" id="addTimeTag">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="tt_name" placeholder="Enter Time Tags" id="tt_name"
                                   class="form-control" required="" list="datalist1">
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="out-form">Update</button>
                            </div>
                        </div>

                    </div>
                    </form>

                    @if(isset($time_tags))
                        <br/>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped" id="timetag-tag-table"
                                       data-sourceurl="{{ route('timetag.tags') }}">
                                    <thead>
                                    <th>Time Tag</th>
                                    <th>Action</th>
                                    </thead>
                                    <tbody>
                                    @foreach($time_tags as $timegtag)
                                    <tr class="row-location" data-id="{{@$timegtag->tt_id}}">
                                        <td>{{ @$timegtag->tt_name }}</td>

                                        <td>
                                            <a href="javascript:;"
                                               data-href="{{route('timetags.tags.destroy',[$timegtag->tt_id])}}"
                                               data-method="DELETE" class="btn-delete"
                                               data-id="{{$timegtag->tt_id}}">
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

        $(document).on('submit','#addTimeTag', function(e){
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
                        $("#timetag-tag-table").load( $('#timetag-tag-table').attr('data-sourceurl') +" #timetag-tag-table");
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