<!DOCTYPE html>
<html lang="fr">
<?php
include_once 'pokemon_api.php';
file_get_contents('collector_data.json');
file_get_contents('collector_pokemon_association.json');
file_get_contents('pokemon_data.json');
session_start();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Pokémon</title>
    <link href="CSS/accueil_style.css" rel="Stylesheet"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="collection.html">
    <link href="catalogue.html">
</head>
<body>

<?php
if (isset($_SESSION['collector_id'])){
    $username=get_collector_by_id($_SESSION['collector_id'])['collector_name'];
}
else{
    $username="Merci de vous connecter";
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if($_POST['type']=='connect'){
        $id_collector = $_POST['id_collector_exist'];
        $username = $_POST['username_exist'];
        $result = verify_collector($id_collector, $username);
        if ($result == "Connecté") {
            $username=get_collector_by_id($_SESSION['collector_id'])['collector_name'];
        }
        elseif ($result == "Mauvais id") {
            $username="Mauvaise combinaison Nom/Id";
        }
        elseif ($result == "Mauvais nom") {
            $username="Mauvaise combinaison Nom/Id";

        }   
    }
    elseif($_POST["type"]=='create'){
        $username_create=$_POST['username_create'];
        $id_collector_create=$_POST['id_collector_create'];
        $gender=$_POST['gender'];
        try {
            add_collector($id_collector_create,$username_create,$gender);
            $_SESSION['collector_id']=$id_collector_create;
            $username=$username_create;
        } 
        catch (\Throwable $th) {
            $username="ID déja existant !";
        }
    }
    

}
?>
<header class="header_nav"> <!-- En-tête de la page -->
    <nav class="menu">   
            <a class="navitem" href="collection.php">Ma collection</a>         <!-- Liens de navigation -->
            <a class="navitem" href="catalogue.php">Attraper des pokemons</a>  
            <?php if(!isset($_SESSION['collector_id'])){ ?>
            <button id="connect" onclick="showPopup()">Se connecter</button> <!-- Bouton de connexion -->
            <?php } else { ?>
                <form method="post" action="deconnect.php" id="form_deco">
                <button id="disconnect" type="submit" >Déconnection</button> <!-- Bouton de déconnexion -->
                </form>
            <?php } ?>
<div id="connect_popup">
    <form method="post" action="index.php">
    <div class="barre_bleu"><button onclick="hidePopup()">X</button></div>
    <!-- Contenu de la pop-up de connexion -->
    <h2>Connecter vous</h2>
    <input type="hidden" name="type" value="connect"/>
    <!-- Champs de connexion (nom d'utilisateur, ID , etc.) -->
    <label for="username_exist">Nom d'utilisateur :</label>
    <input type="text" name="username_exist">

    <label for="id_collector_exist">ID :</label>
    <input type="password" name="id_collector_exist">
    <button onclick="hidePopup()" type="submit" name="connect">Se connecter</button>
    </form>
    <form method="post" action="index.php">
    <h2>Créer un compte</h2>
    <input type="hidden" name="type" value="create"/>
    <label for="username_create">Nom d'utilisateur :</label>
    <input type="text" name="username_create">
    <label for="id_collector_create">ID :</label>
    <input type="password" name="id_collector_create">
    <label for="gender">Genre :</label>
    <input type="text" name="gender">
    <button onclick="hidePopup()">Créer un compte</button>
    </form>
</div>

<script>
    // Fonction pour afficher la pop-up
    function showPopup() {
        var popup = document.getElementById('connect_popup');
        popup.style.display = 'block';
    }

    // Fonction pour cacher la pop-up
    function hidePopup() {
        var popup = document.getElementById('connect_popup');
        popup.style.display = 'none';
    }
</script>
          
    </nav>
    
</header>


<main class="main_accueil"> <!-- Coeur de la page-->

    
<section class="choix"> <!-- Section pour choisir entre "Ma collection" et "Attraper des pokemons" -->
    <a class="select_main_collection" href="collection.php">Ma collection</a>
    <img src="CSS/UI/pokeball_haut.png" id="haut_collection" alt="Haut d'une pokeball"/>
    <img src="CSS/UI/pokeball_bas.png" id="bas_collection" alt="Bas d'une pokeball"/>
</section>

<section class="container_bienvenue">
<p class="mess_bienvenue">Bienvenue </p>
<?php 
if (isset($username)){
 echo '  <p id="nom_dresseur">'.$username.'</p>';
}
?>
</section>
<section class="choix">    
    <a class="select_main_catalogue" href="catalogue.php">Attraper des pokemons</a>
    <img src="CSS/UI/pokeball_haut.png" id="haut_catalogue" alt="Haut d'une pokeball"/>
    <img src="CSS/UI/pokeball_bas.png" id="bas_catalogue" alt="Bas d'une pokeball"/>
</section>

</main>

<footer class="bas_accueil">    <!-- Pied de page de la page -->


    <img src="CSS/UI/assets_supernes_bas.png" alt="bas de l'interface de la super nes" class="bas_supernes_accueil"/>

</footer>

</body>
</html>