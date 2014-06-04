//class Tag{
//	id: number;
//	create_date: Date;
//	name: string;
//	sources: Array<Source>;
//}

var Tag = (function () {
    function Tag(id, create_date, name, sources,articles) {
        this.id = id;
        this.create_date = create_date;
        this.name = name;
        this.sources = sources;
        this.articles = articles;
    }
    return Tag;
})();