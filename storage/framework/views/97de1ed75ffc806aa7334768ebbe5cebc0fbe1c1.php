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

      /*  .fit-image{
            width: 100%;
            object-fit: cover;
            height: 180px; !* only if you want fixed height *!
        }*/

        .merch_out .select2-container--default .select2-selection--single .select2-selection__arrow{
            top: 5px !important;
        }
        .merch_out .select2-container .select2-selection--single {
            height: 38px !important;
        }

        .merch_out .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height: 35px;
        }
        .link_color{
            color: blue;}

    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-10">
            <div class="card card-malle">
                <div class="card-header-malle">
                   <p>Category Id: <span style="margin-right: 120px;color: red"><?php echo e($categorys->Category_id); ?></span> | Created On: <span style="margin-right: 120px;color: red"><?php echo e($categorys->Created_on); ?></span> | Created By: <span style="color: red"><?php echo e(\App\User::getUserName( $categorys->Created_by)); ?></span> <span style="float: right;color: blue"><a href="<?php echo e(route('category.header')); ?>">Back</a></span></p>
                </div>
                <div class="card-body" id="tag-image-body" data-sourceurl="<?php echo e(route('category-tags.edit',[$categorys->Category_id])); ?>">
                    <form method="PATCH" action="<?php echo e(route('category.header.update',[$categorys->Category_id])); ?>" id="editCategoryTag">
                    <div class="row merch_out" id="tag-image-content">

                            <div class="col-md-3">

                                <?php if($categorys->image): ?>
                                    <div class="col-md-12 mb-3 pr-0">
                                        <img class="card-img-top fit-image" src="<?php echo e($live_url.$categorys->image); ?>" alt="image count">
                                        <a  href="javascript:;" data-href="<?php echo e(route('category.header.deleteimage',['id'=>$categorys->Category_id])); ?>" data-method="POST" class="btn-pi-delete" data-id="<?php echo e($categorys->Category_id); ?>">
                                            <span class="text-danger"><?php echo e(__('Delete')); ?></span>
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <div class="col-md-12 mb-3 pr-0">
                                        <div class="upload-msg " style="height: 180px; width: 100%" onclick="$('#upload_5').trigger('click');">
                                            <div style="display: table-cell; vertical-align: middle;">Drop Files Here or click upload a photo </div>
                                        </div>
                                    </div>
                                <?php endif; ?>


                                <input type="file" id="upload_5" data-count="5" class="imguploader" value="Drop Files Here to click upload a photo" accept="image/*" style="display: none;" >

                            </div>


                            <div class="col-md-3">
                                <input type="text" name="Category_name" placeholder="Enter Category Tag" id="category_name"
                                       class="form-control" required="" list="datalist1" data-autocompleturl="<?php echo e(route('category.header.search')); ?>" value="<?php echo e($categorys->Category_name); ?>">
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" id="out-form">Update</button>
                                </div>
                            </div>

                    </div>
                    </form>

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

        $('#main_category_select').select2({
            width:200
        });

        $(document).on('submit','#editCategoryTag', function(e){
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


        $( "#category_name" ).autocomplete({
            source: function (request, response) {
                $.getJSON($("#category_name").attr('data-autocompleturl') +'/' + request.term, function (data) {
                    response($.map(data, function (value, key) {
                        return {
                            label: value,
                            value: key
                        };
                    }));
                });
            },
            select: function(event, ui) {
                $("#category_name").val(ui.item.label);
                $("#tag_id").val(ui.item.value);
                return false;
            }
        });

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
                    // Split the base64 string in data and contentType
                    var block = ImageURL.split(";");
                    // Get the content type

                    var contentType = block[0].split(":")[1];// In this case "image/gif"
                    // get the real base64 content of the file
                    var realData = block[1].split(",")[1];// In this case "iVBORw0KGg...."

                    // Convert to blob
                    var blob = b64toBlob(realData, contentType);
                    var image_count = $('#selected_image').val();
                    var fd = new FormData();
                    fd.append("image", blob);
                    fd.append("Category_id", "<?php echo e(@$categorys->Category_id); ?>");

                    // console.log(fd);
                    $.ajax({
                        url: "<?php echo e(route('category.header.uploadimage')); ?>",
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

                                $('#tag-image-body #tag-image-content').remove();
                                $("#tag-image-body").load( $('#tag-image-body').attr('data-sourceurl') +" #tag-image-content");

                                $('#croppermodal').modal('hide');


                                toastr.success(data.message);

                                setTimeout(function() {
                                    window.location.reload();
                                }, 2000);
                            }
                            select2intalize();
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
                            //var image_count = $(this).attr('data-id')
                            $('#tag-image-body #tag-image-content').remove();
                            $("#tag-image-body").load( $('#tag-image-body').attr('data-sourceurl') +" #tag-image-content");
                            toastr.success(data.message);

                            setTimeout(function() {
                                window.location.reload();
                            }, 2000);
                        }
                        select2intalize();
                    }
                });

            });
        });

        function select2intalize() {
            $('#main_category_select').select2({
                width:200
            });
        }



    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/category_tag/edit_category_header.blade.php ENDPATH**/ ?>