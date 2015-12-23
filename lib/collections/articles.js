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
        if(voteAttributes.value == 1 || voteAttributes.value == -1){
            var user = Meteor.user();

            if (user) {
                var vote = Votes.findOne({articleId: voteAttributes.article._id, userId: user._id})

                removeUpvote = false;
                removeDownvote = false;

                if (_.isUndefined(vote))  {
                    vote = new Vote();
                    vote.value = voteAttributes.value;
                    vote.timestamp = moment.utc();
                    vote.editDate = null;
                    vote.commentId = "";
                    vote.userId = user._id;
                    vote.articleId = voteAttributes.article._id;
                } else {
                    if(voteAttributes.value == vote.value){
                        if(vote.value == 1){
                            removeUpvote = true;
                        }else if (vote.value == -1){
                            removeDownvote = true;
                        }
                    }
                    else if(vote.value == -1 && voteAttributes.value == 1){
                        removeDownvote = true;
                    }else if (vote.value == 1 && voteAttributes.value == -1) {
                        removeUpvote = true;
                    }

                    vote.editDate = moment.utc();

                    if(voteAttributes.value != vote.value){
                        vote.value = voteAttributes.value;
                    }else {
                        vote.value = 0;
                    }
                }

                Votes.update(
                    {articleId: voteAttributes.article._id, userId: user._id},
                    vote,
                    { upsert: true }
                );

                var articleIncrement = vote.value;

                if(removeUpvote){
                    articleIncrement += -1;
                }
                else if (removeDownvote) {
                    articleIncrement += 1;
                }

                Articles.update(
                    voteAttributes.article._id,
                    {$inc: {voteScore: articleIncrement}});

            }else {
                console.log("no user");
            }
        }
	}
});

//export = Article;
