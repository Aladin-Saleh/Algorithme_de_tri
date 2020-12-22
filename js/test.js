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


 
