<?php $__env->startSection('style'); ?>

    <style>
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
                   <p>Category Id: <span style="margin-right: 120px;color: red"><?php echo e($tagMaster->sub_category_id); ?></span> | Created On: <span style="margin-right: 120px;color: red"><?php echo e($tagMaster->Created_on); ?></span> | Created By: <span style="color: red"><?php echo e(\App\User::getUserName( $tagMaster->Created_by)); ?></span> <span style="float: right;color: blue"><a href="<?php echo e(route('category-tags')); ?>">Back</a></span></p>
                </div>
                <div class="card-body" id="tag-image-body" data-sourceurl="<?php echo e(route('category-tags.edit',[$tagMaster->sub_category_id])); ?>">

                    <div class="row merch_out" id="tag-image-content">

                            <div class="col-md-3">

                                <?php if($tagMaster->image): ?>
                                    <div class="col-md-12 mb-3 pr-0">
                                        <img class="card-img-top fit-image" src="<?php echo e($live_url.$tagMaster->image); ?>" alt="image count">
                                        <a  href="javascript:;" data-href="<?php echo e(route('category.tag.deleteimage',['id'=>$tagMaster->sub_category_id])); ?>" data-method="POST" class="btn-pi-delete" data-id="<?php echo e($tagMaster->sub_category_id); ?>">
                                            <span class="text-danger"><?php echo e(__('Delete')); ?></span>
                                        </a>
                                    </div>
                                <?php else: ?>

                                    <div class="col-md-12 mb-3 pr-0">
                                        <form action="<?php echo e(route('category.tag.uploadimage')); ?>" class="dropzone" id="my-awesome-dropzone">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="sub_category_id" value="<?php echo e(@$tagMaster->sub_category_id); ?>">
                                        </form>
                                    </div>

                                <?php endif; ?>

                            </div>
                            <div class="col-md-9">
                                <form method="PATCH" action="<?php echo e(route('category-tags.update',[$tagMaster->sub_category_id])); ?>" id="editCategoryTag">
                                    <div class="row">
                                    <div class="col-md-3">
                                        <input type="text" name="Sub_Category_name" placeholder="Enter Category Tag" id="sub_category_name"
                                               class="form-control" required="" list="datalist1" data-autocompleturl="<?php echo e(route('category.tag.search')); ?>" value="<?php echo e($tagMaster->Sub_Category_name); ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select id="main_category_select" name="Category_id">
                                                <?php if(!empty($categorys)): ?>
                                                    <?php $__currentLoopData = $categorys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($category->Category_id); ?>" <?php if($category->Category_id == $tagMaster->Category_id): ?> selected <?php endif; ?>><?php echo e($category->Category_name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
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
        </div>
    </div>

    <?php echo $__env->make('partials.image_model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
    <script type="text/javascript" src="<?php echo e(asset('js/dropzone.js')); ?>"></script>
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


        $( "#sub_category_name" ).autocomplete({
            source: function (request, response) {
                $.getJSON($("#sub_category_name").attr('data-autocompleturl') +'/' + request.term, function (data) {
                    response($.map(data, function (value, key) {
                        return {
                            label: value,
                            value: key
                        };
                    }));
                });
            },
            select: function(event, ui) {
                $("#sub_category_name").val(ui.item.label);
                $("#tag_id").val(ui.item.value);
                return false;
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/category_tag/edit_tags.blade.php ENDPATH**/ ?>