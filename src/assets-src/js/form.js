var OnChangeFormSubmitter = function() {
    $('form.js-on-change-form input, .js-on-change-form select').on('change', function(e) {
        $(this).parents('form.js-on-change-form').find('form').trigger('submit');
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

$(document).on('app:loaded', function(){
    new OnChangeFormSubmitter();
    new ModalFormSubmitter();
    new ImageUploadForm();
    new RelativeFields(); 
});
