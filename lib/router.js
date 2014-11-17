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
    return {sort: this.sort, limit: this.articlesLimit()};
  },
  subscriptions: function() {
    this.articlesSub = Meteor.subscribe('articles', this.findOptions());
  },
  articles: function() {
    return Articles.find({}, this.findOptions());
  },
  data: function() {
    var hasMore = this.articles().count() === this.articlesLimit();
    
    return {
      articles: this.articles(),
      ready: this.articlesSub.ready,
      nextPath: hasMore ? this.nextPath() : null
    };
  }
  
});

NewArticlesController = ArticlesListController.extend({
  sort: {submitted: -1, _id: -1},
  nextPath: function() {
    return Router.routes.newArticles.path({articlesLimit: this.articlesLimit() + this.increment})
  }
});
BestArticlesController = ArticlesListController.extend({
  sort: {upvotes: -1, submitted: -1, _id: -1},
  nextPath: function() {
    return Router.routes.bestArticles.path({articlesLimit: this.articlesLimit() + this.increment})
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

Router.route('/', {
  name: 'home',
  controller: NewArticlesController
});

Router.route('/new/:articlesLimit?', {name: 'newArticles'});

Router.route('/best/:articlesLimit?', {name: 'bestArticles'});

Router.onBeforeAction('dataNotFound', {only: 'articlePage'});
Router.onBeforeAction(requireLogin, {only: 'articleSubmit'});