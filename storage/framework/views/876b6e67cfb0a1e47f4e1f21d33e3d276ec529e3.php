<?php $__env->startSection('style'); ?>
    <style>
        .promo_amount{
            max-width: 80px !important;
        }

    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-10">
            <div class="card card-malle">
                <div class="card-header-malle">
                   <?php echo e(__('User Setting')); ?>

                </div>
                <div class="card-body">

                    <?php if(isset($settings)): ?>
                        <br/>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped malle-table" id="preference-tag-table"
                                       data-sourceurl="<?php echo e(route('preference-tags')); ?>">
                                    <thead>
                                    <th>Country</th>
                                    <th>G.S.T</th>
                                    <th>Service Charge</th>
                                    <th>Take Out Charge</th>
                                    <th>Delivery Charge</th>

                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="row-location" data-id="<?php echo e(@$setting->us_id); ?>">
                                        <td><?php echo e(@$setting->country->country_name); ?></td>

                                        <td>

                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text text-primary font-weight-bold" id="basic-addon1"><?php echo e($setting->country->currency_symbol); ?></span>
                                                </div>
                                                <input type="text" name="g_s_t" id="" data-id="<?php echo e(@$setting->us_id); ?>" value="<?php echo e(@$setting->g_s_t); ?>" aria-describedby="basic-addon1" class="promo_amount form-control text-primary text-right font-weight-bold" onkeypress="return isNumber(event)" >

                                            </div>

                                        </td>

                                        <td>

                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text text-primary font-weight-bold" id="basic-addon1"><?php echo e($setting->country->currency_symbol); ?></span>
                                                </div>
                                                <input type="text" name="service_charge" id="" data-id="<?php echo e(@$setting->us_id); ?>" value="<?php echo e(@$setting->service_charge); ?>" aria-describedby="basic-addon1" class="promo_amount form-control text-primary text-right font-weight-bold" onkeypress="return isNumber(event)" >

                                            </div>

                                        </td>


                                        <td>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text text-primary font-weight-bold" id="basic-addon1"><?php echo e($setting->country->currency_symbol); ?></span>
                                                </div>
                                                <input type="text" name="take_out_charge" id="" data-id="<?php echo e(@$setting->us_id); ?>" value="<?php echo e(@$setting->take_out_charge); ?>" aria-describedby="basic-addon1" class="promo_amount form-control text-primary text-right font-weight-bold" onkeypress="return isNumber(event)">

                                            </div>

                                        </td>
                                        <td>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text text-primary font-weight-bold" id="basic-addon1"><?php echo e($setting->country->currency_symbol); ?></span>
                                                </div>
                                                <input type="text" name="delivery_charge" id="" data-id="<?php echo e(@$setting->us_id); ?>" value="<?php echo e(@$setting->delivery_charge); ?>" aria-describedby="basic-addon1" class="promo_amount form-control text-primary text-right font-weight-bold" onkeypress="return isNumber(event)">

                                            </div>

                                        </td>

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
                url: '<?php echo e(route('user-setting.create')); ?>',
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/user_setting/index.blade.php ENDPATH**/ ?>