<?php if(isset($promo_id)): ?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-malle">
            <div class="card-header-malle">
            <?php echo e(__('Promotions- Time')); ?>

            </div>
            <div class="card-body">

                <form method="POST" action="<?php echo e(route('promo.outlate.time.store')); ?>" id="addPromoOutlateTime">
                <input type="hidden" name="promo_id" id="promo_id" value="<?php echo e($promo_id); ?>">
                    <input type="hidden" name="po_id" id="outlate_id" value="<?php echo e($outlate_data->po_id); ?>">
                <input type="hidden" name="dow_id" id="time_dow_id" value="">
                    <input type="hidden" name="tt_id" id="tt_id" value="">

                    <div class="row prom_outlate">

                        <div class="col-md-4">
                            <div class="form-group">
                                <select id="day_select">
                                    <?php if(!empty($day_selects)): ?>
                                        <?php $__currentLoopData = $day_selects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day_select): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($day_select->dow_id); ?>"><?php echo e($day_select->dow_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select id="time_select">
                                    <?php if(!empty($time_data)): ?>
                                        <?php $__currentLoopData = $time_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $time): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($time->tt_id); ?>"><?php echo e($time->tt_name); ?></option>
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
                        <table class="table table-striped malle-table " id="promotion-outtime-table" data-sourceurl="<?php echo e(route('promo-outlets.show',['id'=>$id, 'outlate_id'=>$outlate_data->po_id,'promo_id'=>$promo_id])); ?>">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Day')); ?></th>
                                <th><?php echo e(__('Time')); ?></th>
                                <th><?php echo e(__('Action')); ?></th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>

                         <?php $__currentLoopData = $promotion_outlate_time; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promotion_out_time): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="row-promo-out-day" data-id="<?php echo e($promotion_out_time->pot_id); ?>">

                                <td> <?php echo e(@$promotion_out_time->dayweek->dow_name); ?></td>
                                <td><?php echo e(@$promotion_out_time->timeTag->tt_name); ?> </td>
                                <td>
                                     <a  href="javascript:;" data-href="<?php echo e(route('promo.outlate.time.destroy',[$promotion_out_time->pot_id])); ?>" data-method="DELETE" class="btn-delete" data-id="<?php echo e($promotion_out_time->pot_id); ?>">
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
 <?php /**PATH /home/malle/public_html/adminlaravel3/resources/views/main/promotions/prom_outlate_time.blade.php ENDPATH**/ ?>