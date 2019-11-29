<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="card card-container">
        <img class="img-card-admin" src="<?php echo e(asset('assets/images/logo/malle.png')); ?>">
        <form class="form-admin-login" method="POST" action="<?php echo e(route('login')); ?>" autocomplete="off">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <input type="email" name="email_id" placeholder="Email Address" class="form-control" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" class="form-control" required><!-- 
                <a href="#" class="forgot-password " data-toggle="modal" data-target="#forgotPasswordModal">Forgot Password?</a> -->

            </div>
 
            <div class="form-group pt-4">
                <button type="submit" class="btn btn-block btn-sign-in">Sign in</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/auth/login.blade.php ENDPATH**/ ?>