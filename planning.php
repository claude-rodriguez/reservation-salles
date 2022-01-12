<?php
require_once("config/bdd.php");
$semaine = [
    "Lundi",
    "Mardi",
    "Mercredi",
    "Jeudi",
    "Vendredi",
];
$sql = "SELECT reservations.id, titre, description, debut, fin, id_utilisateur FROM `reservations` 
INNER JOIN utilisateurs ON reservations.id_utilisateur = utilisateurs.id WHERE 1;" // inner join de la table reservations et utilisateur via les id des 2 tables

?>

<head>
    <link rel="stylesheet" type="text/css" href="css/reservationsalles.css">
    <title>Index</title>
</head>

<header>
    <?php
    if (isset($_SESSION['login'])) { // si quelqu'un est co 
        include_once("include/headeronline.php"); //on remplace inscription par connection
    } else {
        include_once('include/header.php'); //sinon on laisse inscription
    }
    ?>
</header>

<body>

    <main id="">

        <h1>Reservations</h1>

        <table id="">
            <tr class="">
                <?php foreach ($semaine as $jour) { ?>
            <tr>&nbsp;</tr>
            <tr><?= $jour ?></tr>
        <?php } ?>
        </tr>
        <?php for($i = 8 ; $i <= 19; $i++){

            ?>
        <tr class="">
            <td><?= $i ?>H</td>


            <td class="">Réveil</td>
            <td class="normal">Réveil</td>
            <td class="normal">Réveil</td>
            <td class="normal">Réveil</td>
            <td class="normal">Réveil</td>
<?php } ?>
        </tr>

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