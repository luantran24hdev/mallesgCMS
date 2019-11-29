<?php if(isset($promo_id)): ?>
<div class="row">
    <div class="col-md-12"> 
        <form method="PUT" action="<?php echo e(route('promotions.update',['promotions' => $promo_id])); ?>" id="editPromoform" autocomplete="off">
            <div class="row">
                 <div class="col-md-5">
                 <div class="form-group">
                    <input type="hidden" name="promo_id" id="promo_id" value="<?php echo e($promo_id); ?>">
                    <input type="hidden" name="merchant_id" id="merchant_id" value="<?php echo e($id); ?>">
                </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <div class="form-group">
                        <label class="mb-2 font-12"><?php echo e(__('Promotion Name')); ?></label>
                        <input type="text" name="promo_name" id="promo_name" placeholder="Promotion Name" value="<?php echo e($current_promo->promo_name); ?>" required="" class="form-control">

                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="mb-2 font-12"><?php echo e(__('Amount')); ?></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-primary font-weight-bold" id="basic-addon1"><?php echo e($current_merchant->country->currency_symbol); ?></span>
                                </div>
                                 <input type="text" name="amount" id="promo_amount" value="<?php echo e($current_promo->amount); ?>" aria-describedby="basic-addon1" class="form-control text-primary text-right font-weight-bold" onkeypress="return isNumber(event)">

                            </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="mb-2 font-12">Other Offer</label>
                            <div class="input-group mb-2">
                                 <input type="text" name="other_offer" id="other_offer" value="<?php echo e($current_promo->other_offer); ?>" class="form-control" maxlength="15">

                            </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-7">

                    <div class="form-group">
                        <label class="mb-2 font-12">Description</label>
                        <textarea style="height: 200px;" type="text" name="description" id="description" required="" value="" class="form-control"><?php echo e($current_promo->description); ?></textarea>
                    </div>
                </div>

                

                <div class="col-md-2">

                    <div class="form-group">
                        <label class="mb-2 font-12"><?php echo e(__('Was')); ?></label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text text-primary font-weight-bold" id="basic-addon1"><?php echo e($current_merchant->country->currency_symbol); ?></span>
                            </div>
                            <input type="text" name="was_amount" id="was_amount" value="<?php echo e($current_promo->was_amount); ?>" aria-describedby="basic-addon1" class="form-control text-primary text-right font-weight-bold" onkeypress="return isNumber(event)">

                        </div>
                    </div>

                    <div class="form-group">
                    <label class="mb-2 font-12">Active</label><br>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-default <?php if($current_promo->active=="Y"): ?> active <?php endif; ?>" id="yes_active">
                                    <input type="radio" name="options" autocomplete="off"> Yes
                                </label>
                                <label class="btn btn-default <?php if($current_promo->active!="Y"): ?> active <?php endif; ?>" id="no_active">
                                    <input type="radio" name="options" autocomplete="off"> No
                                </label>

                            </div>

                            <input type="hidden" name="active_txt" id="active_txt" <?php if($current_promo->active): ?> value="Y" <?php else: ?> value="N" <?php endif; ?>>
                    </div>


                    <div class="form-group">
                            <label class="mb-2 font-12">Redeemable</label><br>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-default <?php if($current_promo->redeemable=="Y"): ?> active <?php endif; ?>" id="yes_redeemable">
                                    <input type="radio" name="redeemable" autocomplete="off"> Yes
                                </label>
                                <label class="btn btn-default <?php if($current_promo->redeemable!="Y"): ?> active <?php endif; ?>" id="no_redeemable">
                                    <input type="radio" name="redeemable" autocomplete="off"> No
                                </label>

                            </div>

                            <input type="hidden" name="redeemable_txt" id="redeemable_txt" value="<?php echo e($current_promo->redeemable); ?>">
                    </div>




                </div>



                <div class="col-md-3">
                    <label class="mb-2 font-12">Promotion Starts on</label>
                    <div class="input-group">
                        <input type="text" name="start_on" id="start_date" placeholder="Start Date" class="form-control py-2 border-right-0 border hasDatepicker" value="<?php echo e($current_promo->start_on); ?>">

                                    <span class="input-group-append">
                                            <button class="btn btn-outline-secondary border-left-0 border" type="button">
                                                    <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                            </div>
                <br>
                    <div class="checkbox">
                                    <label class="mb-2 font-12">
                                        <input type="checkbox" value="Y" name="no_end_date" id="no_end_date" <?php if($current_promo->no_end_date): ?> checked <?php endif; ?>> 
                                    No End Date</label>
                                </div>

                    <label class="mb-2 font-12">Promotion Ends on </label>
                    <div class="input-group">
                        <input type="text" name="ends_on" id="end_date" placeholder="End Date" value="<?php if($current_promo->no_end_date!="Y"): ?><?php echo e($current_promo->ends_on); ?><?php endif; ?>" class="form-control py-2 border-right-0 border hasDatepicker" <?php if($current_promo->no_end_date): ?> disabled <?php endif; ?>>
                                    <span class="input-group-append">
                                            <button class="btn btn-outline-secondary border-left-0 border" type="button">
                                                    <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                            </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary" id="btnEditPromo">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php endif; ?><?php /**PATH /home/malle/public_html/adminlaravel3/resources/views/main/promotions/edit.blade.php ENDPATH**/ ?>