Template.article_page.onCreated(function() {
    var self = this;
    self.autorun(function() {
      self.subscribe('votes');
    });
});

Template.article_page.helpers({
    Article: function() {
        return Articles.findOne();
    },upvoted: function(){
        vote = Votes.findOne({articleId: this._id});

        if(_.isUndefined(vote) == false){
            if (vote.value == 1){
                return "green";
            }
        }

        return "";
    },downvoted: function(){
        vote = Votes.findOne({articleId: this._id});

        if(_.isUndefined(vote) == false){
            if(vote.value == -1){
                return "red";
            }
        }

        return "";
    }

});

Template.article_page.events({
    "click .upvote": function(event, template){
        Meteor.call('voteArticle', {article: this, value: 1});
    },
    "click .downvote": function(event, template){
        Meteor.call('voteArticle', {article: this, value: -1});
    }
});
