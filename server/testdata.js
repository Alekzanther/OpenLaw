
if (Articles.find().count() == 0){
    var kalle = new Article();
    kalle.title = "Test1";
    kalle.description = "Classes in ES6 is cool";
    Articles.insert(kalle);

    kalle = new Article();
    kalle.title = "Anka";
    kalle.description = "gick på en planka";
    Articles.insert(kalle);
}
