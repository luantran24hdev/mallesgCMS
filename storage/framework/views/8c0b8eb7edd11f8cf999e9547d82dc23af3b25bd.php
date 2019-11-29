<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-10">
            <div class="card card-malle">
                <div class="card-header-malle">
                    <?php echo e(__('Manage Inquiry')); ?>

                </div>

                    <?php if(isset($inquirys)): ?>
                        <br/>
                        <div class="row container">
                            <div class="col-md-12">
                                <table class="table table-striped malle-table" id="preference-tag-table"
                                       data-sourceurl="<?php echo e(route('manage.inquiry')); ?>">
                                    <thead>
                                        <th>Date</th>
                                        <th>Outlet Name</th>
                                        <th>Country</th>
                                        <th>Contact Person</th>
                                        <th>Contact Number</th>
                                        <th>Email</th>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $inquirys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inquiry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="row-location" data-id="<?php echo e(@$inquiry->Inquiry_id); ?>">
                                            <td><?php echo e(@$inquiry->Inquiry_Date); ?></td>
                                            <td><?php echo e(@$inquiry->Outlet_name); ?></td>
                                            <td><?php echo e(@$inquiry->country->country_name); ?></td>
                                            <td><?php echo e(@$inquiry->Contact_person); ?></td>
                                            <td><?php echo e(@$inquiry->Contact_number); ?></td>
                                            <td><?php echo e(@$inquiry->Email_id); ?></td>
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/malle/public_html/adminlaravel3/resources/views/main/inquiry/index.blade.php ENDPATH**/ ?>