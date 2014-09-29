//class Tag{
//	id: number;
//	create_date: Date;
//	name: string;
//	sources: Array<Source>;
//}

var tag = (function () {
    function tag(id, create_date, name, sources,articles) {
        this.id = id;
        this.create_date = create_date;
        this.name = name;
        this.sources = sources;
        this.articles = articles;
    }
    return tag;
})();