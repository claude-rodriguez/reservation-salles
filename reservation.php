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
    <link rel="stylesheet" href="../reservation-salles/css/reservation.css">
    <title>reservation salles</title>
</head>

<body class="b-g">
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
            }
            $explosionDebut = explode(" ", $debut);
            $explosionHeureD = explode(":", $explosionDebut[1]);
            $explosionFin = explode(" ", $fin);
            $explosionHeureF = explode(":", $explosionFin[1]);

            $jourReserv = $explosionDebut[0]; // on choisit les jours le premier côté de l'array
            $explosionJour = explode("-", $jourReserv); // on transforme encore une fois notre string à chaque fois qu'il y a un - on crée une nouvelle valeur à notre array
            $jourNum = date("N", mktime(0, 0, 0, $explosionJour[1], $explosionJour[2], $explosionJour[0])); //jour de la semaine

        ?>
            <section>
                <article>
                    <h1> <u><?= $titre; ?></u></h1>

                    <p>
                        La description de la réservation:
                    </p>
                    <p>
                        <?= $description; ?>
                    </p>
                    <hr>
                    <p>
                        Jour de réservation :
                    </p>
                    <p>
                        Le <?= $explosionJour[2] ?>/<?= $explosionJour[1] ?>/<?= $explosionJour[0] ?>
                    </p>
                    <p>Heure de début :
                    </p>
                    <p>
                        à <?= $explosionHeureD[0]; ?>:00 Heures
                    </p>
                    <p>Votre heure de fin :
                    </p>
                    <p>
                        à <?= $explosionHeureF[0]; ?>:00 Heures
                    </p>

                    <p>
                        <i>
                            Réservé par
                            <?= $login; ?>
                        </i>
                    </p>
                </article>
            </section>
        <?php
        }
        ?>
    </main>
    <footer>
        <?php include_once("include/footer.php"); ?>
    </footer>
</body>