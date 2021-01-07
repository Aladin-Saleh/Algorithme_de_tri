class Votant_test
{
    //Prototype
    
    score = array(1/141, 1/141, 1/141, 1/141, 1/141, 1/141, 1/141, 1/141, 1/141, 1/141);
    constructor(nom)
    {
        this.nom = nom;
      
    }
}

//console.log()
//acda = JSON.parse("ACDA");
//console.log(acda);

console.log(Object.values(votes.saleh).length)


Object.keys(votes.saleh).forEach(element => console.log(JSON.parse(JSON.stringify(element))));
    










//Object to String (conversion)
var test ="";
for (let index = 0; index < Object.values(votes.saleh.ACDA[0]).length; index++) {
    test += Object.values(votes.saleh.ACDA[0][index]);
    
}
var testObj = JSON.parse(JSON.stringify(test));
//Comparaison d'object
if ( Object.is(testObj,votes.saleh.ACDA[2]))
{
    console.log("OUI")
}

















function votant()
{
    for (var i = 0; i < Object.values(votes.saleh).length; i++) {
        console.log(Object.values(votes.saleh[i]));
        for (var j = 0; j < Object.values(votes.saleh[i]).length; j++) {
            //console.log(Object.values(votes.saleh[j]));
            
        }

    }
}