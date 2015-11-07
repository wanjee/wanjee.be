var app = app || {};

(function () {
    'use strict';

    var Router = Backbone.Router.extend({
        routes: {
            '' : 'homeAction',
            'posts' : 'postsAction',
            'posts/:slug' : 'postAction',

            homeAction : function() {
                /*
                app.Posts.fetch();

                $('body').html(new PostListView({collection: app.Posts}).render().el)
                */
                console.log('homeAction');
            },

            postsAction : function() {
                /*
                app.Posts.fetch();
                */

                console.log('postsAction');

            }
        }
    });

    app.Router = new Router();
    Backbone.history.start();
})();