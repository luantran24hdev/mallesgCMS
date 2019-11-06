@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card card-malle">
                <div class="card-header-malle">
                  {{ @$events[0]->mall->mall_name  }} Events

                    <a href="{{route('malls')}}">
                    <span class="link_color" style="float: right">
                        Back
                    </span>
                    </a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('mall-events.store') }}" id="addEvents">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="event_name" placeholder="Event Name" id="event_name"
                                   class="form-control" required="" list="datalist1" data-autocompleturl="">
                            <input type="hidden" name="mall_id" value="{{$events[0]->mall_id}}">
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="out-form">Update</button>
                            </div>
                        </div>

                    </div>

                    </form>
                    <div class="row">
                        <div class="col-md-2">
                           Show:
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <button class="btn btn-primary" id="all">All</button>
                                <button class="btn btn-light" id="current">{{ \App\EventMaster::C }}</button>
                                <button class="btn btn-light" id="past">{{ \App\EventMaster::P }}</button>
                                <button class="btn btn-light" id="upcoming">{{ \App\EventMaster::U }}</button>
                            </div>
                        </div>

                    </div>

                    @if(isset($events))
                        <br/>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped malle-table" id="event-table"
                                       data-sourceurl="{{ route('mall-events',['id'=>$events[0]->mall_id]) }}">
                                    <thead>
                                    <th>Event Name</th>
                                    <th>Mall Name</th>
                                    <th style="display: none">Type</th>
                                    <th>Event Type</th>
                                    <th>Featured</th>
                                    <th>Created By</th>
                                    <th>Action</th>
                                    </thead>
                                    <tbody>
                                    @foreach($events as $event)
                                    <tr class="row-location" data-id="{{@$event->event_id}}">
                                        <td>{{ @$event->event_name }}</td>
                                        <td>{{ @$event->mall->mall_name }}</td>
                                        <td style="display: none">{{ @$event->type }}</td>
                                        <td>
                                            <select name="type" id="" class="events_column_update dd-orange" data-href="{{route('events.column-update',[$event->event_id])}}" data-method="POST">
                                                <option value="P" @if($event->type=='P') selected @endif>{{ \App\EventMaster::P }}</option>
                                                <option value="C" @if($event->type=='C') selected @endif>{{ \App\EventMaster::C }}</option>
                                                <option value="U" @if($event->type=='U') selected @endif>{{ \App\EventMaster::U }}</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="featured" id="" class="events_column_update dd-orange" data-href="{{route('events.column-update',[$event->event_id])}}" data-method="POST">
                                                <option value="N" @if($event->featured=='N') selected @endif>No</option>
                                                <option value="Y" @if($event->featured=='Y') selected @endif>Yes</option>
                                            </select>
                                        </td>
                                        <td>{{ \App\User::getUserName($event->user_id) }}</td>
                                        <td>
                                            <a href="{{route('mall-events.edit',[$event->event_id])}}"><span class="text-info">Edit</span></a>
                                            |
                                            <a href="javascript:;"
                                               data-href="{{route('mall-events.destroy',[$event->event_id])}}"
                                               data-method="DELETE" class="btn-delete"
                                               data-id="{{$event->event_id}}">
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

        $(document).on('submit','#addEvents', function(e){
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
                        $("#event-table").load( $('#event-table').attr('data-sourceurl') +" #event-table");
                        toastr.success(data.message);
                    }
                },
                error: function(data){
                    exeptionReturn(data);
                }
            });
        });

        $(document).ready(function() {
            var dataTables =  $('#event-table').DataTable({
                    responsive: true,
                    aaSorting: [],
                    paging: false,
                   // "scrollX": true
                }
            );

            $('#current').on('click',function () {
                dataTables.columns(2).search("C").draw();
            });
            $('#past').on('click',function () {
                dataTables.columns(2).search("P").draw();
            });
            $('#upcoming').on('click',function () {
                dataTables.columns(2).search("U").draw();
            });
            $('#all').on('click',function () {
                dataTables.columns(2).search("").draw();
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


        $( "#tag_name" ).autocomplete({
            source: function (request, response) {
                $.getJSON($("#tag_name").attr('data-autocompleturl') +'/' + request.term, function (data) {
                    response($.map(data, function (value, key) {
                        return {
                            label: value,
                            value: key
                        };
                    }));
                });
            },
            select: function(event, ui) {
                $("#tag_name").val(ui.item.label);
                $("#tag_id").val(ui.item.value);
               // window.location.href = '{{route("malls")}}/'+ui.item.value;
                return false;
            }
        });

        // change promo outlate live, featured and redeem status
        $(document).on('change', '.events_column_update', function(e){
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