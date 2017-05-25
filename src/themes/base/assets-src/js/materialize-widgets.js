var MaterializeWidgets = function() {
    if (typeof($.material_select) != undefined) {
        $('select:not([data-krajee-select2])').material_select();
    }
    
    if (typeof($.sideNav) != undefined) {
        $("#sidebar-button").sideNav();
    }

    if (typeof($.tooltip) != undefined) {
        $('.tooltipped').tooltip({delay: 50});
    }

    if (typeof($.tabs) != undefined) {
        $('ul.tabs').tabs();
    }

    if (typeof($.modal) != undefined) {
        $('.modal').modal();
    }

    if (typeof($.pickadate) != undefined) {
        $('.datepicker').each(function(){
            $(this).pickadate(
                JSON.parse(
                    decodeURIComponent(
                        $(this).attr('data-datepicker-settings')
                    )
                )
            ); 
        });
    }
}

$(function(){
    new MaterializeWidgets();
});
