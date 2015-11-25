Template.article_page.helpers({
  Article: function() {
    return Articles.findOne();
  }
});
