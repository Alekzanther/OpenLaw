//Format:
//
//usage rights
//origin
//?

Images = new Mongo.Collection("images");

OLImage = class OLImage {
    constructor() {
        this.usagerights = "";
        this.origin = "";
        this.url = "";
    }
}
