<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-10">
            <div class="card card-malle">
                <div class="card-header-malle"><?php echo e($owner->mall_owner_name); ?>

                    <a href="<?php echo e(route('mall-owner')); ?>" style="float: right">Back</a>
                </div>
                <div class="card-body merch_out">
                    <?php if(isset($malllists)): ?>
                        <br/>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped malle-table"  id="mall_type-table"
                                       data-sourceurl="<?php echo e(route('mall-owner')); ?>">
                                    <thead>
                                    <th>Mall Owned / Managed</th>
                                    <th>City Name</th>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $malllists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mall): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="row-location">
                                            <td><?php echo e(@$mall->mall_name); ?>

                                            </td>
                                            <td><?php echo e(\App\CityMaster::getCityName(@$mall->city_id)); ?></td>
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



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/mall_list/show_owner.blade.php ENDPATH**/ ?>