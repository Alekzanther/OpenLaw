
Template.articlesList.helpers({
  articles: function() {
     return Articles.find({}, {sort: {submitted: -1}});
  }
});