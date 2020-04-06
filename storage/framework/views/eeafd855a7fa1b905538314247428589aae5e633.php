<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style type="text/css">
        .card {
            margin-bottom: 0px;
        }

        .btn-default {
            color: #fff;
            background-color: #ccc;
            border-color: #ccc;
        }

        .active {
            background-color: #007bff !important;
        }

        .pic {
            width: 100%;
            height: 100%;
        }


        .upload-demo-wrap {
            width: 100%;
            height: 100;
        }

        .upload-msg {
            text-align: center;
            font-size: 22px;
            color: #aaa;
            border: 1px solid #aaa;
            display: table;
            cursor: pointer;
        }

        .fit-image {
            width: 100%;
            object-fit: cover;
            height: 213px; /* only if you want fixed height */
        }


        .prom_outlate .select2-container--default .select2-selection--single .select2-selection__arrow{
            top: 5px !important;
        }
        .prom_outlate .select2-container .select2-selection--single {
            height: 38px !important;
        }

        .prom_outlate .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height: 35px;
        }
        .prom_outlate .select2-container{
            top:30px;
        }

    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="row" >
        <div class="col-md-12">
            <div class="card card-malle">
                <div class="card-header-malle">
                    
                    <span>
                    <?php echo e($current_promo->promo_name); ?>

                        </span>
                    <span style="text-align: center; margin-left: 250px">
                        <?php echo e($current_merchant->merchant_name); ?>

                    </span>

                    <?php if(isset($promo_id)): ?>
                      <a style="float:right;" href="<?php echo e(route('promotions.show',['promotions'=>$id, 'promo_id'=>$promo_id])); ?>"><?php echo e(__('Back')); ?></a>
                    <?php endif; ?>
                    
                </div>
                <div class="card-body" data-sourceurl="<?php echo e(route('promo-outlets.show',['id'=>$id, 'outlate_id'=>$outlate_data->po_id,'promo_id'=>$promo_id])); ?>" id="editoutlatedata">
                    <form method="POST" action="<?php echo e(route('promo.update.outlate')); ?>" id="editOutlates">
                        <input type="hidden" name="out_id" value="<?php echo e($outlate_data->po_id); ?>">
                    <div class="row" >
                        <div class="col-md-3 mb-3 pr-0">
                            <?php if(count($promotion_images) > 0): ?>
                            <img class="card-img-top fit-image"
                                 src="<?php echo e($live_url.$promotion_images[0]->image_name); ?>"
                                 alt="image count">
                            <?php else: ?>
                                <i class="fa fa-picture-o" aria-hidden="true" style="font-size: 200px;"></i>
                            <?php endif; ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="col-md-12 font-12">Live</label>
                                    <select name="live" id="" class="outlate_live dd-orange" data-href=""
                                            data-method="PUT">
                                        <option value="Y" <?php if($outlate_data->live=='Y'): ?> selected <?php endif; ?>>Yes</option>
                                        <option value="N" <?php if($outlate_data->live=='N'): ?> selected <?php endif; ?>>No</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-md-12 font-12">Featured</label>
                                    <select name="featured" id="" class="outlate_featured dd-orange" data-href=""
                                            data-method="PUT">
                                        <option value="Y" <?php if($outlate_data->featured=='Y'): ?> selected <?php endif; ?>>Yes</option>
                                        <option value="N" <?php if($outlate_data->featured=='N'): ?> selected <?php endif; ?>>No</option>

                                    </select>
                                </div>

                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label class="mb-2 font-12"><?php echo e(__('Amount')); ?></label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-primary font-weight-bold" id="basic-addon1"><?php echo e($current_merchant->country->currency_symbol); ?></span>
                                            </div>
                                            <input type="text" name="amount" id="promo_amount" value="<?php if(empty($outlate_data->amount)): ?> <?php echo e($current_promo->amount); ?> <?php else: ?> <?php echo e($outlate_data->amount); ?> <?php endif; ?>" aria-describedby="basic-addon1" class="form-control text-primary text-right font-weight-bold" onkeypress="return isNumber(event)">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label class="mb-2 font-12"><?php echo e(__('Was')); ?></label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text text-primary font-weight-bold" id="basic-addon1"><?php echo e($current_merchant->country->currency_symbol); ?></span>
                                            </div>
                                            <input type="text" name="was_amount" id="was_amount" value="<?php echo e($current_promo->was_amount); ?>" aria-describedby="basic-addon1" class="form-control text-primary text-right font-weight-bold" onkeypress="return isNumber(event)" readonly>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label class="mb-2 font-12"><?php echo e(__('Other Offer')); ?></label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="other_offer" value="" aria-describedby="basic-addon1" class="form-control text-primary text-right font-weight-bold" readonly>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-5 mb-3 pr-0">
                            <label class="mb-2 font-12">Description</label>
                            <textarea style="height: 250px;" type="text"  id="description" required=""
                                      value="" class="form-control" disabled><?php echo e($current_promo->description); ?></textarea>
                            </textarea>
                            <label class="mb-2 font-12">Additional Description</label>
                            <textarea style="height: 250px;" type="text" name="desc_2" id="description"
                                      value="" class="form-control"><?php echo e($outlate_data->desc_2); ?></textarea>
                            </textarea>
                        </div>
                        <div class="col-md-3 mb-3 pr-0">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" id="out-form">Update</button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="mb-2 font-12">Promotion Starts on</label>
                                <div class="input-group">
                                    <input type="text" name="start_on" id="start_date" placeholder="Start Date" class="form-control py-2 border-right-0 border hasDatepicker" value="<?php if(empty($outlate_data->start_on)): ?> <?php echo e($current_promo->start_on); ?> <?php else: ?> <?php echo e($outlate_data->start_on); ?> <?php endif; ?>">

                                    <span class="input-group-append">
                                            <button class="btn btn-outline-secondary border-left-0 border" type="button">
                                                    <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                </div>
                                <br>
                                <div>
                                <label class="mb-2 font-12">
                                    <input type="checkbox" value="Y" name="no_end_date" id="no_end_date" <?php if($outlate_data->no_end_date == 'Y'): ?> checked <?php endif; ?>  onclick="noenddate()">
                                    No End Date</label>
                            </div>
                                <label class="mb-2 font-12">Promotion Ends on </label>
                                <div class="input-group">
                                    <input type="text" name="ends_on" id="end_date" placeholder="End Date" value="<?php echo e(@$outlate_data->ends_on); ?>" class="form-control py-2 border-right-0 border hasDatepicker" <?php if($outlate_data->no_end_date == 'Y'): ?> disabled <?php endif; ?>>
                                    <span class="input-group-append">
                                            <button class="btn btn-outline-secondary border-left-0 border" type="button">
                                                    <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                </div>

                                <br>
                                <div class="checkbox">
                                    <label class="mb-2 font-12">
                                        <input type="checkbox" value="Y" name="taxes" id="taxes" <?php if($outlate_data->taxes == 'Y'): ?> checked <?php endif; ?>>
                                        Taxes & Services</label>
                                </div>

                                <div class="checkbox">
                                    <label class="mb-2 font-12">
                                        <input type="checkbox" value="Y" name="takeout" id="takeout" <?php if($outlate_data->takeout == 'Y'): ?> checked <?php endif; ?>>
                                        Take Away </label>
                                </div>
                            </div>

                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    
    <?php echo $__env->make('main.promotions.prom_outlate', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('main.promotions.prom_outlate_time', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



    <div class="modal fade" id="deletelocationmodal" tabindex="-1" role="dialog" aria-labelledby="deletemodallocationlabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletemodallocationlabel">Delete Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <p class="font-12">Are you sure you want to delete this location?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" id="btnDeleteLocation">Yes</button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script>


    $('#week_select').val('');
    $('#week_select').select2({
        placeholder: 'Select Week Day',
        allowClear: true,
        width:300
    });

     $('#week_select').on('select2:select', function (e) {
         $("#dow_id").val(e.params.data.id);
     });

    $('#day_select').val('');
    $('#day_select').select2({
        placeholder: 'Select Day',
        allowClear: true,
        width:300
    });

    $('#day_select').on('select2:select', function (e) {
        $("#time_dow_id").val(e.params.data.id);
    });


    $('#time_select').val('');
    $('#time_select').select2({
        placeholder: 'Select Time',
        allowClear: true,
        width:300
    });

    $('#time_select').on('select2:select', function (e) {
        $("#tt_id").val(e.params.data.id);
    });

    // change promo tag status
    $(document).on('change', '.promo_days', function(e){
        e.preventDefault();
        var selectOp = $(this);
        var attrName = selectOp.attr("name");

        $.ajax({
            url: selectOp.attr('data-href'),
            type: selectOp.attr('data-method'),
            dataType:'json',
            data: {
                day : selectOp.attr('name'),
                value : selectOp.find('option:selected').val(),
                'promo_id' : '<?php echo e($promo_id); ?>',
                'po_id' : '<?php echo e($outlate_data->po_id); ?>'
            },
            success:function(data){
                if(data.status==='error'){
                    errorReturn(data)
                }else{
                    $("#outlate-day-table").load($('#outlate-day-table').attr('data-sourceurl')+" #outlate-day-table");
                    toastr.success(data.message);
                }
            },
            error: function(data){
                exeptionReturn(data);
            }
        });
    });

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 46 || charCode > 57) ) {
            return false;
        }
        return true;
    }
    $('#start_date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
            format: 'DD/MM/YYYY'
        }
    });

    function noenddate(){
      // /  debugger;
        /*$('#no_end_date').click(function() {*/
            if ($('#no_end_date'). prop("checked") == true) {
                $("#end_date").attr('disabled', true).val("");
            }
            else {
                $("#end_date").attr('disabled', false);
            }
        /*});*/
    }


    $('#end_date').daterangepicker({

        autoApply :false,
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
            //cancelLabel: 'Clear',
            format: 'DD/MM/YYYY'
        }
    });


    $(document).on('submit','#editOutlates', function(e){
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
                    //errorReturn(data)
                    toastr.error(data.message, 'Error');
                }else{
                    $("#editoutlatedata").load($('#editoutlatedata').attr('data-sourceurl')+" #editoutlatedata");
                    noenddate();
                    toastr.success(data.message);

                }
            },
            error: function(data){
                exeptionReturn(data);
            }
        });
    });


    $(document).on('submit','#addPromoOutlateDay', function(e){
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
                    $("#promotion-outday-table").load( $('#promotion-outday-table').attr('data-sourceurl') +" #promotion-outday-table");
                    toastr.success(data.message);
                }
            },
            error: function(data){
                exeptionReturn(data);
            }
        });
    });

    $(document).on('submit','#addPromoOutlateTime', function(e){
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
                    $("#promotion-outtime-table").load( $('#promotion-outtime-table').attr('data-sourceurl') +" #promotion-outtime-table");
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
                        $('.row-promo-out-day[data-id="'+btndelete.attr('data-id')+'"]').remove();
                        toastr.success(data.message);

                    }
                }
            });

        });
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/promotions/editoutlets.blade.php ENDPATH**/ ?>