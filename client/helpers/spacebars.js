UI.registerHelper('pluralize', function(n, singular, plural) {
  // fairly stupid pluralizer
  if (n === 1) {
    return n + ' ' + singular;
  } else {
    return n + ' ' + plural;
  }
});