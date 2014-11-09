Template.articleItem.helpers({
  ownPost: function() {    
    return this.userId === Meteor.userId();  
  },
  author: function() {
    return this.author;
  },
  domain: function() {
    var a = document.createElement('a');
    a.href = this.url;
    return a.hostname;
  },
  commentsCount: function() {
    return this.commentsCount;
  }
});