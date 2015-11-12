var app = app || {};
app.Views = app.Views || {};

(function ($) {
    'use strict';

    app.Views.App = Backbone.View.extend({
        el: '#page-secondary',

        /**
         * Initialize
         */
        initialize: function() {
            // Once posts are fetched fill in the teaser section with latest promoted

        },

        go: function(view) {
            var previous = this.currentPage || null;
            var next = view || null;

            if (previous) {
                console.log('remove previous');
                previous.remove();
                /*
                previous.transitionOut(function () {
                    previous.remove();
                });*/
            }

            if (next) {
                console.log('render next');
                next.render({ page: true });
                this.$el.append( next.$el );
                //next.transitionIn();
            }

            this.currentPage = next;
        }
    });

    app.instance = new app.Views.App();
})(jQuery);