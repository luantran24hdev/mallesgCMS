<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle">
                Images for Event
            </div>
            <div class="card-body" id="promo-image-body1" data-sourceurl="<?php echo e(route('mall-offers.edit',[$offer->offer_id])); ?>">

                <div class="row" id="promo-image-content1">
                    <input type="text" id="selected_image" style="display: none;">
                    <?php for($i=1;$i<6;$i++): ?>
                        <?php
                            $empty = true;
                        ?>

                        <?php if(!empty($offer_images)): ?>
                        <?php $__currentLoopData = $offer_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offer_image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($offer_image->count == $i): ?>

                                <div class="col-md-4 mb-3 pr-0">
                                    <img class="card-img-top fit-image" src="<?php echo e($live_url.$offer_image->Image_name); ?>" alt="image count <?php echo e($offer_image->count); ?>">
                                    
                                    <a  href="javascript:;" data-href="<?php echo e(route('offers.deleteimage',['id'=>$offer_image->moi_id])); ?>" data-method="POST" class="btn-pi-delete" data-id="<?php echo e($offer_image->count); ?>">
                                        <span class="text-danger"><?php echo e(__('Delete')); ?></span>
                                    </a>
                                </div>
                                <?php
                                    $empty = false;
                                ?>
                            <?php endif; ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

                        <?php if($empty): ?>
                        <div class="col-md-4 mb-3 pr-0">
                                <div class="upload-msg " style="height: 200px; max-width: 310px; width: 100%" >
                                    <div style="display: table-cell; vertical-align: middle;" onclick="$('#upload_<?php echo e($i); ?>').trigger('click');">Click to upload a file </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <input type="file" id="upload_<?php echo e($i); ?>" data-count="<?php echo e($i); ?>" class="imguploader" value="Choose a file" accept="image/*" style="display: none;" >
                    <?php endfor; ?>

                    
 
                </div>

             </div>
        </div>
    </div>
</div>


<?php /**PATH /home/malle/public_html/adminlaravel3/resources/views/main/offer/offer_images.blade.php ENDPATH**/ ?>