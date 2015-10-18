var app = app || {};

(function () {
    'use strict';

    var Posts = Backbone.Collection.extend({
        // Reference to this collection's model.
        model: app.Post,

        // FIXME Move domain declaration to a better place
        url: 'http://back.shuwee.dev/app_dev.php/posts'
    });

    // Create our global collection of Posts.
    app.Posts = new Posts();
})();