<?php

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
    $this->nom = $nom;
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
          echo $i;
          echo "<br>";
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
    echo $test;
    echo "<br>------------------------<br>";

    for ($j=0; $j < count($matiere); $j++) 
      { 
        $mat = $matiere[$j];
        
        
        if (isset($obj->$test->$mat)) 
        {
          echo $mat;
          echo "<br>";
          for ($k=0; $k < count($obj->$test->$mat) ; $k++) 
          { 
            $votant[$i]->setClass($mat,$obj->$test->$mat[$k]);
            echo $obj->$test->$mat[$k];
            echo "<br>";
          }
          
         
        }
        else
        {
          echo "Pas de vote";
          break;
        }

      }
      echo "<br>------------------------<br>";
   

  }
 
}




setInfoVote();
?>


<!DOCTYPE html>
<html lang="fr">
<link rel="stylesheet" href="http://www.iut-fbleau.fr/css/tacit.css">
<link rel="stylesheet" href="../css/style.css">
<script src="http://www.iut-fbleau.fr/projet/maths/?f=pagerank.js"></script>
<script src="http://www.iut-fbleau.fr/projet/maths/?f=logins.js"></script>
<script src="../js/test.js"></script>
<script src="../js/Votant.js"></script>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le Joli Classificateur</title>

    <h1 style="text-align: center;">LE JOLI CLASSIFICATEUR DE PAUL & ALADIN</h1>
</head>
<body>
    
<h2 style="text-align: center;">Sélectionner les matières qui seront prises en compte lors de la recherche du meilleur élève !</h2>
</br>
</br>
</br>

    <div style="column-count: 2; text-align: center;">
        <form name="checkbox_matiere">
            <input type="checkbox" id="math" name="math" value="math">
            <label for="math"> Math</label><br>
    
            <input type="checkbox" id="anglais" name="anglais" value="anglais">
            <label for="anglais"> Anglais</label><br>
    
            <input type="checkbox" id="EC" name="EC" value="EC">
            <label for="EC"> EC</label><br>
    
            <input type="checkbox" id="EGOD" name="EGOD" value="EGOD">
            <label for="EGOD"> EGOD</label><br>
    
            <input type="checkbox" id="ASR" name="ASR" value="ASR">
            <label for="EGOD"> ASR</label><br>
    
            <input type="checkbox" id="ACDA" name="ACDA" value="ACDA">
            <label for="ACDA"> ACDA</label><br>
    
            <input type="checkbox" id="SGBD" name="SGBD" value="SGBD">
            <label for="SGBD"> SGBD</label><br>
    
            <input type="checkbox" id="APL" name="APL" value="APL">
            <label for="APL" > APL</label><br>
        </form>
        

        
        
      </div>

      <button onclick="getCheckbox()" style="text-align: center;">
        <p>afficher le résultat</p>
      </button>
    
</body>
</html>