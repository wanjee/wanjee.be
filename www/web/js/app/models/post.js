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
        },
        urlRoot: '/posts',

        initialize: function(options) {
            //this.slug = options.slug;
        },

        fetchBySlug: function(){
            this.fetch(/*{ data: $.param({ slug: this.slug }) }*/)
        }

    });
})();