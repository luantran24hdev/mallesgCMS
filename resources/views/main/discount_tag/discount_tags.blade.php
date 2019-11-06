@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card card-malle">
                <div class="card-header-malle">
                   {{__('Discount/Sale Tags')}}
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('discount-tags.store')}}" id="addDiscountTag">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="tag_name" placeholder="Enter Tag" id="tag_name"
                                   class="form-control" required="" list="datalist1" data-autocompleturl="{{route('tag.search')}}">
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="out-form">Update</button>
                            </div>
                        </div>

                    </div>
                    </form>

                    @if(isset($tags_master))
                        <br/>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped malle-table" id="discount-tag-table"
                                       data-sourceurl="{{ route('discount-tags') }}">
                                    <thead>
                                    <th>Tag Type</th>
                                    <th>Action</th>
                                    </thead>
                                    <tbody>
                                    @foreach($tags_master as $tag_master)
                                    <tr class="row-location" data-id="{{@$tag_master->tag_id}}">
                                        <td>{{ @$tag_master->tag_name }}</td>

                                        <td>
                                            <a href="{{route('discount-tags.edit',[$tag_master->tag_id])}}"><span class="text-info">Edit</span></a>
                                            |
                                            <a href="javascript:;"
                                               data-href="{{route('discount-tags.destroy',[$tag_master->tag_id])}}"
                                               data-method="DELETE" class="btn-delete"
                                               data-id="{{$tag_master->tag_id}}">
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

        $(document).on('submit','#addDiscountTag', function(e){
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
                $("#tag_id").val(ui.item.value);
               // window.location.href = '{{route("malls")}}/'+ui.item.value;
                return false;
            }
        });

    </script>
@endsection