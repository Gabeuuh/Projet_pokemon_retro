<!DOCTYPE html>
<html lang="fr">
<?php
session_start();
include_once 'pokemon_api.php';
file_get_contents('collector_data.json');
file_get_contents('collector_pokemon_association.json');
file_get_contents('pokemon_data.json');
$all_poke_from_collector = list_all_pokemon_from_collector(1);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails pokémon</title>
    <link href="CSS/accueil_style.css" rel="Stylesheet" />
    <link href="CSS/details_poke_style.css" rel="Stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
</head>

<body>

    <header class="header_nav">
        <nav class="menu">
            <a class="navitem" href="index.php">Accueil</a>
            <a class="navitem" href="collection.php">Ma collection</a>
            <a class="navitem" href="catalogue.php">Attraper des pokémons</a>
            <?php if (!isset($_SESSION['collector_id'])) { ?>
                <button id="connect" onclick="showPopup()">Se connecter</button> <!-- Bouton de connexion -->
            <?php } else { ?>
                <form method="post" action="deconnect.php" id="form_deco">
                    <button id="disconnect" type="submit">Déconnexion</button> <!-- Bouton de déconnexion -->
                </form>
            <?php } ?>
        </nav>
    </header>


    <main class="main_detail">
        <!-- Section supérieure de la description -->
        <article class="haut_description">
            <p class="haut_gauche">Détails pokémon</p>
            <button class="next_poke">Pokémon suivant</button>
        </article>
        <section class="centre_description">
            <article class="desc_gauche">
                <div class="titre_desc">
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        $id = $_POST["numero"];
                        $association_id = $_POST["association_id"];
                        $rename = $_POST["rename_poke"];
                        change_pokemon_nickname($association_id, $rename);
                    } else {
                        $id = $_GET["numero"];
                    }

                    $tab_poke = get_pokemon_by_id($id);

                    if (isset($_GET["association_id"])) {
                        $association_id = $_GET["association_id"];
                        $rename = get_association_by_id($association_id)["pokemon_nickname"];
                    }
                    if (empty($rename)) {
                        $poke_name = $tab_poke["identifier"];
                    } else {
                        $poke_name = $rename;
                    }
                    echo ("<h1>" . ucfirst($poke_name) . "</h1>");
                    ?>
                    <button class="crayon_bouton" onclick="rename()">
                        <img src="CSS\UI\crayon_pixel.png" alt="Crayon pixellisé" class="crayon" />
                    </button>
                    <?php
                    if (isset($id) && isset($association_id)) {
                        echo '          
        <div id="rename">
            <form method="post" action="details_poke.php">
            <input type="hidden" name="numero" value=' . $id . '>
            <input type="hidden" name="association_id" value=' . $association_id . '>
            <label for="rename_poke">Renommer le pokémon : </label>
            <input type="text" name="rename_poke">
            <button onclick="closeRename()" type="submit" name="rename">Valider</button>
            </form>
        </div>';
                    }
                    ?>
                </div>
                <img src="api/img/full/<?= $id; ?>.png" alt="Image d'un pokémon" class="img_poke_desc" />
            </article>
            <!-- Partie centrale de la description -->
            <article class="desc_centre">
                <p>Numéro du pokémon</p>
                <p>Expérience de base</p>
                <p>Taille</p>
                <p>Poids</p>
            </article>
            <!-- Partie droite de la description -->
            <article class="desc_droite">
                <p>
                    <?= $id; ?>
                </p>
                <p>
                    <?= $tab_poke["base_experience"]; ?>
                </p>
                <p>
                    <?= $tab_poke["height"]; ?>cm
                </p>
                <p>
                    <?= $tab_poke["weight"]; ?>kg
                </p>
            </article>
        </section>

        <article class="bas_description">
            <?php
            echo ('        
 <form method="post" action="collection.php" class="bas_description">
 <input type="hidden" name="pokemon_id" value="' . $id . '">');
            if (isset($_GET["association_id"])) {
                echo ('
 <input type="hidden" name="association_id" value="' . $association_id . '">
 ');
            }
            ?>
            <p>Cliquer pour ajouter à votre collection</p>
            <?php
            if (isset($_GET["association_id"])) {
                echo ('<button type="submit" name="delete_poke" class="boutton_details">
    <img src="CSS/UI/moins_pixel.png" id="boutton_remove"/>
    </button>');
            }

            ?>
            <button type="submit" name="add_poke" class="boutton_details">
                <img src="CSS/UI/plus_pixel.png" id="boutton_add" />
            </button>

            <!-- Affichage de la quantité actuelle -->
            <p class="quantité_poke">Quantité actuel : <span id="number_poke" type="number">
                    <?php echo nombre_poke($id); ?>
                </span></p>
            </form>
        </article>


    </main>

    <script>
        function rename() {
            var popup = document.getElementById('rename');
            popup.style.display = 'block';
        }

        // Fonction pour cacher la pop-up
        function closeRename() {
            var popup = document.getElementById('rename');
            popup.style.display = 'none';
            console.log('rename')
        }

    </script>



    <footer class="bas_autre">

        <img src="CSS/UI/assets_supernes_bas.png" alt="bas de l'interface de la super nes" class="bas_supernes" />

    </footer>

















</body>

</html>