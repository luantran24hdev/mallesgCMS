<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-10">
            <div class="card card-malle">
                <div class="card-header-malle">
                    <?php echo e(__('Manage Shoppers')); ?>

                </div>

                    <?php if(isset($shoppers)): ?>
                        <br/>
                        <div class="row container">
                            <div class="col-md-12">
                                <table class="table table-striped malle-table" id="preference-tag-table"
                                       data-sourceurl="<?php echo e(route('manage.inquiry')); ?>">
                                    <thead>
                                        <th>Registered On</th>
                                        <th>Full Name</th>
                                        <th>Gender</th>
                                        <th>Mobile #</th>
                                        <th>Email ID</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $shoppers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shopper): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="row-location" data-id="<?php echo e(@$shopper->Shopper_id); ?>">
                                            <td><?php echo e(@$shopper->Registered_on); ?></td>
                                            <td><?php echo e(@$shopper->Shopper_name); ?></td>
                                            <td><?php echo e(\App\User::getGender(@$shopper->Gender)); ?></td>
                                            <td><?php echo e(@$shopper->Mobile_number); ?></td>
                                            <td><?php echo e(@$shopper->Email_id); ?></td>
                                            <td><a href="<?php echo e(route('manage.edit.shoppers',$shopper->Shopper_id)); ?>"> Edit </a></td>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/shoppers/index.blade.php ENDPATH**/ ?>