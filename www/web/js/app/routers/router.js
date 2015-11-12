var app = app || {};

(function () {
    'use strict';

    app.Router = Backbone.Router.extend({
        routes: {
            '': 'homeAction',
            'posts': 'postsAction',
            'posts/:slug': 'postAction'
        },

        initialize: function () {
            //app.instance = new app.Views.App();
        },

        homeAction : function() {
            console.log('homeAction');

            app.instance.go();
        },

        postsAction : function() {
            console.log('postsAction');

            var PostListView = new app.Views.PostList();
            app.instance.go(PostListView);
        },

        postAction: function(slug) {
            console.log('postACtion ' + slug);

            var PostDetailsView = new app.Views.PostDetails({'slug': slug});
            app.instance.go(PostDetailsView);
        }
    });

    app.router = new app.Router();
    Backbone.history.start();
})();