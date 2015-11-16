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
    Backbone.history.start();

    /**
     * Smooth scrolling & ensure menu anchor heads to homepage before scrolling
     */
    $('a[href*=#]:not([href=#]):not([href^="#/"])').click(function() {

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