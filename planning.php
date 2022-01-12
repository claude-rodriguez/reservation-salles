<?php
require_once("config/bdd.php");
$semaine = [
    "Lundi",
    "Mardi",
    "Mercredi",
    "Jeudi",
    "Vendredi",
];
$sql = "SELECT reservations.id, titre, description, debut, fin, id_utilisateur , utilisateurs.login FROM `reservations` 
INNER JOIN utilisateurs ON reservations.id_utilisateur = utilisateurs.id WHERE 1 ORDER BY debut DESC"; // inner join de la table reservations et utilisateur via les id des 2 tables
$prep = $bdd->prepare($sql);
$prep->execute();
$reservation = $prep->fetchAll(PDO::FETCH_ASSOC);
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
            include_once("include/headeronline.php"); //on remplace inscription par connection
        } else {
            include_once('include/header.php'); //sinon on laisse inscription
        }
        ?>
    </header>



    <main id="">

        <h1>Reservations</h1>

        <table id="">
            <tr class="">
                <?php foreach ($semaine as $jour) { ?>
            <tr>&nbsp;</tr>
            <tr><?= $jour ?></tr>
            </tr>
        <?php } ?>

        <?php for ($i = 8; $i <= 19; $i++) {

        ?>
            <tr class="">
                <td><?= $i ?>H</td>
            </tr>
            <tr>
                <td class="">Réveil</td>
                <td class="normal">Réveil</td>
                <td class="normal">Réveil</td>
                <td class="normal">Réveil</td>
                <td class="normal">Réveil</td>
            </tr>
        <?php } ?>

        </table>

    </main>
    <footer>

        <footer>
            <?php
            include_once('include/footer.php');
            ?>
        </footer>

</body>

</html>