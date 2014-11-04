Template.articleItem.helpers({
  ownPost: function() {    
    return this.userId === Meteor.userId();  
  },
  author: function() {
    return this.userId;
  },
  domain: function() {
    var a = document.createElement('a');
    a.href = this.url;
    return a.hostname;
  }
});