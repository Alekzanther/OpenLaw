var Model = {
    
    users: Array(),
    articles: Array(),
    comments: Array(),
    sources: Array(),
    tags: Array(),
    votes: Array(),
    test: Array(),
    json: String,
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
    		jsonData = JSON.parse(data);
    		Model.json = data;
    		
    		///// ARTICLES
    		for(item in jsonData.article)
			{
				item = jsonData.article[item];
				Model.articles.push(new Article(item.id, item.create_date,null,null,null));//
			}
    		
    		///// COMMENTS
			for(comment in jsonData.comment)
			{
				comment = jsonData.comment[comment];
				linkedUser = null;
				for (u = 0; u < Model.users.length; u++)
				{
					if (Model.users[u].id == comment.userId)
						linkedUser = Model.users[u];		
				}
				Model.comments.push(new Comment(comment.id, comment.create_date,comment.value,linkedUser,comment.edit_date,null,null));//
				
			}
			
			////// SOURCES
			for(item in jsonData.source)
			{
				item = jsonData.source[item];
				Model.sources.push(new Source(item.id, item.create_date, item.name, null,null,null));//
			}
			
			////// TAGS
			for(item in jsonData.tag)
			{
				item = jsonData.tag[item];
				Model.tags.push(new Tag(item.id, item.create_date,item.name,null));//
			}
			
			////// USERS
			for(item in jsonData.user)
			{
				item = jsonData.user[item];
				Model.users.push(new User(item.name, item.email,null,null,null,item.id));//
			}
			
			////// VOTES
			for(item in jsonData.vote)
			{
				item = jsonData.vote[item];
				Model.votes.push(new Vote(item.comment, item.value, item.create_data, null, null,item.id));//
			}
			
			
		});
    }
};
Model.getRealData();

