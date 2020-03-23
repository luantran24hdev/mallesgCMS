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
                    <div class="card-header-malle">Mall Info
                    <a href="<?php echo e(route('malls')); ?>" style="float: right">Back</a>
                    </div>
                    <div class="card-body">
                        <form  method="post" action="<?php echo e(route('malls.update',[$mall->mall_id])); ?>">

                            <?php echo csrf_field(); ?>
                            <?php echo e(method_field('PATCH')); ?>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="hidden" name="mall_id_main" id="mall_id_main" value="<?php echo e($mall->mall_id); ?>">
                                        <label class="mb-2 font-12">Mall Name</label>
                                        <input type="text" name="mall_name" placeholder="Mall Name" id="mallname" class="form-control col-md-12" value="<?php echo e($mall->mall_name); ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">

                                    <label class="mb-2 font-12">Mall Type</label><br>

                                            <select name="mt_id" class="form-control col-md-12">
                                                <?php $__currentLoopData = $malltypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $malltype): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($malltype->mt_id); ?>" <?php if($malltype->mt_id == $mall->mt_id): ?> selected <?php endif; ?>> <?php echo e($malltype->type_name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>

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
                                                    <option value="<?php echo e($country->country_id); ?>" <?php if($mall->country_id == $country->country_id): ?> selected <?php endif; ?>><?php echo e($country->country_name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="mb-2 font-12">City</label><br>
                                    <div class="dropdown">
                                        <select name="city_id" class="form-control col-md-12" id="city_control">
                                            <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($city->city_id); ?>" <?php if($city->city_id == $mall->city_id): ?> selected <?php endif; ?>><?php echo e($city->city_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="mb-2 font-12">Town</label><br>
                                    <div class="dropdown">
                                        <select name="town_id" class="form-control col-md-12" id="town_control">
                                            <?php $__currentLoopData = $towns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $town): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($town->town_id); ?>" <?php if($town->town_id == $mall->town_id): ?> selected <?php endif; ?>><?php echo e($town->town_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Address</label><br>
                                        <textarea rows="4" class="form-control" name="business_address"><?php echo e($mall->business_address); ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="mb-2 font-12">Postal Code</label><br>
                                            <input type="text" name="postal_code" class="form-control" placeholder="Postal Code" value="<?php echo e($mall->postal_code); ?>">

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="mb-2 font-12">Telephone #</label><br>
                                            <input type="text" name="telephone" class="form-control" placeholder="Telephone" value="<?php echo e($mall->telephone); ?>">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="mb-2 font-12">Featured</label><br>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-default <?php if($mall->featured == 'Y'): ?> active <?php endif; ?>"  id="yes_featured_merchant">
                                            <input type="radio" name="featured" autocomplete="off" value="Y" class="column_update"> Yes
                                        </label>
                                        <label class="btn btn-default <?php if($mall->featured == 'N' || $mall->featured == ''): ?> active <?php endif; ?>" id="no_featured_merchant">
                                            <input type="radio" name="featured"  autocomplete="off" value="N" class="column_update"> No
                                        </label>


                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="mb-2 font-12">GPS Street</label><br>
                                        <input type="text" name="gps_street" class="form-control" placeholder="GPS Street" value="<?php echo e($mall->gps_street); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Website</label><br>
                                        <input type="text" name="website" class="form-control" placeholder="Website" value="<?php echo e($mall->website); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Facebook</label>
                                        <input type="text" name="facebook" id="facebook" placeholder="Facebook" class="form-control" value="<?php echo e($mall->facebook); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Instagram</label>
                                        <input type="text" name="instagram" id="instagram" placeholder="Instagram" class="form-control" value="<?php echo e($mall->instagram); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Twitter</label>
                                        <input type="text" name="twitter" id="twitter" placeholder="Twitter" class="form-control" value="<?php echo e($mall->twitter); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-2 font-12">YouTube</label>
                                        <input type="text" name="youtube" id="youtube" placeholder="YouTube" class="form-control" value="<?php echo e($mall->youtube); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-2 font-12">Mall Managed By</label><br>
                                        <input type="text" name="managed_by" placeholder="Enter Company Name"
                                               class="form-control" id="managed_by" value="<?php echo e(\App\MallOwner::getOwnerName($mall->managed_by)); ?>" list="datalist1" data-autocompleturl="<?php echo e(route('mall-owner.search')); ?>">
                                        <input type="hidden" name="managed_by" id="mo_id" value="">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-2 font-12">About Us</label>
                                        <textarea type="text" name="about_us" id="about_us" placeholder="About Us" class="form-control" rows="5"><?php echo e($mall->about_us); ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="mb-2 font-12">Latitude</label><br>
                                            <input type="text" name="lat" class="form-control" placeholder="Latitude" value="<?php echo e($mall->lat); ?>">

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="mb-2 font-12">Longitude</label><br>
                                            <input type="text" name="long" class="form-control" placeholder="Longitude" value="<?php echo e($mall->long); ?>">

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="mb-2 font-12">Opening Hours</label>
                                            <textarea type="text" name="opening_hour" id="opening_hour" placeholder="Opening Hours" class="form-control" rows="3"><?php echo e($mall->opening_hour); ?></textarea>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="mb-2 font-12">Mall Active</label><br>
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">

                                        <label class="btn btn-default <?php if($mall->mall_active == 'Y'): ?> active <?php endif; ?>"  id="yes_merchantactive">
                                            <input type="radio" name="mall_active" autocomplete="off" value="Y" class="column_update"> Yes
                                        </label>
                                        <label class="btn btn-default <?php if($mall->mall_active == 'N'): ?> active <?php endif; ?>" id="no_merchantactive">
                                            <input type="radio" name="mall_active"  autocomplete="off" value="N" class="column_update"> No
                                        </label>

                                    </div>
                                    <input type="hidden" name="mallactive" id="mallactive" value="<?= $mall['mall_active'] ?>">
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

    $( "#managed_by" ).autocomplete({
        source: function (request, response) {
            $.getJSON($("#managed_by").attr('data-autocompleturl') +'/' + request.term, function (data) {
                response($.map(data, function (value, key) {
                    return {
                        label: value,
                        value: key
                    };
                }));
            });
        },
        select: function(event, ui) {
            $("#managed_by").val(ui.item.label);
            $("#mo_id").val(ui.item.value);
            return false;
        }
    });

   /* $(document).ready(function() {
         var dataTables = $('.mall_info_table').DataTable();
         dataTables.columns(2).search("Restaurant").draw();
    });
*/
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/mall_list/mall_info.blade.php ENDPATH**/ ?>