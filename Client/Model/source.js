//class Source{
//	id: number;
//	create_date: Date;
//	name: string;
//	user: User;
//	tags: Array<Tag>;
//	articles: Array<Article>; 
//}

var Source = (function () {
    function Source(id, create_date, name, user,tags,articles) {
        this.id = id;
        this.create_date = create_date;
        this.name = name;
        this.user = user;
        this.tags = tags;
        this.articles = articles;
    }
    return Source;
})();