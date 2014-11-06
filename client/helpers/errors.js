Errors = new Meteor.Collection(null); //client side

throwError = function(message) {
  Errors.insert({message: message});
};

