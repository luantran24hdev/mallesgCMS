<?php if(isset($promo_id)): ?>
<div class="row">
  <div class="col-md-10">
    <div class="card card-malle">
      <div class="card-header-malle">
        <?php echo e(__('Promotions in Outlets')); ?>

      </div>
      <div class="card-body">
        
        <form method="POST" action="<?php echo e(route('promo-outlets.store')); ?>" id="addOutlates">
          <input type="hidden" name="promo_id" id="promo_id" value="<?php echo e($promo_id); ?>">
          <input type="hidden" name="merchant_id" id="merchant_id" value="<?php echo e($id); ?>">
          <input type="hidden" name="mall_id" id="mall_id" value="">

          
          <div class="row prom_out">
            <div class="col-md-4">
                <div class="form-group">
                  <label class="mb-2 font-12"><?php echo e(__('Search Mall Name')); ?></label>
                <select id="prom_out">
                    <?php if(!empty($mall_lists)): ?>
                        <?php $__currentLoopData = $mall_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mall): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($mall['mall_id']); ?>"><?php echo e($mall['mall_name']); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </select>
                </div>
              

            </div>


            
            <div class="col-md-3">
              <div class="form-group">
                <label class="mb-2 font-12"><?php echo e(__('Location')); ?></label>
                <select name="merchantlocation_id" id="locations" class="form-control">
                  <option value="">--- Select ----</option>
                </select>
              </div>
            </div>
            
            <div class="col-md-3">
              <button type="submit" class="btn btn-primary col-md-12 top-t" id="btnMerchantPromotion"><?php echo e(__('Update')); ?></button>
            </div>
          </div>
        </form>
        
        <div class="row">
          <div class="col-md-12"> 
            <table class="table table-striped malle-table " id="promotion-outlate-table" data-sourceurl="<?php echo e(route('promotions.show',['promotions'=>$id, 'promo_id' => $promo_id])); ?>">
             <thead>
             <tr>
               <th>Promotional Name</th>
               <th>Mall Name</th>
               <th>Location</th>
               <th>Level</th>
               <th>Live</th>
               <th>Featured</th>
               <th>Redeem</th>
               <th>Action</th>

             </tr>
             </thead>
              <tbody>

                <?php if(isset($current_promo->outlets)): ?>
                <?php $__currentLoopData = $current_promo->outlets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $outlet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="row-promotion" data-id="<?php echo e($outlet->po_id); ?>">
                  <td><?php echo e(optional($current_promo)->promo_name); ?></td>
                  <td><?php echo e(optional($outlet->mall)->mall_name); ?></td>
                  <td>
                    <?php echo e(optional($outlet->merchantLocation)->merchant_location); ?>

                  </td>
                  <td>
                    <?php echo e(optional($outlet->merchantLocation)->floor['level']); ?>

                  </td>
                  <td>
                    <select name="live" id="" class="column_update dd-orange" data-href="<?php echo e(route('promo-outlets.update',['promo_active' => $outlet->po_id])); ?>" data-method="PUT">
                      <option value="Y" <?php if($outlet->live=='Y'): ?> selected <?php endif; ?>>Yes</option>
                      <option value="N" <?php if($outlet->live=='N'): ?> selected <?php endif; ?>>No</option>
                    </select>
                  </td>
                  <td>
                   <select name="featured" id="" class="column_update dd-orange" data-href="<?php echo e(route('promo-outlets.update',['promo_active' => $outlet->po_id])); ?>" data-method="PUT">
                      <option value="Y" <?php if($outlet->featured=='Y'): ?> selected <?php endif; ?>>Yes</option>
                      <option value="N" <?php if($outlet->featured=='N'): ?> selected <?php endif; ?>>No</option>
                    </select>
                  </td>
                  <td>
                    <select name="redeem" id="" class="column_update dd-orange" data-href="<?php echo e(route('promo-outlets.update',['promo_active' => $outlet->po_id])); ?>" data-method="PUT">
                      <option value="Y" <?php if($outlet->redeem=='Y'): ?> selected <?php endif; ?>>Yes</option>
                      <option value="N" <?php if($outlet->redeem=='N'): ?> selected <?php endif; ?>>No</option>
                    </select>
                  </td>
                  <td>

                    <a href="<?php echo e(route('promo-outlets.show',['id'=>$id, 'outlate_id'=>$outlet->po_id,'promo_id'=>$outlet->promo_id])); ?>" data="2" class="btn-edit"><span class="text-success">Edit</span></a>
                    |
                    &nbsp;
                    <a  href="javascript:;" data-href="<?php echo e(route('promo-outlets.destroy',['promo_active' => $outlet->po_id])); ?>" data-method="DELETE" class="btn-delete" data-id="<?php echo e($outlet->po_id); ?>">
                      <span class="text-danger">Delete</span>
                    </a>
                  </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/promotions/outlets.blade.php ENDPATH**/ ?>