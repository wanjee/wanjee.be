var app = app || {};
console.log(app);
(function ($) {
    'use strict';

    app.PostListView = Backbone.View.extend({
        tagname: 'ul',
        render: function() {
            _(this.collection).each(function(post) {
               this.$el.append(new SinglePostView({model: post}.render().el))
            });
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