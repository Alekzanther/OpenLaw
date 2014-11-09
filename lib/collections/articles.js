Articles = new Meteor.Collection('articles');

Articles.allow({  
  update: function(userId, post) { return ownsDocument(userId, post); },  
  remove: function(userId, post) { return ownsDocument(userId, post); },
});

Articles.deny({  
  update: function(userId, post, fieldNames) {    
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
      author: user.name,
      submitted: new Date(),
      commentsCount: 0
    });    
    
    var articleId = Articles.insert(article);    
    return {      
      _id: articleId    
    };  
  }
});