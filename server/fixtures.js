// Fixture data
if (Articles.find().count() === 0) {
  var now = new Date().getTime();

  // create two users
  var alexId = Meteor.users.insert({
    profile: { name: 'Alexandrus' }
  });
  var alex = Meteor.users.findOne(alexId);
  var simonId = Meteor.users.insert({
    profile: { name: 'Simonster' }
  });
  var simon = Meteor.users.findOne(simonId);

  var dinlagId = Articles.insert({
    title: 'DinLag',
    userId: simon._id,
    author: simon.profile.name,
    url: 'http://www.dinlag.se/',
    submitted: new Date(now - 7 * 3600 * 1000),
    commentsCount: 2,
    upvoters: [], 
    votes: 0
  });

  Comments.insert({
    articleId: dinlagId,
    userId: alex._id,
    author: alex.profile.name,
    submitted: new Date(now - 5 * 3600 * 1000),
    body: 'Vilken fin sida...'
    
  });

  Comments.insert({
    articleId: dinlagId,
    userId: simon._id,
    author: simon.profile.name,
    submitted: new Date(now - 3 * 3600 * 1000),
    body: 'Tack Alex.'
  });

  Articles.insert({
    title: 'Sweddit',
    userId: alex._id,
    author: alex.profile.name,
    url: 'http://www.reddit.com/r/sweden',
    submitted: new Date(now - 10 * 3600 * 1000),
    commentsCount: 0,
    upvoters: [], 
    votes: 0
  });

  Articles.insert({
    title: 'Chill Trap',
    userId: simon._id,
    author: simon.profile.name,
    url: 'https://www.youtube.com/watch?v=8ATu1BiOPZA',
    submitted: new Date(now - 12 * 3600 * 1000),
    commentsCount: 0,
    upvoters: [], 
    votes: 0
  });
  
  for (var i = 0; i < 10; i++) {
    Articles.insert({
      title: 'Test article #' + i,
      author: simon.profile.name,
      userId: simon._id,
      url: 'http://google.com/?q=test-' + i,
      submitted: new Date(now - i * 3600 * 1000 + 1),
      commentsCount: 0,
      upvoters: [], 
      votes: 0
    });
  }
}