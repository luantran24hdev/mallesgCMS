

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

toastr.options.showEasing = 'swing';
toastr.options.progressBar = true;

var exeptionReturn = function(data){ 
    bootbox.alert({
        title: 'Error: Please Report to Admin!',
        message: data.responseJSON.message,
        className: 'rubberBand animated'
    });
}

var errorReturn = function(data){ 
    bootbox.alert({
        title: 'Error',
        message: data.message,
        className: 'rubberBand animated'
    });
}