var Model = (function () {
    function Model() {
    	Model.prototype.generateData();   
    }
    
    Model.users = null;
    Model.articles = null;
    Model.comments = null;
    Model.sources = null;
    Model.tags = null;
    Model.votes = null;
    
    Model.prototype.generateData = function()
    {
    	Model.users = Array();
	    Model.articles = Array();
	    Model.comments = Array();
	    Model.sources = Array();
	    Model.tags = Array();
	    Model.votes = Array();
	    for (var i=0;i<10;i++)
	    {
	    	Model.users.push(new User("user " + i,i + "@test.com",null,null,null,i));
	    	Model.articles.push(new Article(i,new Date(),null,null,null));
	    	Model.comments.push(new Comment(i,new Date(), "Komment " + i , Model.users[i],new Date(),null,null)); 
		    Model.sources.push(new Source(i,new Date(),"Namn " + i, null,null,null));
		    Model.tags.push(new Tag(i,new Date(),"Namn " + i, null));
	    }
    };
    return Model;
})();