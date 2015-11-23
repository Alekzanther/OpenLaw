//Format:
//
//text
//-> articleId
//-> userId
//-> voteIds

Comments = new Mongo.Collection('comments');


Comment = class Comment {
    constructor() {
        this.text = "";
        this.articleId = "";
        this.userId = "";
        this.voteIds = [];
    }
}
