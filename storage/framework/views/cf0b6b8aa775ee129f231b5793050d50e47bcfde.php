<?php if(isset($promo_id)): ?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-malle">
            <div class="card-header-malle">
            <?php echo e(__('Promotion Outlate')); ?>

            </div>
            <div class="card-body">

                <form method="POST" action="<?php echo e(route('promo.outlate.store')); ?>" id="addPromoOutlateDay">
                <input type="hidden" name="promo_id" id="promo_id" value="<?php echo e($promo_id); ?>">
                    <input type="hidden" name="po_id" id="outlate_id" value="<?php echo e($outlate_data->po_id); ?>">
                <input type="hidden" name="merchant_id" id="merchant_id" value="<?php echo e($id); ?>">
                <input type="hidden" name="dow_id" id="dow_id" value="">

                    <div class="row prom_outlate">

                        <div class="col-md-4">
                            <div class="form-group">
                                <select id="week_select">
                                    <?php if(!empty($daysofweek)): ?>
                                        <?php $__currentLoopData = $daysofweek; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $weekday): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($weekday->dow_id); ?>"><?php echo e($weekday->dow_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary col-md-12 top-t" id="btnMerchantPromotion"><?php echo e(__('Update')); ?></button>
                            </div>
                        </div>

                    </div>
                </form>

                <div class="row ">
                    <div class="col-md-12"> 
                        <table class="table table-striped malle-table " id="promotion-outday-table" data-sourceurl="<?php echo e(route('promo-outlets.show',['id'=>$id, 'outlate_id'=>$outlate_data->po_id,'promo_id'=>$promo_id])); ?>">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Promo Name')); ?></th>
                                <th><?php echo e(__('Which Mall')); ?></th>
                                <th><?php echo e(__('which Day')); ?></th>
                                <th><?php echo e(__('Action')); ?></th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>

                         <?php $__currentLoopData = $promotions_out_days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promotions_out_day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="row-promo-out-day" data-id="<?php echo e($promotions_out_day->pod_id); ?>">
                                <td><?php echo e($promotions_out_day->promomaster->promo_name); ?> </td>
                                <td> <?php echo e($promotions_out_day->outlatedata->mall->mall_name); ?></td>
                                <td> <?php echo e(@$promotions_out_day->dayweek->dow_name); ?></td>
                                <td>
                                     <a  href="javascript:;" data-href="<?php echo e(route('promo.outlate.day.destroy',[$promotions_out_day->pod_id])); ?>" data-method="DELETE" class="btn-delete" data-id="<?php echo e($promotions_out_day->pod_id); ?>">
                                            <span class="text-danger"><?php echo e(__('Delete')); ?></span>
                                        </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
 <?php /**PATH /home/malle/public_html/adminlaravel3/resources/views/main/promotions/prom_outlate.blade.php ENDPATH**/ ?>