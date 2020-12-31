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
        $acda[] = $vote;
        break;
      case 'APL':
        $apl[] = $vote;
        break;
      case 'ASR':
        $asr[] = $vote;
        break;
      case 'ANG':
        $ang[] = $vote;
        break;  
      case 'ART':
        $art[] = $vote;
        break;
      case 'EC':
        $ec[] = $vote;
        break;
      case 'EGOD':
        $egod[] = $vote;
        break;
      case 'MAT':
        $mat[] = $vote;
        break;  
      case 'SGBD':
        $sgbd[] = $vote;
        break;
      case 'SPORT':
        $sport[] = $vote;
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


function getInfoVote()
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
            $votant[$i]->setClass($mat,$mat[$k]);
            echo $obj->$test->$mat[$k];
            echo "<br>";
          }
          echo "gettttttttttttttttttttttttttttttttttttttttttttttttt<br>";
          echo $votant[$i]->getAcda();
         
         
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




getInfoVote();
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