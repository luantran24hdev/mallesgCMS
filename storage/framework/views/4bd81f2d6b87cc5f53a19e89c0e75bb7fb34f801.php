<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-10">
            <div class="card card-malle">
                <div class="card-header-malle">
                   <?php echo e(__('Discount/Sale Tags')); ?>

                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('discount-tags.store')); ?>" id="addDiscountTag">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="tag_name" placeholder="Enter Tag" id="tag_name"
                                   class="form-control" required="" list="datalist1" data-autocompleturl="<?php echo e(route('tag.search')); ?>">
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="out-form">Update</button>
                            </div>
                        </div>

                    </div>
                    </form>

                    <?php if(isset($tags_master)): ?>
                        <br/>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped malle-table" id="discount-tag-table"
                                       data-sourceurl="<?php echo e(route('discount-tags')); ?>">
                                    <thead>
                                    <th></th>
                                    <th>Tag Type</th>
                                    <th>Favorite</th>
                                    <th>Action</th>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $tags_master; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag_master): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="row-location" data-id="<?php echo e(@$tag_master->tag_id); ?>">
                                        <td>
                                            <?php if(!empty($tag_master->image)): ?>
                                                <img src="<?php echo e($live_url.$tag_master->image); ?>" width="50px" height="50px">
                                            <?php else: ?>
                                                <i class="fa fa-picture-o" aria-hidden="true" style="font-size: 50px;"></i>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e(@$tag_master->tag_name); ?></td>

                                        <td>
                                            <select name="favorite" id="" class="tag_column_update dd-orange" data-href="<?php echo e(route('tag.column-update',[$tag_master->tag_id])); ?>" data-method="POST">
                                                <option value="N" <?php if($tag_master->favorite=='N'): ?> selected <?php endif; ?>>No</option>
                                                <option value="Y" <?php if($tag_master->favorite=='Y'): ?> selected <?php endif; ?>>Yes</option>
                                            </select>
                                        </td>

                                        <td>
                                            <a href="<?php echo e(route('discount-tags.edit',[$tag_master->tag_id])); ?>"><span class="text-info">Edit</span></a>
                                            |
                                            <a href="javascript:;"
                                               data-href="<?php echo e(route('discount-tags.destroy',[$tag_master->tag_id])); ?>"
                                               data-method="DELETE" class="btn-delete"
                                               data-id="<?php echo e($tag_master->tag_id); ?>">
                                                <span class="text-danger">Delete</span>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
    <?php echo $__env->make('partials.delete_model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
    <script>

        $(document).on('submit','#addDiscountTag', function(e){
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
                        $("#discount-tag-table").load( $('#discount-tag-table').attr('data-sourceurl') +" #discount-tag-table");
                        toastr.success(data.message);
                    }
                },
                error: function(data){
                    exeptionReturn(data);
                }
            });
        });


        // delete
        $(document).on('click', '.btn-delete', function(e){
            e.preventDefault();
            var btndelete = $(this);

            $('#deletelocationmodal').modal('show');

            $('#btnDeleteLocation').unbind().click(function(){

                $.ajax({
                    url: btndelete.attr('data-href'),
                    type: btndelete.attr('data-method'),
                    dataType:'json',
                    success:function(data){
                        if(data.status==='error'){
                            toastr.error(data.message);
                        }else{
                            $('#deletelocationmodal').modal('hide');
                            $('.row-location[data-id="'+btndelete.attr('data-id')+'"]').remove();
                            toastr.success(data.message);

                        }
                    }
                });

            });
        });

        $( "#tag_name" ).autocomplete({
            source: function (request, response) {
                $.getJSON($("#tag_name").attr('data-autocompleturl') +'/' + request.term, function (data) {
                    response($.map(data, function (value, key) {
                        return {
                            label: value,
                            value: key
                        };
                    }));
                });
            },
            select: function(event, ui) {
                $("#tag_name").val(ui.item.label);
                $("#tag_id").val(ui.item.value);
               // window.location.href = '<?php echo e(route("malls")); ?>/'+ui.item.value;
                return false;
            }
        });


        $(document).on('change', '.tag_column_update', function(e){
            e.preventDefault();
            //debugger;
            var selectOp = $(this);
            var attrName = selectOp.attr("name");

            $.ajax({
                url: selectOp.attr('data-href'),
                type: selectOp.attr('data-method'),
                dataType:'json',
                data: {
                    name : selectOp.attr('name'),
                    value : selectOp.find('option:selected').val()
                },
                success:function(data){
                    console.log(data);
                    if(data.status==='error'){
                        errorReturn(data)
                    }else{
                        //$('#merchant-list-table tbody').remove();
                        //  $("#merchant-list-table").load( $('#merchant-list-table').attr('data-sourceurl') +" #merchant-list-table");
                        toastr.success(data.message);
                    }
                },
                error: function(data){
                    console.log(data);
                    exeptionReturn(data);
                }
            });

        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/discount_tag/discount_tags.blade.php ENDPATH**/ ?>