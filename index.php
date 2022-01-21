<?php
require_once("config/bdd.php");

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/reservationsalles.css">
    <title>RESERVATION SALLES</title>
</head>

<body>
    <header>
        <?php
        if (isset($_SESSION['login'])) { // si quelqu'un est co 
            include_once("include/headeronline.php"); //tu mets ça
        } else {
            include_once('include/header.php'); //sinon ça 
        }
        ?>
    </header>

    <main id="crindexmain">

        <div id="background1"> <img src="images/salle-removebg-preview.png" alt=""></div>
        <section id="section_index">
            <article class="art_index">
                <h2 id="h2_index">Réservez votre salle</h2>
            </article>

            <article class="art_index">

                <h3>Salle Pandora (25 personnes)</h3>
                <div id="div_index2">
                    <a href="planning.php">
                        <img class="img_index" src="images/salle25.jfif" alt="">
                    </a>
                </div>
                <p class="alpad">Cliquez sûre la photo pour voir les disponibilité<b>(1 heure de réservation max)<b></p>

            </article>
        </section>
        </div>
        <div id="background2">
            <img src="images/salle-removebg-preview.png" alt="">
        </div>
    </main>


    <footer class="">
        <?php
        include_once('include/footer.php');
        ?>
    </footer>

</body>

</html>