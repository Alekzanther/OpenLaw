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
    }

}

//export = Article;
