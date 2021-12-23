<?php session_start();
// require_once("config/bdd.php");

?>

<head>
    <link rel="stylesheet" type="text/css" href="css/reservationsalles.css">
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

        <div id="background1"> <img src="../reservation-salles/images/salle-removebg-preview.png" alt=""></div>
        <section id="section_index">
            <article class="art_index">
                <h2 id="h2_index">Réservez votre salle</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora tempore modi est maxime excepturi nesciunt repellendus ut, magni dolorem pariatur nemo non rem ipsam distinctio itaque, illum quasi. Aperiam, animi.</p>
            </article>
            <article class="art_index">

                <h3>Salle Aurora (10 personnes)</h3>
                <div id="div_index1">
                    <img class="img_index" src="../reservation-salles/images/salle10.jfif" alt="">
                </div>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Beatae, fugit molestiae? Velit saepe repudiandae delectus dolore deleniti accusantium harum ratione consequatur odit, at neque unde, facilis maiores molestiae iusto nam!</p>

            </article>
            <article class="art_index">

                <h3>Salle Pandora (25 personnes)</h3>
                <div id="div_index2">
                    <img class="img_index" src="../reservation-salles/images/salle25.jfif" alt="">
                </div>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Beatae, fugit molestiae? Velit saepe repudiandae delectus dolore deleniti accusantium harum ratione consequatur odit, at neque unde, facilis maiores molestiae iusto nam!</p>

            </article>
        </section>
        </div>
        <div id="background2"> <img src="../reservation-salles/images/salle-removebg-preview.png" alt=""></div>
    </main>


    <footer>
        <?php
        include_once('include/footer.php');
        ?>
    </footer>

</body>

</html>