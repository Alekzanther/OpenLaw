//class Article{
//	id: number;
//	create_date: Date;
//	votes: Array<Vote>;
//	sources: Array<Source>;
//	comments: Array<Comment>;
//}

var Article = (function () {
    function Article(id, create_date, votes, sources,comments, tags) {
        this.id = id;
        this.create_date = create_date;
        this.votes = votes;
        this.sources = sources;
        this.comments = comments;
        this.tags = tags;
    }
    return Article;
})();