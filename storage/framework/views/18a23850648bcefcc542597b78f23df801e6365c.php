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

    .btn-default{
        color: #fff !important;
        background-color: #ccc !important;
        border-color: #ccc !important;
    }
    .active{
        background-color: #007bff !important;
        border-color: #007bff !important;
    }
    .pic {
        width: 100%;
        height: 100%;
    }

</style>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-10">
        <?php echo $__env->make('partials.flash_message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="row">

            <div class="col-md-12">
                <div class="card card-malle">
                    <div class="card-header-malle"><?php echo e($company->company_name); ?>

                    <a href="<?php echo e(route('merchant-company')); ?>" style="float:right;">Back</a>
                    </div>
                    <div class="card-body">
                        <form  method="post" action="<?php echo e(route('merchant-company.update',[$company->company_id])); ?>">

                            <?php echo csrf_field(); ?>
                            <?php echo e(method_field('PATCH')); ?>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Company Name</label>
                                        <input type="text" name="company_name" placeholder="Mall Name" id="mallname" class="form-control col-md-12" value="<?php echo e($company->company_name); ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">

                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary col-md-6 mt-4" id="btnUpdateMall">Update</button>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-md-3">
                                    <label class="mb-2 font-12">Country</label><br>
                                    <div class="dropdown">

                                            <select name="country_id" class="form-control col-md-12" id="country_select">
                                                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($country->country_id); ?>" <?php if($company->country_id == $country->country_id): ?> selected <?php endif; ?>><?php echo e($country->country_name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="mb-2 font-12">City</label><br>
                                    <div class="dropdown">
                                        <select name="city_id" class="form-control col-md-12" id="city_control">
                                            <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($city->city_id); ?>" <?php if($city->city_id == $company->city_id): ?> selected <?php endif; ?>><?php echo e($city->city_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Company Address</label><br>
                                        <textarea rows="4" class="form-control" name="company_address"><?php echo e($company->company_address); ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="mb-2 font-12">Postal Code</label><br>
                                            <input type="text" name="postal_code" class="form-control" placeholder="Postal Code" value="<?php echo e($company->postal_code); ?>">

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="mb-2 font-12">Telephone #</label><br>
                                            <input type="text" name="telephone" class="form-control" placeholder="Telephone" value="<?php echo e($company->telephone); ?>">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Website</label><br>
                                        <input type="text" name="website" class="form-control" placeholder="Website" value="<?php echo e($company->website); ?>">
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

<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
<script>



    $(document).on('submit','#editmallform', function(e){
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


    $(".column_update").change(function(){

        var value = $(this).val();
        var attrName = $(this).attr("name");
        var mall_id = $('#mall_id_main').val();

        $.ajax({
            type : 'ajax',
            method : 'post',
            url : '<?php echo e(route('malls.column-update')); ?>/'+mall_id,
            data : {name:attrName,
                    value : value},
            async : false,
            dataType : 'json',
            success : function(data){

                // /toastr.success(data.message);
                toastr['info'](data.message);

            },
            error : function(){
                toastr['error']('Could not update.');
            }
        });
    });

    $('#country_select').on('change', function (e) {

        var id= $(this).children("option:selected").val();

        $.ajax({
            url: '<?php echo e(route('malls.getcitymall')); ?>',
            type: 'POST',
            dataType:'json',
            data : {'id':id},
            success:function(data){
                // /console.log(data);
                $('#city_control').html(data.city);
                $('#town_control').html('<option value="">--- Select ----</option>');
            }
        });

    });

    $('#city_control').on('change', function (e) {

        var id= $(this).children("option:selected").val();

        $.ajax({
            url: '<?php echo e(route('malls.gettownmall')); ?>',
            type: 'POST',
            dataType:'json',
            data : {'id':id},
            success:function(data){
                // /console.log(data);
                $('#town_control').html(data.town);

            }
        });

    });

   /* $(document).ready(function() {
         var dataTables = $('.mall_info_table').DataTable();
         dataTables.columns(2).search("Restaurant").draw();
    });
*/
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/merchants_list/edit_company.blade.php ENDPATH**/ ?>