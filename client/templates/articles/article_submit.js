Template.articleSubmit.events({
  'submit form': function(e) {
    e.preventDefault();

    var article = {
      url: $(e.target).find('[name=url]').val(),
      title: $(e.target).find('[name=title]').val()
    };
    
    Meteor.call('articleInsert', article, function(error, result) {            
      if (error)        
        return alert(error.reason); // display the error to the user and abort
      
      if (result.postExists)        
        alert('Post with this URL already exists');
      
      Router.go('articlePage', {_id: result._id});
    });
  }
});