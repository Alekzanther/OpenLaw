Template.article_list.onCreated(function() {
    var self = this;
    self.autorun(function() {
      self.subscribe('articles');

    });
});

Template.article_list.helpers({
  Articles: function() {
    return Articles.find({});
  }
});
