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

                                        <td><?php echo e(@$shopper->Shopper_name); ?>

                                            <br><br><br><span><b> Driver / Rider </b> </span> &nbsp;&nbsp;&nbsp;
                                            <select name="dr_id" id="" class="shopper_column_update dd-orange" data-href="<?php echo e(route('shopper.column-update',[$shopper->Shopper_id])); ?>" data-method="POST">
                                                <option value="Y" <?php if($shopper->dr_id=='Y'): ?> selected <?php endif; ?>>Yes</option>
                                                <option value="N" <?php if($shopper->dr_id=='N'): ?> selected <?php endif; ?>>No</option>
                                            </select>
                                        </td>
                                        <td><?php echo e(\App\User::getGender(@$shopper->Gender)); ?>

                                            <br><br><br><span><b> Merchant </b> </span> &nbsp;&nbsp;&nbsp;
                                            <select name="app_merchant" id="" class="shopper_column_update dd-orange" data-href="<?php echo e(route('shopper.column-update',[$shopper->Shopper_id])); ?>" data-method="POST">
                                                <option value="Y" <?php if($shopper->app_merchant=='Y'): ?> selected <?php endif; ?>>Yes</option>
                                                <option value="N" <?php if($shopper->app_merchant=='N'): ?> selected <?php endif; ?>>No</option>
                                            </select>
                                        </td>
                                        <td><?php echo e(@$shopper->Mobile_number); ?> <br> <span style="color: green">Verified</span>
                                            <br><br><span><b> App Admin </b> </span> &nbsp;&nbsp;&nbsp;
                                            <select name="app_admin" id="" class="shopper_column_update dd-orange" data-href="<?php echo e(route('shopper.column-update',[$shopper->Shopper_id])); ?>" data-method="POST">
                                                <option value="Y" <?php if($shopper->app_admin=='Y'): ?> selected <?php endif; ?>>Yes</option>
                                                <option value="N" <?php if($shopper->app_admin=='N'): ?> selected <?php endif; ?>>No</option>
                                            </select>
                                        </td>
                                        <td><?php echo e(@$shopper->Email_id); ?>  <br> <span style="color: red">Verify Now</span>
                                            <br><br><span><b> App User </b> </span> &nbsp;&nbsp;&nbsp;
                                            <select name="app_user" id="" class="shopper_column_update dd-orange" data-href="<?php echo e(route('shopper.column-update',[$shopper->Shopper_id])); ?>" data-method="POST">
                                                <option value="Y" <?php if($shopper->app_user=='Y'): ?> selected <?php endif; ?>>Yes</option>
                                                <option value="N" <?php if($shopper->app_user=='N'): ?> selected <?php endif; ?>>No</option>
                                            </select>
                                        </td>
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


        // change promo outlate live, featured and redeem status
        $(document).on('change', '.shopper_column_update', function(e){
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

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/shoppers/index.blade.php ENDPATH**/ ?>