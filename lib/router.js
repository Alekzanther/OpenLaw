Router.configure({
  layoutTemplate: 'layout',
  loadingTemplate: 'loading',
  notFoundTemplate: 'notFound',
  waitOn: function() { 
    return Meteor.subscribe('notifications'); 
  }

});

ArticlesListController = RouteController.extend({
  template: 'articlesList',
  increment: 5, 
  articlesLimit: function() { 
    return parseInt(this.params.articlesLimit) || this.increment; 
  },
  findOptions: function() {
    return {sort: {submitted: -1}, limit: this.articlesLimit()};
  },
  subscriptions: function() {
    this.articlesSub = Meteor.subscribe('articles', this.findOptions());
  },
  articles: function() {
    return Articles.find({}, this.findOptions());
  },
  data: function() {
    var hasMore = this.articles().count() === this.articlesLimit();
    var nextPath = this.route.path({articlesLimit: this.articlesLimit() + this.increment});
    return {
      articles: this.articles(),
      ready: this.articlesSub.ready,
      nextPath: hasMore ? nextPath : null
    };
  }
  
});

Router.route('/articles/:_id', {
  name: 'articlePage',
  waitOn: function() {
    return [
      Meteor.subscribe('singleArticle', this.params._id),
      Meteor.subscribe('comments', this.params._id)
    ];
  },
  data: function() { return Articles.findOne(this.params._id); }
});

Router.route('/submit', {name: "articleSubmit"});

Router.route('/articles/:_id/edit', {  
  name: 'articleEdit',  
  waitOn: function() { 
    return Meteor.subscribe('singleArticle', this.params._id);
  },
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

Router.route('/:articlesLimit?',{
  name: 'articlesList'
});

Router.onBeforeAction('dataNotFound', {only: 'articlePage'});
Router.onBeforeAction(requireLogin, {only: 'articleSubmit'});