//class Comment{
//	id: number;
//	value: string;
//	create_date: Date;
//	edit_date: Date;
//	user: User;
//	votes: Array<Vote>;
//	article: Article;
//}

var Comment = (function () {
    function Comment(id, create_date, value, user,edit_date,article, votes) {
        this.id = id;
        this.create_date = create_date;
        this.value = value;
        this.user = user;
        this.edit_date = edit_date;
        this.article = article;
        this.votes = votes;
    }
    return Comment;
})();