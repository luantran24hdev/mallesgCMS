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
                   <p>Event Id: <span style="margin-right: 120px;color: red"><?php echo e($event->event_id); ?></span> | Created On: <span style="margin-right: 120px;color: red"><?php echo e($event->created_on); ?></span> | Created By: <span style="color: red"><?php echo e(\App\User::getUserName( $event->user_id)); ?></span> <span style="float: right;color: blue"><a href="<?php echo e(route('mall-events',['id'=>$event->mall_id])); ?>">Back</a></span></p>
                </div>
                <div class="card-body" id="tag-image-body" data-sourceurl="<?php echo e(route('mall-events.edit',[$event->event_id])); ?>">
                    <form method="PATCH" action="<?php echo e(route('mall-events.update',[$event->event_id])); ?>" id="editDiscountTag">
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo csrf_field(); ?>
                                <div class="form-group">
                                    <label class="mb-2 font-12"><?php echo e(__('Event Name')); ?></label>
                                    <input type="text" name="event_name" id="promo_name" placeholder="Promotion Name" value="<?php echo e($event->event_name); ?>" required="" class="form-control">

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="mb-2 font-12"><?php echo e(__('Mall Name')); ?></label>
                                    <div class="input-group mb-3">
                                        <input type="text" value="<?php echo e($event->mall->mall_name); ?>" required="" class="form-control" readonly="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="mb-2 font-12"><?php echo e(__('Category')); ?></label>
                                    <div class="input-group mb-2">
                                            <select id="town_control" class="form-control" name="ec_id">

                                                <?php if(!empty($events_categorys)): ?>
                                                    <option value=""> --- Select ---- </option>
                                                    <?php $__currentLoopData = $events_categorys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e(@$category->ec_id); ?>" <?php if($event->ec_id == $category->ec_id): ?> selected <?php endif; ?> ><?php echo e(@$category->event_cat); ?> </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </select>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-2 font-12">Description</label>
                                    <textarea style="height: 200px;" type="text" name="event_description" id="description" value="<?php echo e($event->event_description); ?>" class="form-control"><?php echo e($event->event_description); ?></textarea>
                                </div>
                            </div>

                            <div class="col-md-6 row" >
                                <div class="col-md-6">
                                    <label class="mb-2 font-12">Start Date</label>
                                    <div class="input-group">
                                        <input type="text" name="start_date" id="start_date" placeholder="Start Date" class="form-control py-2 border-right-0 border hasDatepicker" value="<?php echo e($event->start_date); ?>">

                                        <span class="input-group-append">
                                                <button class="btn btn-outline-secondary border-left-0 border" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="mb-2 font-12">End Date</label>
                                    <div class="input-group">


                                        <input type="text" name="end_date" id="end_date" placeholder="End Date" class="form-control py-2 border-right-0 border hasDatepicker" value="<?php if($event->end_date != ""): ?> <?php echo e($event->end_date); ?> <?php endif; ?>" <?php if($event->end_date == ''): ?> disabled <?php endif; ?>>

                                        <span class="input-group-append">
                                            <button class="btn btn-outline-secondary border-left-0 border" type="button">
                                                    <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                    </div>
                                    <input type="checkbox" name="no_end_date" id="no_end_date" onclick="noenddate()" <?php if($event->end_date == null): ?> checked <?php endif; ?>>
                                    No End Date</label>
                                </div>
                                <div class="col-md-12">
                                    <label class="mb-2 font-12">Timing</label>
                                    <div class="input-group">

                                        <input type="text" name="event_timing" placeholder="Timing" value="<?php echo e($event->event_timing); ?>"  class="form-control">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="mb-2 font-12">Event Venue</label>
                                    <textarea style="height: 100px;" type="text" name="location" id="location" class="form-control"><?php echo e($event->location); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label class="mb-2 font-12">
                                            <input type="checkbox" value="Y" name="just_1_day" id="" <?php if($event->just_1_day == 'Y'): ?> checked <?php endif; ?>>
                                            Just One Day</label>
                                    </div>
                                    <br>
                                    <div class="checkbox">
                                        <label class="mb-2 font-12">
                                            <input type="checkbox" value="Y" name="all_day" id="" <?php if($event->all_day == 'Y'): ?> checked <?php endif; ?>>
                                            All Day</label>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary" id="btnEditPromo">Update</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

     <?php echo $__env->make('main.event.event_images', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make('partials.image_model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/croppie.css')); ?>">
    <script type="text/javascript" src="<?php echo e(asset('js/croppie.min.js')); ?>"></script>
    <script>

        $('#start_date,#end_date').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'DD/MM/YYYY'
            }
        });
        $(document).on('submit','#editDiscountTag', function(e){
            e.preventDefault();
            var data = $(this).serialize();
            var url = $(this).attr('action');
            var type =  $(this).attr('method');

            $.ajax({
                url: url,
                type: type,
                dataType:'json',
                data:data,
                success:function(data){
                    if(data.status==='error'){
                        toastr.error(data.message, 'Error');
                    }else{
                        //$("#discount-tag-table").load( $('#discount-tag-table').attr('data-sourceurl') +" #discount-tag-table");
                        toastr.success(data.message);
                    }
                },
                error: function(data){
                    exeptionReturn(data);
                }
            });
        });


        function noenddate(){
            // /  debugger;
            /*$('#no_end_date').click(function() {*/
            if ($('#no_end_date'). prop("checked") == true) {
                $("#end_date").attr('disabled', true).val("");
            }
            else {
                $("#end_date").attr('disabled', false);
            }
            /*});*/
        }


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
                    fd.append("event_id", "<?php echo e(@$event->event_id); ?>");
                    fd.append("event_count", image_count);


                    //console.log('dddddddddddd');

                    // console.log(fd);
                    $.ajax({
                        url: "<?php echo e(route('events.uploadimage')); ?>",
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/event/edit.blade.php ENDPATH**/ ?>