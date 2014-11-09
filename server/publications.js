Meteor.publish('articles', function() {
  return Articles.find();
});

Meteor.publish('comments', function(articleId) {
  check(articleId, String);
  return Comments.find({articleId: articleId});
});