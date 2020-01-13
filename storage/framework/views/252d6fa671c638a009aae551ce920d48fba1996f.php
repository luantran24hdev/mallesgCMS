<?php $__env->startSection('content'); ?>
    <div class="row">

        <div class="col-md-10">
            <div class="card card-malle">
                <div class="card-header-malle">
                  <?php echo e(@$mall->mall_name); ?> Events

                    <a href="<?php echo e(route('malls')); ?>">
                    <span class="link_color" style="float: right">
                        Back
                    </span>
                    </a>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('mall-events.store')); ?>" id="addEvents">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="event_name" placeholder="Event Name" id="event_name"
                                   class="form-control" required="" list="datalist1" data-autocompleturl="">
                            <input type="hidden" name="mall_id" value="<?php echo e($mall->mall_id); ?>">
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="out-form">Update</button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="checkbox" name="no_events" class="no_events" data-href="<?php echo e(route('malls.column-update',[$mall->mall_id])); ?>" data-method="POST" <?php if($mall->no_events == 'Y'): ?> checked <?php endif; ?>> No Events
                            </div>
                        </div>


                    </div>

                    </form>
                    <div class="row">
                        <div class="col-md-2">
                           Show:
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <button class="btn btn-primary" id="all">All</button>
                                <button class="btn btn-light" id="current"><?php echo e(\App\EventMaster::C); ?></button>
                                <button class="btn btn-light" id="past"><?php echo e(\App\EventMaster::P); ?></button>
                                <button class="btn btn-light" id="upcoming"><?php echo e(\App\EventMaster::U); ?></button>
                            </div>
                        </div>

                    </div>
                    <?php if(isset($events)): ?>
                        <br/>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped malle-table" id="event-table"
                                       data-sourceurl="<?php echo e(route('mall-events',['id'=>$mall->mall_id])); ?>">
                                    <thead>
                                    <th>Event Name</th>
                                    <th>Mall Name</th>
                                    <th style="display: none">Type</th>
                                    <th>Event Type</th>
                                    <th>Featured</th>
                                    <th>Created By</th>
                                    <th>Action</th>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="row-location" data-id="<?php echo e(@$event->event_id); ?>">
                                        <td><?php echo e(@$event->event_name); ?></td>
                                        <td><?php echo e(@$event->mall->mall_name); ?></td>
                                        <td style="display: none"><?php echo e(@$event->type); ?></td>
                                        <td>
                                            <select name="type" id="" class="events_column_update dd-orange" data-href="<?php echo e(route('events.column-update',[$event->event_id])); ?>" data-method="POST">
                                                <option value="P" <?php if($event->type=='P'): ?> selected <?php endif; ?>><?php echo e(\App\EventMaster::P); ?></option>
                                                <option value="C" <?php if($event->type=='C'): ?> selected <?php endif; ?>><?php echo e(\App\EventMaster::C); ?></option>
                                                <option value="U" <?php if($event->type=='U'): ?> selected <?php endif; ?>><?php echo e(\App\EventMaster::U); ?></option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="featured" id="" class="events_column_update dd-orange" data-href="<?php echo e(route('events.column-update',[$event->event_id])); ?>" data-method="POST">
                                                <option value="N" <?php if($event->featured=='N'): ?> selected <?php endif; ?>>No</option>
                                                <option value="Y" <?php if($event->featured=='Y'): ?> selected <?php endif; ?>>Yes</option>
                                            </select>
                                        </td>
                                        <td><?php echo e(\App\User::getUserName($event->user_id)); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('mall-events.edit',[$event->event_id])); ?>"><span class="text-info">Edit</span></a>
                                            |
                                            <a href="javascript:;"
                                               data-href="<?php echo e(route('mall-events.destroy',[$event->event_id])); ?>"
                                               data-method="DELETE" class="btn-delete"
                                               data-id="<?php echo e($event->event_id); ?>">
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

        $(document).on('submit','#addEvents', function(e){
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
                        $("#event-table").load( $('#event-table').attr('data-sourceurl') +" #event-table");
                        toastr.success(data.message);
                    }
                },
                error: function(data){
                    exeptionReturn(data);
                }
            });
        });

        $(document).ready(function() {
            var dataTables =  $('#event-table').DataTable({
                    responsive: true,
                    aaSorting: [],
                    paging: false,
                   // "scrollX": true
                }
            );

            $('#current').on('click',function () {
                dataTables.columns(2).search("C").draw();
            });
            $('#past').on('click',function () {
                dataTables.columns(2).search("P").draw();
            });
            $('#upcoming').on('click',function () {
                dataTables.columns(2).search("U").draw();
            });
            $('#all').on('click',function () {
                dataTables.columns(2).search("").draw();
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


        $( "#tag_name" ).autocomplete({
            source: function (request, response) {
                $.getJSON($("#tag_name").attr('data-autocompleturl') +'/' + request.term, function (data) {
                    response($.map(data, function (value, key) {
                        return {
                            label: value,
                            value: key
                        };
                    }));
                });
            },
            select: function(event, ui) {
                $("#tag_name").val(ui.item.label);
                $("#tag_id").val(ui.item.value);
               // window.location.href = '<?php echo e(route("malls")); ?>/'+ui.item.value;
                return false;
            }
        });

        // change promo outlate live, featured and redeem status
        $(document).on('change', '.events_column_update', function(e){

            //alert('sdsds');
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


        $(document).on('change', '.no_events', function(e){

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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/event/index.blade.php ENDPATH**/ ?>