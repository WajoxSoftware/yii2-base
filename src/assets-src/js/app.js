var RelativeFields = function() {

    this.getContainer = function() {
        return $('.js-relative-fields');
    };

    this.renderItem = function(field, target, condition) {
        if ($(target).length == 0) return;

        if ($(field).val() == condition) {
            $(target).show();
        } else {
            $(target).hide();
        }
    };

    this.render = function() {
        var self = this;

        this.getContainer().find('[data-role="relative-field"]').each(function(){
            var target = $(this).attr('data-target');
            var condition = $(this).attr('data-condition');

            var targets = target.split(';');
            var conditions = condition.split(';');

            if (targets.length == 0
                || conditions.length == 0
                || targets.length != conditions.length
            ) return;

            for (i in targets) {
                $(targets[i]).hide(0);
            }

            for (i in targets) {
                self.renderItem(this, targets[i], conditions[i]);
            }
        });
    };

    this.bindEvents = function() {
        var self = this;
        this.getContainer().find('input, select, button').on('change click', function(e){
            self.render();
        });
    };

    this.render();
    this.bindEvents();
};

var ModalFormSubmitter = function() {
    $('.js-modal-form [type="submit"]').on('click touchstart', function(e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        $(this).parents('.js-modal-form').find('form').trigger('submit');
        return false;
    });
};

var OnChangeFormSubmitter = function() {
    $('form.js-on-change-form input, .js-on-change-form select').on('change', function(e) {
        $(this).parents('form.js-on-change-form').find('form').trigger('submit');
    });
};

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

var ImageUploadForm = function() {
    this.bindEvents = function() {
        var self = this;

        $('form.js-image-upload-form input[type="file"]').on('change', function(e) {
            var file = e.target.files.item(0);
            var reader = new FileReader();
            var form = $(this).parents('form:first');
            reader.onload = function(e) {
                form.find('img').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        });

        $('form.js-image-upload-form .js-select-file').on('click touchstart', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();

            var form = $(this).parents('form:first');
            form.find('input[type="file"]').trigger('click');

            return false;
        });
    };

    this.init = function() {
        this.bindEvents();
    };

    this.init();
};

var HtmlWidgets = function() {
    this.renderGroup = function(group)
    {
        var collapsible = group.find('.js-collapsible[data-expanded]');

        if (collapsible.length == 0) {
            group.find('.js-collapsible').show(0);
            return;
        }
        
        group.find('.js-collapsible').hide(0);
        collapsible.show(0);
    },

    this.render = function(collapsible) {
        var expanded = collapsible.is('[data-expanded]');
        var expandedClass = collapsible.attr('data-expanded-class');
        var group = collapsible.parents('.js-collapsible-group');
    
        if (expanded) {
            collapsible.addClass(expandedClass);
            collapsible.find('.js-toggle-box').show(0);
            collapsible.find('.js-collapsed').hide(0);
            collapsible.find('.js-expanded').show(0);
        } else {
            collapsible.removeClass(expandedClass);
            collapsible.find('.js-toggle-box').hide(0);
            collapsible.find('.js-expanded').hide(0);
            collapsible.find('.js-collapsed').show(0);
        }

        if (group.length == 0) {
            return;
        }

        this.renderGroup(group);
    };

    this.expand = function(collapsible) {
        collapsible.attr('data-expanded', true);

        this.render(collapsible);
    };

    this.collapse = function(collapsible) {
        collapsible.removeAttr('data-expanded');

        this.render(collapsible);
    };

    this.toggle = function(collapsible) {
        var expanded = collapsible.is('[data-expanded]');

        if (expanded) {
            this.collapse(collapsible);
        } else {
            this.expand(collapsible);
        }
    };

    this.renderAll = function() {
        var self = this;

        $('.js-collapsible').each(function() {
            self.render($(this));
        });

        $('.js-collapsible-group').each(function() {
            self.renderGroup($(this));
        });
    };

    this.bindEvents = function() {
        var self = this;

        $('.js-collapsible .js-expand').on('click touchstart', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();

            var collapsible = $(this).parents('.js-collapsible');

            self.expand(collapsible);

            return self;
        });

        $('.js-collapsible .js-collapse').on('click touchstart', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();

            var collapsible = $(this).parents('.js-collapsible');

            self.collapse(collapsible);

            return false;
        });

        $('.js-collapsible .js-toggle').on('click touchstart', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();

            var collapsible = $(this).parents('.js-collapsible');

            self.toggle(collapsible);


            return false;
        });
    };


    this.init = function() {
        // $('table.table').stacktable();
        $(function() { $.material.init(); });
        this.bindEvents();
        this.renderAll();
    };

    this.init();
};


window.App = {
    initHtmlWidgets: function() {
        new HtmlWidgets();
    },

    initModalFormSubmitter: function() {
        new ModalFormSubmitter();
    },

    initImageUploadForm: function() {
        new ImageUploadForm();
    },

    initRelativeFields: function() {
        new RelativeFields();
    },

    initRemoteForms: function() {
        new RemoteFormsManager();
    },

    initOnChangeFormSubmitter: function() {
        new OnChangeFormSubmitter();
    },

    initLoginModal: function() {
        /*
        $('.js-login-button').on('click touchstart', function(e) {
            e.preventDefault();

            $('#login_modal .js-sign-in, #login_modal  .js-sign-up').hide(0);
            if ($(this).attr('data-form') == 'sign-in') {
                $('#login_modal .js-sign-in').show(0);
            } else {
                $('#login_modal  .js-sign-up').show(0);
            }

            $('#login_modal').modal().show(0);
        });

        $('#login_modal .js-sign-in-button').on('click touchstart', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();

            $('#login_modal  .js-sign-up').hide(0);
            $('#login_modal  .js-sign-in').show(0);

            return false;
        });

        $('#login_modal .js-sign-up-button').on('click touchstart', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();

            $('#login_modal  .js-sign-in').hide(0);
            $('#login_modal  .js-sign-up').show(0);

            return false;
        });*/
    },


    init: function() {
        //bind events
        //init all components
        this.initHtmlWidgets();
        this.initModalFormSubmitter();
        this.initOnChangeFormSubmitter();
        this.initImageUploadForm();
        this.initRemoteForms();
        this.initLoginModal();
        this.initRelativeFields();
    },


    bindEvents: function() {
        var self = this;
        
        /*$(document).on('pjax:success', '[data-pjax-container]', function(e, data){

            console.log(data);
            console.log(e);

            $(data).find('script').each(function() {
                console.log(this.html());
                eval(this.html());
            });

            $('body').trigger('loaded');
        });*/

        $(document).on('loaded', 'body', function() {
            self.init();
        });
    },

    run: function() {
        this.bindEvents();
        this.init();
        //$('body').trigger('loaded');
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

        $(modal_id).modal('show');

        $(modal_id).find('script').each(function() {
            eval(this.html());
        });

        $('body').trigger('loaded');
    },

    hideModal: function(content) {
        var modal = $(content);
        var modal_id = '#' + modal.attr('id');

        $(modal_id).modal('hide');
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
    window.App.run();
    
    $('#wrapper-loading').hide(0);
    $('#wrapper').show(0);
});
