Comments = new Meteor.Collection('comments');

Meteor.methods({
  commentInsert: function(commentAttributes) {
    
    check(this.userId, String);
    check(commentAttributes, {
      articleId: String,
      body: String
    });
    
    var user = Meteor.user();
    var article = Articles.findOne(commentAttributes.articleId);
    
    if (!article)
      throw new Meteor.Error('invalid-comment', 'You must comment on a article');
    
    comment = _.extend(commentAttributes, {
      userId: user._id,
      author: user.username,
      submitted: new Date()
    });
    
    Articles.update(comment.articleId, {$inc: {commentsCount: 1}});
    
    comment._id = Comments.insert(comment);
    
    createCommentNotification(comment);
    
    return comment._id;
    
  }
});