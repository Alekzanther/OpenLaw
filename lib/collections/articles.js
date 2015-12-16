//Format:
//
//title
//-> descriptionId
//-> commentIds
//-> tagIds
//-> sourceIds


Articles = new Mongo.Collection('articles');

Article = class Article {
    constructor() {
        this.title = "";
        this.descriptionId = "";
        this.commentIds = [];
        this.tagIds = [];
        this.sourceIds = [];
        this.voteScore = 0;
    }

}

Meteor.methods({
	voteArticle: function(voteAttributes) {
		//check(this.userId, String);
        var user = Meteor.user();
        if (user) {

    		//check(commentAttributes, { ConnectedEntityID: String, Text: String });

            console.log("upvote");
            var vote = Votes.findOne({articleId: voteAttributes.article._id, userId: user._id})
            if (_.isUndefined(vote))  {

                vote = new Vote();
                vote.value = voteAttributes.value;
                vote.timestamp = moment.utc();
                vote.editDate = null;
                vote.commentId = "";
                vote.userId = user._id;
                vote.articleId = voteAttributes.article._id;
            } else {
                vote.editDate = moment.utc();
                vote.value = voteAttributes.value;
                console.log("this awdpojawd")
            }

            Votes.update(
                {articleId: voteAttributes.article._id, userId: user._id},
                vote,
                { upsert: true }
            );

            if (vote.value > 0) {
                Articles.update(
                    voteAttributes.article._id,
                    {$inc: {voteScore: 1}}
                );
            } else {
                Articles.update(
                    voteAttributes.article._id,
                    {$inc: {voteScore: -1}}
                );
            }


        }
	}
});

//export = Article;
