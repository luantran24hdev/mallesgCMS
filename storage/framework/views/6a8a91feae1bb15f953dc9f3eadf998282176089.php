<?php if(isset($promo_id)): ?>
<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle">
            <?php echo e(__('Preference Tags')); ?>

            </div>
            <div class="card-body">

                <form method="POST" action="<?php echo e(route('promotion.preference.store')); ?>" id="addPromoPreference">
                <input type="hidden" name="promo_id" id="promo_id" value="<?php echo e($promo_id); ?>">
                    <input type="hidden" name="merchant_id" id="merchant_id" value="<?php echo e($id); ?>">
                <input type="hidden" name="preference_id" id="preference_id" value="">

                    <div class="row prom_cat">
                        <div class="col-md-6">
                            <div class="form-group">
                                <select id="preference_select">
                                    <?php if(!empty($preference_master_lists)): ?>
                                        <?php $__currentLoopData = $preference_master_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preference_master): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($preference_master->preference_id); ?>"><?php echo e($preference_master->preference_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>




                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary col-md-12 top-t" id="btnMerchantPromotion"><?php echo e(__('Add Preference')); ?></button>
                            </div>
                        </div>



                    </div>
                </form>

                <div class="row ">
                    <div class="col-md-12"> 
                        <table class="table table-striped malle-table " id="promotion-preference-table" data-sourceurl="<?php echo e(route('promotions.show',['promotions'=>$id, 'promo_id' => $promo_id])); ?>">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Promotions Name')); ?></th>
                                <th><?php echo e(__('Primary Cat')); ?></th>
                                <th><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php //print_r($promotion_categorys->master); die; ?>
                         <?php $__currentLoopData = $preference_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preference_list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="row-promo-tags" data-id="<?php echo e($preference_list->pp_id); ?>">

                                <td> <?php echo e(@$preference_list->preference->preference_name); ?> </td>
                                <td>
                                    <select name="primary_tag"  class="deal-status primary_tag" data-id="<?php echo e($preference_list->pp_id); ?>" data-href="<?php echo e(route('promotion.preference.setprimary',['id'=>$preference_list->pp_id])); ?>" data-method="POST">
                                        <option value="N" <?php if($preference_list->primary_tag=="N"): ?> selected <?php endif; ?>>No</option>
                                        <option value="Y" <?php if($preference_list->primary_tag=="Y"): ?> selected <?php endif; ?>>Yes</option>
                                    </select>
                                </td>
                                <td>
                                    <a  href="javascript:;" data-href="<?php echo e(route('promotion.preference.destroy',['promotions'=>$preference_list->pp_id])); ?>" data-method="DELETE" class="btn-pt-delete" data-id="<?php echo e($preference_list->pp_id); ?>">
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
 <?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/promotions/preference.blade.php ENDPATH**/ ?>