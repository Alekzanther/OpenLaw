Router.configure({
  layoutTemplate: 'layout',
  loadingTemplate: 'loading',
  notFoundTemplate: 'notFound',
  waitOn: function() { return Meteor.subscribe('articles'); }

});

Router.route('/', {name: 'articlesList'});
Router.route('/articles/:_id', {
  name: 'articlePage',
  data: function() { return Articles.findOne(this.params._id); }
});

Router.onBeforeAction('dataNotFound', {only: 'articlePage'});