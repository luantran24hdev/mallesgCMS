<div class="col-md-2 mt-4">
    <div class="sidebar">
        <?php if(Auth::user()): ?>
            <div class="container">
                <div class="row">
                    <h5>Hi ! <span class="text-info"><?php echo e(Auth::user()->short_name); ?></span></h5><br>
                    <div class="text-email"><?php echo e(Auth::user()->email_id); ?></div>
                </div><hr>
            </div>
        <?php endif; ?>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><a class="malle-link" href="<?php echo e(route('malls')); ?>"><?php echo e(__('Mall List')); ?></a></li>
            <li class="list-group-item"><a class="malle-link" href="<?php echo e(route('merchants.list')); ?>"><?php echo e(__('Merchants List')); ?></a></li>
            <li class="list-group-item"><a class="malle-link" href="<?php echo e(route('merchants')); ?>"><?php echo e(__('Merchants in Outlets')); ?></a></li>
            <li class="list-group-item"><a class="malle-link" href="<?php echo e(route('promotions')); ?>"><?php echo e(__('New Promotions')); ?></a></li>
            <li class="list-group-item"><a class="malle-link" href="<?php echo e(route('time-tags')); ?>"><?php echo e(__('Time Tags')); ?></a></li>
            <li class="list-group-item"><a class="malle-link" href="<?php echo e(route('preference-tags')); ?>"><?php echo e(__('Preference Tags')); ?></a></li>
            <li class="list-group-item"><a class="malle-link" href="<?php echo e(route('discount-tags')); ?>"><?php echo e(__('Discount Tags')); ?></a></li>
            <li class="list-group-item"><a class="malle-link" href="<?php echo e(route('category-tags')); ?>"><?php echo e(__('Category Tags')); ?></a></li>
            <li class="list-group-item"><a class="malle-link" href="<?php echo e(route('manage.inquiry')); ?>"><?php echo e(__('Manage Inquiry')); ?></a></li>
            <li class="list-group-item"><a class="malle-link" href="<?php echo e(route('manage.shoppers')); ?>"><?php echo e(__('Manage Shoppers')); ?></a></li>
            <li class="list-group-item"><a class="malle-link" href="<?php echo e(route('country')); ?>"><?php echo e(__('Manage Country')); ?></a></li>
        </ul>

    </div>
</div>
<?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/partials/sidebar.blade.php ENDPATH**/ ?>