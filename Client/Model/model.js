var Model = {

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
			this.users.push(new User("user " + i, i + "@test.com", null, null, null, i));
			this.articles.push(new Article(i, new Date(), null, null, null));
			this.comments.push(new Comment(i, new Date(), "Comment " + i, this.users[i], new Date(), null, null));
			this.sources.push(new Source(i, new Date(), "Namn " + i, null, null, null));
			this.tags.push(new Tag(i, new Date(), "Namn " + i, null));
		}
	},

	save : function(param) {
		alert(this.users[0].name);
		alert(param.name);
	},

	getRealData : function() {

		this.test = "data";
		$.get("http://localhost/OpenLaw/Server/DataAccess/getData.php?type=all", function(data, status) {
			jsonData = JSON.parse(data);
			Model.json = data;

			////// TAGS
			for (item in jsonData.tag) {
				item = jsonData.tag[item];
				Model.tags.push(new Tag(item.id, item.create_date, item.name, Array(),Array()));
				//
			}

			///// ARTICLES
			for (item in jsonData.article) {
				item = jsonData.article[item];
				newArticle = new Article(item.id, item.create_date, Array(), Array(), Array(),Array());

				for(tagId in item.tagIds)
				{
					for (u = 0; u < Model.tags.length; u++)
					{
						if (Model.tags[u].id == item.tagIds[tagId])
						{
							newArticle.tags.push(Model.tags[u]);
							Model.tags[u].articles.push(newArticle);
							break;
						}
					}
				}

				Model.articles.push(newArticle);
				//
			}

			///// COMMENTS
			for (comment in jsonData.comment) {
				comment = jsonData.comment[comment];

				var newComment = new Comment(comment.id, comment.create_date, comment.value, null, comment.edit_date, null, Array());

				for ( u = 0; u < Model.articles.length; u++) {
					if (Model.articles[u].id == comment.articleId) {
						newComment.article = Model.articles[u];
						Model.articles[u].comments.push(newComment);
						break;
					}
				}

				Model.comments.push(newComment);

			}

			////// SOURCES
			for (item in jsonData.source) {
				item = jsonData.source[item];
				newSource = new Source(item.id, item.create_date, item.name, null, Array(), Array());

				for (articleId in item.articleIds) {
					for ( u = 0; u < Model.articles.length; u++) {
						if (Model.articles[u].id == item.articleIds[articleId]) {
							newSource.articles.push(Model.articles[u]);
							Model.articles[u].sources.push(newSource);
							break;
						}
					}
				}

				for (tagId in item.tagIds) {
					for ( u = 0; u < Model.tags.length; u++) {
						if (Model.tags[u].id == item.tagIds[tagId]) {
							newSource.tags.push(Model.tags[u]);
							Model.tags[u].sources.push(newSource);
							break;
						}
					}
				}

				Model.sources.push(newSource);
				//
			}

			////// VOTES
			for (item in jsonData.vote) {
				item = jsonData.vote[item];
				newVote = new Vote(null, item.value, item.create_data, null, null, item.id);

				if (item.commentId != null) {
					for ( u = 0; u < Model.comments.length; u++) {
						if (Model.comments[u].id == item.commentId) {
							newVote.comment = Model.comments[u];
							Model.comments[u].votes.push(newVote);
							break;
						}
					}
				}

				if (item.articleId != null) {
					for ( u = 0; u < Model.articles.length; u++) {
						if (Model.articles[u].id == item.articleId) {
							newVote.article = Model.articles[u];
							Model.articles[u].votes.push(newVote);
							break;
						}
					}
				}
				Model.votes.push(newVote);
				//
			}

			////// USERS
			for (item in jsonData.user) {
				item = jsonData.user[item];
				newUser = new User(item.name, item.email, Array(), Array(), null, item.id);

				for (commentId in item.commentIds) {
					for ( u = 0; u < Model.comments.length; u++) {
						if (Model.comments[u].id == item.commentIds[commentId]) {
							newUser.comments.push(Model.comments[u]);
							Model.comments[u].user = newUser;
							break;
						}
					}
				}

				for (voteId in item.voteIds) 
				{
					for ( u = 0; u < Model.votes.length; u++) {

						if (Model.votes[u].id == item.voteIds[voteId]) {

							newUser.votes.push(Model.votes[u]);
							Model.votes[u].user = newUser;
							break;
						}
					}
				}
				
				if (item.sourceId != null) {
					for ( u = 0; u < Model.sources.length; u++) {
						if (Model.sources[u].id == item.sourceId) {
							newUser.source = Model.sources[u];
							Model.sources[u].user = newUser;
							break;
						}
					}
				}

				Model.users.push(newUser);
				//
			}

		});
	}
};
Model.getRealData();

