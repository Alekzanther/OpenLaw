//class Vote{
//	id: number;
//	create_date: Date;
//	value: number;
//	user: User;
//	comment: Comment;
//	article: Article;
//}

var Vote = (function () {
    function Vote(comment, value, create_date, user, article, id) {
        this.comment = comment;
        this.value = value;
        this.create_date = create_date;
        this.user = user;
        this.article = article;
        this.id = id;
    }
    return Vote;
})();