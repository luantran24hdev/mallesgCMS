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

    <div class="row">
        <div class="col-md-12">
            <div class="card card-malle">
                <div class="card-header-malle">
                    {{__('Manage Promotions')}}

                    {{--@if(isset($promo_id))
                      <a style="float:right;" href="{{route('promotions.show',['promotions'=>$id])}}">{{__('Back')}}</a>
                    @endif--}}
                    Back
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-3 mb-3 pr-0">
                            <img class="card-img-top fit-image"
                                 src="{{$live_url.$promotion_images[0]->image_name}}"
                                 alt="image count">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-md-12 font-12">Live</label>
                                    <select name="live" id="" class="outlate_live dd-orange" data-href=""
                                            data-method="PUT">
                                        <option value="Y">Yes</option>
                                        <option value="N">No</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-md-12 font-12">Featured</label>
                                    <select name="live" id="" class="outlate_featured dd-orange" data-href=""
                                            data-method="PUT">
                                        <option value="Y">Yes</option>
                                        <option value="N">No</option>
                                    </select>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">{{__('Amount')}}</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-primary font-weight-bold" id="basic-addon1"><i class="fa fa-rupee" style="font-size:24px"></i></span>
                                            </div>
                                            <input type="text" name="amount" id="promo_amount" value="{{$current_promo->amount}}" aria-describedby="basic-addon1" class="form-control text-primary text-right font-weight-bold" onkeypress="return isNumber(event)">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">{{__('Other Offer')}}</label>
                                        <div class="input-group mb-3">
                                            <input type="text" name="other_offer" id="other_offer" value="" aria-describedby="basic-addon1" class="form-control text-primary text-right font-weight-bold">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-5 mb-3 pr-0">
                            <label class="mb-2 font-12">Description</label>
                            <textarea style="height: 250px;" type="text" name="description" id="description" required=""
                                      value="" class="form-control">{{ $current_promo->description }}</textarea>
                            </textarea>
                            <label class="mb-2 font-12">Additional Description</label>
                            <textarea style="height: 250px;" type="text" name="description" id="description" required=""
                                      value="" class="form-control"></textarea>
                            </textarea>
                        </div>
                        <div class="col-md-3 mb-3 pr-0">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" id="btnEditPromo">Update</button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="mb-2 font-12">Promotion Starts on</label>
                                <div class="input-group">
                                    <input type="text" name="start_on" id="start_date" placeholder="Start Date" class="form-control py-2 border-right-0 border hasDatepicker" value="">

                                    <span class="input-group-append">
                                            <button class="btn btn-outline-secondary border-left-0 border" type="button">
                                                    <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                </div>
                                <br>

                                <label class="mb-2 font-12">Promotion Ends on </label>
                                <div class="input-group">
                                    <input type="text" name="ends_on" id="end_date" placeholder="End Date" value="" class="form-control py-2 border-right-0 border hasDatepicker" >
                                    <span class="input-group-append">
                                            <button class="btn btn-outline-secondary border-left-0 border" type="button">
                                                    <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('main.promotions.days')
@endsection
