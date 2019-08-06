

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

// autocomplete
var jcomplete = function(element){
    var targetid = $(element).attr('jautocom-targetid');
    var redirecturl = $(element).attr('jautocom-redirecturl');
    $( element ).autocomplete({
        source: function (request, response) {
            $.getJSON($(element).attr('jautocom-sourceurl') +'/' + request.term, function (data) {
                response($.map(data, function (value, key) {
                    return {
                        label: value,
                        value: key
                    };
                }));
            });
        },
          select: function(event, ui) {
            $(element).val(ui.item.label); 
                //this will determin the call back of autocomplete
                if(typeof redirecturl !== typeof undefined && redirecturl !== false){
                    window.location.href = $(element).attr('jautocom-redirecturl')+ui.item.value;
                }else if(typeof targetid !== typeof undefined && targetid !== false){
                    $($(element).attr('jautocom-targetid')).val(ui.item.value); 
                }
            return false;
          }
    });
}