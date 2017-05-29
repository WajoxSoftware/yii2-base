var RemoteFormsManager = function() {
    $('.js-remote-form [type="submit"]').on('click touchstart', function(e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        $(this).parents('form').trigger('submit');

        return false;
    });

    $('.js-remote-form').on('submit', function(e) {
        var form = $(this);
        var data = new FormData(form.get(0));

        form.addClass('js-loading');
        form.attr('disabled', true);

        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();

        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response_data, textStatus, jqXHR) {
                form.trigger('reset');
                eval(response_data);
                $('body').trigger('loaded');
                form.removeClass('js-loading');
                form.removeAttr('disabled');
            },
            error: function() {
                form.removeClass('js-loading');
                form.removeAttr('disabled');
            }
        });

        return false;
    });

    $('.js-remote-link').on('click touchstart', function(e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        $.ajax({
            url: $(this).attr('href'),
            method: 'GET',
            success: function(response_data, textStatus, jqXHR) {
                eval(response_data);
                $('body').trigger('loaded');
            }
        });

        return false;
    });
};

$(document).on('app:loaded', function(){
    new RemoteFormsManager();
});