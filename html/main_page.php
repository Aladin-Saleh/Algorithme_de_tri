<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="stylesheet" href="http://www.iut-fbleau.fr/css/tacit.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="http://www.iut-fbleau.fr/projet/maths/?f=pagerank.js"></script>
    <script src="http://www.iut-fbleau.fr/projet/maths/?f=logins.js"></script>
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
        <form name="checkbox_matiere" method="post" action="votant.php">
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

            <input type="checkbox" id="ART" name="ART" value="ART">
            <label for="ART" > ART</label><br>

            <input type="checkbox" id="SPORT" name="SPORT" value="SPORT">
            <label for="SPORT" > SPORT</label><br>

            <button type="submit" style="text-align: center;">
              <p>afficher le résultat</p>
            </button>
        </form>
        

        
        
      </div>
    
</body>
</html>