//Format:
//
//title
//-> description
//-> comments
//-> tags
//-> sources


Articles = new Mongo.Collection('articles');

Article = class Article {
    constructor(){
        this.title = "";
        this.description = "";
        this.comments = [];
        this.tags = [];
        this.sources = [];
    }
};

//export = Article;
