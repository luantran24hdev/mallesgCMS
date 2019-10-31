@extends('layouts.app')

<style>
    .mall_out .select2-container--default .select2-selection--single .select2-selection__arrow{
        top: 5px !important;
    }
    .mall_out .select2-container .select2-selection--single {
        height: 38px !important;
    }

    .mall_out .select2-container--default .select2-selection--single .select2-selection__rendered{
        line-height: 35px;
    }

</style>

@section('content')
<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle">{{__('Merchant In')}} <span style="color: #1d68a7"> {{ $mall->mall_name }} ({{ @$total_merchant }}) </span></div>
            <div class="card-body">

            <div class="row mall_out">

                @if(!isset($id))
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="mb-2 font-12">{{__('Merchant Type')}}</label>
                            <br>
                            <select id="country_select">
                                @if(!empty($locations))
                                    <option value="all">All ({{ @$total_merchant }})</option>
                                    @foreach($locations as $key1 =>$location1)
                                        <option value="{{ $location1[0]->mt_id }}">{{$key1 }} ({{ count($location1) }})</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="mb-2 font-12">{{__('Floor / Level')}}</label>
                            <br>
                            <select id="level_select">
                                @if(!empty($levels))
                                    <option value="all">All</option>
                                    @foreach($levels as $level)
                                        <option value="{{ $level->level_id }}" title="{{ $level->level  }}">{{ $level->level  }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                @endif
            </div>

            @if(isset($locations))
            <br />
            <div class="row">
                <div class="col-md-12">

                    @foreach($locations as $key=>$location1)
                    <div class="hide show_{{$location1[0]->mt_id}}">
                     <b>{{ $key }} ({{ count($location1) }})</b>
                    <table class="table table-striped malle-table mall_info_table" data-sourceurl="">
                        <tbody>
                        @foreach($location1 as $location)
                            <tr class="level_{{ @$location->level_id }} levelhide">
                                <td>{{@$location->merchant_name}}</td>
                                <td>{{$key}}</td>
                                <td>{{@$mall->mall_name}}</td>
                                <td>{{@$location->level}}</td>
                                <td>{{@$location->merchant_location}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                    @endforeach

                </div>
            </div>
            @endif

            </div>
        </div>
    </div>
</div>

@endsection


@section('script')
<script>


    $('#country_select,#level_select').select2({
        width:200
    });

    $('#country_select').on('select2:select', function (e) {
        var id= e.params.data.id;

        if(id == 'all'){
            $('.hide').show();
        }else{
            $('.hide').hide();
            $('.show_'+id).show();
        }

    });

    $('#level_select').on('select2:select', function (e) {
        var id= e.params.data.id;

        if(id == 'all'){
            $('.levelhide').show();
        }else{
            $('.levelhide').hide();
            $('.level_'+id).show();
        }

    });


   /* $(document).ready(function() {
         var dataTables = $('.mall_info_table').DataTable();
         dataTables.columns(2).search("Restaurant").draw();
    });
*/
  </script>
@endsection