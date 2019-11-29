<?php $__env->startSection('style'); ?>

    <style>
        .card{
            margin-bottom: 0px;
        }
        .btn-default{
            color: #fff;
            background-color: #ccc;
            border-color: #ccc;
        }
        .active{
            background-color: #007bff !important;
        }
        .pic {
            width: 100%;
            height: 100%;
        }


        .upload-demo-wrap {
            width: 100%;
            height: 100%;
        }

        .upload-msg {
            text-align: center;
            font-size: 22px;
            color: #aaa;
            border: 1px solid #aaa;
            display: table;
            cursor: pointer;
        }



    </style>
<?php $__env->stopSection(); ?>

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

<?php echo $__env->make('partials.image_model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/croppie.css')); ?>">
    <script type="text/javascript" src="<?php echo e(asset('js/croppie.min.js')); ?>"></script>
    <script>




        $( function() {
            var $uploadCrop = $('#upload-demo');
            $uploadCrop.croppie({
                enableResize: true,
                enableExif: true,
                viewport: {
                    width: 550,
                    height: 390,
                },
                boundary: {
                    width: 647,
                    height: 459
                }
            });

            $('#croppermodal').on('shown.bs.modal', function() {
                $uploadCrop.croppie('bind');
            });



            $(document).on('click','.upload-result', function (ev) {
                $uploadCrop.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function (resp) {

                    var ImageURL = resp;

                    //console.log(ImageURL);
                    // Split the base64 string in data and contentType
                    var block = ImageURL.split(";");
                    // Get the content type

                    // console.log(block);
                    var contentType = block[0].split(":")[1];// In this case "image/gif"
                    // get the real base64 content of the file
                    var realData = block[1].split(",")[1];// In this case "iVBORw0KGg...."

                    // Convert to blob
                    var blob = b64toBlob(realData, contentType);
                    var image_count = $('#selected_image').val();
                    // Create a FormData and append the file
                    var fd = new FormData();
                    fd.append("image", blob);
                    fd.append("merchantlocation_id", "<?php echo e(@$location->merchantlocation_id); ?>");
                    fd.append("merchant_id", "<?php echo e(@$location->merchant_id); ?>");
                    fd.append("count", image_count);


                    //console.log('dddddddddddd');

                    // console.log(fd);
                    $.ajax({
                        url: "<?php echo e(route('locations.uploadimage')); ?>",
                        data: fd,// the formData function is available in almost all new browsers.
                        type:"POST",
                        contentType:false,
                        processData:false,
                        cache:false,
                        dataType:"json", // Cha
                        success:function(data){
                            if(data.status==='error'){
                                errorReturn(data)
                            }else{
                                $('#croppermodal').modal('hide');
                                toastr.success(data.message);
                                window.setTimeout(function(){location.reload()},2000)
                            }
                        },
                        error: function(data){
                            exeptionReturn(data);
                        }
                    });

                });
            });



            $(document).on('change', '.imguploader', function () {
                readFile(this);
                $('#selected_image').val($(this).attr('data-count'));
            });

            function readFile(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    $('#croppermodal').modal('show');

                    reader.onload = function (e) {
                        $('.upload-demo-wrap').show();
                        $uploadCrop.croppie('bind', {
                            url: e.target.result
                        }).then(function(){
                            console.log('jQuery bind complete');
                        });

                    }

                    reader.readAsDataURL(input.files[0]);

                }
                else {
                    alert("Sorry - you're browser doesn't support the FileReader API");
                }
            }

            function b64toBlob(b64Data, contentType, sliceSize) {
                contentType = contentType || '';
                sliceSize = sliceSize || 512;

                var byteCharacters = atob(b64Data);
                var byteArrays = [];

                for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
                    var slice = byteCharacters.slice(offset, offset + sliceSize);

                    var byteNumbers = new Array(slice.length);
                    for (var i = 0; i < slice.length; i++) {
                        byteNumbers[i] = slice.charCodeAt(i);
                    }

                    var byteArray = new Uint8Array(byteNumbers);

                    byteArrays.push(byteArray);
                }

                var blob = new Blob(byteArrays, {type: contentType});
                return blob;
            }
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



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/malle/public_html/adminlaravel3/resources/views/main/merchants/merchant_locations_images.blade.php ENDPATH**/ ?>