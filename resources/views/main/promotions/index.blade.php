@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> 
    <style type="text/css">
        .card{
            margin-bottom: 0px;
        }
        .btn-default{
            color: #fff;
            background-color: #ccc;
            border-color: #ccc;
        }
        .active{
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

.fit-image{
width: 100%;
object-fit: cover;
height: 213px; /* only if you want fixed height */
}
    </style>
@endsection

@section('content')                        
<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle">
            {{__('Manage Promotions')}}

            @if(isset($promo_id))
            <a style="float:right;" href="{{route('promotions.show',['promotions'=>$id])}}">{{__('Back')}}</a>
            @endif 
            </div>
            <div class="card-body">

            <div class="row">
                <div class="col-md-3">
                    <label class="mb-2 font-12">{{__('Merchant')}}</label>
                    <input type="text" name="merchant_name" placeholder="Type Merchant Name" id="merchant_name" class="form-control" required="" value="{{@$current_merchant->merchant_name}}"  jautocom-sourceurl="{{route('merchants.search')}}" jautocom-redirecturl="{{route('promotions')}}/" />

                </div>
            </div>

            @if(isset($promotions) && empty($promo_id))
            <br />
            <div class="row">
                <div class="col-md-12"> 
                    <form method="POST" action="{{route('promotions.store')}}" id="frm-add-promotion">
                        <input type="hidden" name="merchant_id" id="mall_id" value="{{$current_merchant->merchant_id}}">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="mb-2 font-12">{{__('Promotion Name')}}</label>
                                    <input type="text" name="promo_name" placeholder="Promotion Name" id="promo_name" class="form-control" required="">
                                </div>
                            </div>
 
 
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary col-md-12 top-t" id="btnMerchantPromotion">{{__('Add Promotion')}}</button>
                            </div>
                        </div>
                    </form>
                    <table class="table table-striped malle-table " id="promotion-table" data-sourceurl="{{route('promotions.show',['promotions'=>$id])}}">
                        <thead>
                            <tr>
                                <th>{{__('Promotion Name')}}</th>
                                <th>{{__('Merchant Name')}}</th>
                                <th>{{__('Created By')}}</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                         @foreach($promotions as $promotions)
                            <tr class="row-promotion" data-id="{{$promotions->promo_id}}">
                                <td>{{$promotions->promo_name}}</td> 
                                <td>{{$promotions->merchant->merchant_name}}</td> 
                                <td>{{$promotions->creator->short_name}}</td> 
                                <td>
                                    <a href="{{route('promotions.show',['promotions'=>$id, 'promo_id'=>$promotions->promo_id])}}" data="2" class="btn-edit"><span class="text-success">Edit</span></a>
                                    |
                                    <a  href="javascript:;" data-href="{{route('promotions.destroy',['promotions'=>$promotions->promo_id])}}" data-method="DELETE" class="btn-delete" data-id="{{$promotions->promo_id}}">
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
@include('main.promotions.tags')
@include('main.promotions.days')

<div class="modal fade" id="deletepromotionmodal" tabindex="-1" role="dialog" aria-labelledby="deletemodalpromotionlabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="deletemodalpromotionlabel">Delete Confirmation</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body ">
      <p class="font-12">{{__('Are you sure you want to delete Item?')}}</p>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('No')}}</button>
      <button type="button" class="btn btn-danger" id="btnDeletePromotion">{{__('Yes')}}</button>
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="croppermodal" tabindex="-1" role="dialog" aria-labelledby="cropmodallabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="cropmodallabel">Image Cropper</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body ">
      <div class="upload-demo-wrap" style="display: none">
        <div id="upload-demo"></div>
    </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Cancel')}}</button>
      <button type="button" class="btn upload-result" >{{__('Upload')}}</button>
    </div>
  </div>
</div>
</div>

@endsection


@section('script')
<link rel="stylesheet" type="text/css" href="{{asset('css/croppie.css')}}">
<script type="text/javascript" src="{{asset('js/croppie.min.js')}}"></script>


<script>
  $( function() {

   var $uploadCrop = $('#upload-demo');
   $uploadCrop.croppie({
            enableResize: true,
            enableExif: true,
            viewport: {
                width: 550,
                height: 390, 
            },
            boundary: {
                width: 647,
                height: 459
            }
        });

   $('#croppermodal').on('shown.bs.modal', function() {
        $uploadCrop.croppie('bind');
   });
    

    @if(isset($promo_id))
        $(document).on('click','.upload-result', function (ev) {
            $uploadCrop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function (resp) {

                var ImageURL = resp;

                // Split the base64 string in data and contentType
                var block = ImageURL.split(";");
                // Get the content type
                var contentType = block[0].split(":")[1];// In this case "image/gif"
                // get the real base64 content of the file
                var realData = block[1].split(",")[1];// In this case "iVBORw0KGg...."

                // Convert to blob
                var blob = b64toBlob(realData, contentType);

                // Create a FormData and append the file
                var fd = new FormData();
                fd.append("image", blob);
                fd.append("promo_id", "{{@$promo_id}}");
                fd.append("merchant_id", "{{@$id}}");
                fd.append("image_count", $('#selected_image').val());
                
                $.ajax({
                    url: "{{route('promotions.uploadimage')}}",
                    data: fd,// the formData function is available in almost all new browsers.
                    type:"POST",
                    contentType:false,
                    processData:false,
                    cache:false,
                    dataType:"json", // Cha
                    success:function(data){
                        if(data.status==='error'){
                            errorReturn(data)
                        }else{  
                            $('#promo-image-body #promo-image-content').remove();
                            $("#promo-image-body").load( $('#promo-image-body').attr('data-sourceurl') +" #promo-image-content");
                            $('#croppermodal').modal('hide');
                            toastr.success(data.message);
                        }   
                    },
                    error: function(data){ 
                        exeptionReturn(data);
                    }
                });

            });
        });
    @endif

    $(document).on('change', '.imguploader', function () { 
        readFile(this); 
        $('#selected_image').val($(this).attr('data-count'));
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

    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();            
            $('#croppermodal').modal('show');

            reader.onload = function (e) { 
                $('.upload-demo-wrap').show();
                $uploadCrop.croppie('bind', {
                    url: e.target.result
                }).then(function(){
                    console.log('jQuery bind complete');
                });
                
            }
            
            reader.readAsDataURL(input.files[0]);
            
        }
        else {
            alert("Sorry - you're browser doesn't support the FileReader API");
        }
    }

    // malls autocomplete
    jcomplete('#merchant_name');
    jcomplete('#tag_name','target-id');

    // store promotions
    $(document).on('submit','#frm-add-promotion', function(e){
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
                    errorReturn(data)
                }else{  
                    $('#promotion-table tbody').remove();
                    $("#promotion-table").load( $('#promotion-table').attr('data-sourceurl') +" #promotion-table tbody");
                    toastr.success(data.message);
                }   
            },
            error: function(data){ 
                exeptionReturn(data);
            }
        });
    });   

    // update promotions
    $(document).on('submit','#editPromoform', function(e){
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
                    errorReturn(data)
                }else{  
                    toastr.success(data.message);
                }   
            },
            error: function(data){ 
                exeptionReturn(data);
            }
        });
 
    });   

    // delete promotions
    $(document).on('click', '.btn-delete', function(e){
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
                        $('.row-promotion[data-id="'+btndelete.attr('data-id')+'"]').remove();
                        toastr.success(data.message);
                    }   
                }
            });
                 
        });
    });


    //
    $('#no_end_date').click(function() {
        if ($(this). prop("checked") == true) {
                $("#end_date").attr('disabled', true).val("");
        }
        else {
                $("#end_date").attr('disabled', false);
        }
    });

    $('#yes_redeemable').click(function(){
        $('#redeemable_txt').val('Y');
    });

    $('#no_redeemable').click(function(){
        $('#redeemable_txt').val('N');
    });

    $('#yes_active').click(function(){
            $('#active_txt').val('Y');
        });

    $('#no_active').click(function(){
        $('#active_txt').val('N');
    });


     // store promotags
    $(document).on('submit','#addPromoTag', function(e){
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
                    errorReturn(data)
                }else{  
                    $('#promotion-tag-table tbody').remove();
                    $("#promotion-tag-table").load( $('#promotion-tag-table').attr('data-sourceurl') +" #promotion-tag-table tbody");
                    toastr.success(data.message);
                }   
            },
            error: function(data){ 
                exeptionReturn(data);
            }
        });
    });  

    // delete promotion tags
    $(document).on('click', '.btn-pt-delete', function(e){
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
                        $('.row-promo-tags[data-id="'+btndelete.attr('data-id')+'"]').remove();
                        toastr.success(data.message);
                    }   
                }
            });
                 
        });
    });

    // change promo tag status
    $(document).on('change', '.primary_tag', function(e){
        e.preventDefault();
        var selectOp = $(this); 
 
         $.ajax({
            url: selectOp.attr('data-href'),
            type: selectOp.attr('data-method'),       
            dataType:'json',
            data: {'primary_tag': selectOp.find('option:selected').val()},
            success:function(data){
                if(data.status==='error'){
                    errorReturn(data)
                }else{  

                    toastr.success(data.message);
                }   
            },
            error: function(data){ 
                exeptionReturn(data);
            }
        });

    });

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
                value : selectOp.find('option:selected').val()
            },
            success:function(data){
                if(data.status==='error'){
                    errorReturn(data)
                }else{  

                    toastr.success(data.message);
                }   
            },
            error: function(data){ 
                exeptionReturn(data);
            }
        });

    });


    // delete promo image
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
                        $('#promo-image-body #promo-image-content').remove();
                        $("#promo-image-body").load( $('#promo-image-body').attr('data-sourceurl') +" #promo-image-content");
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
        if (charCode > 31 && (charCode < 46 || charCode > 57) ) {
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
  </script>
@endsection