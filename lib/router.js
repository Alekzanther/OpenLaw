function requiredLogin(context, redirect) {
  // this works only because the use of Fast Render
  var redirectPath = (!Meteor.userId())? "/login" : null;
  if (redirectPath != null) {
    console.log("OMG NO USER FOUND");
    redirect(redirectPath);
  }
};

FlowRouter.notFound = {
    action: function() {
      console.log("Route not found");
      FlowLayout.render('layout', {main: "notFound" });
    }
};

FlowRouter.subscriptions = function() {
  //this.register('Updates', Meteor.subscribe('updates'));
  //this.register('userData', Meteor.subscribe('userData'));
};


FlowRouter.route('/article/:id', {

    // define subscriptions
    subscriptions: function(params, queryParams) {
      this.register("article", Meteor.subscribe('article', params.id));
    },

    // onwards to the article page
    action: function(params, queryParams) {
        FlowLayout.render('layout', {main: "article_page" });
    }
});

FlowRouter.route('/', {
    // do some action for this route
    action: function(params, queryParams) {
        FlowLayout.render('layout', {main: "home" });
    }
});


// FlowRouter.route('/', {
//     triggersEnter: [function(context, redirect) {
//       redirect('/home');
//     }]
// });
