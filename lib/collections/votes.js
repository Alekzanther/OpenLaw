//Format:
//
//value (-1, 0, +1)
//timestamp
//editDate --null if not edited
//-> commentId
//-> articleId
//-> userId --the user that voted


Votes = new Mongo.Collection("votes");


Vote = class Vote {
    constructor() {
        this.value = 0;
        this.timestamp = null;
        this.editDate = null;
        this.commentId = "";
        this.userId = "";
        this.articleId = "";
    }
}
