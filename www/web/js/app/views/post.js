var app = app || {};
app.Views = app.Views || {};

(function ($) {
    'use strict';

    app.Views.PostList = Backbone.View.extend({
        classname: 'post-list',
        template: _.template($('script[name=post-list]').html()),

        /*
        initialize: function() {
            app.Posts.fetch({reset: true});

            this.render();
        },
        */

        render: function() {
            this.$el.html('PostList');
            return this;
        }

    });

    app.Views.PostTeaser = Backbone.View.extend({
        classname: 'post-teaser',
        template: _.template($('script[name=post-teaser]').html()),

        render: function() {
            this.$el.html('PostTeaser');
            return this;
        }

    });

    app.Views.PostDetails = Backbone.View.extend({
        classname: 'post-details',
        template: _.template($('script[name=post-details]').html()),

        initialize: function() {

            this.render();
        },

        render: function() {
            this.$el.html('PostDetails');
            return this;
        }
    });

}(jQuery));