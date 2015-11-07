var app = app || {};

(function () {
    'use strict';

    var Posts = Backbone.Collection.extend({
        // Reference to this collection's model.
        model: app.Post,

        // FIXME Move domain declaration to a better place
        url: 'http://shuwee.dev/app_dev.php/posts',

        /**
         * As we have a nested response to protect against JSON Hijacking we need
         * to add special sauce here in order to properly retrieve posts from the response.
         */
        parse: function (response){

            var posts = response.posts;

            // Convert the "posts" object to an array and return
            // the resulting array

            return _.map(posts, function (value, key) {
                return posts[key];
            });
        }
    });

    // Create our global collection of Posts.
    app.Posts = new Posts();
})();