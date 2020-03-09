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
                <?php echo $__env->make('main.merchants_list.merchant_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="card-body merch_out">
                    <form method="POST" action="<?php echo e(route('merchant-company.store')); ?>" id="addMalltype">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="company_name" placeholder="Enter Company Name"
                                       class="form-control" id="sub_category_name" required="" list="datalist1" data-autocompleturl="<?php echo e(route('merchant-company.search')); ?>">
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select id="main_category_select" name="city_id">
                                        <?php if(!empty($citys)): ?>
                                            <option value="">Select City</option>
                                            <?php $__currentLoopData = $citys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($city->city_id); ?>"><?php echo e($city->city_name); ?></option>
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

                    <?php if(isset($companys)): ?>
                        <br/>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped malle-table"  id="mall_type-table"
                                       data-sourceurl="<?php echo e(route('merchant-company')); ?>">
                                    <thead>
                                    <th>Company Name</th>
                                    <th>City</th>
                                    <th>Action</th>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $companys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="row-location" data-id="<?php echo e(@$company->company_id); ?>">
                                            <td><?php echo e(@$company->company_name); ?>

                                                <br><br>
                                            <span style="float: left" class="link_color"><a href="<?php echo e(route('merchant-company.edit',[$company->company_id])); ?>"><b>Main Info</b></a></span>
                                                <span style="margin-left: 20px" class="link_color"><a href="<?php echo e(route('merchant-company.show',[$company->company_id])); ?>"><b>Merchants Owned</b></a></span>
                                            </td>
                                            <td><?php echo e(\App\CityMaster::getCityName(@$company->city_id)); ?></td>

                                            <td>
                                                <a href="javascript:;"
                                                   data-href="<?php echo e(route('merchant-company.destroy',[$company->company_id])); ?>"
                                                   data-method="DELETE" class="btn-delete"
                                                   data-id="<?php echo e($company->company_id); ?>">
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
        $('#main_category_select').select2({
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/merchants_list/company.blade.php ENDPATH**/ ?>