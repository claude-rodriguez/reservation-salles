<?php
require_once("config/bdd.php");
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

    <main id="crindexmain">
        <div>
            <h1>Reservations</h1>
            <table id="crtableplan">
                <tr class="crplanningtr">
                    <td></td>
                    <td>Lundi</td>
                    <td>Mardi</td>
                    <td>Mercredi</td>
                    <td>Jeudi</td>
                    <td>Vendredi</td>
                </tr>
                <tr class="crplanningtr">
                    <td>8h</td>
                </tr>
                <tr class="crplanningtr">
                    <td>9h</td>
                </tr>
                <tr class="crplanningtr">
                    <td>10h</td>
                </tr>
                <tr class="crplanningtr">
                    <td>11h</td>
                </tr>
                <tr class="crplanningtr">
                    <td>12h</td>
                </tr>
                <tr class="crplanningtr">
                    <td>13h</td>
                </tr>
                <tr class="crplanningtr">
                    <td>14h</td>
                </tr>
                <tr class="crplanningtr">
                    <td>15h</td>
                </tr>
                <tr class="crplanningtr">
                    <td>16h</td>
                </tr>
                <tr class="crplanningtr">
                    <td>17h</td>
                </tr>
                <tr class="crplanningtr">
                    <td>18h</td>
                </tr>
                <tr class="crplanningtr">
                    <td>19h</td>
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