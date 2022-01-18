<?php
require_once("config/bdd.php"); // connexion à la bdd

$semaine = [
    "Lundi",
    "Mardi",
    "Mercredi",
    "Jeudi",
    "Vendredi",
];
// if(isset($_GET["reservation"])){
//     $dateParDefault="";

//     if ($_GET['date_start'] == 1)
//     {
//         $dateParDefault = date('Y-m-d', strtotime('monday this week'));
//     }
// }


$mardi = date('Y/m/d', strtotime("+1day this week"));
$mercredi = date('Y/m/d', strtotime("+2day this week"));
$jeudi = date('Y/m/d', strtotime("+3day this week"));
$vendredi = date('Y/m/d', strtotime("+4day this week"));



if (isset($_GET["jour"])) {
    $jour = $_GET["jour"];
    if ($jour == 1) {
        $jour = "Lundi";
        $date = date('Y/m/d', strtotime("this week"));
    } else if ($jour == 2) {
        $jour = "Mardi";
        $date = date('Y/m/d', strtotime("+1 day this week"));
    } else if ($jour == 3) {
        $jour = "Mercredi";
        $date = date('Y/m/d', strtotime("+2 day this week"));
    } else if ($jour == 4) {
        $jour = "Jeudi";
        $date = date('Y/m/d', strtotime("+3 day this week"));
    } else if ($jour == 5) {
        $jour = "Vendredi";
        $date = date('Y/m/d', strtotime("+4 day this week"));
    }
    $semaine = [
        "Lundi",
        "Mardi",
        "Mercredi",
        "Jeudi",
        "Vendredi",
    ];
} else {
    if (isset($_POST["envoyer"])) {

        if ($_POST["debut"] == "Lundi") {
            $dateOffGet = date('Y/m/d', strtotime("this week"));
        } else if ($_POST["debut"] == "Mardi") {
            $dateOffGet = date('Y/m/d', strtotime("+1 day this week"));
        } else if ($_POST["debut"] == "Mercredi") {
            $dateOffGet = date('Y/m/d', strtotime("+2 day this week"));
        } else if ($_POST["debut"] == "Jeudi") {
            $dateOffGet = date('Y/m/d', strtotime("+3 day this week"));
        } else if ($_POST["debut"] == "Vendredi") {
            $dateOffGet = date('Y/m/d', strtotime("+4 day this week"));
        }
    }
}



$timeStamp = date("Y-m-d");
if (!isset($_SESSION['login']) && empty($_SESSION["login"])) { // si l'utilisateur n'es pas co 
    header("Location: connexion.php"); // on l'envoie sûre connexion
    exit;
} else { //sinon

    $id_utilisateur = $_SESSION["id"]; // on stock l'id de la session dans une variable

    if (isset($_POST["envoyer"])) { // si on appuie sûre envoyer

        if (!isset($_POST["titre"]) && empty($_POST["titre"])) { // si le titre n'a pas de valeur

            $msgErr = "Vous n'avez pas de titre !";
        }

        $titreLenght = strlen($_POST["titre"]); //lenght du titre
        $titreMax = 22; // max de char dans mon titre
        if ($titreLenght >= $titreMax) {
            $msgErr = "Votre Titre doit faire moins de 22 caractères !";
        } else if (isset($_POST["description"]) && empty($_POST["description"])) {
            $msgErr = "Vous n'avez pas rempli de description";
        }
        $descriptionLenght = strlen($_POST["description"]); // idem pour desc
        $descriptionMax = 106;

        if ($descriptionLenght >= $descriptionMax) {
            $msgErr = "Votre description doit avoir moins de 106 caractères !";
        } else if (!isset($_POST["debut"]) && empty($_POST["debut"]) && !isset($_POST["debutH"]) && empty($_POST["debutH"])) {
            $msgErr = "Vous avez besoin d'une date de début";
        } else if (!isset($_POST["fin"]) && empty($_POST["fin"]) && !isset($_POST["finH"]) && empty($_POST["finH"])) {
            $msgErr = "Vous avez besoin d'une date de fin";
        }

        $sql2 = "SELECT reservations.debut FROM reservations WHERE debut = ?";
        $prep = $bdd->prepare($sql2);
        $prep->execute(array($_POST["debut"] . " " . $_POST["debutH"]));
        $debutSql = $prep->fetchAll();

        if (count($debutSql) > 0) {
            $msgErr = "Votre horaire est déjà réservé";
        }
        if (empty($msgErr)) {
            if (isset($_GET["jour"])) {

                echo "Gleget";
                $titre = strip_tags(htmlspecialchars($_POST["titre"]));
                $description = strip_tags(htmlspecialchars($_POST["description"]));
                $debut = strip_tags(htmlspecialchars($date . " " . $_POST["debutH"]));
                $fin = strip_tags(htmlspecialchars($date . " " . Intval($_POST["debutH"] + 1)));

                $sql = "INSERT INTO `reservations`(`titre`, `description`, `debut`, `fin`, `id_utilisateur`) VALUES (?,?,?,?,?)";
                $prepsql = $bdd->prepare($sql);
                $insertReserv = $prepsql->execute(array($titre, $description, $debut, $fin, $id_utilisateur));
                $msgErr = "Reservation envoyée ";

                // if (empty($_POST)) {
                    header("location: reservation-form.php");
                    exit;
                }
            } else {
                echo "ofget";
                $titre = strip_tags(htmlspecialchars($_POST["titre"]));
                $description = strip_tags(htmlspecialchars($_POST["description"]));
                $debut = strip_tags(htmlspecialchars($dateOffGet . " " . $_POST["debutH"]));
                $fin = strip_tags(htmlspecialchars($dateOffGet . " " . Intval($_POST["debutH"] + 1)));

                $sql = "INSERT INTO `reservations`(`titre`, `description`, `debut`, `fin`, `id_utilisateur`) VALUES (?,?,?,?,?)";
                $prepsql = $bdd->prepare($sql);
                $insertReserv = $prepsql->execute(array($titre, $description, $debut, $fin, $id_utilisateur));
                $msgErr = "Reservation envoyée ";

                header("location: reservation-form.php");
                exit;
            }
        }
    }


?>

    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="css/form.css">
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
            <form id="" action="" method="post">
                <div style="color: red;">
                    <?php
                    if (isset($msgErr)) {
                        echo $msgErr;
                    }
                    ?>
                </div>
                <table id="">
                    <div id="">
                        <tr class="">
                            <td colspan="2">
                                <h2 id="">Reservation de votre salle</h2>
                            </td>
                        </tr>
                        <tr class="">
                            <td class=""><label class="" for="titre">titre</label></td>
                            <td class=""><input class="" type="text" name="titre" id="" placeholder="" required></td>
                        </tr>
                        <tr class="">
                            <td class=""><label class="" for="description">description</label></td>
                            <td class=""><input class="" type="text" name="description" id="" placeholder="" required></td>
                        </tr>
                        <tr class="">
                            <td class=""><label class="" for="debut">date de début <i>(1 h de réservation)</i></label></td>
                            <td><i>Samedi et Dimanche indisponible</i></td>
                            <?php if (isset($_GET["jour"])) { ?>
                                <td> <select name="debut" id="debut">
                                        <?php

                                        foreach ($semaine as $key => $value) {

                                        ?>

                                            <option value=<?= "$date" ?> <?php if ($value == $jour) echo "selected" ?>> <?= $value; ?> </option>
                                        <?php
                                        } ?>
                                    </select></td>

                            <?php } else {
                            ?> <td> <select name="debut" id="debut">
                                        <?php
                                        foreach ($semaine as $key => $value) {
                                        ?>

                                            <option> <?= $value; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                <?php  } ?>

                                <td class="">
                                    <select name="debutH">
                                        <!-- heure du début -->
                                        <option value="">Choisir votre heure</option>

                                        <?php

                                        if (empty($_GET["heure"])) {
                                            for ($i = 8; $i <= 18; $i++) { // i = heure de 8h à 18h
                                        ?>
                                                <option value=<?= $i ?>><?= $i ?>:00</option>
                                            <?php }
                                        } else {
                                            ?>
                                            <option selected="$_GET['heure']"><?= $_GET["heure"]; ?> </option>
                                        <?php
                                        }

                                        ?>
                                </td>
                        </tr>
                        </select>


                        <tr class="">
                            <td class=""><label class="" for="fin">heure de fin <i>(1 h de réservation)</i></label></td>

                            <td><select name="fin">
                                    <!-- heure de fin -->
                                    <option value="">Choisir l'heure de fin</option>
                                    <?php if (empty($_GET["heure"])) {
                                        for ($i = 9; $i <= 19; $i++) { // i = heure de 9h à 19h
                                    ?>
                                            <option value=<?= $i ?>><?= $i ?>:00</option>
                                        <?php }
                                    } else {
                                        $getHeure = $_GET["heure"] + 1
                                        ?>
                                        <option selected="$getHeure"><?= $getHeure ?>:00</option>
                                    <?php
                                    } ?>

                                </select>
                            </td>
                        </tr>
                        <tr class="">
                            <td class=""><input class="" type="submit" name="envoyer" value="Envoyer le formulaire"></td>
                        </tr>
                    </div>
                </table>
            </form>

        </main>
        <footer>
        <?php
        include_once('include/footer.php');
    
        ?>
        </footer>
    </body>

    </html>