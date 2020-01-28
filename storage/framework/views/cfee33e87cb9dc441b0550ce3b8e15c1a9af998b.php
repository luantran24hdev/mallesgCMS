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
                    <?php echo e(\App\MerchantMaster::getMerchantName($id)); ?>

                    <span><a href="<?php echo e(route('merchants.list')); ?>" style="float: right">Back</a></span>
                </div>
                <div class="card-body merch_out">
                    <form method="POST" action="<?php echo e(route('merchant-contact.store')); ?>" id="addCategoryTag">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="mb-2 font-12">Contact Person</label>
                            <input type="text" name="contact_person" placeholder="Contact Person" id=""
                                   class="form-control" required="">
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="mb-2 font-12">Position Held</label>
                                <input type="text" name="position_held" placeholder="Position Held" id=""
                                       class="form-control" required="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="mb-2 font-12">Contact #</label>
                                <input type="text" name="contact_number" placeholder="Contact" id=""
                                       class="form-control" required="" >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="mb-2 font-12">Email</label>
                                <input type="hidden" name="merchant_id" value="<?php echo e($id); ?>">
                                <input type="text" name="email_id" placeholder="Email" id=""
                                       class="form-control" required="" >
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="out-form">Update</button>
                            </div>
                        </div>

                    </div>
                    </form>

                    <?php if(isset($contacts)): ?>
                        <br/>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped malle-table" id="category-tag-table"
                                       data-sourceurl="<?php echo e(route('merchant-contact.show',$id)); ?>">
                                    <thead>
                                    <th>Contact Person</th>
                                    <th>Position Held</th>
                                    <th>Contact #</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="row-location" data-id="<?php echo e(@$contact->mrc_id); ?>">
                                        <td><?php echo e(@$contact->contact_name); ?></td>
                                        <td><?php echo e(@$contact->position_held); ?></td>
                                        <td><?php echo e(@$contact->contact_number); ?></td>
                                        <td><?php echo e(@$contact->email_id); ?></td>

                                        <td>
                                            <a href="<?php echo e(route('merchant-contact.edit',[$contact->mrc_id])); ?>"><span class="text-info">Edit</span></a>
                                            |
                                            <a href="javascript:;"
                                               data-href="<?php echo e(route('merchant-contact.destroy',[$contact->mrc_id])); ?>"
                                               data-method="DELETE" class="btn-delete"
                                               data-id="<?php echo e($contact->mrc_id); ?>">
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

        $(document).on('submit','#addCategoryTag', function(e){
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
                        $("#category-tag-table").load( $('#category-tag-table').attr('data-sourceurl') +" #category-tag-table");
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
                $("#tag_id").val(ui.item.value);
                return false;
            }
        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/merchants_list/contact.blade.php ENDPATH**/ ?>