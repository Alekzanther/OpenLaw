if (!window.Model)
{
function getModel() {
    //function Model() {
    //	Model.prototype.generateData();   
    //}
    
    Model.prototype.users = null;
    Model.prototype.articles = null;
    Model.prototype.comments = null;
    Model.prototype.sources = null;
    Model.prototype.tags = null;
    Model.prototype.votes = null;
    
    Model.prototype.generateData = function()
    {
    	this.users = Array();
	    this.articles = Array();
	    this.comments = Array();
	    this.sources = Array();
	    this.tags = Array();
	    this.votes = Array();
	    for (var i=0;i<10;i++)
	    {
	    	this.users.push(new User("user " + i,i + "@test.com",null,null,null,i));
	    	this.articles.push(new Article(i,new Date(),null,null,null));
	    	this.comments.push(new Comment(i,new Date(), "Comment " + i , this.users[i],new Date(),null,null)); 
		    this.sources.push(new Source(i,new Date(),"Namn " + i, null,null,null));
		    this.tags.push(new Tag(i,new Date(),"Namn " + i, null));
	    }
    };
    
    Model.prototype.save = function(param)
    {
    	alert("a");
    	alert(param);
    };
    
}
window.Model = getModel();

}

