<?php if(isset($promo_id)): ?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-malle">
            <div class="card-header-malle">
            <?php echo e(__('Promotion Days Of Week')); ?>

            </div>
            <div class="card-body"> 
            <table class="table table-striped malle-table" data-sourceurl="<?php echo e(route('promo-outlets.show',['id'=>$id, 'outlate_id'=>$outlate_data->po_id,'promo_id'=>$promo_id])); ?>" id="outlate-day-table">
                <thead>
                    <tr>
                        <?php if($daysofweek): ?> 
                            <?php $__currentLoopData = $daysofweek; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th><?php echo e(ucwords($day)); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?> 
                    </tr>
            </thead>
                <tbody>
                    <tr>                        
                         <?php if($daysofweek): ?> 
                            <?php $__currentLoopData = $daysofweek; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td>
                                    <select name="<?php echo e($day); ?>" id="<?php echo e($day); ?>" class="promo_days dd-orange" data-href="<?php echo e(route('promo-outlets-days.update',['out_id' => $outlate_data->po_id])); ?>" data-method="PUT">
                                        <option value="N" <?php if(@$outlate_data->promotion_days->$day=='N'): ?> selected <?php endif; ?>>No</option>
                                        <option value="Y" <?php if(@$outlate_data->promotion_days->$day=='Y'): ?> selected <?php endif; ?>>Yes</option>
                                    </select>
                                </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>                     
                    </tr>
                </tbody>
            </table>
                
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
 <?php /**PATH /home/malle/public_html/adminlaravel3/resources/views/main/promotions/days.blade.php ENDPATH**/ ?>