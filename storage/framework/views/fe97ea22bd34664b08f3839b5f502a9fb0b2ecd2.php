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
                    <?php echo e(\App\MallMaster::getMallName($mall_id)); ?>

                    <span><a href="<?php echo e(route('malls')); ?>" style="float: right">Back</a></span>
                </div>
                <div class="card-body merch_out">
                    <form method="POST" action="<?php echo e(route('malls.storeMallLevel')); ?>" id="addMalltype">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select id="level_master" name="level_id">
                                        <?php if(!empty($levels)): ?>
                                            <option value="">Select Level</option>
                                            <?php $__currentLoopData = $levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($level->level_id); ?>"><?php echo e($level->level); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" value="<?php echo e($mall_id); ?>" name="mall_id">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select id="level_activity" name="level_activity_id">
                                        <?php if(!empty($levels)): ?>
                                            <option value="">Select Level Activity</option>
                                            <?php $__currentLoopData = $level_activitys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level_activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($level_activity->la_id); ?>"><?php echo e($level_activity->level_activity); ?></option>
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

                    <?php if(isset($level_malls)): ?>
                        <br/>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped malle-table"  id="mall_type-table"
                                       data-sourceurl="<?php echo e(route('malls.level',[$mall_id])); ?>">
                                    <thead>
                                    <th></th>
                                    <th>Level / Floor</th>
                                    <th>Level Activity</th>
                                    <th>Mall</th>
                                    <th>Created By</th>
                                    <th>Action</th>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $level_malls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level_mall): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="row-location" data-id="<?php echo e(@$level_mall->lm_id); ?>">
                                            <td>
                                                <?php if(!empty($level_mall->level->level_image)): ?>
                                                    <img src="<?php echo e($live_url.$level_mall->level->level_image); ?>" width="50px" height="50px">
                                                <?php else: ?>
                                                    <i class="fa fa-picture-o" aria-hidden="true" style="font-size: 50px;"></i>
                                                <?php endif; ?>
                                            </td>

                                            <td><?php echo e(@$level_mall->level->level); ?></td>
                                            <td><?php echo e(@$level_mall->level_activity->level_activity); ?></td>
                                            <td><?php echo e(@$level_mall->mall->mall_name); ?></td>
                                            <td><?php echo e(\App\User::getUserName( @$level_mall->created_by )); ?></td>
                                            <td>
                                                <a href="javascript:;"
                                                   data-href="<?php echo e(route('malls.level.destroy',[$level_mall->lm_id])); ?>"
                                                   data-method="DELETE" class="btn-delete"
                                                   data-id="<?php echo e($level_mall->lm_id); ?>">
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
        $('#level_master,#level_activity').select2({
            width:200
        });
        $(document).on('submit','#addMalltype', function(e){
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
                        $("#mall_type-table").load( $('#mall_type-table').attr('data-sourceurl') +" #mall_type-table");
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
                //$("#tag_id").val(ui.item.value);
                return false;
            }
        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/mall_list/level_mall.blade.php ENDPATH**/ ?>