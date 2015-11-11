// Local (client-only) collection
Errors = new Mongo.Collection(null);


throwError = function(message) {
  Materialize.toast(message, 4000, 'red darken-2'); // 4000 is the duration of the toast
};

Template.error.rendered = function() {
  var error = this.data;
  Meteor.setTimeout(function () {
    Errors.remove(error._id);  }, 3000);
};
