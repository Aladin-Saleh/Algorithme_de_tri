<?php

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
      $this->score[$matiere] += $this->score[$matiere] * (1/$nombre_de_vote_emis);
    }

    function get_score($matiere)
    {
      return $this->score[$matiere];
    }

  } // Fin classe VotantData

  function getVotesMatiere($matiere)
  {
    echo $matiere;
    switch ($matiere) 
    {
      case 'ACDA':
        echo $acda;
        break;
      case 'APL':
        echo $apl;
        break;
      case 'ASR':
        echo $asr;
        break;
      case 'ANG':
        echo $ang;
        break;  
      case 'ART':
        echo $art;
        break;
      case 'EC':
        echo $ec;
        break;
      case 'EGOD':
        echo $egod;
        break;
      case 'MAT':
        echo $mat;
        break;  
      case 'SGBD':
        echo $sgbd;
        break;
      case 'SPORT':
        echo $sport;
        break;


      default:
        echo "vous ne verrez jamais ce message";
        break;
    }
  }



  /*
  1. Créer le graphe p° et la matrice P grâce aux votes.
  p° = 1/nombre de votants
  P = matrice = votes de votant 1 vers votant 2 etc...

  2. Calculer pⁿ⁺¹ grâce à pⁿ*P

  3. Trouver un état stable (si pⁿ⁺¹ = pⁿ)
  Si état stable précis : p = valeurs stables (= pⁿ⁺¹ = pⁿ)
  Sinon, s'il oscille entre deux valeurs, faire la moyenne des deux pour trouver un état "stable"

  4. Diluer et obtenir l'ordre
  */


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
    echo count($obj->saleh->ACDA);

    /* P°=1/141
    P°={1/141, 1/141, 1/141}

    [0,   1/3, 0,   1/3, 1/3, 0,   0,   0
    1/5, 0,   1/5, 1/5, 0,   1/5, 1/5, 0
    0,   0,   1/2, 0,   1/2, 0,   0,   0 
    ]

    P1={1/141*1/5, }*/

    for ($a=0; $a <50 ; $a++) { 
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
                //echo "<br>";
              }
            }
          }
        }
      }
    }

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

  }

  setPoint();

  if(isset($_POST["math"]) || isset($_POST["anglais"]) || isset($_POST["EC"]) || isset($_POST["EGOD"]) || isset($_POST["ASR"]) || isset($_POST["ACDA"]) || isset($_POST["SGBD"]) || isset($_POST["APL"]) || isset($_POST["ART"]) || isset($_POST["SPORT"])) {
      $nom_eleve;
      $tab = array();
      $tab = getListeVotant();
      $matiere = array("ACDA","ANG","APL","ART","ASR","EC","EGOD","MAT","SGBD","SPORT");
      for ($i=0; $i < count($tab); $i++) {
        $nom_eleve = $tab[$i];
        $votant_score_obj[$i] = new VotantData($nom_eleve);
        echo $nom_eleve;
        echo " : ";
        echo "maths";
        echo " = ";
        echo $votant_score_obj[$i]->get_score(7);
        echo "<br>";
      }
  }

?>