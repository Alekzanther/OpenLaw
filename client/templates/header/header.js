Template.header.helpers({
    loggedIn: function(){
        return Meteor.user() != null;
    }
});



Template.header.events({
    "click .logout": function(event, template){
         Accounts.logout();
    }
});
