//Format:
//
//title
//summary
//full text?
//-> imageId

Descriptions = new Mongo.Collection('descriptions');


Description = class Description {
    constructor() {
        this.title = "";
        this.summary = "";
        this.text = "";
        this.imageId = "";
    }
}
