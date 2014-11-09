Router.configure({
  layoutTemplate: 'layout',
  loadingTemplate: 'loading',
  notFoundTemplate: 'notFound',
  waitOn: function() { 
    return Meteor.subscribe('articles'); 
  }

});

Router.route('/', {name: 'articlesList'});

Router.route('/articles/:_id', {
  name: 'articlePage',
  waitOn: function() {
      return Meteor.subscribe('comments', this.params._id);
  },
  data: function() { return Articles.findOne(this.params._id); }
});

Router.route('/submit', {name: "articleSubmit"});


Router.route('/articles/:_id/edit', {  
  name: 'articleEdit',  
  data: function() { return Articles.findOne(this.params._id); }
});

var requireLogin = function() {  
  if (! Meteor.user()) {
        if (Meteor.loggingIn()) {      
          this.render(this.loadingTemplate);    
        } else {      
          this.render('submitDenied');    
        }
  } else {
    this.next();
}}

Router.onBeforeAction('dataNotFound', {only: 'articlePage'});
Router.onBeforeAction(requireLogin, {only: 'articleSubmit'});