var votant =[];//Tableau qui vas contenir toutes les personnes peut importes si elles ont votés

propOwnLogin = Object.getOwnPropertyNames(logins);//Récupère le nombre de potentiel votant
//console.log("Nombre de votant " + propOwnLogin.length); //Affichage du nombre de votant


for(let index = 0; index < propOwnLogin.length; index++) 
{
    votant.push(propOwnLogin[index]);//On ajoute les votant dans le tableau
    //console.log(index + ": " +votant[index]);//Affichage des votants
}

//console.log(typeof votant[111]);//String
//console.log(typeof votes.saleh);//Object
//A faire : pouvoir convertir un type string en Object pour pouvoir concaténer avec toutes les données qu'on a dans le tableau votant
//console.log(Object.keys(votes.saleh));
//console.log(Object.values(votes.saleh.ACDA));
var matiere_coche = [];


/*
*Cette fonction permet de recuperer les checkbox (matiere) qui ont été coché par l'utilisateur
*Elle stocke ensuite toutes les matieres coché dans un tableau qui est commun à tout le programme
*/
function getCheckbox()
{
    clear();
    var list_check_box = document.getElementsByTagName('input');//On recupere tout les elements contenant la balise input
    console.log("nombre de checkbox : " +list_check_box.length);
    for (var i = 0; i < list_check_box.length; i++) 
    {
        var matiere = list_check_box[i];//On stock à chaque fois le nom de l'input à l'indice i dans matiere
     
        if (matiere.getAttribute('type') == 'checkbox') 
        {
            //On verifie que ce qui est stocké est un checkbox
            //console.log(matiere.value);//Si condition est valide alors on l'affiche dans la console (debug)
        }
        if (list_check_box[i].checked == true)//On verifie si la checkbox est coché
        {
            //console.log("ok");
            //console.log("Matière : " + matiere.value);
            matiere_coche[i] = matiere.value;//On le stock dans un tableau que l'on pourra réutiliser plus tard
        }
     
    } 
    debug();
}

function debug()//Fonction de débugage
{
    console.table("matiere coche : " + matiere_coche);
}

function clear() // Fonction de nettoyage du tableau des cases cochées
{
    for(;matiere_coche.length != 0;) // Tant que le tableau n'est pas vide
    {
        matiere_coche.pop(); // On enlève le dernier élément de ce dernier
    }
}







function getVoteRecu(Votant) {
        
    return Votant.vote_recu;
}

function getVoteEmis(Votant) {
    return Votant.vote_emis;
}


 

/*
class Votant{
    constructor(nom,vote_recu,vote_emis,vote = [])
    {
        this.nom = nom;
        this.vote_recu = vote_recu;
        this.vote_emis = vote_emis;
        this.vote = vote;
    }
}
*/