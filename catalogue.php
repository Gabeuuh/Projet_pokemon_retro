<!DOCTYPE html>
<html lang="fr">
<?php
session_start();
include_once 'pokemon_api.php';
file_get_contents('collector_data.json');
file_get_contents('collector_pokemon_association.json');
file_get_contents('pokemon_data.json');
if (!isset($_SESSION['collector_id'])){
    header("Location: index.php");
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue</title>
    <link href="CSS/catalogue_style.css" rel="stylesheet">
    <link href="CSS/accueil_style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cabin+Condensed:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="header_nav">     <!-- En-tête de la page -->
        <nav class="menu">  <!-- Liens de navigation -->
                <a class="navitem" href="index.php">Accueil</a>
                <a class="navitem" href="collection.php">Ma collection</a>
                <?php if(!isset($_SESSION['collector_id'])){ ?>
            <button id="connect" onclick="showPopup()">Se connecter</button> <!-- Bouton de connexion -->
            <?php } else { ?>
                <form method="post" action="deconnect.php" id="form_deco">
                <button id="disconnect" type="submit" >Déconnection</button> <!-- Bouton de déconnexion -->
                </form>
            <?php } ?>  <!-- Bouton de connexion -->
        </nav>
        
    </header>
    
    <main class="main_catalogue">
        <p>Vous pouvez consulter tous les pokémons existants</p>
    <section class="all_poke">  <!-- Section contenant les cartes de pokémons -->

<?php 
$all_poke= list_all_pokemon();
foreach($all_poke as $key => $value){
    echo('
        <section class="all_carte">
        <form method="post" action="collection.php">
        <input type="hidden" name="pokemon_id" value="'.$key.'">
        <a class="carte" href="details_poke.php?numero='.$key.'"> <!-- Répétition des cartes avec des liens vers les détails -->
            <p class="titre_poke">'.ucfirst($value["identifier"]).'</p> <!-- Nom du pokémon -->
            <img class="picture_poke" src="api/img/96px/'.$key.'.png"alt="Image du pokémon"/> <!-- Image du pokémon -->
            <p class="texte">Cliquer pour voir le détail et en ajouter à votre collection</p> <!-- Phrase invitant à cliquer sur la carte -->
        </a>
        <section class="quantite">
            <button type="submit" name="add_poke" class="boutton">
            <img src="CSS/UI/plus_pixel.png" id="boutton_add"/>
            </button>
            <!-- Affichage de la quantité actuelle -->
        <p class="quantite_poke">Quantité actuelle : <span id="number_poke" type="number">'.nombre_poke($key).'</span></p>
        </section>
        </form>
    </section>
');
}
?>
        

    
    </section>  
        


    </main>


    <footer class="bas_autre">      <!-- Pied de page -->
        <img src="CSS/UI/assets_supernes_bas.png"alt="Image du pokémon" alt="bas de l'interface de la super nes" class="bas_supernes"/>
    
    </footer>
</body>
</html>