<?php

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
    private $score = array(1/141, 1/141, 1/141, 1/141, 1/141, 1/141, 1/141, 1/141, 1/141, 1/141);
    public function __construct($n)
    {
      $this->nom = $n;
    }

    function upgrade_score($matiere,$nombre_de_vote_emis) // 0 = acda, 1 = anglais, 2 = apl, 4 = art, 4 = asr, 5 = ec, 6 = egod, 7 = maths, 8 = sgbd, 9 = sport
    {
      //$this->score[$matiere] += $this->score[$matiere] * 0.85 + 0.15 (1/$nombre_de_vote_emis);
      $this->score[$matiere] += $this->score[$matiere] * (1/$nombre_de_vote_emis);
    }

    function diluer_score($nombre_de_vote_emis) {
      $alpha = 0.15;
      //echo "diluage";
      for($i = 0; $i < 10; $i++){
        $this->score[$i] = ((1-$alpha) * $this->score[$i] + (($alpha) * 1/$nombre_de_vote_emis));
      }
    }

    function get_score($matiere)
    {
      return $this->score[$matiere];
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

    for ($a=0; $a <10 ; $a++) { 
      for ($i=0; $i < count($tab); $i++) { 
        $nom_eleve = $tab[$i];
        $votant_score_obj[$i] = new VotantData($nom_eleve);
        for ($j=0; $j < count($tab); $j++) { 
          for($l = 0; $l < 10; $l++){
            $mat = $matiere[$l];
            $votant_sc = $tab[$j]; 
            if ($votant_sc != $nom_eleve) {
              
              if (isset($obj->$votant_sc->$mat)) 
              {
                for ($k=0; $k <count($obj->$votant_sc->$mat) ; $k++) { 
                  if ($nom_eleve == $obj->$votant_sc->$mat[$k]) {
                    $votant_score_obj[$i]->upgrade_score($l,count($obj->$votant_sc->$mat));
                    //$votant_score_obj[$i]->diluer_score(count($obj->$votant_sc->$mat));
                  }
                  //echo "<br>";
                }
              }
              
            }
          }
        }
      }
    }
/*
    for($m = 0; $m < count($votant_score_obj); $m++) {
      if (isset($obj->$votant_sc->$mat)) {
        $votant_score_obj[$m]->diluer_score(count($obj->$votant_sc->$mat));
      }
    }*/

    for ($i=0; $i < count($tab); $i++) { 

      $matiere = array("ACDA","ANG","APL","ART","ASR","EC","EGOD","MAT","SGBD","SPORT");
      $nom_eleve = $tab[$i];

      echo $nom_eleve;
      echo "<br>";
      for($j = 0; $j < 10; $j++) {
        echo $matiere[$j];
        echo " : ";
        echo $votant_score_obj[$i]->get_score($j);
        echo "<br>";
      }
      echo "------------------------------------------------<br>";
    }
    return $votant_score_obj;
  }

  getScore();

  function getScore()
  {

    if(isset($_POST["math"]) || isset($_POST["anglais"]) || isset($_POST["EC"]) || isset($_POST["EGOD"]) || isset($_POST["ASR"]) || isset($_POST["ACDA"]) || isset($_POST["SGBD"]) || isset($_POST["APL"]) || isset($_POST["ART"]) || isset($_POST["SPORT"])) 
    {
      $nom_eleve;
      $tab = array();
      $tab = getListeVotant();
      $matiere = array("ACDA","ANG","APL","ART","ASR","EC","EGOD","MAT","SGBD","SPORT");
      $votant_score_obj = setPoint();
      if(isset($_POST["ACDA"])) {
        echo "acda a été coché<br>";
        prems(0, $votant_score_obj);
      }
      if(isset($_POST["anglais"])) {
        echo "anglais a été coché<br>";
        prems(1, $votant_score_obj);
      }
      if(isset($_POST["APL"])) {
        echo "apl a été coché<br>";
        prems(2, $votant_score_obj);
      }
      if(isset($_POST["ART"])) {
        echo "art a été coché<br>";
        prems(3, $votant_score_obj);
      }
      if(isset($_POST["ASR"])) {
        echo "asr a été coché<br>";
        prems(4, $votant_score_obj);
      }
      if(isset($_POST["EC"])) {
        echo "ec a été coché<br>";
        prems(5, $votant_score_obj);
      }
      if(isset($_POST["EGOD"])) {
        echo "egod a été coché<br>";
        prems(6, $votant_score_obj);
      }
      if(isset($_POST["math"])) {
        echo "maths a été coché<br>";
        prems(7, $votant_score_obj);
      }
      if(isset($_POST["SGBD"])) {
        echo "sgbd a été coché<br>";
        prems(8, $votant_score_obj);
      }
      if(isset($_POST["SPORT"])) {
        echo "sport a été coché<br>";
        prems(9, $votant_score_obj);
      }
    }
  }

  function prems($choix, $votant_score_obj) {
    $nom_eleve;
    $tab = array();
    $tab = getListeVotant();
    $premier_score = $votant_score_obj[0]->get_score($choix);
    $premier_nom;
    $matiere = array("ACDA","ANG","APL","ART","ASR","EC","EGOD","MAT","SGBD","SPORT");
    for ($i=0; $i < count($tab); $i++) {
      $nom_eleve = $tab[$i];
      if ($votant_score_obj[$i]->get_score($choix) > $premier_score ) {
        $premier_score = $votant_score_obj[$i]->get_score($choix);
        $premier_nom = $nom_eleve;
      }
    }

    echo "Le plus fort c'est lui ! <br>";
    echo $premier_nom;
    echo " : ";
    echo $matiere[$choix];
    echo " = ";
    echo $premier_score;
    echo "<br><br>";
  }

?>