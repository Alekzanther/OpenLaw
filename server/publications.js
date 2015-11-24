Meteor.publish('articles', function() {
	return Articles.find();
});

Meteor.publish('article', function(id) {
	return Articles.find({
		_id: id
	});
});
