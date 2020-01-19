<?php if(isset($promo_id)): ?>
<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle">
            <?php echo e(__('Promotion Tags')); ?>

            </div>
            <div class="card-body">

                <form method="POST" action="<?php echo e(route('promo-tags.store')); ?>" id="addPromoTag">
                <input type="hidden" name="promo_id" id="promo_id" value="<?php echo e($promo_id); ?>">
                <input type="hidden" name="merchant_id" id="merchant_id" value="<?php echo e($id); ?>">
                <input type="hidden" name="tag_id" id="tag_id" value="">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="mb-2 font-12"><?php echo e(__('Tag Name')); ?></label>
                                <input type="text" name="tag_name" placeholder="Tag Name" id="tag_name" class="form-control" required="" jautocom-sourceurl="<?php echo e(route('promo-tags.search')); ?>" jautocom-targetid="tag_id">
                            </div>
                        </div>


                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary col-md-12 top-t" id="btnMerchantPromotion"><?php echo e(__('Add Tag')); ?></button>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-md-12"> 
                        <table class="table table-striped malle-table " id="promotion-tag-table" data-sourceurl="<?php echo e(route('promotions.show',['promotions'=>$id, 'promo_id' => $promo_id])); ?>">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Tag Name')); ?></th>
                                <th><?php echo e(__('Primary Tag')); ?></th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                         <?php $__currentLoopData = $promotion_tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo_tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="row-promo-tags" data-id="<?php echo e($promo_tag->pt_id); ?>">
                                <td> <?php echo e($promo_tag->master->tag_name); ?></td>  
                                <td>
                                    <select name="primary_tag"  class="deal-status primary_tag" data-id="<?php echo e($promo_tag->pt_id); ?>" data-href="<?php echo e(route('promo-tags.setprimary',['id'=>$promo_tag->pt_id])); ?>" data-method="POST">
                                        <option value="N" <?php if($promo_tag->primary_tag!="Y"): ?> selected <?php endif; ?>>No</option>
                                        <option value="Y" <?php if($promo_tag->primary_tag=="Y"): ?> selected <?php endif; ?>>Yes</option>
                                    </select>
                                </td>
                                <td>
                                    <a  href="javascript:;" data-href="<?php echo e(route('promo-tags.destroy',['promotions'=>$promo_tag->pt_id])); ?>" data-method="DELETE" class="btn-pt-delete" data-id="<?php echo e($promo_tag->pt_id); ?>">
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
 <?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/promotions/tags.blade.php ENDPATH**/ ?>