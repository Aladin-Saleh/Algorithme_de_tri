<?php
class VotantData
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
 
}
class Votant 
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

  function setClass($matiere,$vote)
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

  function getAcda()
  {
    return $this->acda;
  }
}



function getListeVotant()
{

  $obj = json_decode(file_get_contents('../JSON/liste_votant.json'));
  $array_votant = array();
  $i = 0;
  foreach($obj as $key=>$val){
  //echo $key." , ";
  $array_votant[$i++] = $key;

}

for ($i=0; $i < count($array_votant); $i++) 
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
  $tab = getListeVotant();

  $matiere = array("ACDA","ANG","APL","ART","ASR","EC","EGOD","MAT","SGBD","SPORT");


  for ($i=0; $i <count($tab) ; $i++) 
  { 
    $test = $tab[$i];
    $votant[$i] = new Votant($test,null,null,null,null,null,null,null,null,null,null);
    //echo $test;
    $votantData[$i] = new VotantData($test);//pas fini
    //echo "<br>------------------------<br>";

    for ($j=0; $j < count($matiere); $j++) 
      { 
        $mat = $matiere[$j];
        
        if (isset($obj->$test->$mat)) 
        {
          //echo $mat;
          //echo "<br>";
          for ($k=0; $k < count($obj->$test->$mat) ; $k++) 
          { 
            $votant[$i]->setClass($mat,$obj->$test->$mat[$k]);
            
            //echo $obj->$test->$mat[$k];
            //echo "<br>";
          }
         
        }
        else
        {
          //echo "Pas de vote";
          break;
        }
      }
      //echo "<br>------------------------<br>";
  }

  $nom_eleve = array();

  for ($i=0; $i < 141; $i++) { 
      $nom_eleve = $tab[$i];
      $votant_score_obj[$i] = new VotantData($nom_eleve);
      echo $nom_eleve;
      echo "<br> point de ";
      echo $nom_eleve;
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