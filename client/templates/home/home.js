Template.home.onCreated(function() {
    var self = this;
    self.autorun(function() {
      self.subscribe('articles');
      
    });
});

Template.home.helpers({
  Articles: function() {
    return Articles.find({});
  }
});
