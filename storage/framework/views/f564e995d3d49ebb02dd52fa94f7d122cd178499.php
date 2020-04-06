<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle">
                Images for   <span class="link_color"> <?php echo e($location->merchant->merchant_name); ?> | <?php echo e($location->mall->mall_name); ?> | <?php echo e($location->merchant_location); ?></span>

                <span style="float: right" class="link_color"><a href="<?php echo e(route('merchants.show',[$location->merchant_id])); ?>"> Back </a> </span>
            </div>
            <div class="card-body" id="promo-image-body1" data-sourceurl="">

                <div class="row" id="promo-image-content1">
                    <input type="text" id="selected_image" style="display: none;">
                    <?php for($i=1;$i<4;$i++): ?>
                        <?php
                            $empty = true;
                        ?>

                        <?php if(!empty($locations_images)): ?>
                        <?php $__currentLoopData = $locations_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $locations_image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($locations_image->image_count == $i): ?>

                                <div class="col-md-4 mb-3 pr-0">
                                    <img class="card-img-top fit-image" src="<?php echo e($live_url.$locations_image->image); ?>" alt="image count <?php echo e($locations_image->image_count); ?>">
                                    
                                    <a  href="javascript:;" data-href="<?php echo e(route('locations.deleteimage',['id'=>$locations_image->mli_id])); ?>" data-method="POST" class="btn-pi-delete" data-id="<?php echo e($locations_image->image_count); ?>">
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
                                <form action="<?php echo e(route('locations.uploadimage')); ?>" class="dropzone" id="my-awesome-dropzone">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="image_count" value="<?php echo e($i); ?>">
                                    <input type="hidden" name="merchant_id" value="<?php echo e(@$location->merchant_id); ?>">
                                    <input type="hidden" name="merchantlocation_id" value="<?php echo e(@$location->merchantlocation_id); ?>">
                                </form>
                            </div>
                        <?php endif; ?>

                    <?php endfor; ?>


                </div>

             </div>
        </div>
    </div>
</div>

<?php echo $__env->make('partials.image_model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script type="text/javascript" src="<?php echo e(asset('js/dropzone.js')); ?>"></script>

    <script>
           $(document).on('click', '.btn-pi-delete', function(e){
            e.preventDefault();
            var btndelete = $(this);

            $('#deletepromotionmodal').modal('show');

            $('#btnDeletePromotion').unbind().click(function(){

                $.ajax({
                    url: btndelete.attr('data-href'),
                    type: btndelete.attr('data-method'),
                    dataType:'json',
                    success:function(data){
                        if(data.status==='error'){
                            errorReturn(data)
                        }else{
                            $('#deletepromotionmodal').modal('hide');
                            //var image_count = $(this).attr('data-id');
                            toastr.success(data.message);
                            window.setTimeout(function(){location.reload()},2000)
                        }
                    }
                });

            });
        });

    </script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/merchants/merchant_locations_images.blade.php ENDPATH**/ ?>