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
        this.bindEvents();
        this.renderAll();
    };

    this.init();
};

$(document).on('app:loaded', function(){
    new HtmlWidgets();
});