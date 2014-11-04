Articles = new Meteor.Collection('articles');


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
      submitted: new Date()    
    });    
    
    var articleId = Articles.insert(article);    
    return {      
      _id: articleId    
    };  
  }
});