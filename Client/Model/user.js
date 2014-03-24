//class User{
//	name: string;
//    email: string;
//    votes: Array<Vote>;
//    comments: Array<Comment>;
//    source: Source;
//    id: number;
//	
//	constructor(name: string,email: string, votes:Array<Vote>, comments: Array<Comment>,source: Source, id: number){
//		this.name = name;
//		this.comments = comments;
//		this.email = email;
//		this.id = id;
//		this.source = source;
//		this.votes = votes;
//	}
//}

var User = (function () {
    function User(name, email, votes, comments, source, id) {
        this.name = name;
        this.comments = comments;
        this.email = email;
        this.id = id;
        this.source = source;
        this.votes = votes;
    }
    return User;
})();