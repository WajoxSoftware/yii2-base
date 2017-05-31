window.App = {
    init: function() {
        return;
    },

    bindEvents: function() {
        var self = this;
        
        $(document).on('app:loaded', function() {
            self.init();
        });
    },

    run: function() {
        this.bindEvents();
        
        $(document).trigger('app:loaded');
    },

    //utilites
    alert: function(type, content) {
        alert(content);
    },

    showModal: function(content) {
        var modal = $(content);
        var modal_id = '#' + modal.attr('id');

        if ($(modal_id).length > 0) {
            $(modal_id).html(modal.html());
        } else {
            $('body').append(modal);
        }

        if ($(modal_id).is(':visible')) {
            return;
        }

        $(modal_id).modal();
        $(modal_id).modal('open');

        $(modal_id).find('script').each(function() {
            eval(this.html());
        });

        $(document).trigger('app:loaded');
    },

    hideModal: function(content) {
        var modal = $(content);
        var modal_id = '#' + modal.attr('id');

        $(modal_id).modal('close');
    },

    importAssets: function(content) {
        var $content = $(content);
        $('body').append($content);
    },

    redirect: function(url) {
        window.location.href = url;
    },

    reload: function() {
        //$.pjax.reload('[data-pjax-container]');
        window.location.reload();
    }

};

$(document).ready(function() {
    $('[data-page-loading="true"]').addClass('hidden');
    $('[data-page-loaded="true"]').removeClass('hidden');

    window.App.run();
});
