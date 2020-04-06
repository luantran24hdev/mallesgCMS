<?php $__env->startSection('style'); ?>

    <style>
        .card{
            margin-bottom: 0px;
        }
       
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle">
                <?php echo e($merchant->merchant_name); ?>

                <a href="<?php echo e(route('merchants.list')); ?>">
                <span class="link_color" style="float: right">
                    Back
                </span>
                </a>
            </div>

            <div class="card-header-malle" style="background: white">
              Images For Website
            </div>


            <div class="card-body" id="promo-image-body" data-sourceurl="<?php echo e(route('merchants.images',['merchant_id'=>$merchant->merchant_id])); ?>">

                <div class="row" id="promo-image-content">
                   

                         <?php if($merchant->web_image): ?>
                             <div class="col-md-12 mb-3 pr-0">
                                 <img class="card-img-top fit-image" src="<?php echo e($live_url.$merchant->web_image); ?>" alt="image count">
                                 <a  href="javascript:;" data-href="<?php echo e(route('merchants.webdeleteimage',['id'=>$merchant->merchant_id])); ?>" data-method="POST" class="btn-pi-delete" data-id="<?php echo e($merchant->merchant_id); ?>">
                                     <span class="text-danger"><?php echo e(__('Delete')); ?></span>
                                 </a>
                             </div>
                         <?php else: ?>

                            <div class="col-md-4">
                                <form action="<?php echo e(route('merchants.uploadimage')); ?>" class="dropzone" id="image_5">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="merchant_id" value="<?php echo e($merchant->merchant_id); ?>">
                                </form>
                            </div>
                            
                         <?php endif; ?>


                        



                </div>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle">
                Images for App
            </div>
            <div class="card-body" id="promo-image-body1" data-sourceurl="<?php echo e(route('merchants.images',['merchant_id'=>$merchant->merchant_id])); ?>">

                <div class="row" id="promo-image-content1">
                    <input type="text" id="selected_image" style="display: none;">
                    <?php for($i=1;$i<4;$i++): ?>
                        <?php
                            $empty = true;
                        ?>

                        <?php if($merchant->merchantImage): ?>
                        <?php $__currentLoopData = $merchant->merchantImage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $merchant_image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($merchant_image->image_count == $i): ?>

                                <div class="col-md-4 mb-3 pr-0">
                                    <img class="card-img-top" src="<?php echo e($live_url.$merchant_image->image_name); ?>" alt="image count <?php echo e($merchant_image->image_count); ?>">
                                    
                                    <a  href="javascript:;" data-href="<?php echo e(route('merchants.deletemallimage',['id'=>$merchant_image->merchant_image_id])); ?>" data-method="POST" class="btn-pi-delete" data-id="<?php echo e($merchant_image->image_count); ?>">
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
                            


                            <div class="col-md-4">
                                <form action="<?php echo e(route('merchants.uploadimage')); ?>" class="dropzone" id="image_<?php echo e($i); ?>">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="image_count" value="<?php echo e($i); ?>">
                                    <input type="hidden" name="merchant_id" value="<?php echo e($merchant->merchant_id); ?>">
                                </form>
                            </div>


                        <?php endif; ?>

                        
                    <?php endfor; ?>



                </div>

             </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle">
                Merchant Logo
            </div>
            <div class="card-body" id="promo-image-body2" data-sourceurl="<?php echo e(route('merchants.images',['merchant_id'=>$merchant->merchant_id])); ?>">

                <div class="row" id="promo-image-content2">
                    <input type="text" id="selected_image" style="display: none;">

                <?php if(!empty($merchant->merchant_logo)): ?>
                        <div class="col-md-4 mb-3 pr-0">
                            <img class="card-img-top" src="<?php echo e($logo_live_url.$merchant->merchant_logo); ?>" alt="image count" style="width: 200px !important;">
                            
                            <br>
                            <a  href="javascript:;" data-href="<?php echo e(route('merchants.deletelogoimage',['id'=>$merchant->merchant_id])); ?>" data-method="POST" class="btn-pi-delete" data-id="<?php echo e($merchant->merchant_id); ?>">
                                <span class="text-danger"><?php echo e(__('Delete')); ?></span>
                            </a>
                        </div>



                       <?php else: ?>


                        <div class="col-md-4">
                            <form action="<?php echo e(route('merchants.uploadimage')); ?>" class="dropzone" id="my-awesome-dropzone">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="image_count" value="0">
                                <input type="hidden" name="merchant_id" value="<?php echo e($merchant->merchant_id); ?>">
                            </form>
                        </div>


                            
                    <?php endif; ?>



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


    $( function() {
        Dropzone.options.myAwesomeDropzone = {
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 2, // MB
            accept: function(file, done) {
                done();
            },
            init: function() {
                this.on("maxfilesexceeded", function(file){
                    toastr['error']('Upload one file only');

                });
                this.on("success", function(file, responseText) {
                    //console.log('asdasdasdsad');
                    toastr.success(responseText);
                    //console.log(responseText);
                    //ndow.location.reload();
                    //location.reload();
                });
            }
        };
    });



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
                            toastr.success(data.message);
                            window.setTimeout(function(){location.reload()},2000)
                        }
                    }
                });

        });
    });



</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/merchants_list/merchant_images.blade.php ENDPATH**/ ?>