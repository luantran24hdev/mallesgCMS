<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-10">
            <div class="card card-malle">
                <div class="card-header-malle"><?php echo e($company->company_name); ?>

                    <a href="<?php echo e(route('merchant-company')); ?>" style="float: right">Back</a>
                </div>
                <div class="card-body merch_out">
                    <?php if(isset($merchants)): ?>
                        <br/>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped malle-table"  id="mall_type-table"
                                       data-sourceurl="<?php echo e(route('merchant-company')); ?>">
                                    <thead>
                                    <th>Merchant Owned / Managed</th>
                                    <th>City Name</th>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $merchants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $merchant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="row-location">
                                            <td><?php echo e(@$merchant->merchant_name); ?>

                                            </td>
                                            <td><?php echo e(\App\CityMaster::getCityName(@$merchant->city_id)); ?></td>
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
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/merchants_list/show_merchant_owned.blade.php ENDPATH**/ ?>