<style>
    .mall_out .select2-container--default .select2-selection--single .select2-selection__arrow{
        top: 5px !important;
    }
    .mall_out .select2-container .select2-selection--single {
        height: 38px !important;
    }

    .mall_out .select2-container--default .select2-selection--single .select2-selection__rendered{
        line-height: 35px;
    }

</style>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-10">
        <div class="card card-malle">

            <?php echo $__env->make('main.mall_list.mall_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="card-body">

            <form method="POST" action="<?php echo e(route('malls.store')); ?>" id="InsertMalls">

                <div class="row mall_out">
                    <div class="col-md-3">
                        <label class="mb-2 font-12">Mall Name</label>
                        <input type="text" name="mall_name" placeholder="Enter Mall Name" id="mall_name" class="form-control" required="" list="datalist1" data-autocompleturl="<?php echo e(route('malls.search')); ?>" value="<?php echo e(@$current_malls->mall_name); ?>">

                    </div>
                    <?php if(!isset($id)): ?>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="mb-2 font-12"><?php echo e(__('Country')); ?></label>
                                <br>
                                <select id="country_select">
                                    <?php if(!empty($countrys)): ?>
                                        <?php $__currentLoopData = $countrys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $country_total = \App\CountryMaster::totalCountryMall($country->country_id);?>
                                            <option value="<?php echo e($country->country_id); ?>" title="<?php echo e($country->country_name); ?>"><?php echo e($country->country_name); ?> (<?php echo e($country_total); ?>)</option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="mb-2 font-12"><?php echo e(__('City')); ?></label>
                                <br>
                                <select id="city_control" class="form-control">
                                    <?php $country_total = \App\CountryMaster::totalCountryMall(1);?>
                                        <option value="<?php echo e(@$citymaster->city_id); ?>" title="<?php echo e(@$citymaster->city_name); ?>"><?php echo e(@$citymaster->city_name); ?> (<?php echo e($country_total); ?>)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="mb-2 font-12"><?php echo e(__('Town')); ?></label>
                                <br>
                                <select id="town_control" class="form-control">

                                    <?php if(!empty($townmasters)): ?>
                                        <option value="all">All (<?php echo e($country_total = \App\CountryMaster::totalCountryMall(1)); ?>)</option>
                                        <?php $__currentLoopData = $townmasters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $townmaster): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $town_total = \App\TownMaster::totalTownMall(1,$townmaster->city_id,$townmaster->town_id);?>
                                            <option value="<?php echo e(@$townmaster->town_id); ?>" title="<?php echo e(@$townmaster->town_name); ?>"><?php echo e(@$townmaster->town_name); ?> (<?php echo e($town_total); ?>)</option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="mb-2 font-12"><?php echo e(__('Mall Type')); ?></label>
                                <select id="mall_type">
                                    <?php if(!empty($mall_types)): ?>
                                        <option value="all">All (<?php echo e($country_total = \App\CountryMaster::totalCountryMall(1)); ?>)</option>
                                        <?php $__currentLoopData = $mall_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mall_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $type_total = \App\MallType::totalTypeMall($mall_type->country_id,$mall_type->city_id,$mall_type->mt_id);?>
                                            <option value="<?php echo e($mall_type->malltype->type_name); ?>"><?php echo e($mall_type->malltype->type_name); ?> (<?php echo e($type_total); ?>)</option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-12 row insert_mall" style="display: none;">
                    <div class="form-group">
                        <button class="btn btn-primary" id="out-form">Update</button>
                    </div>
                </div>
             </form>

            <?php if(isset($current_mallss)): ?>
            <br />
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped malle-table" id="mall-list-table" <?php if(isset($id)): ?>  data-sourceurl="<?php echo e(route('merchants.show',['merchant'=>@$id])); ?>" <?php else: ?> data-sourceurl="<?php echo e(route('malls')); ?>" <?php endif; ?> >
                        <thead>
                        <th>Mall Name</th>
                        <th>Town</th>
                        <th>City</th>
                        <th>Country</th>
                        <th>Type</th>
                        <th>Beta</th>
                        <th>Active</th>
                        <th>Featured</th>
                        <th>Merchant</th>
                        <th>Events</th>
                        <th>Promos</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $current_mallss; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $current_malls): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="row-location" data-id="<?php echo e($current_malls->mall_id); ?>">
                                <td><?php echo e(@$current_malls->mall_name); ?>

                                    <br><br><span class="link_color"><a href="<?php echo e(route('malls.edit',[$current_malls->mall_id])); ?>"><b>Mall Info</b> </a></span>
                                </td>
                                <td><?php echo e(@$current_malls->town->town_name); ?>

                                    <br><br><span class="link_color"><a href="<?php echo e(route('malls.images',['malls'=>$current_malls->mall_id])); ?>"><b>Images</b> </a></span>
                                </td>
                                <td><?php echo e(@$current_malls->city->city_name); ?>

                                    <br><br><span class="link_color"><a href="<?php echo e(route('mall-events',['id'=>$current_malls->mall_id])); ?>"><b>Events</b> </a></span>
                                </td>
                                <td><?php echo e(@$current_malls->country->country_name); ?>

                                    <br><br> <span class="link_color"><a href="<?php echo e(route('mall-parking.edit',[$current_malls->mall_id])); ?>"> <b> Parking Info</b> </a></span>
                                </td>
                                <td><?php echo e(@$current_malls->malltype->type_name); ?>

                                    <br><br><span class="link_color"><a href="<?php echo e(route('mall-offers',['id'=>$current_malls->mall_id])); ?>"> <b>Offers</b> </a></span>
                                </td>
                                <td>
                                    <span style="display: none"> <?php echo e($current_malls->beta); ?> </span>
                                    <select name="beta" id="" class="malls_column_update dd-orange" data-href="<?php echo e(route('malls.column-update',[$current_malls->mall_id])); ?>" data-method="POST">
                                        <option value="N" <?php if($current_malls->beta=='N'): ?> selected <?php endif; ?>>No</option>
                                        <option value="Y" <?php if($current_malls->beta=='Y'): ?> selected <?php endif; ?>>Yes</option>

                                    </select>
                                </td>
                                <td>
                                    <select name="mall_active" id="" class="malls_column_update dd-orange" data-href="<?php echo e(route('malls.column-update',[$current_malls->mall_id])); ?>" data-method="POST">
                                        <option value="N" <?php if($current_malls->mall_active=='N'): ?> selected <?php endif; ?>>No</option>
                                        <option value="Y" <?php if($current_malls->mall_active=='Y'): ?> selected <?php endif; ?>>Yes</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="featured" id="" class="malls_column_update dd-orange" data-href="<?php echo e(route('malls.column-update',[$current_malls->mall_id])); ?>" data-method="POST">
                                        <option value="N" <?php if($current_malls->featured=='N'): ?> selected <?php endif; ?>>No</option>
                                        <option value="Y" <?php if($current_malls->featured=='Y'): ?> selected <?php endif; ?>>Yes</option>
                                    </select>
                                </td>

                                <?php $total_merchant = \App\MallMaster::total_merchant($current_malls->mall_id) ?>
                                <td><?php if($total_merchant > 0): ?>
                                        <a href="<?php echo e(route('mall.merchant.info',[$current_malls->mall_id])); ?>"><span style="color: blue"><b> <?php echo e(@$total_merchant); ?></b></span></a>
                                    <?php else: ?>
                                        <?php echo e(@$total_merchant); ?>

                                    <?php endif; ?>
                                </td>
                                <td> <?php echo e(@$total_event = \App\MallMaster::total_event($current_malls->mall_id)); ?></td>
                                <td> <?php echo e(@$total_promos = \App\MallMaster::total_promos($current_malls->mall_id)); ?></td>
                                <td>

                                    <a  href="javascript:;" data-href="<?php echo e(route('malls.destroy',['malls'=>$current_malls->mall_id])); ?>" data-method="DELETE" class="btn-delete" data-id="<?php echo e($current_malls->mall_id); ?>">
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


    $(document).on('submit','#InsertMalls', function(e){
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
                    //$("#event-table").load( $('#event-table').attr('data-sourceurl') +" #event-table");
                    $("#mall-list-table").load( $('#mall-list-table').attr('data-sourceurl') +" #mall-list-table");
                    toastr.success(data.message);
                }
            },
            error: function(data){
                exeptionReturn(data);
            }
        });
    });

    $(document).ready(function() {
        var dataTables =  $('#mall-list-table').DataTable({
                responsive: true,
                aaSorting: [],
                paging: false,
                "scrollX": true
            }
        );

        '<?php if(!isset($id)) { ?>'
            dataTables.columns(3).search("Singapore").draw();
        '<?php } ?>'

        $('#country_select').on('select2:select', function (e) {

            var val = e.params.data.title;
            var id= e.params.data.id;

            //console.log(val);
            dataTables.columns(3).search(val).draw();
            dataTables.columns(2).search("").draw();
            dataTables.columns(1).search("").draw();
            dataTables.columns(4).search("").draw();

           $.ajax({
                url: '<?php echo e(route('malls.getcity')); ?>',
                type: 'POST',
                dataType:'json',
               data : {'id':id},
                success:function(data){
                    // /console.log(data);
                    $('#city_control').html(data.city);
                }
            });

            $.ajax({
                url: '<?php echo e(route('malls.getTown')); ?>',
                type: 'POST',
                dataType:'json',
                data : {'id':id},
                success:function(data){
                    // /console.log(data);
                    $('#town_control').html(data.town);
                }
            });

            var country_id = $("#country_select").val();
            $.ajax({
                url: '<?php echo e(route('malls.getType')); ?>',
                type: 'POST',
                dataType:'json',
                data : {'country_id':country_id},
                success:function(data){
                    //console.log(data);
                    $('#mall_type').html(data.city);
                    //dataTables.ajax.reload();
                }
            });

            // /dataTables.ajax.reload();

        });

        $('#city_control').on('select2:select', function (e) {
            //console.log('city');
            var val = e.params.data.title;



            if(val=='all'){
                dataTables.columns(2).search("").draw();
            }else{
                dataTables.columns(2).search(val).draw();
            }
            var country_id = $("#country_select").val();
            var city_id = $("#city_control").val();

            $.ajax({
                url: '<?php echo e(route('malls.getType')); ?>',
                type: 'POST',
                dataType:'json',
                data : {'country_id':country_id,city_id:city_id},
                success:function(data){
                    //console.log(data);
                    $('#mall_type').html(data.city);
                }
            });

            $.ajax({
                url: '<?php echo e(route('malls.getTown')); ?>',
                type: 'POST',
                dataType:'json',
                data : {'id':country_id,city_id:city_id},
                success:function(data){
                    // /console.log(data);
                    $('#town_control').html(data.town);
                }
            });


        });

        $('#mall_type').on('select2:select', function (e) {
            // $("#time_dow_id").val(e.params.data.id);
            var val = e.params.data.id;
            //console.log(e.params.data.text);
            if(val=='all'){
                dataTables.columns(4).search("").draw();
            }else{
                dataTables.columns(4).search(val).draw();
            }
        });

        $('#town_control').on('select2:select', function (e) {
            // $("#time_dow_id").val(e.params.data.id);
            var val = e.params.data.title;
            //console.log(e.params.data.text);
            if(val=='all'){
                dataTables.columns(1).search("").draw();
            }else{
                dataTables.columns(1).search(val).draw();
            }
        });


    });

  $( function() {

      //$('#country_select').val('');
      $('#country_select,#mall_type,#city_control,#town_control').select2({
          width:130
      });

    $("#start_date").datepicker({dateFormat: 'dd/mm/yy'});
            $("#end_date").datepicker({dateFormat: 'dd/mm/yy'});

    // malls

    // malls
    $( "#mall_name" ).autocomplete({
        source: function (request, response) {
            $.getJSON($("#mall_name").attr('data-autocompleturl') +'/' + request.term, function (data) {
                if(data.length == 0){
                    $('.insert_mall').show();
                }else{
                    $('.insert_mall').hide();
                }
                response($.map(data, function (value, key) {
                    return {
                        label: value,
                        value: key
                    };
                }));
            });
        },
          select: function(event, ui) {
             $("#mall_name").val(ui.item.label);
             $("#mall_id").val(ui.item.value);
              window.location.href = '<?php echo e(route("malls")); ?>/'+ui.item.value;
             return false;
          }
    });

    // store
    $(document).on('submit','#frm-add-location', function(e){
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
                    alert(data.message);
                }else{
                    $('#location-table tbody').remove();
                    $("#location-table").load( $('#location-table').attr('data-sourceurl') +" #location-table tbody");
                    toastr.success("Successfully Added!");
                }
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
                        window.location.href = '<?php echo e(route('malls')); ?>';
                    }
                }
            });

        });
    });




      // change promo outlate live, featured and redeem status
      $(document).on('change', '.malls_column_update', function(e){
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
                      //$('#merchant-list-table tbody').remove();
                      //$("#merchant-list-table").load( $('#merchant-list-table').attr('data-sourceurl') +" #merchant-list-table");
                      toastr.success(data.message);
                  }
              },
              error: function(data){
                  console.log(data);
                  exeptionReturn(data);
              }
          });

      });


  });
  </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\adminlaravel3\resources\views/main/mall_list/index.blade.php ENDPATH**/ ?>