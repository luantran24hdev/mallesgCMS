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

    </style>
@endsection

@section('content')

    <div class="row" >
        <div class="col-md-12">
            <div class="card card-malle">
                <div class="card-header-malle">
                    {{--{{__('Manage Promotions')}}--}}
                    <span>
                    {{ $current_promo->promo_name }}
                        </span>
                    <span style="text-align: center; margin-left: 250px">
                        {{ $current_merchant->merchant_name }}
                    </span>

                    @if(isset($promo_id))
                      <a style="float:right;" href="{{route('promotions.show',['promotions'=>$id, 'promo_id'=>$promo_id])}}">{{__('Back')}}</a>
                    @endif
                    {{--Back--}}
                </div>
                <div class="card-body" data-sourceurl="{{route('promo-outlets.show',['id'=>$id, 'outlate_id'=>$outlate_data->po_id,'promo_id'=>$promo_id])}}" id="editoutlatedata">
                    <form method="POST" action="{{route('promo.update.outlate')}}" id="editOutlates">
                        <input type="hidden" name="out_id" value="{{ $outlate_data->po_id }}">
                    <div class="row" >
                        <div class="col-md-3 mb-3 pr-0">
                            <img class="card-img-top fit-image"
                                 src="{{$live_url.$promotion_images[0]->image_name}}"
                                 alt="image count">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-md-12 font-12">Live</label>
                                    <select name="live" id="" class="outlate_live dd-orange" data-href=""
                                            data-method="PUT">
                                        <option value="Y" @if($outlate_data->live=='Y') selected @endif>Yes</option>
                                        <option value="N" @if($outlate_data->live=='N') selected @endif>No</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-md-12 font-12">Featured</label>
                                    <select name="featured" id="" class="outlate_featured dd-orange" data-href=""
                                            data-method="PUT">
                                        <option value="Y" @if($outlate_data->featured=='Y') selected @endif>Yes</option>
                                        <option value="N" @if($outlate_data->featured=='N') selected @endif>No</option>

                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">{{__('Amount')}}</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-primary font-weight-bold" id="basic-addon1">{{$current_merchant->country->currency_symbol}}</span>
                                            </div>
                                            <input type="text" name="amount" id="promo_amount" value="@if(empty($outlate_data->amount)) {{$current_promo->amount}} @else {{ $outlate_data->amount }} @endif" aria-describedby="basic-addon1" class="form-control text-primary text-right font-weight-bold" onkeypress="return isNumber(event)">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">{{__('Other Offer')}}</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="other_offer" value="" aria-describedby="basic-addon1" class="form-control text-primary text-right font-weight-bold" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-5 mb-3 pr-0">
                            <label class="mb-2 font-12">Description</label>
                            <textarea style="height: 250px;" type="text"  id="description" required=""
                                      value="" class="form-control" disabled>{{ $current_promo->description }}</textarea>
                            </textarea>
                            <label class="mb-2 font-12">Additional Description</label>
                            <textarea style="height: 250px;" type="text" name="desc_2" id="description"
                                      value="" class="form-control">{{ $outlate_data->desc_2 }}</textarea>
                            </textarea>
                        </div>
                        <div class="col-md-3 mb-3 pr-0">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" id="out-form">Update</button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="mb-2 font-12">Promotion Starts on</label>
                                <div class="input-group">
                                    <input type="text" name="start_on" id="start_date" placeholder="Start Date" class="form-control py-2 border-right-0 border hasDatepicker" value="@if(empty($outlate_data->start_on)) {{$current_promo->start_on}} @else {{ $outlate_data->start_on }} @endif">

                                    <span class="input-group-append">
                                            <button class="btn btn-outline-secondary border-left-0 border" type="button">
                                                    <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                </div>
                                <br>

                                <label class="mb-2 font-12">Promotion Ends on </label>
                                <div class="input-group">
                                    <input type="text" name="ends_on" id="end_date" placeholder="End Date" value="{{ @$outlate_data->ends_on }}" class="form-control py-2 border-right-0 border hasDatepicker" >
                                    <span class="input-group-append">
                                            <button class="btn btn-outline-secondary border-left-0 border" type="button">
                                                    <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                </div>

                                <br>
                                <div class="checkbox">
                                    <label class="mb-2 font-12">
                                        <input type="checkbox" value="Y" name="taxes" id="taxes" @if($outlate_data->taxes == 'Y') checked @endif>
                                        Taxes & Services</label>
                                </div>

                                <div class="checkbox">
                                    <label class="mb-2 font-12">
                                        <input type="checkbox" value="Y" name="takeout" id="takeout" @if($outlate_data->takeout == 'Y') checked @endif>
                                        Take Away </label>
                                </div>
                            </div>

                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @include('main.promotions.days')
@endsection
@section('script')
<script>

    // change promo tag status
    $(document).on('change', '.promo_days', function(e){
        e.preventDefault();
        var selectOp = $(this);
        var attrName = selectOp.attr("name");

        $.ajax({
            url: selectOp.attr('data-href'),
            type: selectOp.attr('data-method'),
            dataType:'json',
            data: {
                day : selectOp.attr('name'),
                value : selectOp.find('option:selected').val(),
                'promo_id' : '{{$promo_id}}',
                'po_id' : '{{$outlate_data->po_id}}'
            },
            success:function(data){
                if(data.status==='error'){
                    errorReturn(data)
                }else{
                    $("#outlate-day-table").load($('#outlate-day-table').attr('data-sourceurl')+" #outlate-day-table");
                    toastr.success(data.message);
                }
            },
            error: function(data){
                exeptionReturn(data);
            }
        });
    });

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 46 || charCode > 57) ) {
            return false;
        }
        return true;
    }
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


    $(document).on('submit','#editOutlates', function(e){
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
                    //errorReturn(data)
                    toastr.error(data.message, 'Error');
                }else{
                    //$('#promotion-outlate-table tbody').remove();
                    //$('#editoutlatedata').remove();

                    //console.log($('#editoutlatedata').attr('data-sourceurl')+'#editoutlatedata');
                    $("#editoutlatedata").load($('#editoutlatedata').attr('data-sourceurl')+" #editoutlatedata");
                    toastr.success(data.message);
                }
            },
            error: function(data){
                exeptionReturn(data);
                //toastr.error('I do not think that word means what you think it means.', 'Inconceivable!');
            }
        });
    });


</script>
@endsection