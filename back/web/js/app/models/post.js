var app = app || {};

(function () {
    'use strict';

    // Post Model
    app.Post = Backbone.Model.extend({
        defaults: {
            title: '',
            slug: '',
            summary: '',
            content: '',
            image: '',
            publishedAt: ''
        }
    });
})();