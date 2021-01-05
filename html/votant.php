<?php

/****************************************/
/*            Classe Votant             */
/****************************************/

class VotantData // Class VotantData
{

  //exemple seulement pour acda
  private $nom;
  private $score = 0;
  public function __construct($n)
  {
    $this->nom = $n;
    

  }

  function upgrade_score()
  {
    $this->score++;
  }

  function get_score()
  {
    return $this->score;
  }

} // Fin classe VotantData

class Votant // Classe Votant
{
private $name;
private $acda = array();
private $asr = array();
private $ang = array();
private $egod = array();
private $apl = array();
private $ec = array();
private $sgbd = array();
private $art = array();
private $sport = array();
private $mat = array();

  public function __construct($nom,$acda,$asr,$apl,$mat,$ang,$ec,$egod,$sgbd,$art,$sport)
  {
    $this->name = $nom;
    $this->acda = $acda;
    $this->ang = $ang;
    $this->apl = $apl;
    $this->art = $art;
    $this->asr = $asr;
    $this->ec = $ec;
    $this->egod = $egod;
    $this->mat = $mat;
    $this->sgbd = $sgbd;
    $this->sport = $sport;
  }

  function setClass($matiere,$vote) // Méthode qui attribue à un utilisateur ses votes
  {
    switch ($matiere) 
    {
      case 'ACDA':
        $i = 0;
        if ($this->acda[$i] != null) {
          $i++;
        }
        else
        {
          $this->acda[$i] = $vote;
        }
        break;
      case 'APL':
        $i = 0;
        if($this->apl[$i] != null)
        {
          $i++;
        }
        else
        {
        $apl[$i] = $vote;
        }
        break;
      case 'ASR':
        $i = 0;
        if($this->asr[$i] != null)
        {
          $i++;
        }
        else
        {
        $asr[$i] = $vote;
        }
        break;
      case 'ANG':
        $i = 0;
        if($this->ang[$i] != null)
        {
          $i++;
        }
        else
        {
        $ang[$i] = $vote;
        }
        break;  
      case 'ART':
        $i = 0;
        if($this->art[$i] != null)
        {
          $i++;
        }
        else
        {
        $art[$i] = $vote;
        }
        break;
      case 'EC':
        $i = 0;
        if($this->ec[$i] != null)
        {
          $i++;
        }
        else
        {
        $ec[$i] = $vote;
        }
        break;
      case 'EGOD':
        $i = 0;
        if($this->egod[$i] != null)
        {
          $i++;
        }
        else
        {
        $egod[$i] = $vote;
        }
        break;
      case 'MAT':
        $i = 0;
        if($this->mat[$i] != null)
        {
          $i++;
        }
        else
        {
        $mat[$i] = $vote;
        }
        break;  
      case 'SGBD':
        $i = 0;
        if($this->sgbd[$i] != null)
        {
          $i++;
        }
        else
        {
        $sgbd[$i] = $vote;
        }
        break;
      case 'SPORT':
        $i = 0;
        if($this->sport[$i] != null)
        {
          $i++;
        }
        else
        {
        $sport[$i] = $vote;
        }
        break;
          
      
      default:
       echo "vous ne verrez jamais ce message";
        break;
    }
  }

  function getAcda() // Méthode qui renvoie le tableau acda
  {
    return $this->acda;
  }
} // Fin classe Votant


function getListeVotant()
{

  $obj = json_decode(file_get_contents('../JSON/liste_votant.json'));
  $array_votant = array();
  $i = 0;
  foreach($obj as $key=>$val){ // On assigne les utilisateurs au tableau array_votant
  //echo $key." , ";
    $array_votant[$i++] = $key;
  }

  for ($i=0; $i < count($array_votant); $i++) // Affichage des noms des utilisateurs
  { 
    //echo $array_votant[$i];
    //echo "<br>";
  }

  return $array_votant;

}


function setInfoVote()
{
  echo "Start php function.<br>";
  
  $obj = json_decode(file_get_contents('../JSON/www.iut-fbleau.fr.json'));
  $tab = array();
  $tab = getListeVotant();              // Le tableau tab contient les noms des utilisateurs

  $matiere = array("ACDA","ANG","APL","ART","ASR","EC","EGOD","MAT","SGBD","SPORT");


  for ($i=0; $i <count($tab) ; $i++)    // Pour chaque utilisateur
  { 
    $test = $tab[$i];                         // On assigne la variable test à l'utilisateur courant
    $votant[$i] = new Votant($test,null,null,null,null,null,null,null,null,null,null); // On crée un votant qui a pour nom le nom de récupéré plus haut
    //echo $test;
    $votantData[$i] = new VotantData($test);  // Pas fini
    //echo "<br>------------------------<br>";

    for ($j=0; $j < count($matiere); $j++)    // Pour chaque matière
      { 
        $mat = $matiere[$j];                        // On assigne la variable mat à la matière courante
        
        if (isset($obj->$test->$mat))               // Si l'utilisateur a voté
        {
          //echo $mat;
          //echo "<br>";
          for ($k=0; $k < count($obj->$test->$mat) ; $k++) // Pour toutes les personnes pour qui l'utilisateur a voté,
          { 
            $votant[$i]->setClass($mat,$obj->$test->$mat[$k]);    // On attribue les votes à l'utilisateur
            
            //echo $obj->$test->$mat[$k];
            //echo "<br>";
          }
         
        }
        else                                        // Sinon
        {
          //echo "Pas de vote";
          break;
        }
      }
      //echo "<br>------------------------<br>";
  }

  $nom_eleve = array();

  for ($i=0; $i < 141; $i++) {  // Pour chaque élève 
      $nom_eleve = $tab[$i];    // On attribue la variable nom_eleve à l'élève courant
      $votant_score_obj[$i] = new VotantData($nom_eleve);
      echo $nom_eleve;
      echo "<br> point de $nom_eleve";
      echo "<br>";
      for ($j=0; $j < 141; $j++) { 
          $mat = $matiere[0];
          $votant_sc = $tab[$j]; 
          if (isset($obj->$votant_sc->$mat)) 
          {
           
            for ($k=0; $k <count($obj->$votant_sc->$mat) ; $k++) { 
              echo $mat;
              echo "<br>";
              echo $obj->$votant_sc->$mat[$k];
              echo "   : ";
              echo $nom_eleve;
              if ($nom_eleve == $obj->$votant_sc->$mat[$k]) {
                $votant_score_obj[$i]->upgrade_score();
              }
              echo "<br>";

            }

          }
        
      }
  }

  for ($i=0; $i < 141; $i++) { 
    //score acda
    echo $votant_score_obj[$i]->get_score();
    echo "<br>";
  }

}

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

setInfoVote();

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


















?>