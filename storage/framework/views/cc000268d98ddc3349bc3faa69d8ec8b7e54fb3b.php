<?php if(isset($promo_id)): ?>
<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle">
            <?php echo e(__('Promotion Meals')); ?>

            </div>
            <div class="card-body">

                <form method="POST" action="<?php echo e(route('promotion.mealgroup.store')); ?>" id="addMeal">
                <input type="hidden" name="promo_id" id="promo_id" value="<?php echo e($promo_id); ?>">
                    <input type="hidden" name="merchant_id" id="merchant_id" value="<?php echo e($id); ?>">
                    <input type="hidden" name="mg_id" id="mg_id" value="">


                    <div class="row prom_cat">
                        <div class="col-md-6">
                            <div class="form-group">
                                <select id="mg_select">
                                    <?php if(!empty($manage_meal_lists)): ?>
                                        <?php $__currentLoopData = $manage_meal_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manage_meal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($manage_meal->mg_id); ?>"><?php echo e($manage_meal->meal_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary col-md-12 top-t" id="btnMerchantPromotion"><?php echo e(__('Update')); ?></button>
                            </div>
                        </div>



                    </div>
                </form>

                <div class="row ">
                    <div class="col-md-12"> 
                        <table class="table table-striped malle-table " id="promotion-meal-table" data-sourceurl="<?php echo e(route('promotions.show',['promotions'=>$id, 'promo_id' => $promo_id])); ?>">
                        <thead>
                            <tr>
                                <th></th>
                                <th><?php echo e(__('Meal Name')); ?></th>
                                <th><?php echo e(__('Primary Cat')); ?></th>
                                <th><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php //print_r($promotion_categorys->master); die; ?>
                         <?php $__currentLoopData = $promo_meal_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo_meal_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="row-promo-tags" data-id="<?php echo e($promo_meal_group->pmg_id); ?>">
                                <td>
                                    <?php if(!empty($promo_meal_group->meal_group->meal_image)): ?>
                                        <img src="<?php echo e($live_url_age.$promo_meal_group->meal_group->meal_image); ?>" width="50px" height="50px">
                                    <?php else: ?>
                                        <i class="fa fa-picture-o" aria-hidden="true" style="font-size: 50px;"></i>
                                    <?php endif; ?>
                                </td>

                                <td> <?php echo e(@$promo_meal_group->meal_group->meal_name); ?> </td>

                                <td>
                                    <select name="primary_cat"  class="deal-status primary_tag" data-id="<?php echo e($promo_meal_group->pmg_id); ?>" data-href="<?php echo e(route('promotion.mealgroup.setprimary',['id'=>$promo_meal_group->pmg_id])); ?>" data-method="POST">
                                        <option value="N" <?php if($promo_meal_group->primary_cat=="N"): ?> selected <?php endif; ?>>No</option>
                                        <option value="Y" <?php if($promo_meal_group->primary_cat=="Y"): ?> selected <?php endif; ?>>Yes</option>
                                    </select>
                                </td>
                                <td>
                                    <a  href="javascript:;" data-href="<?php echo e(route('promotion.mealgroup.destroy',['promotions'=>$promo_meal_group->pmg_id])); ?>" data-method="DELETE" class="btn-pt-delete" data-id="<?php echo e($promo_meal_group->pmg_id); ?>">
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
 <?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/promotions/meal_group.blade.php ENDPATH**/ ?>