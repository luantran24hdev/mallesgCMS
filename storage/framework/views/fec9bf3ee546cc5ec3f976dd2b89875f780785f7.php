<?php $__env->startSection('content'); ?>
    <div class="row">

        <div class="col-md-10">
            <div class="card card-malle">
                <div class="card-header-malle">
                  <?php echo e(@$mall->mall_name); ?> Offers

                    <a href="<?php echo e(route('malls')); ?>">
                    <span class="link_color" style="float: right">
                        Back
                    </span>
                    </a>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('mall-offers.store')); ?>" id="addOffers">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="offer_title" placeholder="Offer Title" id="offer_title"
                                   class="form-control" list="datalist1" data-autocompleturl="">
                            <input type="hidden" name="mall_id" value="<?php echo e($mall->mall_id); ?>">
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="out-form">Update</button>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="checkbox" name="no_offers" class="no_offers" data-href="<?php echo e(route('malls.column-update',[$mall->mall_id])); ?>" data-method="POST" <?php if($mall->no_offers == 'Y'): ?> checked <?php endif; ?>> No Offers
                            </div>
                        </div>

                    </div>

                    </form>

                    <?php if(isset($offers)): ?>
                        <br/>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped malle-table" id="offer-table"
                                       data-sourceurl="<?php echo e(route('mall-offers',['id'=>$mall->mall_id])); ?>">
                                    <thead>
                                    <th>Offer Title</th>
                                    <th>Mall Name</th>
                                    <th>Live</th>
                                    <th>Featured</th>
                                    <th>Created By</th>
                                    <th>Action</th>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $offers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $offer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="row-location" data-id="<?php echo e(@$offer->offer_id); ?>">
                                        <td><?php echo e(@$offer->offer_title); ?></td>
                                        <td><?php echo e(@$offer->mall->mall_name); ?></td>
                                        <td>
                                            <select name="live" id="" class="offers_column_update dd-orange" data-href="<?php echo e(route('offers.column-update',[$offer->offer_id])); ?>" data-method="POST">
                                                <option value="N" <?php if($offer->live=='N'): ?> selected <?php endif; ?>>No</option>
                                                <option value="Y" <?php if($offer->live=='Y'): ?> selected <?php endif; ?>>Yes</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="featured" id="" class="offers_column_update dd-orange" data-href="<?php echo e(route('offers.column-update',[$offer->offer_id])); ?>" data-method="POST">
                                                <option value="N" <?php if($offer->featured=='N'): ?> selected <?php endif; ?>>No</option>
                                                <option value="Y" <?php if($offer->featured=='Y'): ?> selected <?php endif; ?>>Yes</option>
                                            </select>
                                        </td>
                                        <td><?php echo e(\App\User::getUserName($offer->user_id)); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('mall-offers.edit',[$offer->offer_id])); ?>"><span class="text-info">Edit</span></a>
                                            |
                                            <a href="javascript:;"
                                               data-href="<?php echo e(route('mall-offers.destroy',[$offer->offer_id])); ?>"
                                               data-method="DELETE" class="btn-delete"
                                               data-id="<?php echo e($offer->offer_id); ?>">
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

        $(document).on('submit','#addOffers', function(e){
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
                        $("#offer-table").load( $('#offer-table').attr('data-sourceurl') +" #offer-table");
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

        // change promo outlate live, featured and redeem status
        $(document).on('change', '.offers_column_update', function(e){
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
                        toastr.success(data.message);
                    }
                },
                error: function(data){
                    console.log(data);
                    exeptionReturn(data);
                }
            });

        });

        $(document).on('change', '.no_offers', function(e){

            //alert('sdsds');
            e.preventDefault();
            //debugger;
            var selectOp = $(this);
            var attrName = selectOp.attr("name");

            if($(this).is(":checked")) {
                var value = 'Y';
            }
            else{
                var value = 'N';
            }

            $.ajax({
                url: selectOp.attr('data-href'),
                type: selectOp.attr('data-method'),
                dataType:'json',
                data: {
                    name : selectOp.attr('name'),
                    value : value
                },
                success:function(data){
                    console.log(data);
                    if(data.status==='error'){
                        errorReturn(data)
                    }else{
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/offer/index.blade.php ENDPATH**/ ?>