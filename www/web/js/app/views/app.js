var app = app || {};
app.Views = app.Views || {};

(function ($) {
    'use strict';

    app.Views.App = Backbone.View.extend({
        el: '#page',
        currentPage: null,

        initialize: function() {
        },

        goToPage: function (view) {

            var previous = this.currentPage || null;
            var next = view;

            if (previous) {
                previous.$el.removeClass('isVisible');

                var self = this;
                _.delay(function() {
                    // transitionEnd event does not always trigger
                    previous.remove();
                    next.render();
                    self.$el.append( next.$el );
                    next.$el.addClass('isVisible');
                    self.currentPage = next;

                }, 500); // match delay with the animation delay
            }
            else {
                // do it immediately
                next.render();
                this.$el.append( next.$el );
                next.$el.addClass('isVisible');
                this.currentPage = next;
            }

        }
    });

    app.instance = new app.Views.App();
})(jQuery);