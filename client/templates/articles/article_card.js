Template.article_card.events({
  'click .card': function(e, template) {
    FlowRouter.go("/article/" + this._id);
  }
});
