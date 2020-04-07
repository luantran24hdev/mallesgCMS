
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />

    <title>Mall-E - Admin2</title>

    <link href="<?php echo e(asset('images/logo/malle.png')); ?>" rel="icon" type="image">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" >
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />


    <link href="<?php echo e(asset('css/toastr.min.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('fontawesome/css/all.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('css/dropzone.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('css/jqueryui.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('css/malle_style.css')); ?>" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .link_color{
            color: blue;
        }
    </style>

    <?php echo $__env->yieldContent('style'); ?>

</head>

<body class="dashboard-body">
    <div id="app">
        <nav class="navbar navbar-light bg-malle">
            <div class="container">
                <a class="navbar-brand text-light" href="<?php echo e(route('home')); ?>">
                    <img src="<?php echo e(asset('images/logo/rec.png')); ?>" width="110" height="50" class="d-inline-block align-top" alt="">
                    | <?php echo e(__('Admin Dashboard')); ?>

                </a>
                <a class="my-2 btn-logout btn btn-danger bg-red" href="<?php echo e(route('logout')); ?>"><?php echo e(__('Logout')); ?></a>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <?php echo $__env->make('partials.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>

        </div>
    </div>
</body>

<script type="text/javascript" src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>

<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>


<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="<?php echo e(asset('js/toastr.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/popper.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/bootbox.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/bootbox.locales.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('js/defaults.js')); ?>"></script>
<?php echo $__env->yieldContent('script'); ?>
</html>
<?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/layouts/app.blade.php ENDPATH**/ ?>