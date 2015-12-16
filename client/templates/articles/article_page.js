Template.article_page.helpers({
  Article: function() {
    return Articles.findOne();
  }
});

Template.article_page.events({
    "click .upvote": function(event, template){
        console.log(this);
        Meteor.call('voteArticle', {article: this, value: 1});
    },
    "click .downvote": function(event, template){
        console.log(this);
        Meteor.call('voteArticle', {article: this, value: -1});
    }
});
