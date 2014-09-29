var model = {

	users : Array(),
	articles : Array(),
	comments : Array(),
	sources : Array(),
	tags : Array(),
	votes : Array(),
	test : Array(),
	json : String,
	generateData : function() {
		this.users = Array();
		this.articles = Array();
		this.comments = Array();
		this.sources = Array();
		this.tags = Array();
		this.votes = Array();
		for (var i = 0; i < 10; i++) {
			this.users.push(new user("user " + i, i + "@test.com", null, null, null, i));
			this.articles.push(new article(i, new Date(), null, null, null));
			this.comments.push(new comment(i, new Date(), "Comment " + i, this.users[i], new Date(), null, null));
			this.sources.push(new source(i, new Date(), "Namn " + i, null, null, null));
			this.tags.push(new tag(i, new Date(), "Namn " + i, null));
		}
	},

	save : function(param) {
		//alert(param.name);
		var cache = [];
		model.SaveObject = "{\"" + param.constructor.name + "\":" + JSON.stringify(param, function(key, value) {
		    if (typeof value === 'object' && value !== null) {
		        if (cache.indexOf(value) !== -1) {
		            // Circular reference found, discard key
		            //console.log(value);
		            return;
		        }

		        
		        cache.push(value);
		    }
		    
		    return value;
		});
		model.SaveObject += "}";
		cache = null; // Enable garbage collection
		//	console.log("http://localhost/OpenLaw/Server/DataAccess/setData.php?type=user?data=" + model.SaveObject);
		$.post( "http://localhost/OpenLaw/Server/DataAccess/setData.php", { data : model.SaveObject }, function( data ) {
			
			//$( ".result" ).html( data );
		});
	},

	getRealData : function() {

		this.test = "data";
		$.get("http://localhost/OpenLaw/Server/DataAccess/getData.php?type=all", function(data, status) {
			jsonData = JSON.parse(data);
			model.json = data;
			model.jsonData = jsonData;
			////// TAGS
			for (item in jsonData.tag) {
				item = jsonData.tag[item];
				model.tags.push(new tag(item.id, item.create_date, item.name, Array(),Array()));
				//
			}

			///// ARTICLES
			for (item in jsonData.article) {
				item = jsonData.article[item];
				newArticle = new article(item.id, item.create_date, Array(), Array(), Array(),Array(), item.value, item.name);

				for(tagId in item.tagIds)
				{
					for (u = 0; u < model.tags.length; u++)
					{
						if (model.tags[u].id == item.tagIds[tagId])
						{
							newArticle.tags.push(model.tags[u]);
							model.tags[u].articles.push(newArticle);
							break;
						}
					}
				}

				model.articles.push(newArticle);
				//
			}

			///// COMMENTS
			for (item in jsonData.comment) {
				item = jsonData.comment[item];

				var newComment = new comment(item.id, item.create_date, item.value, null, item.edit_date, null, Array());

				for ( u = 0; u < model.articles.length; u++) {
					if (model.articles[u].id == item.articleId) {
						newComment.article = model.articles[u];
						model.articles[u].comments.push(newComment);
						break;
					}
				}

				model.comments.push(newComment);

			}

			////// SOURCES
			for (item in jsonData.source) {
				item = jsonData.source[item];
				newSource = new source(item.id, item.create_date, item.name, null, Array(), Array());

				for (articleId in item.articleIds) {
					for ( u = 0; u < model.articles.length; u++) {
						if (model.articles[u].id == item.articleIds[articleId]) {
							newSource.articles.push(model.articles[u]);
							model.articles[u].sources.push(newSource);
							break;
						}
					}
				}

				for (tagId in item.tagIds) {
					for ( u = 0; u < model.tags.length; u++) {
						if (model.tags[u].id == item.tagIds[tagId]) {
							newSource.tags.push(model.tags[u]);
							model.tags[u].sources.push(newSource);
							break;
						}
					}
				}

				model.sources.push(newSource);
				//
			}

			////// VOTES
			for (item in jsonData.vote) {
				item = jsonData.vote[item];
				newVote = new vote(null, item.value, item.create_data, null, null, item.id);

				if (item.commentId != null) {
					for ( u = 0; u < model.comments.length; u++) {
						if (model.comments[u].id == item.commentId) {
							newVote.comment = model.comments[u];
							model.comments[u].votes.push(newVote);
							break;
						}
					}
				}

				if (item.articleId != null) {
					for ( u = 0; u < model.articles.length; u++) {
						if (model.articles[u].id == item.articleId) {
							newVote.article = model.articles[u];
							model.articles[u].votes.push(newVote);
							break;
						}
					}
				}
				model.votes.push(newVote);
				//
			}

			////// USERS
			for (item in jsonData.user) {
				item = jsonData.user[item];
				newUser = new user(item.name, item.email, Array(), Array(), null, item.id);

				for (commentId in item.commentIds) {
					for ( u = 0; u < model.comments.length; u++) {
						if (model.comments[u].id == item.commentIds[commentId]) {
							newUser.comments.push(model.comments[u]);
							model.comments[u].user = newUser;
							break;
						}
					}
				}

				for (voteId in item.voteIds) 
				{
					for ( u = 0; u < model.votes.length; u++) {

						if (model.votes[u].id == item.voteIds[voteId]) {

							newUser.votes.push(model.votes[u]);
							model.votes[u].user = newUser;
							break;
						}
					}
				}
				
				if (item.sourceId != null) {
					for ( u = 0; u < model.sources.length; u++) {
						if (model.sources[u].id == item.sourceId) {
							newUser.source = model.sources[u];
							model.sources[u].user = newUser;
							break;
						}
					}
				}

				model.users.push(newUser);
				//
			}

		});
	}
};
model.getRealData();

