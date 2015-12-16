var getInformation = function(template){
  var username = template.find('#username').value;
  var password = template.find('#password').value;
  return {username:username, password:password};
};

var getCreateInformation = function(template){
  var username = template.find('#create-username').value;
  var password = template.find('#create-password').value;
  var email = template.find('#create-email').value;
  return {username:username, password:password, email: email};
};

Template.login.helpers({
    create: function(){

    },
    rendered: function(){

    },
    destroyed: function(){

    },
});

Template.login.events({
    "click .loginButton": function(event, template){
        event.preventDefault();
        var loginInfo = getInformation(template)
        Meteor.loginWithPassword(loginInfo.username, loginInfo.password, function(error){
            if(error){
                alert(error);
            }
            else{
                FlowRouter.go('/');
            }
        });

    },
    "click .createButton": function(event, template){
        event.preventDefault();
        Accounts.createUser(getCreateInformation(template), function(error){
            if(error){
                alert(error);
            }
            else{
                FlowRouter.go('/');
            }
        });
    }
});
