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
            app.Posts.on('reset', function () {
                Backbone.history.start();

                _.delay(function() {
                    $('body').addClass('loaded');

                }, 1000);
            });
            app.Posts.fetch({reset: true});
        },

        homeAction : function() {
            var HomeView = new app.Views.Home();
            app.instance.goToPage(HomeView);
        },

        postsAction : function() {
            var PostListView = new app.Views.PostList();
            app.instance.goToPage(PostListView);
        },

        postAction: function(slug) {
            var PostDetailsView = new app.Views.PostDetails({'slug': slug});
            app.instance.goToPage(PostDetailsView);
        }
    });

    app.router = new app.Router();

    /**
     * Smooth scrolling & ensure menu anchor heads to homepage before scrolling
     */
    $('body').delegate('a[href*=#]:not([href=#]):not([href^="#/"])', 'click', (function() {

        // first navigate to home if we are not already on it
        if (!$('#page > div').hasClass('home')) {
            app.router.navigate('#/', {trigger: true});
        }

        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') || location.hostname == this.hostname) {

            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top
                }, 1000);
                return false;
            }
        }
    });
})();