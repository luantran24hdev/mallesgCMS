@extends('layouts.app')

@section('style')

<style type="text/css">
.ui-autocomplete {
  position: absolute;
  top: 100%;
  left: 0;
  z-index: 1000;
  display: none;
  float: left;
  min-width: 160px;
  padding: 5px 0;
  margin: 2px 0 0;
  list-style: none;
  font-size: 14px;
  text-align: left;
  background-color: #ffffff;
  border: 1px solid #cccccc;
  border: 1px solid rgba(0, 0, 0, 0.15);
  border-radius: 4px;
  -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
  background-clip: padding-box;
  max-height: 300px;
        overflow-y: auto;   /* prevent horizontal scrollbar */
        overflow-x: hidden; /* add padding to account for vertical scrollbar */
        z-index:1000 !important;
}

.ui-autocomplete > li > div {
  display: block;
  padding: 3px 20px;
  clear: both;
  font-weight: normal;
  line-height: 1.42857143;
  color: #333333;
  white-space: nowrap;
}

.ui-state-hover,
.ui-state-active,
.ui-state-focus {
  text-decoration: none;
  color: #262626;
  background-color: #f5f5f5;
  cursor: pointer;
}

.ui-helper-hidden-accessible {
  border: 0;
  clip: rect(0 0 0 0);
  height: 1px;
  margin: -1px;
  overflow: hidden;
  padding: 0;
  position: absolute;
  width: 1px;
}

</style>

@endsection

@section('content')
<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle">{{__('Manage Merchants')}}</div>
            <div class="card-body">

            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="mall_name" placeholder="Type Merchant Name" id="mall_name" class="form-control" required="" value="{{@$current_merchant->merchant_name}}" />

                </div>
            </div>

            @if(isset($locations))
            <br />
            <div class="row">
                <div class="col-md-12">
                    <h3><span class="text-info">{{$current_merchant->merchant_name}}    </span></h3>
                    <table class="table table-striped malle-table">
                        @foreach($locations as $location)
                            <tr class="row-location" data-id="{{$location->merchantLocation_id}}">
                                <td>{{$location->mall->mall_name}}</td>
                                <td>{{$location->merchant_location}}</td>
                                <td>{{$location->floor->level}}</td>
                                <td>
                                    <a  href="javascript:;" data-href="{{route('locations.destroy',['merchants'=>$location->merchantLocation_id])}}" data-method="DELETE" class="btn-delete" data-id="{{$location->merchantLocation_id}}">
                                        <span class="text-danger">Delete</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            @endif

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deletelocationmodal" tabindex="-1" role="dialog" aria-labelledby="deletemodallocationlabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="deletemodallocationlabel">Delete Confirmation</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body ">
      <p class="font-12">Are you sure you want to delete this location?</p>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
      <button type="button" class="btn btn-danger" id="btnDeleteLocation">Yes</button>
    </div>
  </div>
</div>
</div>
@endsection


@section('script')
<script>
  $( function() {
    var availableTags = {!! $merchantOptions !!};
    $( "#mall_name" ).autocomplete({
      source: function (request, response) {
        response($.map(availableTags, function (value, key) {
            return {
                label: value,
                value: key
            };
        }));
    },
      select: function(event, ui) {
        window.location.href = '{{route("merchants")}}/'+ui.item.value;
      }
    });


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
                        alert(data.message);
                    }else{  
                        $('#deletelocationmodal').modal('hide');
                        $('.row-location[data-id="'+btndelete.attr('data-id')+'"]').remove();
                        toastr.success("Successfully Removed!");
                    }   
                }
            });
                 
        });
    });


  });
  </script>
@endsection