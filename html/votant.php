<?php


/*
 * @author Aladin SALEH & Paul MINGUET
 * 1. Créer le graphe p° et la matrice P grâce aux votes.
 * p° = 1/nombre de votants
 * P = matrice = votes de votant 1 vers votant 2 etc...
 *
 * 2. Calculer pⁿ⁺¹ grâce à pⁿ*P
 *
 * 3. Trouver un état stable (si pⁿ⁺¹ = pⁿ)
 * Si état stable précis : p = valeurs stables (= pⁿ⁺¹ = pⁿ)
 * Sinon, s'il oscille entre deux valeurs, faire la moyenne des deux pour trouver un état "stable"
 *
 * 4. Diluer et obtenir l'ordre
 */

/* P°=1/143
 * P°={1/143, 1/143, 1/143}
 *
 * [0,   1/3, 0,   1/3, 1/3, 0,   0,  0
 * 1/5, 0,   1/5, 1/5, 0,   1/5, 1/5, 0
 * 0,   0,   1/2, 0,   1/2, 0,   0,   0 
 * ]
 *
 * P1={1/141*1/5,...}
 */

  /****************************************/
  /*            Classe Votant             */
  /****************************************/

  class VotantData // Class VotantData
  {

   //On stocke tout les votants dans une classe VotantData
   //Un votant a un nom,score et poids.
    private $nom;
   
    private $poids = array(1/143,1/143,1/143,1/143,1/143,1/143,1/143,1/143,1/143,1/143);//P0 le poids de chaque "page" est le meme 1/(le nombre d'eleve(page))
    private $score = array(1/143 * 1/143,1/143 * 1/143,1/143 * 1/143,1/143 * 1/143,1/143 * 1/143,1/143 * 1/143,1/143 * 1/143,1/143 * 1/143,1/143 * 1/143,1/143 * 1/143);//au debut P0 le score de tout le monde est 1/143 * 1/143
    public function __construct($n)
    {
      $this->nom = $n;

    }

    function upgrade_score($matiere,$nombre_de_vote_emis)//Cette fonction est appelle lors du vote
    {
       //si 0.85=d, a=1-d=0.15
      //on multiplie par 1-a=0.85, et on rajoute 0.15 aux scores
      //la hiérarchie est respectée
      $this->score[$matiere] += (0.15/$this->poids[$matiere]) + 0.85*(1/$nombre_de_vote_emis);
     
    }

    function diluer_score() {//Premier fonction de test pour diluer, il se peut quelle ne soit pas utiliser voir supprimer
     
      $alpha = 0.15;
      //echo "diluage";
      for($i = 0; $i < 10; $i++){
        $this->score[$i] = ((1-$alpha) * $this->score[$i] )+ $alpha ;
      }
    }

    function reduce_score($matiere)
    {
      $this->score[$matiere] = $this->score[$matiere]/100;
    }

    function setPoids($indice,$new_value)
    {
      $this->poids[$indice] = $new_value;
    }

    function get_score($matiere)
    {
      return $this->score[$matiere];
    }

    function get_nom()
    {
      return $this->nom;
    }

  } // Fin classe VotantData
  function getListeVotant()
  {
    $obj = json_decode(file_get_contents('../JSON/liste_votant.json'));
    $array_votant = array();
    $i = 0;
    foreach($obj as $key=>$val){ // On assigne les utilisateurs au tableau array_votant
     
      $array_votant[$i++] = $key;
    }
    return $array_votant;
  }

  function setPoint()
  {
    $nom_eleve;
    $tab = array();
    $tab = getListeVotant();
    $matiere = array("ACDA","ANG","APL","ART","ASR","EC","EGOD","MAT","SGBD","SPORT");
    $obj = json_decode(file_get_contents('../JSON/www.iut-fbleau.fr.json'));

    for ($i=0; $i < count($tab); $i++) {
      //On crée les objet votant
      $nom_eleve = $tab[$i];
      $votant_score_obj[$i] = new VotantData($nom_eleve);
    }
      for ($itteration=0; $itteration < 10; $itteration++) { //On ittere 10 fois pour être le plus précis possible et que ce ne soit pas trop long
        /*
        *On ittere autant dde fois qu'il ya de votant
        *On rentre ensuite dans une 2e boucle qui elle aussi ittere autant de fois qu'il y'a de votant
        *Enfin on compare les votes des votants de la 2e boucle avec le votant de la premiere boucle
        *Si le nom du votant est le meme cela veut dire qu'il a reçu un vote, on lui upgrade(augmente) donc son score
        *Une fois que tout les votes ont été recuperé, on set(défini) les nouveaux poids et on recommence 
        */
        for ($i=0; $i < count($tab); $i++) { 
          $nom_eleve = $tab[$i];
          for ($j=0; $j < count($tab); $j++) { 
            for($l = 0; $l < 10; $l++){
              $mat = $matiere[$l];
              $votant_nom = $tab[$j]; 
               if ($nom_eleve != $votant_nom) {
                if (isset($obj->$votant_nom->$mat)) 
                {
                  for ($k=0; $k <count($obj->$votant_nom->$mat) ; $k++) { 
                    if ($nom_eleve == $obj->$votant_nom->$mat[$k]) {
                      $votant_score_obj[$i]->upgrade_score($l,count($obj->$votant_nom->$mat));
                    }
                  }
                }
               }
            }
          }
        }
        for ($ind_user=0; $ind_user < count($tab); $ind_user++) { 
          for ($ind=0; $ind < 10; $ind++) { 
            $votant_score_obj[$ind_user]->setPoids($ind,$votant_score_obj[$ind_user]->get_score($ind));
            $votant_score_obj[$ind_user]->reduce_score($ind);
          }
        }
      }
    return $votant_score_obj;
  }

  getScore();
  

  function getScore() {
    if(isset($_POST["math"]) || isset($_POST["anglais"]) || isset($_POST["EC"]) || isset($_POST["EGOD"]) || isset($_POST["ASR"]) || isset($_POST["ACDA"]) || isset($_POST["SGBD"]) || isset($_POST["APL"]) || isset($_POST["ART"]) || isset($_POST["SPORT"])) {
      $nom_eleve;
      $tab_matieres = array();
      $tab = array();
      $tab = getListeVotant();
      $top_score = array();
      $matiere = array("ACDA","ANG","APL","ART","ASR","EC","EGOD","MAT","SGBD","SPORT");
      $coche = array("ACDA", "anglais", "APL", "ART", "ASR", "EC", "EGOD", "math", "SGBD", 'SPORT');
      $votant_score_obj = setPoint();

      for($i = 0; $i < count($coche); $i++) {
        if(isset($_POST[$coche[$i]])) {
          array_push($tab_matieres, $i);
        }
      }
      prems($tab_matieres, $votant_score_obj);
    }
  }

  function prems($choix, $votant_score_obj) {
    $nom_eleve;
    $tab = array();
    $tab = getListeVotant();
    $score_eleves = array();
    $premier_score = 0;
    $premier_nom;
    $matiere = array("ACDA","ANG","APL","ART","ASR","EC","EGOD","MAT","SGBD","SPORT");
    for ($i=0; $i < count($tab); $i++) {
      $score = 0;
      $nom_eleve = $tab[$i];
      for($j = 0; $j < count($choix); $j++){
        $score += $votant_score_obj[$i]->get_score($choix[$j]);
      }
      $score = $score/count($choix);
      $score_eleves[$nom_eleve] = $score;
      arsort($score_eleves);
      if ($score > $premier_score ) {
        $premier_score = $score;
        $premier_nom = $nom_eleve;
      }
    }

    echo '<!DOCTYPE html>
    <html lang="fr">
    
    <head>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Résultats</title>
    
        <h1 style="text-align: center;">RÉSULTATS</h1>
    </head>
    <body>
        <a href="main_page.php"><button>Retour au choix des matières</button></a><br>';
  
    echo "Matières sélectionnées : ";
    for($i = 0; $i < count($choix)-1; $i++) {
      echo $matiere[$choix[$i]];
      echo ", ";
    }
    echo $matiere[$choix[count($choix)-1]];

    echo '<table class="greyGridTable">';
    echo "<thead><tr><th>Rang</th><th>Nom</th><th>Score</th><th>Progression</th></thead>";
    $count = 1;
    foreach ($score_eleves as $nom_eleve => $score) {
      echo '<tr><td>'.$count.'</td><td>'.$nom_eleve.'</td><td>'.$score.'</td><td><div class="w3-light-grey">
      <div class="w3-container w3-grey w3-center" style="width:'.exp($score*73).'%">&nbsp;</div>
    </div></td></tr>';
      $count++;
    }
    echo "</table>";
  }

?>