var app = app || {};
app.Views = app.Views || {};

(function ($) {
    'use strict';

    app.Views.Home = Backbone.View.extend({
        className: 'home',
        template: _.template($('script[name=home]').html()),

        render: function() {
            this.$el.html(this.template());
            return this;
        }
    });

}(jQuery));