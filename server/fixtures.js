if (Articles.find().count() === 1) {
  Articles.insert({
    title: 'Test postus numero uno',
    url: 'http://wikipedia.com/'
  });

  Articles.insert({
    title: 'This is running on Meteor',
    url: 'http://meteor.com'
  });

  Articles.insert({
    title: 'Sveriges rikes lag',
    url: 'https://lagen.nu/'
  });
}