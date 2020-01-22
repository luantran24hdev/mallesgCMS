<?php if($errors->any()): ?>
    <div class="row">
        <div class="col-md-12 mt-4">
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <ul>
                    <?php echo implode('', $errors->all('
                    <li class="error">:message</li>
                    ')); ?>

                </ul>
            </div>
        </div>
    </div>
    
<?php endif; ?>
<?php if(\Illuminate\Support\Facades\Session::has('error')): ?>
    <div class="row">
        <div class="col-md-12 mt-4">
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <?php echo session('error'); ?>

            </div>
        </div>
    </div>
<?php endif; ?>
<?php if(\Illuminate\Support\Facades\Session::has('success')): ?>
    <div class="row">
        <div class="col-md-12 mt-4">
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <?php echo session('success'); ?>

            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/partials/flash_message.blade.php ENDPATH**/ ?>