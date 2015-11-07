var app = app || {};

(function ($) {
    'use strict';

    // The Application
    // ---------------

    // Our overall **AppView** is the top-level piece of UI.
    app.AppView = Backbone.View.extend({
        el: '#post-promoted',

        template: _.template($('#post-promoted-item-template').html()),

        /**
         * Initialize
         */
        initialize: function() {
            // Once posts are fetched fill in the teaser section with latest promoted
            app.Posts.on('reset', this.addPromotedPosts, this);

            app.Posts.fetch({reset: true});

            this.render();
        },

        /**
         * Get latest posts and promote them on homepage
         */
        addPromotedPosts: function() {
            // list of post is ordered by date desc, so lasts are firsts
            var lastPosts = app.Posts.first(3);
            this.$el.html('');
            _.each(lastPosts, this.addSinglePromotedPost, this);
        },

        /**
         * Render a single post and append it to $el
         * @param post
         */
        addSinglePromotedPost: function(post) {
            var view = new app.PromotedPostView({model: post});
            this.$el.append(view.render().el);
        }
    });

})(jQuery);