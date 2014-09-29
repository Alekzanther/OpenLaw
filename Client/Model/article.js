//class Article{
//	id: number;
//	create_date: Date;
//	votes: Array<Vote>;
//	sources: Array<Source>;
//	comments: Array<Comment>;
//}

var article = (function () {
    function article(id, create_date, votes, sources,comments, tags, value, name) {
        this.id = id;
        this.create_date = create_date;
        this.votes = votes;
        this.sources = sources;
        this.comments = comments;
        this.tags = tags;
        this.value = value;
        this.name = name; 
    }
    return article;
})();