var votant =[];//Tableau qui vas contenir toutes les personnes peut importes si elles ont votés

propOwnLogin = Object.getOwnPropertyNames(logins);//Récupère le nombre de potentiel votant
console.log("Nombre de votant " + propOwnLogin.length); //Affichage du nombre de votant


for(let index = 0; index < propOwnLogin.length; index++) 
{
    votant.push(propOwnLogin[index]);//On ajoute les votant dans le tableau
    console.log(index + ": " +votant[index]);//Affichage des votants
}

console.log(typeof votant[111]);//String
console.log(typeof votes.saleh);//Object
//A faire : pouvoir convertir un type string en Object pour pouvoir concaténer avec toutes les données qu'on a dans le tableau votant
console.log(Object.keys(votes.saleh));
console.log(Object.values(votes.saleh.ACDA));





//Formule mathématique pour faire le classement
//Brouillon 
var user1;
var user2;
var user3;
var user4;
//Chaque user possède un tableau contenant les users qui on voté pour lui

var usersPoint = [user1 =[user1,user3,user4,user2],user2 = [user1,user4],user3 = [user1,user2],user4 = [user3]];//Tableau qui contient les tableaux de vote de tout les users
//user1 = 3        user2 = 2           user3 = 2         user4 = 1
var tableauDePoint = [];//Initialisation du tableau de point
var tableauClassement = [];//Initialisation du tableau de classement

for (let index = 0; index < usersPoint.length; index++) {
    tableauDePoint[index] = usersPoint[index].length;//On met dans le tableau de point le nombre de votes reçu par chaque user dans l'ordre 1-4
    var id = index +1;//Sert seulement pour l'affichage
    console.log("User"+id+" : "+tableauDePoint[index]);//Debugage des valeurs
    for (let index2 = 0; index2 < tableauDePoint.length; index2++) {
        var buf = tableauDePoint[index];
        
        
    }

}

for (let index = 0; index < usersPoint.length; index++) {
    console.log(index + " --+ " + usersPoint[index].includes(user1));//Test : Est supposé vérifier si ça contient un user

    
    
}



 
