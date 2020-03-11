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

            @include('main.mall_list.mall_menu')

            <div class="card-body">

            <form method="POST" action="{{ route('malls.store') }}" id="InsertMalls">

                <div class="row mall_out">
                    <div class="col-md-3">
                        <label class="mb-2 font-12">Mall Name</label>
                        <input type="text" name="mall_name" placeholder="Enter Mall Name" id="mall_name" class="form-control" required="" list="datalist1" data-autocompleturl="{{route('malls.search')}}" value="{{ @$current_malls->mall_name}}">

                    </div>
                    @if(!isset($id))
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="mb-2 font-12">{{__('Country')}}</label>
                                <br>
                                <select id="country_select">
                                    @if(!empty($countrys))
                                        @foreach($countrys as $country)
                                            <?php $country_total = \App\CountryMaster::totalCountryMall($country->country_id);?>
                                            <option value="{{ $country->country_id }}" title="{{$country->country_name}}">{{ $country->country_name }} ({{ $country_total }})</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="mb-2 font-12">{{__('City')}}</label>
                                <br>
                                <select id="city_control" class="form-control">
                                    <?php $country_total = \App\CountryMaster::totalCountryMall(1);?>
                                        <option value="{{ @$citymaster->city_id }}" title="{{ @$citymaster->city_name }}">{{ @$citymaster->city_name }} ({{ $country_total }})</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="mb-2 font-12">{{__('Town')}}</label>
                                <br>
                                <select id="town_control" class="form-control">

                                    @if(!empty($townmasters))
                                        <option value="all">All ({{ $country_total = \App\CountryMaster::totalCountryMall(1)}})</option>
                                        @foreach($townmasters as $townmaster)
                                            <?php $town_total = \App\TownMaster::totalTownMall(1,$townmaster->city_id,$townmaster->town_id);?>
                                            <option value="{{ @$townmaster->town_id }}" title="{{ @$townmaster->town_name }}">{{ @$townmaster->town_name }} ({{ $town_total }})</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="mb-2 font-12">{{__('Mall Type')}}</label>
                                <select id="mall_type">
                                    @if(!empty($mall_types))
                                        <option value="all">All ({{ $country_total = \App\CountryMaster::totalCountryMall(1)}})</option>
                                        @foreach($mall_types as $mall_type)
                                            <?php $type_total = \App\MallType::totalTypeMall($mall_type->country_id,$mall_type->city_id,$mall_type->mt_id);?>
                                            <option value="{{ $mall_type->malltype->type_name }}">{{ $mall_type->malltype->type_name }} ({{ $type_total }})</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-md-12 row insert_mall" style="display: none;">
                    <div class="form-group">
                        <button class="btn btn-primary" id="out-form">Update</button>
                    </div>
                </div>
             </form>

            @if(isset($current_mallss))
            <br />
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped malle-table" id="mall-list-table" @if(isset($id))  data-sourceurl="{{route('merchants.show',['merchant'=>@$id])}}" @else data-sourceurl="{{route('malls')}}" @endif >
                        <thead>
                        <th>Mall Name</th>
                        <th>Town</th>
                        <th>City</th>
                        <th>Country</th>
                        <th>Type</th>
                        <th>Beta</th>
                        <th>Active</th>
                        <th>Featured</th>
                        <th>Merchant</th>
                        <th>Events</th>
                        <th>Promos</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach($current_mallss as $current_malls)
                            <tr class="row-location" data-id="{{$current_malls->mall_id}}">
                                <td>{{ @$current_malls->mall_name }}
                                    <br><br><span class="link_color"><a href="{{ route('malls.edit',[$current_malls->mall_id]) }}"><b>Mall Info</b> </a></span>
                                </td>
                                <td>{{ @$current_malls->town->town_name }}
                                    <br><br><span class="link_color"><a href="{{ route('malls.images',['malls'=>$current_malls->mall_id]) }}"><b>Images</b> </a></span>
                                </td>
                                <td>{{ @$current_malls->city->city_name }}
                                    <br><br><span class="link_color"><a href="{{ route('mall-events',['id'=>$current_malls->mall_id]) }}"><b>Events</b> </a></span>
                                </td>
                                <td>{{ @$current_malls->country->country_name }}
                                    <br><br> <span class="link_color"><a href="{{ route('mall-parking.edit',[$current_malls->mall_id]) }}"> <b> Parking Info</b> </a></span>
                                </td>
                                <td>{{ @$current_malls->malltype->type_name }}
                                    <br><br><span class="link_color"><a href="{{ route('mall-offers',['id'=>$current_malls->mall_id]) }}"> <b>Offers</b> </a></span>
                                </td>
                                <td>
                                    <span style="display: none"> {{ $current_malls->beta }} </span>
                                    <select name="beta" id="" class="malls_column_update dd-orange" data-href="{{route('malls.column-update',[$current_malls->mall_id])}}" data-method="POST">
                                        <option value="N" @if($current_malls->beta=='N') selected @endif>No</option>
                                        <option value="Y" @if($current_malls->beta=='Y') selected @endif>Yes</option>

                                    </select>
                                    <br><br><span class="link_color"><a href="{{ route('malls.level',['id'=>$current_malls->mall_id]) }}"> <b>Level</b> </a></span>
                                </td>
                                <td>
                                    <select name="mall_active" id="" class="malls_column_update dd-orange" data-href="{{route('malls.column-update',[$current_malls->mall_id])}}" data-method="POST">
                                        <option value="N" @if($current_malls->mall_active=='N') selected @endif>No</option>
                                        <option value="Y" @if($current_malls->mall_active=='Y') selected @endif>Yes</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="featured" id="" class="malls_column_update dd-orange" data-href="{{route('malls.column-update',[$current_malls->mall_id])}}" data-method="POST">
                                        <option value="N" @if($current_malls->featured=='N') selected @endif>No</option>
                                        <option value="Y" @if($current_malls->featured=='Y') selected @endif>Yes</option>
                                    </select>
                                </td>

                                <?php $total_merchant = \App\MallMaster::total_merchant($current_malls->mall_id) ?>
                                <td>@if($total_merchant > 0)
                                        <a href="{{ route('mall.merchant.info',[$current_malls->mall_id]) }}"><span style="color: blue"><b> {{ @$total_merchant }}</b></span></a>
                                    @else
                                        {{ @$total_merchant }}
                                    @endif
                                </td>
                                <td> {{ @$total_event = \App\MallMaster::total_event($current_malls->mall_id) }}</td>
                                <td> {{ @$total_promos = \App\MallMaster::total_promos($current_malls->mall_id) }}</td>
                                <td>

                                    <a  href="javascript:;" data-href="{{route('malls.destroy',['malls'=>$current_malls->mall_id])}}" data-method="DELETE" class="btn-delete" data-id="{{$current_malls->mall_id}}">
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


    $(document).on('submit','#InsertMalls', function(e){
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
                    //$("#event-table").load( $('#event-table').attr('data-sourceurl') +" #event-table");
                    $("#mall-list-table").load( $('#mall-list-table').attr('data-sourceurl') +" #mall-list-table");
                    toastr.success(data.message);
                }
            },
            error: function(data){
                exeptionReturn(data);
            }
        });
    });

    $(document).ready(function() {
        var dataTables =  $('#mall-list-table').DataTable({
                responsive: true,
                aaSorting: [],
                paging: false,
                "scrollX": true
            }
        );

        '<?php if(!isset($id)) { ?>'
            dataTables.columns(3).search("Singapore").draw();
        '<?php } ?>'

        $('#country_select').on('select2:select', function (e) {

            var val = e.params.data.title;
            var id= e.params.data.id;

            //console.log(val);
            dataTables.columns(3).search(val).draw();
            dataTables.columns(2).search("").draw();
            dataTables.columns(1).search("").draw();
            dataTables.columns(4).search("").draw();

           $.ajax({
                url: '{{ route('malls.getcity') }}',
                type: 'POST',
                dataType:'json',
               data : {'id':id},
                success:function(data){
                    // /console.log(data);
                    $('#city_control').html(data.city);
                }
            });

            $.ajax({
                url: '{{ route('malls.getTown') }}',
                type: 'POST',
                dataType:'json',
                data : {'id':id},
                success:function(data){
                    // /console.log(data);
                    $('#town_control').html(data.town);
                }
            });

            var country_id = $("#country_select").val();
            $.ajax({
                url: '{{ route('malls.getType') }}',
                type: 'POST',
                dataType:'json',
                data : {'country_id':country_id},
                success:function(data){
                    //console.log(data);
                    $('#mall_type').html(data.city);
                    //dataTables.ajax.reload();
                }
            });

            // /dataTables.ajax.reload();

        });

        $('#city_control').on('select2:select', function (e) {
            //console.log('city');
            var val = e.params.data.title;



            if(val=='all'){
                dataTables.columns(2).search("").draw();
            }else{
                dataTables.columns(2).search(val).draw();
            }
            var country_id = $("#country_select").val();
            var city_id = $("#city_control").val();

            $.ajax({
                url: '{{ route('malls.getType') }}',
                type: 'POST',
                dataType:'json',
                data : {'country_id':country_id,city_id:city_id},
                success:function(data){
                    //console.log(data);
                    $('#mall_type').html(data.city);
                }
            });

            $.ajax({
                url: '{{ route('malls.getTown') }}',
                type: 'POST',
                dataType:'json',
                data : {'id':country_id,city_id:city_id},
                success:function(data){
                    // /console.log(data);
                    $('#town_control').html(data.town);
                }
            });


        });

        $('#mall_type').on('select2:select', function (e) {
            // $("#time_dow_id").val(e.params.data.id);
            var val = e.params.data.id;
            //console.log(e.params.data.text);
            if(val=='all'){
                dataTables.columns(4).search("").draw();
            }else{
                dataTables.columns(4).search(val).draw();
            }
        });

        $('#town_control').on('select2:select', function (e) {
            // $("#time_dow_id").val(e.params.data.id);
            var val = e.params.data.title;
            //console.log(e.params.data.text);
            if(val=='all'){
                dataTables.columns(1).search("").draw();
            }else{
                dataTables.columns(1).search(val).draw();
            }
        });


    });

  $( function() {

      //$('#country_select').val('');
      $('#country_select,#mall_type,#city_control,#town_control').select2({
          width:130
      });

    $("#start_date").datepicker({dateFormat: 'dd/mm/yy'});
            $("#end_date").datepicker({dateFormat: 'dd/mm/yy'});

    // malls

    // malls
    $( "#mall_name" ).autocomplete({
        source: function (request, response) {
            $.getJSON($("#mall_name").attr('data-autocompleturl') +'/' + request.term, function (data) {
                if(data.length == 0){
                    $('.insert_mall').show();
                }else{
                    $('.insert_mall').hide();
                }
                response($.map(data, function (value, key) {
                    return {
                        label: value,
                        value: key
                    };
                }));
            });
        },
          select: function(event, ui) {
             $("#mall_name").val(ui.item.label);
             $("#mall_id").val(ui.item.value);
              window.location.href = '{{route("malls")}}/'+ui.item.value;
             return false;
          }
    });

    // store
    $(document).on('submit','#frm-add-location', function(e){
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
                    alert(data.message);
                }else{
                    $('#location-table tbody').remove();
                    $("#location-table").load( $('#location-table').attr('data-sourceurl') +" #location-table tbody");
                    toastr.success("Successfully Added!");
                }
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
                        window.location.href = '{{ route('malls') }}';
                    }
                }
            });

        });
    });




      // change promo outlate live, featured and redeem status
      $(document).on('change', '.malls_column_update', function(e){
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
                      //$("#merchant-list-table").load( $('#merchant-list-table').attr('data-sourceurl') +" #merchant-list-table");
                      toastr.success(data.message);
                  }
              },
              error: function(data){
                  console.log(data);
                  exeptionReturn(data);
              }
          });

      });


  });
  </script>
@endsection
