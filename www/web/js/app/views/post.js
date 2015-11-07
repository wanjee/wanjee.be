var app = app || {};

(function ($) {
    'use strict';

    app.PromotedPostView = Backbone.View.extend({
        tagname: 'li',
        template: _.template($('#post-promoted-item-template').html()),

        render: function() {
            this.$el.html(this.template(this.model.toJSON()));
            return this;
        }
    });

    app.SinglePostView = Backbone.View.extend({
        tagname: 'li',
        render: function() {
            $this.$el.html(this.model.get('title'));
            return this;
        }


    });

}(jQuery));