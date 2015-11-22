
if (Articles.find().count() == 0){
    var kalle = new Article();
    kalle.title = "Test1";
    kalle.description = "Classes in ES6 is cool";
    Articles.insert(kalle);
}
