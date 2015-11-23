function requiredLogin(context, redirect) {
  // this works only because the use of Fast Render
  var redirectPath = (!Meteor.userId())? "/login" : null;
  if (redirectPath != null) {
    console.log("OMG NO USER FOUND");
    redirect(redirectPath);
  }
};

FlowRouter.notFound = {
    // Subscriptions registered here don't have Fast Render support.
    subscriptions: function() {
      this.register('userData', Meteor.subscribe('userData'));
    },
    action: function() {
      console.log("Route not found");
      FlowLayout.render('layout', {main: "notFound" });
    }
};

FlowRouter.subscriptions = function() {
  //this.register('Updates', Meteor.subscribe('updates'));
  //this.register('userData', Meteor.subscribe('userData'));
};

FlowRouter.route('/:id', {
    //triggersEnter: [requiredLogin],

    // define your subscriptions
    //subscriptions: function(params, queryParams) {
    //  this.register("singleNotification", Meteor.subscribe('singleNotification', params.id));
    //},

    // do some action for this route
    //action: function(params, queryParams) {
    //    FlowLayout.render('layout', {main: "notificationPage" });
    //    Session.set("currentPage","Notification");
    //}
});

FlowRouter.route('/', {
    // do some action for this route
    action: function(params, queryParams) {
        FlowLayout.render('layout', {main: "home" });
        Session.set("currentPage","Din Lag");
    }
});


// FlowRouter.route('/', {
//     triggersEnter: [function(context, redirect) {
//       redirect('/home');
//     }]
// });
