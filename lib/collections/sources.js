//Format:
//
//title
//-> descriptionId
//-> articleIds
//-> userIds
//-> tagIds

Sources = new Mongo.Collection("sources");

Source = class Source {
    constructor() {
        this.title = "";
        this.descriptionId = "";
        this.articleIds = [];
        this.userIds = [];
        this.tagIds = [];
    }
}
