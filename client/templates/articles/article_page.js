Template.articlePage.helpers({
  comments: function() {
    return Comments.find({articleId: this._id});
  }
});
