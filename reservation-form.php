<?php

require_once("config/bdd.php");

if (!isset($_SESSION['login']) && empty($_SESSION["login"])) {
    header("Location: profil.php");
    exit;
} else {

    $id_utilisateur = $_SESSION["id"];

    if (isset($_POST["envoyer"])) {


        $sql = "SELECT * FROM reservations WHERE reservations.id = 1 BETWEEN debut AND fin"; // il manque le where ?
        $query = $bdd->prepare($sql);
        $query->execute();
        $horaire = $query->fetchAll();
        //var_dump($horaire);
        if (!isset($_POST["titre"]) && empty($_POST["titre"])) {

            $msgErr = "Vous n'avez pas de titre !";
        }

        $titreLenght = strlen($_POST["titre"]);
        $titreMax = 32;
        if ($titreLenght >= $titreMax) {
            $msgErr = "Votre Titre doit faire moins de 32 caractères !";
        } else if (isset($_POST["description"]) && empty($_POST["description"])) {
            $msgErr = "Vous n'avez pas rempli de description";
        }
        $descriptionLenght = strlen($_POST["description"]);
        $descriptionMax = 106;

        if ($descriptionLenght >= $descriptionMax) {
            $msgErr = "Votre description doit avoir moins de 106 caractères !";
        } else if (!isset($_POST["debut"]) && empty($_POST["debut"]) && !isset($_POST["debutH"]) && empty($_POST["debutH"])) {
            $msgErr = "Vous avez besoin d'une date de début";
        } else if (!isset($_POST["fin"]) && empty($_POST["fin"]) && !isset($_POST["finH"]) && empty($_POST["finH"])) {
            $msgErr = "Vous avez besoin d'une date de fin";
        }
        //     foreach($horaire as $hor){
        //     if($_POST["debut"] == $hor["debut"] && $_POST["fin"] == $hor["fin"]){

        //         $msgErr = "L'horaire que vous avez choisit n'est pas disponible";
        //     } 
        // }
        $sql2 = "SELECT reservations.debut FROM reservations WHERE debut = ?";
        $prep = $bdd->prepare($sql2);
        $prep->execute(array($_POST["debut"] . " " . $_POST["debutH"]));
        $debutSql = $prep->fetchAll();

        if (count($debutSql) > 0){
            $msgErr = "Votre horaire est déjà réservé";
        }

        if (empty($msgErr)) {

    $titre = strip_tags(htmlspecialchars($_POST["titre"]));
    $description = strip_tags(htmlspecialchars($_POST["description"]));
    $debut = strip_tags(htmlspecialchars($_POST["debut"] . " " . $_POST["debutH"]));
    $fin = strip_tags(htmlspecialchars($_POST["debut"] . " " . $_POST["debutH"] + 1));

            $sql = "INSERT INTO `reservations`(`titre`, `description`, `debut`, `fin`, `id_utilisateur`) VALUES (?,?,?,?,?)";
            $prepsql = $bdd->prepare($sql);
            $insertReserv = $prepsql->execute(array($titre, $description, $debut, $fin, $id_utilisateur));
            $msgErr = "Reservation envoyée ";
            unset($_POST);
            if(empty($_POST)){
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
                            <td class=""><label class="" for="debut">date de début</label></td>
                            <td><input class="" type="date" name="debut"></td>
                            <td class=""> <select name="debutH">
                                    <!-- heure du début -->
                                    <option value="">Choisir votre heure</option>
                                    <?php for ($i = 8; $i <= 18; $i++) { // i = heure de 8h à 18h
                                    ?>
                                        <option value=<?= $i ?>><?= $i ?>:00</option>
                                    <?php }

                                    ?>
                            </td>
                        </tr>
                        </select>


                        <tr class="">
                            <td class=""><label class="" for="fin">date de fin</label></td>

                            <td><select name="fin">
                                    <!-- heure de fin -->
                                    <option value="">Choisir votre heure</option>
                                    <?php for ($i = 9; $i <= 19; $i++) { // i = heure de 9h à 19h
                                    ?>
                                        <option value=<?= $i ?>><?= $i ?>:00</option>
                                    <?php } ?>

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
    }
        ?>
        </footer>
    </body>

    </html>