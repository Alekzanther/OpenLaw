Articles = new Meteor.Collection('articles');

Articles.allow({  
  update: function(userId, article) { return ownsDocument(userId, article); },  
  remove: function(userId, article) { return ownsDocument(userId, article); },
});

Articles.deny({  
  update: function(userId, article, fieldNames) {    
    // may only edit the following two fields:    
    return (_.without(fieldNames, 'url', 'title').length > 0);  }
});


Meteor.methods({
  
  
  articleInsert: function(articleAttributes) {    
    
    check(Meteor.userId(), String);  
    check(articleAttributes, {      
      title: String,      
      url: String    
    });
    
    var existingItem = Articles.findOne({url: articleAttributes.url});    
    if (existingItem) {      
      return {        
        postExists: true,        
        _id: existingItem._id
      }; 
    }
    
    var user = Meteor.user();    
    var article = _.extend(articleAttributes, {      
      userId: user._id,       
      author: user.username,
      submitted: new Date(),
      commentsCount: 0,
      upvoters: [], 
      downvoters: [], 
      upvotes: 0,
      downvotes: 0
    });    
    
    var articleId = Articles.insert(article);    
    return {      
      _id: articleId    
    };  
  },
  
  upvote: function(articleId) {
    check(this.userId, String);
    check(articleId, String);
    
    var affected = Articles.update({
        _id: articleId,
        upvoters: {$ne : this.userId}
      },{
        $addToSet: {upvoters: this.userId},
        $inc: {upvotes: 1}
    });
    
    if(!affected){
      throw new Meteor.Error('invalid', 'Could not vote')
    }
  },
  
  downvote: function(articleId) {
    check(this.userId, String);
    check(articleId, String);
    
    var affected = Articles.update({
        _id: articleId,
        downvoters: {$ne : this.userId}
      },{
        $addToSet: {downvoters: this.userId},
        $inc: {downvotes: 1}
    });
    
    if(!affected){
      throw new Meteor.Error('invalid', 'Could not vote')
    }
  }
});