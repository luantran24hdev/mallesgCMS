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
                                    <th></th>
                                    <th>Full Name</th>
                                    <th>Gender</th>
                                    <th>Mobile #</th>
                                    <th>Email ID</th>
                                    <th>Registered On</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $shoppers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shopper): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="row-location" data-id="<?php echo e(@$shopper->Shopper_id); ?>">
                                        <td>
                                            <?php if(!empty($shopper->image)): ?>
                                                <img src="<?php echo e($live_url.$shopper->image); ?>" width="50px" height="50px">
                                            <?php else: ?>
                                                <i class="fa fa-picture-o" aria-hidden="true" style="font-size: 50px;"></i>
                                            <?php endif; ?>
                                        </td>

                                        <td><?php echo e(@$shopper->Shopper_name); ?></td>
                                        <td><?php echo e(\App\User::getGender(@$shopper->Gender)); ?></td>
                                        <td><?php echo e(@$shopper->Mobile_number); ?> <br> <span style="color: green">Verified</span></td>
                                        <td><?php echo e(@$shopper->Email_id); ?>  <br> <span style="color: red">Verify Now</span></td>
                                        <td><?php echo e(@$shopper->Registered_on); ?></td>
                                        <td><a href="<?php echo e(route('manage.edit.shoppers',$shopper->Shopper_id)); ?>"> Edit </a>
                                            |
                                            <a href="javascript:;"
                                               data-href="<?php echo e(route('shopper.delete',$shopper->Shopper_id)); ?>"
                                               data-method="DELETE" class="btn-delete"
                                               data-id="<?php echo e($shopper->Shopper_id); ?>">
                                                <span class="text-danger">Delete</span>
                                            </a>
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

    <?php echo $__env->make('partials.delete_model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>

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

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/shoppers/index.blade.php ENDPATH**/ ?>