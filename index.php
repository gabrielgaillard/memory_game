<?php
$mysqlClient = new PDO('mysql:host=localhost;dbname=memory_game;charset=utf8', 'root', 'root'); // Connection BDD
$sqlQuery = 'SELECT * FROM memory_game ORDER BY best_time DESC LIMIT 1'; // je selectionne en base de donnée dans la table memory_game le champs best_time qui est décroissant car dans notre jeu le temps est décroissant. J'aurais alors le plus grand temps d'affiché celui qui aura été réalisé le plus rapidement.
$timesStatement = $mysqlClient->prepare($sqlQuery);
$timesStatement->execute(); // excution de la requete
$times = $timesStatement->fetchAll();
foreach ($times as $time) {
    $display_best_time = $time['best_time']; //j'affecte à ma variable display_best_time le temps récupéré en base de donnée, ainsi je vais pouvoir l'afficher dans mon span portant l'id "best_time".
}

if (isset($_GET["time"])) {
    $player_time = $_GET["time"]; // je récupère en GET & j'affecte a ma variable player_time le temps réalisé par le joueur que j'ai précédemment envoyé en AJAX dans index.js

    // j'enregistre le score en BDD 
    $sql =  sprintf("INSERT INTO memory_game (best_time) VALUES (%d)", $player_time); // j'insère dans ma BDD la valeur de mon score afin de pouvoir le récupérer si il est meilleur à la prochaine partie.
    $test = $mysqlClient->prepare($sql);
    $test->execute(); // j'execute la requete d'enregistrement du score
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" dir="ltr">

<head>
    <title>Jeu de M&eacute;moire</title>
    <link href="Assets/CSS/timer.css" rel="stylesheet"> <!-- je charge mes feuilles de styles-->
    <link href="Assets/CSS/index.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> <!-- j'intègre Jquery , j'ai choisi de l'utiliser pour l'ajax présent dans index.js L70 -->
</head>

<body>
    <header>
        <h1 id="principal_title"> Jeu de m&eacute;moire </h1>
    </header>
    <main>
        <div id="score_time">
            <p> Le meilleur temps réalisé est : <span id="best_time"><?php echo $display_best_time ?> </span> ,tente de battre le recoooord ! :)</p> <!-- je n'ai plus qu'a affiché display_best_time -->
        </div>
        <table id="container_game">
            <!-- -je crée un tableau d'image qui correpsondera au tapis de jeu avec mes cartes pour l'instant retournées, mon javascript va gérer l'évenement qui retournera la carte, rdv dans index.js -->
            <tr>
                <td><img src="Assets/img/cartes/fondcarte.jpg"></td>
                <td><img src="Assets/img/cartes/fondcarte.jpg" /></td>
                <td><img src="Assets/img/cartes/fondcarte.jpg" /></td>
                <td><img src="Assets/img/cartes/fondcarte.jpg" /></td>
                <td><img src="Assets/img/cartes/fondcarte.jpg" /></td>
                <td><img src="Assets/img/cartes/fondcarte.jpg" /></td>
                <td><img src="Assets/img/cartes/fondcarte.jpg" /></td>
            </tr>
            <tr>
                <td><img src="Assets/img/cartes/fondcarte.jpg" /></td>
                <td><img src="Assets/img/cartes/fondcarte.jpg" /></td>
                <td><img src="Assets/img/cartes/fondcarte.jpg" /></td>
                <td><img src="Assets/img/cartes/fondcarte.jpg" /></td>
                <td><img src="Assets/img/cartes/fondcarte.jpg" /></td>
                <td><img src="Assets/img/cartes/fondcarte.jpg" /></td>
                <td><img src="Assets/img/cartes/fondcarte.jpg" /></td>
            <tr>
                <td><img src="Assets/img/cartes/fondcarte.jpg" /></td>
                <td><img src="Assets/img/cartes/fondcarte.jpg" /></td>
                <td><img src="Assets/img/cartes/fondcarte.jpg" /></td>
                <td><img src="Assets/img/cartes/fondcarte.jpg" /></td>
                <td><img src="Assets/img/cartes/fondcarte.jpg" /></td>
                <td><img src="Assets/img/cartes/fondcarte.jpg" /></td>
                <td><img src="Assets/img/cartes/fondcarte.jpg" /></td>
            </tr>
            <tr>
                <td><img src="Assets/img/cartes/fondcarte.jpg" /></td>
                <td><img src="Assets/img/cartes/fondcarte.jpg" /></td>
                <td><img src="Assets/img/cartes/fondcarte.jpg" /></td>
                <td><img src="Assets/img/cartes/fondcarte.jpg" /></td>
                <td><img src="Assets/img/cartes/fondcarte.jpg" /></td>
                <td><img src="Assets/img/cartes/fondcarte.jpg" /></td>
                <td><img src="Assets/img/cartes/fondcarte.jpg" /></td>
            </tr>
        </table>
        <div id="container_score">
            <!--  je crée un container pour y stocker mon timer ainsi que la progress bar, cela me permettra de le masquer plus facilement en fin de partie-->
            <div id="timer">
                120
            </div>
            <div id="myProgress">
                <div id="myBar">
                </div>
            </div>
        </div>
    </main>
    <footer>
        <p><br> Tous droits réservés | O'clock | Gabriel GAILLARD </p>
    </footer>
    <script type="text/javascript" src="Assets/JS/index.js"></script><!-- j'appelle mes scripts js-->
    <script type="text/javascript" src="Assets/JS/timer.js"></script>
</body>
</html>