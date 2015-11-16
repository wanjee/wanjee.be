var app = app || {};
app.Views = app.Views || {};

(function ($) {
    'use strict';

    app.Views.PostList = Backbone.View.extend({
        className: 'post-list',
        template: _.template($('script[name=post-list]').html()),

        initialize: function() {
            app.Posts.fetch({reset: true});
        },

        render: function() {
            this.$el.html(this.template());
            return this;
        }

    });

    app.Views.PostTeaser = Backbone.View.extend({
        className: 'post-teaser',
        template: _.template($('script[name=post-teaser]').html()),

        render: function() {
            this.$el.html(this.template());
            return this;
        }

    });

    app.Views.PostDetails = Backbone.View.extend({
        className: 'post-details',
        template: _.template($('script[name=post-details]').html()),

        initialize: function (options) {
    /*
            var self = this;
            this.options = options || {};
            this.post = new app.Post({ 'slug': this.options.slug});
            this.post.slug = this.options.slug;
            this.post.fetch({
                success: function() {
                    self.render();
                }
            });
            */
            //console.log(this.post);
        },

        render: function() {
            this.$el.html(this.template());
            return this;
        }
    });

}(jQuery));