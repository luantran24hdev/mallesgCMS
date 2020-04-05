<?php if(isset($promo_id)): ?>
<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle">
            <?php echo e(__('Promotion Images')); ?>

            </div>
            <div class="card-body" id="promo-image-body" data-sourceurl="<?php echo e(route('promotions.show',['promotions'=>$id, 'promo_id' => $promo_id])); ?>">


                <?php if($promotion_images): ?>
                <div class="row" id="promo-image-content">
                    <input type="text" id="selected_image" style="display: none;">
                    <?php for($i=1;$i<6;$i++): ?>
                        <?php
                            $empty = true;
                        ?>
                        <?php $__currentLoopData = $promotion_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promotion_image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <?php if($promotion_image->image_count == $i): ?>
                                <div class="col-md-4 mb-3 pr-0">
                                    <img class="card-img-top fit-image" src="<?php echo e($live_url.$promotion_image->image_name); ?>" alt="image count <?php echo e($promotion_image->image_count); ?>">
                                    <a  href="javascript:;" data-href="<?php echo e(route('promotions.deleteimage',['id'=>$promotion_image->mallpromo_image_id])); ?>" data-method="POST" class="btn-pi-delete" data-id="<?php echo e($promotion_image->mallpromo_image_id); ?>">
                                        <span class="text-danger"><?php echo e(__('Delete')); ?></span>
                                    </a>
                                </div>
                                <?php
                                    $empty = false;
                                ?>
                            <?php endif; ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <?php if($empty): ?>
                            

                            <div class="col-md-4 mb-3 pr-0">
                                <form action="<?php echo e(route('promotions.uploadimage')); ?>" class="dropzone" id="image_<?php echo e($i); ?>">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="image_count" value="<?php echo e($i); ?>">
                                    <input type="hidden" name="promo_id" value="<?php echo e(@$promo_id); ?>">
                                    <input type="hidden" name="merchant_id" value="<?php echo e(@$id); ?>">
                                </form>
                            </div>
                        <?php endif; ?>

                        
                    <?php endfor; ?>



                </div>
                <?php endif; ?>

             </div>
        </div>
    </div>

</div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/promotions/images.blade.php ENDPATH**/ ?>