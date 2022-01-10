<?php

require_once("config/bdd.php");

if (isset($_SESSION["id"])) {

    $id_utilisateur = $_SESSION["id"];

    if (isset($_POST["envoyer"])) {

        if (isset($_POST["titre"]) && empty($_POST["titre"])) {

            $msgErr = "Vous n'avez pas de titre !";
        }
        $titreLenght = strlen($_POST["titre"]);
        $titreMax = 32;
        if ($titreLenght >= $titreMax) {
            $msgErr = "Votre Titre doit faire moins de 32 caractères !";
        }

        else if (isset($_POST["description"]) && empty($_POST["description"])) {
            $msgErr = "Vous n'avez pas rempli de description";
        }
        $descriptionLenght = strlen($_POST["description"]);
        $descriptionMax = 106;

        if ($descriptionLenght >= $descriptionMax) {
            $msgErr = "Votre description doit avoir moins de 106 caractères !";
        }
        else if(isset($_POST["debut"]) && empty($_POST["debut"])){
            $msgErr = "Vous avez besoin d'une date de début";
        }
        else if(isset($_POST["fin"]) && empty($_POST["fin"])) {
            $msgErr = "Vous avez besoin d'une date de fin";
        }

        if (empty($msgErr)) {

            $titre = strip_tags(htmlspecialchars($_POST["titre"]));
            $description = strip_tags(htmlspecialchars($_POST["description"]));
            $debut = strip_tags(htmlspecialchars($_POST["debut"]));
            $fin = strip_tags(htmlspecialchars($_POST["fin"]));
            $sql = "INSERT INTO `reservations`(`titre`, `description`, `debut`, `fin`, `id_utilisateur`) VALUES (?,?,?,?,?)";
            $prepsql = $bdd->prepare($sql);
            $insertReserv = $prepsql->execute(array($titre, $description, $debut, $fin, $id_utilisateur));
            $msgErr = "Reservation envoyée ";
            unset($_POST);
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
                        <td class=""><input class="" type="datetime-local" name="debut" id="" placeholder="" required></td>
                    </tr>
                    <tr class="">
                        <td class=""><label class="" for="fin">date de fin</label></td>
                        <td class=""><input class="" type="datetime-local" name="fin" id="" placeholder="" required></td>
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