<?php if(isset($promo_id)): ?>
<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle">
            <?php echo e(__('Promotion Category')); ?>

            </div>
            <div class="card-body">

                <form method="POST" action="<?php echo e(route('promo-category.store')); ?>" id="addPromoCategory">
                <input type="hidden" name="promo_id" id="promo_id" value="<?php echo e($promo_id); ?>">
                <input type="hidden" name="merchant_id" id="merchant_id" value="<?php echo e($id); ?>">
                <input type="hidden" name="sub_category_id" id="sub_category_id" value="">

                    <div class="row prom_cat">
                        <div class="col-md-6">
                            <div class="form-group">
                                <select id="category_select">
                                    <?php if(!empty($sub_category_lists)): ?>
                                        <?php $__currentLoopData = $sub_category_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->sub_category_id); ?>"><?php echo e($category->Sub_Category_Name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>




                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary col-md-12 top-t" id="btnMerchantPromotion"><?php echo e(__('Add Category')); ?></button>
                            </div>
                        </div>



                    </div>
                </form>

                <div class="row ">
                    <div class="col-md-12"> 
                        <table class="table table-striped malle-table " id="promotion-category-table" data-sourceurl="<?php echo e(route('promotions.show',['promotions'=>$id, 'promo_id' => $promo_id])); ?>">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Category Name')); ?></th>
                                <th><?php echo e(__('Primary Cat')); ?></th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php //print_r($promotion_categorys->master); die; ?>
                         <?php $__currentLoopData = $promotion_categorys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="row-promo-tags" data-id="<?php echo e($promo_category->pc_id); ?>">

                                <?php $subcatname = \App\PromotionCategory::subCatName($promo_category->sub_category_id);

                                //print_r($subcatname); die;
                                ?>
                                <td> <?php echo e($subcatname); ?> </td>
                                <td>
                                    <select name="primary_tag"  class="deal-status primary_tag" data-id="<?php echo e($promo_category->pc_id); ?>" data-href="<?php echo e(route('promo-category.setprimary',['id'=>$promo_category->pc_id])); ?>" data-method="POST">
                                        <option value="N" <?php if($promo_category->primary_cat=="N"): ?> selected <?php endif; ?>>No</option>
                                        <option value="Y" <?php if($promo_category->primary_cat=="Y"): ?> selected <?php endif; ?>>Yes</option>
                                    </select>
                                </td>
                                <td>
                                    <a  href="javascript:;" data-href="<?php echo e(route('promo-category.destroy',['promotions'=>$promo_category->pc_id])); ?>" data-method="DELETE" class="btn-pt-delete" data-id="<?php echo e($promo_category->pc_id); ?>">
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
 <?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/promotions/category.blade.php ENDPATH**/ ?>