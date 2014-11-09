Notifications = new Meteor.Collection('notifications');

Notifications.allow({
  update: function(userId, doc, fieldNames) {
    return ownsDocument(userId, doc) && 
      fieldNames.length === 1 && fieldNames[0] === 'read';
  }
});

createCommentNotification = function(comment) {
  var article = Articles.findOne(comment.articleId);
  if (comment.userId !== article.userId) {
    Notifications.insert({
      userId: article.userId,
      articleId: article._id,
      commentId: comment._id,
      commenterName: comment.author,
      read: false
    });
  }
};