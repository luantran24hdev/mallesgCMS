<style>
    .mall_out .select2-container--default .select2-selection--single .select2-selection__arrow{
        top: 5px !important;
    }
    .mall_out .select2-container .select2-selection--single {
        height: 38px !important;
    }

    .mall_out .select2-container--default .select2-selection--single .select2-selection__rendered{
        line-height: 35px;
    }

</style>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">
            <div class="card-header-malle"><?php echo e(__('Merchant In')); ?> <span style="color: #1d68a7"> <?php echo e($mall->mall_name); ?> (<?php echo e(@$total_merchant); ?>) </span></div>
            <div class="card-body">

            <div class="row mall_out">

                <?php if(!isset($id)): ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="mb-2 font-12"><?php echo e(__('Merchant Type')); ?></label>
                            <br>
                            <select id="country_select">
                                <?php if(!empty($locations)): ?>
                                    <option value="all">All (<?php echo e(@$total_merchant); ?>)</option>
                                    <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key1 =>$location1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($location1[0]->mt_id); ?>"><?php echo e($key1); ?> (<?php echo e(count($location1)); ?>)</option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="mb-2 font-12"><?php echo e(__('Floor / Level')); ?></label>
                            <br>
                            <select id="level_select">
                                <?php if(!empty($levels)): ?>
                                    <option value="all">All</option>
                                    <?php $__currentLoopData = $levels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($level->level_id); ?>" title="<?php echo e($level->level); ?>"><?php echo e($level->level); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php if(isset($locations)): ?>
            <br />
            <div class="row">
                <div class="col-md-12">

                    <?php $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$location1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="hide show_<?php echo e($location1[0]->mt_id); ?>">
                     <b><?php echo e($key); ?> (<?php echo e(count($location1)); ?>)</b>
                    <table class="table table-striped malle-table mall_info_table" data-sourceurl="">
                        <tbody>
                        <?php $__currentLoopData = $location1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="level_<?php echo e(@$location->level_id); ?> levelhide">
                                <td><?php echo e(@$location->merchant_name); ?></td>
                                <td><?php echo e($key); ?></td>
                                <td><?php echo e(@$mall->mall_name); ?></td>
                                <td><?php echo e(@$location->level); ?></td>
                                <td><?php echo e(@$location->merchant_location); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
            </div>
            <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
<script>


    $('#country_select,#level_select').select2({
        width:200
    });

    $('#country_select').on('select2:select', function (e) {
        var id= e.params.data.id;

        if(id == 'all'){
            $('.hide').show();
        }else{
            $('.hide').hide();
            $('.show_'+id).show();
        }

    });

    $('#level_select').on('select2:select', function (e) {
        var id= e.params.data.id;

        if(id == 'all'){
            $('.levelhide').show();
        }else{
            $('.levelhide').hide();
            $('.level_'+id).show();
        }

    });


   /* $(document).ready(function() {
         var dataTables = $('.mall_info_table').DataTable();
         dataTables.columns(2).search("Restaurant").draw();
    });
*/
  </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/malle/public_html/adminlaravel3/resources/views/main/mall_list/mall_merchant_info.blade.php ENDPATH**/ ?>