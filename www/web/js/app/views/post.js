var app = app || {};
app.Views = app.Views || {};

(function ($) {
    'use strict';

    app.Views.PostList = Backbone.View.extend({
        className: 'post-list',
        template: _.template($('script[name=post-list]').html()),

        initialize: function() {
        },

        render: function() {
            if (this.$el) {
                this.$el.empty();
            }

            var self = this;

            app.Posts.each(function(post) {
                var view = new app.Views.PostTeaser({model: post});
                self.$el.append(view.el);
            });

            return this;
        }
    });

    app.Views.PostTeaser = Backbone.View.extend({
        className: 'post-teaser',
        template: _.template($('script[name=post-teaser]').html()),

        initialize: function() {
            this.render();
        },

        render: function() {
            this.$el.html(this.template(this.model.toJSON()));
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