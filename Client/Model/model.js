var Model = {
    
    users: Array(),
    articles: Array(),
    comments: Array(),
    sources: Array(),
    tags: Array(),
    votes: Array(),
    test: Array(),
    generateData: function()
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
    },
    
    save: function(param)
    {
    	alert(this.users[0].name);
    	alert(param.name);
    },
    
    getRealData: function()
    {
	    
    	this.test = "data";
    	$.get("http://localhost/OpenLaw/Server/DataAccess/getData.php?type=all", function(data, status) {
			Model.test = JSON.parse(data);
			for(items in Model.test)
			{
				if (items == "user")
				{
					alert(items[1].name);
				}
				Model.users.push(new User(user.name, user.email,null,null,null,user.id));
			}
		});
    }
};
Model.getRealData();

