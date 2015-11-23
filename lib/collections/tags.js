//Format:
//
//title
//-> description
//-> articles
//-> sources


Tags = new Mongo.Collection("tags");


Tag = class Tag {
    constructor() {
        this.title = "";
        this.descriptionId = "";
        this.articleIds = [];
        this.sourceIds = [];
    }
}
