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
                   {{__('Main Category Tags')}}
                </div>
                <div class="card-body merch_out">
                    <form method="POST" action="{{route('category-tags.store')}}" id="addCategoryTag">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="Sub_Category_name" placeholder="Enter Category Tag" id="sub_category_name"
                                   class="form-control" required="" list="datalist1" data-autocompleturl="{{route('category.tag.search')}}">
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select id="main_category_select" name="Category_id">
                                    @if(!empty($categorys))
                                        <option value="">Select Main Category</option>
                                        @foreach($categorys as $category)
                                            <option value="{{ $category->Category_id }}">{{$category->Category_name }}</option>
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

                    @if(isset($sub_cats))
                        <br/>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped malle-table" id="category-tag-table"
                                       data-sourceurl="{{ route('category-tags') }}">
                                    <thead>
                                    <th>Category Name</th>
                                    <th>Main Category</th>
                                    <th>Action</th>
                                    </thead>
                                    <tbody>
                                    @foreach($sub_cats as $sub_cat)
                                    <tr class="row-location" data-id="{{@$sub_cat->sub_category_id}}">
                                        <td>{{ @$sub_cat->Sub_Category_name }}</td>
                                        <td>{{ @$sub_cat->category->Category_name }}</td>

                                        <td>
                                            <a href="{{route('category-tags.edit',[$sub_cat->sub_category_id])}}"><span class="text-info">Edit</span></a>
                                            |
                                            <a href="javascript:;"
                                               data-href="{{route('category-tags.destroy',[$sub_cat->sub_category_id])}}"
                                               data-method="DELETE" class="btn-delete"
                                               data-id="{{$sub_cat->sub_category_id}}">
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

        $('#main_category_select').select2({
            width:200
        });

        $(document).on('submit','#addCategoryTag', function(e){
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
                        $("#category-tag-table").load( $('#category-tag-table').attr('data-sourceurl') +" #category-tag-table");
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
                $("#tag_id").val(ui.item.value);
                return false;
            }
        });

    </script>
@endsection