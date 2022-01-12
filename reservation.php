<?php
require_once("config/bdd.php");
?>




<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/reservationsalles.css">
    <title>reservation salles</title>
</head>

<body>
    <header>
        <?php
        if (isset($_SESSION['login'])) { // si quelqu'un est co 
            include_once("include/headeronline.php"); //on remplace inscription par connection
        } else {
            include_once('include/header.php'); //sinon on laisse inscription
        }
        ?>
    </header>
    <main>
        <?php

        if (isset($_GET["reservation"])) {

            $event = $_GET["reservation"];

            $sql = "SELECT reservations.id, titre, description, debut, fin, id_utilisateur , utilisateurs.login FROM `reservations` 
INNER JOIN utilisateurs ON reservations.id_utilisateur = utilisateurs.id WHERE reservations.id = '$event'";
            $prep = $bdd->prepare($sql);
            $prep->execute();
            $sqlEvent = $prep->fetch();

            foreach ($sqlEvent as $zEvent) {

                $titre = $sqlEvent["titre"];
                $description = $sqlEvent["description"];
                $debut = $sqlEvent["debut"];
                $fin = $sqlEvent["fin"];
                $login = $sqlEvent["login"];
            } ?>


            <p>le titre <?= $titre; ?></p>
            <p>La description : <?= $description; ?></p>
            <p>Le début : <?= $debut; ?></p>
            <p>La fin : <?= $fin; ?></p>
            <p>Réservé par : <?= $login; ?></p>

        <?php
        }

        ?>
    </main>

    <footer>

    </footer>
</body>