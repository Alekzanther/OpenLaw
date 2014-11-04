Template.articleEdit.events({
  'submit form': function(e) {
    e.preventDefault();

    var currentArticleId = this._id;

    var articleProperties = {
      url: $(e.target).find('[name=url]').val(),
      title: $(e.target).find('[name=title]').val()
    }

    Articles.update(currentArticleId, {$set: articleProperties}, function(error) {
      if (error) {
        // display the error to the user
        alert(error.reason);
      } else {
        Router.go('articlePage', {_id: currentArticleId});
      }
    });
  },

  'click .delete': function(e) {
    e.preventDefault();

    if (confirm("Are you sure you want to remove this article?")) {
      var currentArticleId = this._id;
      Articles.remove(currentArticleId);
      Router.go('articlesList');
    }
  }
});