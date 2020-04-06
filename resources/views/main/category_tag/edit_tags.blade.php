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
                   <p>Category Id: <span style="margin-right: 120px;color: red">{{ $tagMaster->sub_category_id }}</span> | Created On: <span style="margin-right: 120px;color: red">{{ $tagMaster->Created_on }}</span> | Created By: <span style="color: red">{{ \App\User::getUserName( $tagMaster->Created_by)  }}</span> <span style="float: right;color: blue"><a href="{{ route('category-tags') }}">Back</a></span></p>
                </div>
                <div class="card-body" id="tag-image-body" data-sourceurl="{{route('category-tags.edit',[$tagMaster->sub_category_id])}}">

                    <div class="row merch_out" id="tag-image-content">

                            <div class="col-md-3">

                                @if($tagMaster->image)
                                    <div class="col-md-12 mb-3 pr-0">
                                        <img class="card-img-top fit-image" src="{{ $live_url.$tagMaster->image}}" alt="image count">
                                        <a  href="javascript:;" data-href="{{route('category.tag.deleteimage',['id'=>$tagMaster->sub_category_id])}}" data-method="POST" class="btn-pi-delete" data-id="{{$tagMaster->sub_category_id}}">
                                            <span class="text-danger">{{__('Delete')}}</span>
                                        </a>
                                    </div>
                                @else

                                    <div class="col-md-12 mb-3 pr-0">
                                        <form action="{{ route('category.tag.uploadimage') }}" class="dropzone" id="my-awesome-dropzone">
                                            @csrf
                                            <input type="hidden" name="sub_category_id" value="{{ @$tagMaster->sub_category_id  }}">
                                        </form>
                                    </div>

                                @endif

                            </div>
                            <div class="col-md-9">
                                <form method="PATCH" action="{{route('category-tags.update',[$tagMaster->sub_category_id])}}" id="editCategoryTag">
                                    <div class="row">
                                    <div class="col-md-3">
                                        <input type="text" name="Sub_Category_name" placeholder="Enter Category Tag" id="sub_category_name"
                                               class="form-control" required="" list="datalist1" data-autocompleturl="{{route('category.tag.search')}}" value="{{ $tagMaster->Sub_Category_name }}">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select id="main_category_select" name="Category_id">
                                                @if(!empty($categorys))
                                                    @foreach($categorys as $category)
                                                        <option value="{{ $category->Category_id }}" @if($category->Category_id == $tagMaster->Category_id) selected @endif>{{$category->Category_name }}</option>
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
                            </div>

                    </div>


                </div>
            </div>
        </div>
    </div>

    @include('partials.image_model')
@endsection


@section('script')
    <script type="text/javascript" src="{{ asset('js/dropzone.js') }}"></script>
    <script>

        $('#main_category_select').select2({
            width:200
        });

        $(document).on('submit','#editCategoryTag', function(e){
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
                        //$("#discount-tag-table").load( $('#discount-tag-table').attr('data-sourceurl') +" #discount-tag-table");
                        toastr.success(data.message);
                    }
                },
                error: function(data){
                    exeptionReturn(data);
                }
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
                            //var image_count = $(this).attr('data-id')
                            $('#tag-image-body #tag-image-content').remove();
                            $("#tag-image-body").load( $('#tag-image-body').attr('data-sourceurl') +" #tag-image-content");
                            toastr.success(data.message);

                            setTimeout(function() {
                                window.location.reload();
                            }, 2000);
                        }
                        select2intalize();
                    }
                });

            });
        });

        function select2intalize() {
            $('#main_category_select').select2({
                width:200
            });
        }



    </script>
@endsection
