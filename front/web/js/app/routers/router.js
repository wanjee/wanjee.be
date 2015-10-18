var app = app || {};

(function () {
    'use strict';

    var Router = Backbone.Router.extend({
        routes: {
            '' : 'home',
            'posts' : 'posts',
            'posts/:slug' : 'post',

            home : function() {
                app.Posts.fetch();

                //$('body').html(new PostListView({collection: app.Posts}).render().el)
            }
        }
    });

    app.Router = new Router();
    Backbone.history.start();
})();