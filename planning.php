<?php
require_once("config/bdd.php");
require_once("include/fonction.php");
$semaine = [
    "Lundi",
    "Mardi",
    "Mercredi",
    "Jeudi",
    "Vendredi",
];


if (isset($_GET["page"]) && !empty($_GET["page"])) {

    $currentPage = (int) htmlspecialchars(strip_tags($_GET["page"]));
} else {
    $currentPage = 1;
}

$sql = "SELECT reservations.id, titre, description, debut, fin, id_utilisateur , utilisateurs.login FROM `reservations` 
INNER JOIN utilisateurs ON reservations.id_utilisateur = utilisateurs.id  "; // inner join de la table reservations et utilisateur via les id des 2 tables
$prep = $bdd->prepare($sql);
$prep->execute();
$reservations = $prep->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/planning.css">
    <title>RESERVATION SALLES</title>
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


    <main id="">

        <h1 class="bg-dark text-light">Réservations</h1>

        <div class="right">

            <img class="Alpad" src="images/salle25.jfif" width="30%" height="30%">

            <table class="">

                <th class="bg-dark text-light">
                    Heures
                </th>

                <?php foreach ($semaine as $jours) { // je parcour mon array de la semaine pour pouvoir afficher les jours
                ?>

                    <th class="bg-dark text-light"><?= $jours ?>
                    </th>

                <?php
                }

                $heure = 8; // heure du début de journée initialisé à 8
                $finDeJournée = 19; // heure de fin de journée initialisé à 8

                while ($heure <= $finDeJournée) { // tant l'heure de début n'est pas arrivé jusqu'à l'heure de fin

                ?>
                    <tr class="">

                        <td class="bg-dark text-light">

                            <?= $heure ?>:00
                        </td>
                        <?php
                        $jour = 1;
                        while ($jour < 6) {

                            $resa = false;

                            foreach ($reservations as $reservation) {
                                //debut de la reservation
                                $heureJour = $heure . $jour; // des heures et des jours lié

                                $dateHeureReserv = $reservation["debut"];
                                $explosionReserv = explode(" ", $dateHeureReserv); //on sépare le jour et l'heure= on explose la string pour en faire un array la valeur de l'array est définis à chaque fois qu'il y a un espace grâce à = " "

                                $jourReserv = $explosionReserv[0]; // on choisit les jours le premier côté de l'array
                                $explosionJour = explode("-", $jourReserv); // on transforme encore une fois notre string à chaque fois qu'il y a un - on crée une nouvelle valeur à notre array
                                $jourNum = date("N", mktime(0, 0, 0, $explosionJour[1], $explosionJour[2], $explosionJour[0])); //jour de la semaine

                                $heureReserv = $explosionReserv[1]; // on choisit le 2ème côté de notre array pour prendre les heures 
                                $explosionHeure = explode(":", $heureReserv); // on éxplose la string pour crée un array à chaque fois que : les sépares
                                $heureNum = date("G", mktime($explosionHeure[0], $explosionHeure[1], $explosionHeure[2], 0, 0, 0));

                                //je lie le jour et l'heure de réservation
                                $heureJourReserv = $heureNum . $jourNum;


                                $titreResa = $reservation["titre"]; // titre de la réservation
                                $idResa = $reservation["id"]; //id de la réservation
                                $loginResa = $reservation['login']; // login de la reservation


                                // Si il y a une correspondance on rentre dans cette case 
                                if ($heureJour == $heureJourReserv && $jour == $jourNum) {
                                    
                                    $resa = true;
                                    $titreLenght = strlen($titreResa);
                                    $titreCharMax = 14;

                                    if ($jourNum == 1) {
                                    
                                        $date = date('Y/m/d', strtotime("this week"));
                                    } else if ($jourNum == 2) {
                                        
                                        $date = date('Y/m/d', strtotime("+1 day this week"));
                                    } else if ($jourNum == 3) {
                                        
                                        $date = date('Y/m/d', strtotime("+2 day this week"));
                                    } else if ($jourNum == 4) {
                                        
                                        $date = date('Y/m/d', strtotime("+3 day this week"));
                                    } else if ($jourNum == 5) {
                                        
                                        $date = date('Y/m/d', strtotime("+4 day this week"));
                                    }
    
                                    if (date("Y/m/d") > $date) {

                                    $sqll = "DELETE FROM `reservations` WHERE id = ?";
                                    $prep = $bdd->prepare($sqll);
                                    $delReserv = $prep->execute(array($idResa));
                                    }
    

                                    if ($titreLenght >= $titreCharMax) {

                        ?>
                                        <td><a class="btn btn-outline-danger bg-dark" href="reservation.php?reservation=<?= $idResa;  ?>"><?= substr($titreResa, 0, $titreCharMax) . ".."; ?><br> Par : <?= $loginResa ?></a></td>

                                    <?php
                                    } else {

                                    ?>
                                        <td>
                                            <a class="btn btn-outline-danger bg-dark" href="reservation.php?reservation=<?= $idResa;  ?>">
                                                <?= $titreResa; ?><br> Par : <?= $loginResa ?>
                                            </a>
                                        </td>

                                    <?php
                                    }
                                    break;
                                }
                            }
                            if ($resa == false) {

                                if ($jour == 1) {
                                    
                                    $date = date('Y/m/d', strtotime("this week"));
                                } else if ($jour == 2) {
                                    
                                    $date = date('Y/m/d', strtotime("+1 day this week"));
                                } else if ($jour == 3) {
                                    
                                    $date = date('Y/m/d', strtotime("+2 day this week"));
                                } else if ($jour == 4) {
                                    
                                    $date = date('Y/m/d', strtotime("+3 day this week"));
                                } else if ($jour == 5) {
                                    
                                    $date = date('Y/m/d', strtotime("+4 day this week"));
                                }

                                if (date("Y/m/d") > $date) {

                                    ?>
                                    <td>

                                        <a class="btn btn-outline-danger bg-dark" href="">
                                            Indisponible
                                        </a>
                                    </td>
                                <?php

                                } else {

                                ?>
                                    <td>

                                        <a class="btn btn-outline-primary" href="reservation-form.php?jour=<?= $jour ?>&heure=<?= $heure ?>:00">
                                            Disponible
                                        </a>
                                    </td>
                    <?php
                                }
                            }
                            $jour++;
                        }
                        $heure++;
                    }
                    ?>


                    </tr>
            </table>
        </div>


    </main>
    <footer>

        <footer>
            <?php
            include_once('include/footer.php');
            ?>
        </footer>

</body>

</html>