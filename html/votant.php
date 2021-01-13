<?php

//echo count(getListeVotant())."<br>";
/*
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

/* P°=1/141
 * P°={1/141, 1/141, 1/141}
 *
 * [0,   1/3, 0,   1/3, 1/3, 0,   0,  0
 * 1/5, 0,   1/5, 1/5, 0,   1/5, 1/5, 0
 * 0,   0,   1/2, 0,   1/2, 0,   0,   0 
 * ]
 *
 * P1={1/141*1/5, }
 */

  /****************************************/
  /*            Classe Votant             */
  /****************************************/

  class VotantData // Class VotantData
  {

    //exemple seulement pour acda
    private $nom;
   
    private $poids = 1/143;
    private $score = array(1/143 * 1/143,1/143 * 1/143,1/143 * 1/143,1/143 * 1/143,1/143 * 1/143,1/143 * 1/143,1/143 * 1/143,1/143 * 1/143,1/143 * 1/143,1/143 * 1/143);
    public function __construct($n)
    {
      $this->nom = $n;


    }

    function upgrade_score($matiere,$nombre_de_vote_emis) 
    {
      $this->score[$matiere] += 0.15/143 + 0.85*(1/143);
    }

    function diluer_score() {
      $alpha = 0.15;
      //echo "diluage";
      for($i = 0; $i < 10; $i++){
        $this->score[$i] = ((1-$alpha) * $this->score[$i] )+ $alpha ;
      }
    }

    function setPoids($new_value)
    {
      $this->poids = $new_value;
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
      //echo $key." , ";
      $array_votant[$i++] = $key;
    }

    /*for ($i=0; $i < count($array_votant); $i++) // Affichage des noms des utilisateurs
    { 
      //echo $array_votant[$i];
      //echo "<br>";
    }*/

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
        $nom_eleve = $tab[$i];
        $votant_score_obj[$i] = new VotantData($nom_eleve);
        for ($j=0; $j < count($tab); $j++) { 
          for($l = 0; $l < 10; $l++){
            $mat = $matiere[$l];
            $votant_sc = $tab[$j]; 
              if (isset($obj->$votant_sc->$mat)) 
              {
                for ($k=0; $k <count($obj->$votant_sc->$mat) ; $k++) { 
                  if ($nom_eleve == $obj->$votant_sc->$mat[$k]) {
                    $votant_score_obj[$i]->upgrade_score($l,count($obj->$votant_sc->$mat));
                  }
                }
              }
            
          }
        }
      }
      for ($i=0; $i <count($tab) ; $i++) { 
        $votant_score_obj[$i]->diluer_score();
      }

      for ($i=0; $i < count($tab); $i++) { 

        $matiere = array("ACDA","ANG","APL","ART","ASR","EC","EGOD","MAT","SGBD","SPORT");
        $nom_eleve = $tab[$i];
  
        //echo $nom_eleve;
        //echo "<br>";
        for($j = 0; $j < 10; $j++) {
          //echo $matiere[$j];
          //echo " : ";
          //echo $votant_score_obj[$i]->get_score($j);
          //echo "<br>";
        }
        //echo "------------------------------------------------<br>";
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
          //echo "$coche[$i] a été coché<br>";
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

    /*echo "<br>Le plus fort c'est lui ! <br>";
    echo $premier_nom;
    echo " : ";
    for($i = 0; $i < count($choix); $i++) {
      echo $matiere[$choix[$i]];
      if(count($choix) > 1)
        echo ", ";
    }
    echo " = ";
    echo $premier_score;
    echo "<br><br><br>";
    echo "Les autres : <br>";*/
    for($i = 0; $i < count($choix); $i++) {
      echo $matiere[$choix[$i]];
      if(count($choix) > 1)
        echo ", ";
    }
    echo "<table>";
    $count = 1;
    foreach ($score_eleves as $nom_eleve => $score) {
      echo "<tr><th>$count</th><th>$nom_eleve</th><th>$score</th></tr>";
      $count++;
    }
  }

?>