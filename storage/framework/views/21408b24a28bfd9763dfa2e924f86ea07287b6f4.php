<?php $__env->startSection('style'); ?>
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
    <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle"><?php echo e(__('Manage Merchants')); ?> (<?php echo e(@$total_merchant); ?>)</div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('merchants.store')); ?>" id="InsertMerchants">
                    <div class="row merch_out">
                        <div class="col-md-3">
                            <label class="mb-2 font-12"><?php echo e(__('Merchant')); ?></label>
                            <input type="text" name="merchant_name" placeholder="Type Merchant Name" id="merchant_name" class="form-control" required="" value="<?php echo e(@$current_merchant->merchant_name); ?>"  data-autocompleturl="<?php echo e(route('merchants.search')); ?>"/>

                        </div>
                        <?php if(!isset($id)): ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-2 font-12"><?php echo e(__('Country')); ?></label>
                                <br>
                                <select id="country_select">
                                    <?php if(!empty($countrys)): ?>
                                        <?php $__currentLoopData = $countrys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $country_total = \App\CountryMaster::totalCountryMerchant($country->country_id);?>
                                            <option value="<?php echo e($country->country_name); ?>"><?php echo e($country->country_name); ?> (<?php echo e($country_total); ?>)</option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="mb-2 font-12"><?php echo e(__('Merchant Type')); ?></label>
                                <select id="merchant_type">
                                    <?php if(!empty($merchant_types)): ?>
                                        <option value="all">All (<?php echo e(@$total_merchant); ?>)</option>
                                        <?php $__currentLoopData = $merchant_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $merchant_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $type_total = \App\MerchantType::totalTypeMerchant($merchant_type->mt_id);?>
                                            <option value="<?php echo e($merchant_type->type); ?>"><?php echo e($merchant_type->type); ?> (<?php echo e($type_total); ?>)</option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>


                    <div class="col-md-12 row insert_merchant" style="display: none">
                        <div class="form-group">
                            <button class="btn btn-primary" id="out-form">Update</button>
                        </div>
                    </div>
                </form>

            <?php if(isset($current_merchants)): ?>
            <br />
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped malle-table" id="merchant-list-table" <?php if(isset($id)): ?>  data-sourceurl="<?php echo e(route('merchants.show',['merchant'=>@$id])); ?>" <?php else: ?> data-sourceurl="<?php echo e(route('merchants.list')); ?>" <?php endif; ?>>
                        <thead>
                        <th>Merchant Name</th>
                        <th>City</th>
                        <th>Country</th>
                        <th>Type</th>
                        <th>Beta</th>
                        <th>Active</th>
                        <th>Featured</th>
                        <th>Outlet</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        <?php if(!empty($current_merchants)): ?>
                        <?php $__currentLoopData = $current_merchants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $current_merchant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="row-location" data-id="<?php echo e($current_merchant->merchant_id); ?>">
                                <td><?php echo e($current_merchant->merchant_name); ?>

                                <br><br><span class="link_color"><a href="<?php echo e(route('merchants.edit',[$current_merchant->merchant_id])); ?>"> Main Info </a> </span>  <span class="link_color" style="float: right"><a href="<?php echo e(route('merchants.images',['merchants'=>$current_merchant->merchant_id])); ?>"> Images</a></span>
                                </td>
                                <td><?php echo e(@$current_merchant->city->city_name); ?></td>
                                <td><?php echo e($current_merchant->country->country_name); ?></td>
                                <td><?php echo e($current_merchant->merchanttype->type); ?></td>
                                <td>
                                    <span style="display: none"> <?php echo e($current_merchant->beta); ?> </span>
                                    <select name="beta" id="" class="merchant_column_update dd-orange" data-href="<?php echo e(route('merchants.column-update',[$current_merchant->merchant_id])); ?>" data-method="POST">
                                        <option value="N" <?php if($current_merchant->beta=='N'): ?> selected <?php endif; ?>>No</option>
                                        <option value="Y" <?php if($current_merchant->beta=='Y'): ?> selected <?php endif; ?>>Yes</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="merchant_active" id="" class="merchant_column_update dd-orange" data-href="<?php echo e(route('merchants.column-update',[$current_merchant->merchant_id])); ?>" data-method="POST">
                                        <option value="N" <?php if($current_merchant->merchant_active=='N'): ?> selected <?php endif; ?>>No</option>
                                        <option value="Y" <?php if($current_merchant->merchant_active=='Y'): ?> selected <?php endif; ?>>Yes</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="featured" id="" class="merchant_column_update dd-orange" data-href="<?php echo e(route('merchants.column-update',[$current_merchant->merchant_id])); ?>" data-method="POST">
                                        <option value="N" <?php if($current_merchant->featured=='N'): ?> selected <?php endif; ?>>No</option>
                                        <option value="Y" <?php if($current_merchant->featured=='Y'): ?> selected <?php endif; ?>>Yes</option>
                                    </select>
                                </td>

                                <td> <?php echo e($outlate_totel  = \App\PromotionOutlet::totalOutlate($current_merchant->merchant_id)); ?></td>
                                <td>
                                    
                                    <a  href="javascript:;" data-href="<?php echo e(route('merchants.destroy',['merchants'=>$current_merchant->merchant_id])); ?>" data-method="DELETE" class="btn-delete" data-id="<?php echo e($current_merchant->merchant_id); ?>">
                                        <span class="text-danger">Delete</span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<?php echo $__env->make('partials.delete_model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
<script>


    $(document).on('submit','#InsertMerchants', function(e){
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
                    $("#merchant-list-table").load( $('#merchant-list-table').attr('data-sourceurl') +" #merchant-list-table");
                    toastr.success(data.message);
                }
            },
            error: function(data){
                exeptionReturn(data);
            }
        });
    });


    $(document).ready(function() {
        var dataTables =  $('#merchant-list-table').DataTable({
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

        $('#merchant_type').on('select2:select', function (e) {
            // $("#time_dow_id").val(e.params.data.id);
            var val = e.params.data.id;

            //console.log(e.params.data.text);
            if(val=='all'){
                dataTables.columns(3).search("").draw();
            }else{
            dataTables.columns(3).search(val).draw();
            }
        });


    });

  $( function() {


     //$('#country_select').val('');
      $('#country_select,#merchant_type').select2({
          width:200
      });

    $("#start_date").datepicker({dateFormat: 'dd/mm/yy'});
            $("#end_date").datepicker({dateFormat: 'dd/mm/yy'});

    // malls
    $( "#merchant_name" ).autocomplete({
        source: function (request, response) {
            $.getJSON($("#merchant_name").attr('data-autocompleturl') +'/' + request.term , function (data) {
                if(data.length == 0){
                    $('.insert_merchant').show();
                }else{
                    $('.insert_merchant').hide();
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
            $("#merchant_name").val(ui.item.label); 
            window.location.href = '<?php echo e(route("merchants.list.show")); ?>/'+ui.item.value;

            return false;
          }
    });

    // malls
    $( "#mall_name" ).autocomplete({
        source: function (request, response) {
            $.getJSON($("#mall_name").attr('data-autocompleturl') +'/' + request.term, function (data) {
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
                    }   
                }
            });
                 
        });
    });




      // change promo outlate live, featured and redeem status
      $(document).on('change', '.merchant_column_update', function(e){
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
                    //  $("#merchant-list-table").load( $('#merchant-list-table').attr('data-sourceurl') +" #merchant-list-table");
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/merchants_list/index.blade.php ENDPATH**/ ?>