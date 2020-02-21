<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle"><?php echo e(__('Manage Merchants')); ?></div>
            <div class="card-body">

            <div class="row">
                <div class="col-md-3">
                    <label class="mb-2 font-12"><?php echo e(__('Merchant')); ?></label>
                    <input type="text" name="merchant_name" placeholder="Type Merchant Name" id="merchant_name" class="form-control" required="" value="<?php echo e(@$current_merchant->merchant_name); ?>"  data-autocompleturl="<?php echo e(route('merchants.search')); ?>"/>

                </div>
            </div>

            <?php if(isset($locations)): ?>
            <br />
            <div class="row">
                <div class="col-md-12">

                    <form method="POST" action="<?php echo e(route('locations.store')); ?>" id="frm-add-location">
                        <input type="hidden" name="mall_id" id="mall_id">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="hidden" name="merchant_id" value="<?php echo e($id); ?>">
                                    <label class="mb-2 font-12">Mall Name</label>
                                    <input type="text" name="mall_name" placeholder="Mall Name" id="mall_name" class="form-control" required="" list="datalist1" data-autocompleturl="<?php echo e(route('malls.search')); ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="mb-2 font-12">Location</label>
                                    <input type="text" name="merchant_location" placeholder="Location" id="location" class="form-control" required="">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="mb-2 font-12">&nbsp;</label>
                                    <select name="level_id" class="form-control" required="">
                                        <?php if($floors): ?>
                                            <option value="">---- <?php echo e(__('Select Level')); ?> ----</option>
                                            <?php $__currentLoopData = $floors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $floor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                             <option value="<?php echo e(@$floor->level_id); ?>"><?php echo e(@$floor->level); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary col-md-12 top-t" id="btnMerchantLocation">Update</button>
                            </div>
                        </div>
                    </form>
                    <table class="table table-striped malle-table " id="location-table" data-sourceurl="<?php echo e(route('merchants.show',['merchant'=>$id])); ?>">
                        <tbody>
                        <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$location1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <tr>
                                <span class="type_name" style="font-size: large;font-weight: 700;"><?php echo e(\App\MallType::getName($key)); ?> (<?php echo e(count($location1)); ?>)</span>
                                <?php  //echo "<pre>"; print_r($location->merchantlocation_id); echo "</pre>"; die;?>
                                <table class="table table-striped malle-table">
                                    <tbody>
                                <?php $__currentLoopData = $location1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key1=>$location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                        <tr class="row-location" data-id="<?php echo e($location->merchantlocation_id); ?>">
                                            <td><?php echo e(@$location->mall_name); ?></td>
                                            <td><?php echo e($location->merchant_location); ?></td>
                                            <td><?php echo e(@$location->level); ?></td>
                                            <td>
                                                <a  href="<?php echo e(route('locations.show',[$location->merchantlocation_id])); ?>">
                                                    <span class="text-info">Edit</span>
                                                </a>
                                                 &nbsp;   | &nbsp;
                                                <a  href="javascript:;" data-href="<?php echo e(route('locations.destroy',[$location->merchantlocation_id])); ?>" data-method="DELETE" class="btn-delete" data-id="<?php echo e($location->merchantlocation_id); ?>">
                                                    <span class="text-danger">Delete</span>
                                                </a>
                                                &nbsp;
                                                <span class="link_color">
                                                <a href="<?php echo e(route('locations.edit',[$location->merchantlocation_id])); ?>/?mid=<?php echo e($current_merchant->merchant_id); ?>" >
                                                  <b> Images</b>
                                                </a></span>
                                            </td>

                                        </tr>


                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </tr>


                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
  $( function() {

    $("#start_date").datepicker({dateFormat: 'dd/mm/yy'});
            $("#end_date").datepicker({dateFormat: 'dd/mm/yy'});

    // malls
    $( "#merchant_name" ).autocomplete({
        source: function (request, response) {
            $.getJSON($("#merchant_name").attr('data-autocompleturl') +'/' + request.term, function (data) {
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
            window.location.href = '<?php echo e(route("merchants")); ?>/'+ui.item.value;

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
            console.log(btndelete.attr('data-href'));
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


  });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/merchants/index.blade.php ENDPATH**/ ?>