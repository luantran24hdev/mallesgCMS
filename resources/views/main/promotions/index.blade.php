@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style type="text/css">
        .card {
            margin-bottom: 0px;
        }

        .btn-default {
            color: #fff;
            background-color: #ccc;
            border-color: #ccc;
        }

        .active {
            background-color: #007bff !important;
        }

        .pic {
            width: 100%;
            height: 100%;
        }


        .upload-demo-wrap {
            width: 100%;
            height: 100;
        }

        .upload-msg {
            text-align: center;
            font-size: 22px;
            color: #aaa;
            border: 1px solid #aaa;
            display: table;
            cursor: pointer;
        }

        .fit-image {
            width: 100%;
            object-fit: cover;
            height: 213px; /* only if you want fixed height */
        }


        .prom_out .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 6px !important;
        }

        .prom_out .select2-container .select2-selection--single {
            height: 38px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px !important;
        }

        .prom_cat .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 32px !important;
        }

        .prom_cat .select2-container .select2-selection--single {
            height: 38px !important;
            margin-top: 25px;
        }

        .merch_out .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 5px !important;
        }

        .merch_out .select2-container .select2-selection--single {
            height: 38px !important;
        }

        .merch_out .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 35px;
        }

    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card card-malle">
                <div class="card-header-malle">
                    {{__('Manage Promotions')}} ({{ count($promotions) }})

                    @if(isset($promo_id))
                        <a style="float:right;"
                           href="{{route('promotions.show',['promotions'=>$id])}}">{{__('Back')}}</a>
                    @endif
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-3">
                            <label class="mb-2 font-12">{{__('Merchant')}}</label>
                            <input type="text" name="merchant_name" placeholder="Type Merchant Name" id="merchant_name"
                                   class="form-control" required="" value="{{@$current_merchant->merchant_name}}"
                                   jautocom-sourceurl="{{route('merchants.search')}}"
                                   jautocom-redirecturl="{{route('promotions')}}/"/>
                        </div>
                        @if(!isset($id))
                            <div class="col-md-4 merch_out">
                                <div class="form-group">
                                    <label class="mb-2 font-12">{{__('Country')}}</label>
                                    <br>
                                    <select id="country_select">
                                        @if(!empty($countrys))
                                            @foreach($countrys as $country)
                                                <?php $country_total = \App\CountryMaster::totalCountryPromotionMerchant($country->country_id);?>
                                                <option
                                                    value="{{ $country->country_name }}">{{ $country->country_name }}
                                                    ({{ $country_total }})
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        @endif

                    </div>

                    @if(isset($promotions) && empty($promo_id))
                        <br/>
                        <div class="row">
                            <div class="col-md-12">
                                @if(isset($id))
                                    <form method="POST" action="{{route('promotions.store')}}" id="frm-add-promotion">
                                        <input type="hidden" name="merchant_id" id="mall_id"
                                               value="{{@$current_merchant->merchant_id}}">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label class="mb-2 font-12">{{__('Promotion Name')}}</label>
                                                    <input type="text" name="promo_name" placeholder="Promotion Name"
                                                           id="promo_name" class="form-control" required="">
                                                </div>
                                            </div>


                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-primary col-md-12 top-t"
                                                        id="btnMerchantPromotion">{{__('Add Promotion')}}</button>
                                            </div>
                                        </div>
                                    </form>
                                @endif
                                <table class="table table-striped malle-table " id="promotion-table"
                                       data-sourceurl="{{route('promotions.show',['promotions'=>@$id])}}">
                                    <thead>
                                    <tr>
                                        <th>{{__('Promotion Name')}}</th>
                                        <th>{{__('Merchant Name')}}</th>
                                        <th>{{__('Merchant Country')}}</th>
                                        <th>{{__('Outlets')}}</th>
                                        <th>{{__('Created By')}}</th>
                                        <th>{{__('Active')}}</th>
                                        <th>{{__('Featured')}}</th>
                                        <th>{{__('Action')}}&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($promotions as $promotions)
                                        <tr class="row-promotion" data-id="{{$promotions->promo_id}}">
                                            <td>{{$promotions->promo_name}}</td>
                                            <td>{{@$promotions->merchant->merchant_name}}</td>
                                            <td>{{@$promotions->merchant->country->country_name}}</td>
                                            <td>{{ $total_outlate = \App\PromotionMaster::totalOutlate($promotions->promo_id) }}</td>
                                            <td>{{$promotions->creator->short_name}}</td>
                                            <td>

                                                <select name="promo_active" id="" class="column_update dd-orange"
                                                        data-href="{{route('promotions.col',['promo_id' => $promotions->promo_id])}}"
                                                        data-method="POST">
                                                    <option value="Y"
                                                            @if($promotions->promo_active=='Y') selected @endif>Yes
                                                    </option>
                                                    <option value="N"
                                                            @if($promotions->promo_active!='Y') selected @endif>No
                                                    </option>
                                                </select>

                                            </td>
                                            <td>
                                                {{--                                                @if($promotions->featured=='Y')--}}
                                                {{--                                                    <span> Yes </span>--}}
                                                {{--                                                @else--}}
                                                <select name="featured" id="" class="column_update dd-orange"
                                                        data-href="{{route('promotions.col',['promo_id' => $promotions->promo_id])}}"
                                                        data-method="POST">
                                                    <option value="Y"
                                                            @if($promotions->featured=='Y') selected @endif>Yes
                                                    </option>
                                                    <option value="N"
                                                            @if($promotions->featured!='Y') selected @endif>No
                                                    </option>
                                                </select>
                                                {{--                                                @endif--}}
                                            </td>
                                            <td>
                                                <a href="{{route('promotions.show',['promotions'=>$promotions->merchant_id, 'promo_id'=>$promotions->promo_id])}}"
                                                   data="2" class="btn-edit"><span class="text-success">Edit</span></a>
                                                |
                                                <a href="javascript:;"
                                                   data-href="{{route('promotions.destroy',['promotions'=>$promotions->promo_id])}}"
                                                   data-method="DELETE" class="btn-delete"
                                                   data-id="{{$promotions->promo_id}}">
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

                    @include('main.promotions.edit')

                </div>
            </div>


        </div>
    </div>

    @include('main.promotions.images')
    @include('main.promotions.outlets')
    @include('main.promotions.tags')
    @include('main.promotions.category')
    @include('main.promotions.preference')
    @include('main.promotions.age_group')
    @include('main.promotions.meal_group')


    @include('partials.delete_model')

@endsection


@section('script')

    <script type="text/javascript" src="{{ asset('js/dropzone.js') }}"></script>
    <script>

        $(document).ready(function () {

            var dataTables = $('#promotion-table').DataTable({
                    responsive: true,
                    aaSorting: [],
                    paging: false
                }
            );
            '<?php if(!isset($id)) { ?>'
            dataTables.columns(2).search("Singapore").draw();
            '<?php } ?>'

            $('#country_select').on('select2:select', function (e) {
                var val = e.params.data.id;
                dataTables.columns(2).search(val).draw();
            });


            $('#prom_out').val('');
            $('#prom_out').select2({
                placeholder: 'Search Mall Name',
                allowClear: true,
                width: 200,
                height: 50
            });
            $('#prom_out').on('select2:select', function (e) {
                $("#mall_name").val(e.params.data.text);
                $("#mall_id").val(e.params.data.id);
                console.log("e");

                $.ajax({
                    type: 'POST',
                    url: '{{ route('promotions.location') }}',
                    //data:'_token = <?php echo csrf_token() ?>',
                    data: {
                        'mall_id': e.params.data.id,
                        'merchent_id': $('#merchant_id').val(),
                        '_token': '<?php echo csrf_token() ?>'
                    },
                    success: function (data) {
                        //$("#msg").html(data.msg);
                        console.log(data.location);
                        $('#locations').html(data.location);
                    }
                });
            });

            $(".column_update_promotion").change(function () {

                var value = $(this).val();
                var attrName = $(this).attr("name");
                var promo_id = $('#promo_id').val();

                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '{{ route('promotions.col') }}',
                    data: {
                        name: attrName,
                        value: value,
                        promo_id: promo_id
                    },
                    async: false,
                    dataType: 'json',
                    success: function (data) {

                        // /toastr.success(data.message);
                        toastr['info'](data.message);

                    },
                    error: function () {
                        toastr['error']('Could not update featured.');
                    }
                });
            });


            $(".checkbox_update_promotion").change(function () {

                var value = $(this).val();
                var attrName = $(this).attr("name");
                var promo_id = $('#promo_id').val();

                if(!$(this).prop("checked")){
                    value= 'N';
                }

                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '{{ route('promotions.col') }}',
                    data: {
                        name: attrName,
                        value: value,
                        promo_id: promo_id
                    },
                    async: false,
                    dataType: 'json',
                    success: function (data) {

                        // /toastr.success(data.message);
                        toastr['info'](data.message);

                    },
                    error: function () {
                        toastr['error']('Could not update featured.');
                    }
                });
            });


            $('#category_select,#preference_select,#age_select,#mg_select').val('');
            $('#category_select').select2({
                placeholder: 'Search Category',
                allowClear: true,
                width: 400,
                height: 50
            });
            $('#preference_select').select2({
                placeholder: 'Search Preference',
                allowClear: true,
                width: 400,
                height: 50
            });
            $('#age_select').select2({
                placeholder: 'Select Age Group Name',
                allowClear: true,
                width: 400,
                height: 50
            });
            $('#mg_select').select2({
                placeholder: 'Select Meal',
                allowClear: true,
                width: 400,
                height: 50
            });
            $('#category_select').on('select2:select', function (e) {
                $("#sub_category_id").val(e.params.data.id);
            });
            $('#preference_select').on('select2:select', function (e) {
                $("#preference_id").val(e.params.data.id);
            });
            $('#age_select').on('select2:select', function (e) {
                $("#ag_id").val(e.params.data.id);
            });
            $('#mg_select').on('select2:select', function (e) {
                $("#mg_id").val(e.params.data.id);
            });

        });

        $(function () {

            $('#country_select').select2({
                width: 200
            });

            $('#start_date').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });

            $('#end_date').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });


            // malls autocomplete
            jcomplete('#merchant_name');
            jcomplete('#tag_name', 'tag_id');

            // store promotions
            $(document).on('submit', '#frm-add-promotion', function (e) {
                e.preventDefault();
                var data = $(this).serialize();
                var url = $(this).attr('action');
                var type = $(this).attr('method');

                $.ajax({
                    url: url,
                    type: type,
                    dataType: 'json',
                    data: data,
                    success: function (data) {
                        if (data.status === 'error') {
                            errorReturn(data)
                        } else {
                            $('#promotion-table tbody').remove();
                            $("#promotion-table").load($('#promotion-table').attr('data-sourceurl') + " #promotion-table tbody");
                            toastr.success(data.message);
                        }
                    },
                    error: function (data) {
                        exeptionReturn(data);
                    }
                });
            });

            // update promotions
            $(document).on('submit', '#editPromoform', function (e) {
                e.preventDefault();
                var data = $(this).serialize();
                var url = $(this).attr('action');
                var type = $(this).attr('method');

                $.ajax({
                    url: url,
                    type: type,
                    dataType: 'json',
                    data: data,
                    success: function (data) {
                        if (data.status === 'error') {
                            errorReturn(data)
                        } else {
                            toastr.success(data.message);
                        }
                    },
                    error: function (data) {
                        exeptionReturn(data);
                    }
                });

            });

            // delete promotions
            $(document).on('click', '.btn-delete', function (e) {
                e.preventDefault();
                var btndelete = $(this);

                $('#deletepromotionmodal').modal('show');

                $('#btnDeletePromotion').unbind().click(function () {

                    $.ajax({
                        url: btndelete.attr('data-href'),
                        type: btndelete.attr('data-method'),
                        dataType: 'json',
                        success: function (data) {
                            if (data.status === 'error') {
                                errorReturn(data)
                            } else {
                                $('#deletepromotionmodal').modal('hide');
                                $('.row-promotion[data-id="' + btndelete.attr('data-id') + '"]').remove();
                                toastr.success(data.message);
                            }
                        }
                    });

                });
            });


            //
            $('#no_end_date').click(function () {
                if ($(this).prop("checked") == true) {
                    $("#end_date").attr('disabled', true).val("");
                } else {
                    $("#end_date").attr('disabled', false);
                }
            });

            // store promotags
            $(document).on('submit', '#addPromoTag', function (e) {
                e.preventDefault();
                var data = $(this).serialize();
                var url = $(this).attr('action');
                var type = $(this).attr('method');

                $.ajax({
                    url: url,
                    type: type,
                    dataType: 'json',
                    data: data,
                    success: function (data) {
                        if (data.status === 'error') {
                            // console.log(data);
                            toastr.error(data.message, 'Error');
                            //errorReturn(data)
                        } else {
                            //console.log(data);
                            $('#promotion-tag-table tbody').remove();
                            $("#promotion-tag-table").load($('#promotion-tag-table').attr('data-sourceurl') + " #promotion-tag-table tbody");
                            toastr.success(data.message);
                        }
                    },
                    error: function (data) {
                        mall_name
                        // console.log(data);
                        exeptionReturn(data);
                    }
                });
            });

            $(document).on('submit', '#addOutlates', function (e) {
                e.preventDefault();
                var data = $(this).serialize();
                var url = $(this).attr('action');
                var type = $(this).attr('method');

                $.ajax({
                    url: url,
                    type: type,
                    dataType: 'json',
                    data: data,
                    success: function (data) {
                        if (data.status === 'error') {
                            //errorReturn(data)
                            toastr.error(data.message, 'Error');
                        } else {
                            $('#promotion-outlate-table tbody').remove();
                            $("#promotion-outlate-table").load($('#promotion-outlate-table').attr('data-sourceurl') + " #promotion-outlate-table");
                            toastr.success(data.message);
                        }
                    },
                    error: function (data) {
                        exeptionReturn(data);
                        //toastr.error('I do not think that word means what you think it means.', 'Inconceivable!');
                    }
                });
            });


            $(document).on('submit', '#addPromoCategory', function (e) {
                e.preventDefault();
                var data = $(this).serialize();
                var url = $(this).attr('action');
                var type = $(this).attr('method');

                $.ajax({
                    url: url,
                    type: type,
                    dataType: 'json',
                    data: data,
                    success: function (data) {
                        if (data.status === 'error') {
                            //errorReturn(data)
                            toastr.error(data.message, 'Error');
                        } else {
                            $('#promotion-category-table tbody').remove();
                            $("#promotion-category-table").load($('#promotion-category-table').attr('data-sourceurl') + " #promotion-category-table");
                            toastr.success(data.message);
                        }
                    },
                    error: function (data) {
                        exeptionReturn(data);
                        //toastr.error('I do not think that word means what you think it means.', 'Inconceivable!');
                    }
                });
            });

            $(document).on('submit', '#addPromoPreference', function (e) {
                e.preventDefault();
                var data = $(this).serialize();
                var url = $(this).attr('action');
                var type = $(this).attr('method');

                $.ajax({
                    url: url,
                    type: type,
                    dataType: 'json',
                    data: data,
                    success: function (data) {
                        if (data.status === 'error') {
                            //errorReturn(data)
                            toastr.error(data.message, 'Error');
                        } else {
                            $('#promotion-preference-table tbody').remove();
                            $("#promotion-preference-table").load($('#promotion-preference-table').attr('data-sourceurl') + " #promotion-preference-table");
                            toastr.success(data.message);
                        }
                    },
                    error: function (data) {
                        exeptionReturn(data);
                        //toastr.error('I do not think that word means what you think it means.', 'Inconceivable!');
                    }
                });
            });


            $(document).on('submit', '#addPromoAge', function (e) {
                e.preventDefault();
                var data = $(this).serialize();
                var url = $(this).attr('action');
                var type = $(this).attr('method');

                $.ajax({
                    url: url,
                    type: type,
                    dataType: 'json',
                    data: data,
                    success: function (data) {
                        if (data.status === 'error') {
                            //errorReturn(data)
                            toastr.error(data.message, 'Error');
                        } else {
                            $('#promotion-age-table tbody').remove();
                            $("#promotion-age-table").load($('#promotion-age-table').attr('data-sourceurl') + " #promotion-age-table");
                            toastr.success(data.message);
                        }
                    },
                    error: function (data) {
                        exeptionReturn(data);
                        //toastr.error('I do not think that word means what you think it means.', 'Inconceivable!');
                    }
                });
            });

            $(document).on('submit', '#addMeal', function (e) {
                e.preventDefault();
                var data = $(this).serialize();
                var url = $(this).attr('action');
                var type = $(this).attr('method');

                $.ajax({
                    url: url,
                    type: type,
                    dataType: 'json',
                    data: data,
                    success: function (data) {
                        if (data.status === 'error') {
                            //errorReturn(data)
                            toastr.error(data.message, 'Error');
                        } else {
                            $('#promotion-meal-table tbody').remove();
                            $("#promotion-meal-table").load($('#promotion-meal-table').attr('data-sourceurl') + " #promotion-meal-table");
                            toastr.success(data.message);
                        }
                    },
                    error: function (data) {
                        exeptionReturn(data);
                        //toastr.error('I do not think that word means what you think it means.', 'Inconceivable!');
                    }
                });
            });


            // delete promotion tags
            $(document).on('click', '.btn-pt-delete', function (e) {
                e.preventDefault();
                var btndelete = $(this);

                $('#deletepromotionmodal').modal('show');

                $('#btnDeletePromotion').unbind().click(function () {

                    $.ajax({
                        url: btndelete.attr('data-href'),
                        type: btndelete.attr('data-method'),
                        dataType: 'json',
                        success: function (data) {
                            if (data.status === 'error') {
                                errorReturn(data)
                            } else {
                                $('#deletepromotionmodal').modal('hide');
                                $('.row-promo-tags[data-id="' + btndelete.attr('data-id') + '"]').remove();
                                toastr.success(data.message);
                            }
                        }
                    });

                });
            });

            // change promo tag status
            $(document).on('change', '.primary_tag', function (e) {
                e.preventDefault();
                var selectOp = $(this);

                $.ajax({
                    url: selectOp.attr('data-href'),
                    type: selectOp.attr('data-method'),
                    dataType: 'json',
                    data: {'primary_tag': selectOp.find('option:selected').val()},
                    success: function (data) {
                        if (data.status === 'error') {
                            errorReturn(data)
                        } else {

                            toastr.success(data.message);
                        }
                    },
                    error: function (data) {
                        exeptionReturn(data);
                    }
                });

            });


            // change promo outlate live, featured and redeem status
            $(document).on('change', '.column_update', function (e) {
                e.preventDefault();
                var selectOp = $(this);
                var attrName = selectOp.attr("name");

                $.ajax({
                    url: selectOp.attr('data-href'),
                    type: selectOp.attr('data-method'),
                    dataType: 'json',
                    data: {
                        name: selectOp.attr('name'),
                        value: selectOp.find('option:selected').val()
                    },
                    success: function (data) {
                        console.log(data);
                        if (data.status === 'error') {
                            errorReturn(data)
                        } else {
                            $("#promotion-table").load($('#promotion-table').attr('data-sourceurl') + " #promotion-table");
                            toastr.success(data.message);
                        }
                    },
                    error: function (data) {
                        console.log(data);
                        exeptionReturn(data);
                    }
                });

            });


            // delete promo image
            $(document).on('click', '.btn-pi-delete', function (e) {
                e.preventDefault();
                var btndelete = $(this);

                $('#deletepromotionmodal').modal('show');

                $('#btnDeletePromotion').unbind().click(function () {

                    $.ajax({
                        url: btndelete.attr('data-href'),
                        type: btndelete.attr('data-method'),
                        dataType: 'json',
                        success: function (data) {
                            if (data.status === 'error') {
                                errorReturn(data)
                            } else {
                                $('#deletepromotionmodal').modal('hide');
                                $('#promo-image-body #promo-image-content').remove();
                                $("#promo-image-body").load($('#promo-image-body').attr('data-sourceurl') + " #promo-image-content");
                                toastr.success(data.message);
                            }
                        }
                    });

                });
            });

        });

        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 46 || charCode > 57)) {
                return false;
            }
            return true;
        }

        function b64toBlob(b64Data, contentType, sliceSize) {
            contentType = contentType || '';
            sliceSize = sliceSize || 512;

            var byteCharacters = atob(b64Data);
            var byteArrays = [];

            for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
                var slice = byteCharacters.slice(offset, offset + sliceSize);

                var byteNumbers = new Array(slice.length);
                for (var i = 0; i < slice.length; i++) {
                    byteNumbers[i] = slice.charCodeAt(i);
                }

                var byteArray = new Uint8Array(byteNumbers);

                byteArrays.push(byteArray);
            }

            var blob = new Blob(byteArrays, {type: contentType});
            return blob;
        }

        // malls
        $("#mall_name").autocomplete({
            source: function (request, response) {
                $.getJSON($("#mall_name").attr('data-autocompleturl') + '/' + request.term, function (data) {
                    response($.map(data, function (value, key) {
                        return {
                            label: value,
                            value: key
                        };
                    }));
                });
            },
            select: function (event, ui) {
                //console.log(event);

                $("#mall_name").val(ui.item.label);
                $("#mall_id").val(ui.item.value);

                $.ajax({
                    type: 'POST',
                    url: '{{ route('promotions.location') }}',
                    //data:'_token = <?php echo csrf_token() ?>',
                    data: {
                        'mall_id': ui.item.value,
                        'merchent_id': $('#merchant_id').val(),
                        '_token': '<?php echo csrf_token() ?>'
                    },
                    success: function (data) {
                        //$("#msg").html(data.msg);
                        console.log(data.location);
                        $('#locations').html(data.location);
                    }
                });


                return false;
            }
        });

        // autocomplete
        var jcomplete = function (element) {
            var targetid = $(element).attr('jautocom-targetid');
            var redirecturl = $(element).attr('jautocom-redirecturl');
            $(element).autocomplete({
                source: function (request, response) {
                    $.getJSON($(element).attr('jautocom-sourceurl') + '/' + request.term, function (data) {
                        response($.map(data, function (value, key) {
                            return {
                                label: value,
                                value: key
                            };
                        }));
                    });
                },
                select: function (event, ui) {
                    //alert('hii');
                    $(element).val(ui.item.label);
                    //this will determin the call back of autocomplete
                    if (typeof redirecturl !== typeof undefined && redirecturl !== false) {
                        window.location.href = $(element).attr('jautocom-redirecturl') + ui.item.value;
                    } else if (typeof targetid !== typeof undefined && targetid !== false) {
                        $('#tag_id').val(ui.item.value);
                        $($(element).attr('jautocom-targetid')).val(ui.item.value);
                    }
                    return false;
                }
            });
        }


    </script>
    <script>
        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            var btndelete = $(this);

            $('#deletelocationmodal').modal('show');

            $('#btnDeleteLocation').unbind().click(function () {

                $.ajax({
                    url: btndelete.attr('data-href'),
                    type: btndelete.attr('data-method'),
                    dataType: 'json',
                    success: function (data) {
                        if (data.status === 'error') {
                            toastr.error(data.message);
                        } else {
                            $('#deletelocationmodal').modal('hide');
                            $('.row-promotion[data-id="' + btndelete.attr('data-id') + '"]').remove();
                            toastr.success(data.message);
                        }
                    }
                });

            });
        });
    </script>
    <script>
        $(document).on('click', '.btn-pt-delete', function (e) {
            e.preventDefault();
            var btndelete = $(this);

            $('#deletelocationmodal').modal('show');

            $('#btnDeleteLocation').unbind().click(function () {

                $.ajax({
                    url: btndelete.attr('data-href'),
                    type: btndelete.attr('data-method'),
                    dataType: 'json',
                    success: function (data) {
                        if (data.status === 'error') {
                            toastr.error(data.message);
                        } else {
                            $('#deletelocationmodal').modal('hide');
                            $('.row-promo-tags[data-id="' + btndelete.attr('data-id') + '"]').remove();
                            toastr.success(data.message);
                        }
                    }
                });

            });
        });
    </script>

@endsection
