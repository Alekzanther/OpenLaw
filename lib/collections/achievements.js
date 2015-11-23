//Format:
//
//-> description
//script?

Achievements = new Mongo.Collection('achievements');

Achievement = class Achievement {
    constructor() {
        this.descriptionId = "";
        this.script = "";
    }

}
