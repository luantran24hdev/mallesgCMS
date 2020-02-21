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

    .btn-default{
        color: #fff !important;
        background-color: #ccc !important;
        border-color: #ccc !important;
    }
    .active{
        background-color: #007bff !important;
        border-color: #007bff !important;
    }
    .pic {
        width: 100%;
        height: 100%;
    }

</style>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-10">
        <?php echo $__env->make('partials.flash_message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="row">

            <div class="col-md-12">
                <div class="card card-malle">
                    <div class="card-header-malle"><?php echo e($merchant_location->merchant->merchant_name); ?>

                    <a href="<?php echo e(route('merchants.show',[$merchant_location->merchant_id])); ?>" style="float: right">Back</a>
                    </div>
                    <div class="card-body">
                        <form  method="post" action="<?php echo e(route('locations.update',[$merchant_location->merchantlocation_id])); ?>">

                            <?php echo csrf_field(); ?>
                            <?php echo e(method_field('PATCH')); ?>


                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="hidden" name="mall_id" id="mall_id" value="<?php echo e($merchant_location->mall_id); ?>">
                                        <label class="mb-2 font-12">Outlet Location Name</label>
                                        <input type="text" placeholder="Mall Name" id="mallname" class="form-control col-md-12" value="<?php echo e($merchant_location->mall->mall_name); ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Unit No.</label>
                                        <input type="text" name="merchant_location" placeholder="Unit No" id="merchant_location" class="form-control col-md-12" value="<?php echo e($merchant_location->merchant_location); ?>">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="mb-2 font-12">Level</label><br>
                                    <div class="dropdown">
                                        <select name="level_id" class="form-control col-md-12" >
                                            <?php $__currentLoopData = $levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($level->level_id); ?>" <?php if($merchant_location->level_id == $level->level_id): ?> selected <?php endif; ?>><?php echo e($level->level); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary col-md-6 mt-4" id="btnUpdateMall">Update</button>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-md-3">
                                    <label class="mb-2 font-12">Country</label><br>
                                    <div class="dropdown">
                                        <select name="country_id" class="form-control col-md-12" id="country_select">
                                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($country->country_id); ?>" <?php if($merchant_location->country_id == $country->country_id): ?> selected <?php endif; ?>><?php echo e($country->country_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="mb-2 font-12">City</label><br>
                                    <div class="dropdown">
                                        <select name="city_id" class="form-control col-md-12" id="city_control">
                                            <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($city->city_id); ?>" <?php if($city->city_id == $merchant_location->city_id): ?> selected <?php endif; ?>><?php echo e($city->city_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="mb-2 font-12">Town</label><br>
                                    <div class="dropdown">
                                        <select name="town_id" class="form-control col-md-12" id="town_control">
                                            <?php $__currentLoopData = $towns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $town): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($town->town_id); ?>" <?php if($town->town_id == $merchant_location->town_id): ?> selected <?php endif; ?>><?php echo e($town->town_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Address</label><br>
                                        <textarea rows="4" class="form-control" name="loc_address"><?php echo e($merchant_location->loc_address); ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="mb-2 font-12">Postal Code</label><br>
                                            <input type="text" name="postal_code" class="form-control" placeholder="Postal Code" value="<?php echo e($merchant_location->postal_code); ?>">

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="mb-2 font-12">Opening Hours</label>
                                            <input type="time" name="op_hours" id="op_hours" placeholder="Opening Hours" class="form-control" value="<?php echo e($merchant_location->op_hours); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="mb-2 font-12">Telephone #</label><br>
                                            <input type="text" name="loc_telephone" class="form-control" placeholder="Telephone" value="<?php echo e($merchant_location->loc_telephone); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="mb-2 font-12">Closing Hours</label>
                                            <input type="time" name="cls_hours" id="cls_hours" placeholder="Closing Hours" class="form-control" value="<?php echo e($merchant_location->cls_hours); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">GPS Street</label><br>
                                        <input type="text" name="gps_street" class="form-control" placeholder="GPS Street" value="<?php echo e($merchant_location->gps_street); ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Longitude</label><br>
                                        <input type="text" name="longitude" class="form-control" placeholder="Longitude" value="<?php echo e($merchant_location->longtitude); ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">

                                        <label class="mb-2 font-12">Latitude</label>
                                        <input type="text" name="latitude" id="latitude" placeholder="Latitude" class="form-control" value="<?php echo e($merchant_location->latitude); ?>" >
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>



    </div>
</div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
<script>



    $(document).on('submit','#editmallform', function(e){
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
                    //$("#discount-tag-table").load( $('#discount-tag-table').attr('data-sourceurl') +" #discount-tag-table");
                    toastr.success(data.message);
                }
            },
            error: function(data){
                exeptionReturn(data);
            }
        });
    });


    $(".column_update").change(function(){

        var value = $(this).val();
        var attrName = $(this).attr("name");
        var mall_id = $('#mall_id_main').val();

        $.ajax({
            type : 'ajax',
            method : 'post',
            url : '<?php echo e(route('malls.column-update')); ?>/'+mall_id,
            data : {name:attrName,
                    value : value},
            async : false,
            dataType : 'json',
            success : function(data){

                // /toastr.success(data.message);
                toastr['info'](data.message);

            },
            error : function(){
                toastr['error']('Could not update.');
            }
        });
    });

    $('#country_select').on('change', function (e) {

      /*  var id= $(this).children("option:selected").val();

        $.ajax({
            url: '<?php echo e(route('malls.getcitymall')); ?>',
            type: 'POST',
            dataType:'json',
            data : {'id':id},
            success:function(data){
                // /console.log(data);
                $('#city_control').html(data.city);
                $('#town_control').html('<option value="">--- Select ----</option>');
            }
        });*/

    });

    $('#city_control').on('change', function (e) {

       /* var id= $(this).children("option:selected").val();

        $.ajax({
            url: '<?php echo e(route('malls.gettownmall')); ?>',
            type: 'POST',
            dataType:'json',
            data : {'id':id},
            success:function(data){
                // /console.log(data);
                $('#town_control').html(data.town);

            }
        });
*/
    });



   /* $(document).ready(function() {
         var dataTables = $('.mall_info_table').DataTable();
         dataTables.columns(2).search("Restaurant").draw();
    });
*/
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/merchants/edit_merchant_location.blade.php ENDPATH**/ ?>