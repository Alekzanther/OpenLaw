Meteor.publish('articles', function(options) {
  /*check(options, {
    sort: Object,
    limit: Number
  });*/
  return Articles.find({}, options);
});

Meteor.publish('singleArticle', function(id) {
  check(id, String)
  return Articles.find(id);
});

Meteor.publish('comments', function(articleId) {
  check(articleId, String);
  return Comments.find({articleId: articleId});
});

Meteor.publish('notifications', function() {
  return Notifications.find({userId: this.userId, read: false});
});
