Template.articleItem.helpers({

  ownPost: function() {
    return this.userId === Meteor.userId();
  },

  author: function() {
    return this.author;
  },

  domain: function() {
    var a = document.createElement('a');
    a.href = this.url;
    return a.hostname;
  },

  commentsCount: function() {
    return this.commentsCount;
  },

  upvotedClass: function() {
    var userId = Meteor.userId();
    if (userId && !_.include(this.upvoters, userId)) {
      return 'btn-primary upvotable';
    } else if (userId) {
      return 'unvotable';
    } else {
      return 'disabled';
    }
  },

  downvotedClass: function() {
    var userId = Meteor.userId();
    if (userId && !_.include(this.downvoters, userId)) {
      return 'btn-primary downvotable';
    } else if (userId) {
      return 'unvotable';
    } else {
      return 'disabled';
    }
  }

});

Template.articleItem.events({

  'click .upvotable': function(e) {
    e.preventDefault();
    Meteor.call('upvote', this._id);
  },

  'click .downvotable': function(e) {
    e.preventDefault();
    Meteor.call('downvote', this._id);
  },

  'click .unvotable': function(e) {
    e.preventDefault();
    Meteor.call('unvote', this._id);
  }

});
