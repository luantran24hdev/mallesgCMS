@extends('layouts.app')
@section('style')

    <style>
        .card{
            margin-bottom: 0px;
        }
        .btn-default{
            color: #fff;
            background-color: #ccc;
            border-color: #ccc;
        }
        .active{
            background-color: #007bff !important;
        }
        .pic {
            width: 100%;
            height: 100%;
        }


        .upload-demo-wrap {
            width: 100%;
            height: 100%;
        }

        .upload-msg {
            text-align: center;
            font-size: 22px;
            color: #aaa;
            border: 1px solid #aaa;
            display: table;
            cursor: pointer;
        }

        .dropzone .dz-message {
            text-align: center;
            font-size: 11px;
            padding: 17px 0 0 0 !important;
            margin: 0 0 0 0 !important;
        }
        .dropzone .dz-preview .dz-details {
            padding: 0px !important;
        }

        .dropzone .dz-preview .dz-image{
            max-width: 50px !important;
            max-height: 50px !important;
        }

        .dropzone .dz-preview{
            margin: 5px !important;
            min-height: 0px !important;
        }

    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card card-malle">
                <div class="card-header-malle">
                   {{__('Manage Meal Groups')}}
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('meal-group.store')}}" id="addlevel">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="meal_name" placeholder="Meal Name"
                                   class="form-control" required="" list="datalist1">
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="out-form">Update</button>
                            </div>
                        </div>

                    </div>
                    </form>

                    @if(isset($mealgroups))
                        <br/>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped malle-table" id="discount-tag-table"
                                       data-sourceurl="{{ route('meal-group') }}">
                                    <thead>
                                    <th></th>
                                    <th>Meal Name</th>
                                    <th>Action</th>
                                    </thead>
                                    <tbody>
                                    @foreach($mealgroups as $mealgroup)
                                    <tr class="row-location" data-id="{{@$mealgroup->mg_id}}">
                                        <td>
                                            @if(!empty($mealgroup->meal_image))
                                                <img src="{{ $live_url.$mealgroup->meal_image }}" width="50px" height="50px">
                                                <br>
                                                <a  href="javascript:;" data-href="{{route('mealgroup.deleteimage',['id'=>@$mealgroup->mg_id])}}" data-method="POST" class="btn-pi-delete" data-id="{{$mealgroup->mg_id}}">
                                                    <span class="text-danger">{{__('Delete')}}</span>
                                                </a>
                                            @else
                                                {{--<i class="fa fa-picture-o" aria-hidden="true" style="font-size: 50px;"></i>--}}
                                                <form action="{{ route('mealgroup.uploadimage') }}" class="dropzone" style="width: 60px;height: 60px;min-height: 0px !important; padding: 0 0 0 0 !important;">
                                                    @csrf
                                                    <input type="hidden" name="mg_id" value="{{@$mealgroup->mg_id}}">
                                                </form>

                                            @endif
                                        </td>
                                        <td>{{ @$mealgroup->meal_name }}</td>
                                        <td>
                                            <a href="javascript:;"
                                               data-href="{{route('meal-group.destroy',[$mealgroup->mg_id])}}"
                                               data-method="DELETE" class="btn-delete"
                                               data-id="{{$mealgroup->mg_id}}">
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
    @include('partials.image_model')
@endsection


@section('script')
    <script type="text/javascript" src="{{ asset('js/dropzone.js') }}"></script>

    <script>


        Dropzone.autoDiscover = false;

        var urls = ['url1', 'url2'];

        $('.dropzone').each(function(index){
            $(this).dropzone({
                dictDefaultMessage: 'Upload',
            })
        });


        /*var dropzone = new Dropzone("form.uouiuiui", {
            dictDefaultMessage: "Upload"
        });*/

        $(document).on('click', '.btn-pi-delete', function(e){
            e.preventDefault();
            var btndelete = $(this);

            $('#deletepromotionmodal').modal('show');

            $('#btnDeletePromotion').unbind().click(function(){

                $.ajax({
                    url: btndelete.attr('data-href'),
                    type: btndelete.attr('data-method'),
                    dataType:'json',
                    success:function(data){
                        if(data.status==='error'){
                            errorReturn(data)
                        }else{
                            $('#deletepromotionmodal').modal('hide');
                            $("#discount-tag-table").load( $('#discount-tag-table').attr('data-sourceurl') +" #discount-tag-table");
                            toastr.success(data.message);
                            window.location.href = '{{ route('meal-group') }}';
                        }
                    }
                });

            });
        });

        $(document).on('submit','#addlevel', function(e){
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
                        $("#discount-tag-table").load( $('#discount-tag-table').attr('data-sourceurl') +" #discount-tag-table");
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
                $("#tmg_id").val(ui.item.value);
               // window.location.href = '{{route("malls")}}/'+ui.item.value;
                return false;
            }
        });


        $(document).on('change', '.tag_column_update', function(e){
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
