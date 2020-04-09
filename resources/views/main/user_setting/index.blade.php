@extends('layouts.app')
@section('style')
    <style>
        .promo_amount{
            max-width: 80px !important;
        }

    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card card-malle">
                <div class="card-header-malle">
                   {{__('User Setting')}}
                </div>
                <div class="card-body">

                    @if(isset($settings))
                        <br/>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped malle-table" id="preference-tag-table"
                                       data-sourceurl="{{ route('preference-tags') }}">
                                    <thead>
                                    <th>Country</th>
                                    <th>G.S.T</th>
                                    <th>Service Charge</th>
                                    <th>Take Out Charge</th>
                                    <th>Delivery Charge</th>

                                    </thead>
                                    <tbody>
                                    @foreach($settings as $setting)
                                    <tr class="row-location" data-id="{{@$setting->us_id}}">
                                        <td>{{ @$setting->country->country_name }}</td>

                                        <td>

                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text text-primary font-weight-bold" id="basic-addon1">{{$setting->country->currency_symbol}}</span>
                                                </div>
                                                <input type="text" name="g_s_t" id="" data-id="{{@$setting->us_id}}" value="{{@$setting->g_s_t}}" aria-describedby="basic-addon1" class="promo_amount form-control text-primary text-right font-weight-bold" onkeypress="return isNumber(event)" >

                                            </div>

                                        </td>

                                        <td>

                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text text-primary font-weight-bold" id="basic-addon1">{{$setting->country->currency_symbol}}</span>
                                                </div>
                                                <input type="text" name="service_charge" id="" data-id="{{@$setting->us_id}}" value="{{@$setting->service_charge}}" aria-describedby="basic-addon1" class="promo_amount form-control text-primary text-right font-weight-bold" onkeypress="return isNumber(event)" >

                                            </div>

                                        </td>


                                        <td>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text text-primary font-weight-bold" id="basic-addon1">{{$setting->country->currency_symbol}}</span>
                                                </div>
                                                <input type="text" name="take_out_charge" id="" data-id="{{@$setting->us_id}}" value="{{@$setting->take_out_charge}}" aria-describedby="basic-addon1" class="promo_amount form-control text-primary text-right font-weight-bold" onkeypress="return isNumber(event)">

                                            </div>

                                        </td>
                                        <td>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text text-primary font-weight-bold" id="basic-addon1">{{$setting->country->currency_symbol}}</span>
                                                </div>
                                                <input type="text" name="delivery_charge" id="" data-id="{{@$setting->us_id}}" value="{{@$setting->delivery_charge}}" aria-describedby="basic-addon1" class="promo_amount form-control text-primary text-right font-weight-bold" onkeypress="return isNumber(event)">

                                            </div>

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

        function isNumber(evt) {
            //console.log(evt.target.value.length);
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 46 || charCode > 57) ) {
                return false;
            }
            if(evt.target.value.length > 4){
                return false;
            }
            return true;
        }


        $(document).on('blur','.promo_amount', function(e){
            e.preventDefault();

            var id = $(this).attr('data-id');


            $.ajax({
                url: '{{ route('user-setting.create') }}',
                type: 'GET',
                dataType:'json',
                data:{
                    name:$(this).attr('name'),
                    value:$(this).val(),
                    id:id
                },
                success:function(data){
                   /* if(data.status==='error'){
                        toastr.error(data.message, 'Error');
                    }else{
                        $("#preference-tag-table").load( $('#preference-tag-table').attr('data-sourceurl') +" #preference-tag-table");
                        toastr.success(data.message);
                    }*/

                    toastr.success(data.message);
                },
                error: function(data){
                    exeptionReturn(data);
                }
            });
        });

    </script>
@endsection
