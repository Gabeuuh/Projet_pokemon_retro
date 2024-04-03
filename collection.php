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
$all_poke_from_collector = list_all_pokemon_from_collector($_SESSION['collector_id']);
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma collection</title>
    <link href="CSS/catalogue_style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="CSS/collection_style.css" rel="stylesheet">
    <link href="CSS/accueil_style.css" rel="stylesheet">
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
                <a class="navitem" href="catalogue.php">Attraper des pokémons</a>
                <?php if(!isset($_SESSION['collector_id'])){ ?>
            <button id="connect" onclick="showPopup()">Se connecter</button> <!-- Bouton de connexion -->
            <?php } else { ?>
                <form method="post" action="deconnect.php" id="form_deco">
                <button id="disconnect" type="submit" >Déconnection</button> <!-- Bouton de déconnexion -->
                </form>
            <?php } ?>  <!-- Bouton de connexion -->
        </nav>
        
    </header>

    <main class="main_collection">   <!-- Section contenant les cartes de pokémons -->
            <p>Ici vous pouvez consulter les pokémons que vous possédez</p>
        <section class="collec">
<?php 

$id_collector = get_current_id();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pokemonId = $_POST['pokemon_id'];
    $association_id = $_POST['association_id'];
    if (isset($_POST['add_poke'])){
    add_pokemon_to_collector($id_collector, $pokemonId);
}
    elseif(isset($_POST['delete_poke'])){
        delete_pokemon_from_collector($association_id);
    }
    
   
    header('Location: collection.php');
    exit();
    }
foreach ($all_poke_from_collector as $key_collector){
$tab_collector=get_pokemon_by_id($key_collector["pokemon_id"]);
if(empty($key_collector["pokemon_nickname"]== true)){
    $poke_name=$tab_collector["identifier"];
}
else{
    $poke_name=$key_collector["pokemon_nickname"];}
echo('
        <section class="all_carte">
        <form method="post" action="collection.php">
        <input type="hidden" name="pokemon_id" value="'.$key_collector["pokemon_id"].'">
        <input type="hidden" name="association_id" value="'.$key_collector["association_id"].'">
        <a class="carte" href="details_poke.php?numero='.$key_collector["pokemon_id"].'&association_id='.$key_collector["association_id"].'">
            <p class="titre_poke">'.ucfirst($poke_name).'</p>
            <img class="picture_poke" src="api/img/96px/'.$key_collector["pokemon_id"].'.png" alt="Image du pokémon" />
            <div class="texte">Cliquer pour voir le détail</div>  
                      
        </a>
        <section class="quantite">
            <button type="submit" name="delete_poke" class="boutton">
            <img src="CSS/UI/moins_pixel.png" id="boutton_remove"/>
            </button>

            <button type="submit" name="add_poke" class="boutton">
            <img src="CSS/UI/plus_pixel.png" id="boutton_add"/>
            </button>
            <!-- Affichage de la quantité actuelle -->
        <p class="quantite_poke">Quantité actuel : <span id="number_poke" type="number">'.nombre_poke($key_collector["pokemon_id"]).'</span></p>
        </section>
        </form>
        </section>

    ');
}
?>
</section>
    </main>

    <footer class="bas_autre">

        <img src="CSS/UI/assets_supernes_bas.png" alt="Image du pokémo" alt="bas de l'interface de la super nes" class="bas_supernes"/>
    
    </footer>
   
</body>
</html>