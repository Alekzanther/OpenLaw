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

Router.route('/submit', {name: "articleSubmit"});


var requireLogin = function() {  
  if (! Meteor.user()) {
    this.render('submitDenied');  
  } else {
    this.next();
}}

Router.onBeforeAction('dataNotFound', {only: 'articlePage'});
Router.onBeforeAction(requireLogin, {only: 'articleSubmit'});