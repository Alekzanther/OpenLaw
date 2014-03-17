class Comment{
	id: number;
	value: string;
	create_date: Date;
	edit_date: Date;
	user: User;
	votes: Array<Vote>;
	article: Article;
}