var app = app || {};

(function ($) {
    'use strict';

    // The Application
    // ---------------

    // Our overall **AppView** is the top-level piece of UI.
    app.AppView = Backbone.View.extend({
        el: 'body',
        initialize: function() {

            /*
            app.Posts.bind('reset', function () {
                app.PostView.render();
            });

            app.Posts.fetch({reset:true});
            */
        }
    });
})(jQuery);