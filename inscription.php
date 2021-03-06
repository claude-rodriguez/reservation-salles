<?php
include_once("config/bdd.php");

if (isset($_SESSION['id']) && $_SESSION['id'] > 0) {
    header("Location: profil.php");
}

if (isset($_POST['envoyer'])) {
    $erreur = "";
    $login = htmlspecialchars($_POST['login']);
    $password = htmlspecialchars($_POST["password"]);
    $confirmation = htmlspecialchars($_POST['confirm_password']);

    if (!empty($_POST['login']) and !empty($_POST['password']) and !empty($_POST['confirm_password'])) {
        $loginlenght = strlen($login);  //Permet de calculer la longueur du login
        $requete = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ? ");
        $requete->execute(array($login));
        $loginexist = $requete->rowCount();


        if ($loginlenght > 255)
            $erreur = "Votre pseudo ne doit pas depasser 255 caractères !";
        elseif ($password !== $confirmation)
            $erreur = "Les mots de passes sont differents !";
        if ($loginexist !== 0)
            $erreur = "Login deja pris !";
        if ($erreur == "") {
            $hashage = password_hash($password, PASSWORD_DEFAULT);
            //la constante PASSWORD_DEFAULT est concue pour changer dans le temps, au fur et à mesure que des algorithmes plus récents et plus forts sont ajoutés à PHP.
            $insertmbr = $bdd->prepare("INSERT INTO utilisateurs(login, password) VALUES(?, ?)");
            $insertmbr->execute(array($login, $hashage));
            $erreur = "Votre compte à bien été crée, vous pouvez maintenant vous connecter !";
            header("Location: connexion.php");   //Redirige sur la page profil
        }
    }
} ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bitter:wght@200&display=swap" rel="stylesheet">
    <meta charset="UTf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/reservationsalles.css">
    <title>RESERVATION SALLES</title>
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

    <main id="main_ins">

        <div id="background2"> <img src="images/salle-removebg-preview.png" alt=""></div>
        <form id="form_ins" action="" method="post">
            <div style="color: red;">
                <?php
                if (isset($erreur)) {
                    echo @$erreur;
                }
                ?>
            </div>


            <table id="crtable_ins">
                <div id="crdiv_ins">
                    <tr class="crtr_ins">
                        <td colspan="2">
                            <h2 id="cr_ins_h2">Inscrivez Vous</h2>
                        </td>
                    </tr>
                    <tr class="crtr_ins">
                        <td class="crtd_ins"><label class="label_input_ins" for="login">Login</label></td>
                        <td class="crtd_ins"><input class="label_input_ins" type="text" name="login" id="login" placeholder="Your Login" required></td>
                    </tr>
                    <tr class="crtr_ins">
                        <td class="crtd_ins"><label class="label_input_ins" for="pass">Password</label></td>
                        <td class="crtd_ins"><input class="label_input_ins" type="password" id="pass" name="password" minlength="2" placeholder="Your Password" required></td>
                    </tr>
                    <tr class="crtr_ins">
                        <td class="crtd_ins"><label class="label_input_ins" for="conf_pass">Confirm password</label></td>
                        <td class="crtd_ins"><input class="label_input_ins" type="password" id="conf_pass" name="confirm_password" minlength="2" placeholder="Confirm Your Password" required></td>
                    </tr>
                    <tr class="crtr_ins">
                        <td class="crtd_ins"><input class="btn btn-primary" type="submit" name="envoyer" value="Envoyer le formulaire"></td>
                    </tr>
                </div>
            </table>
        </form>


        <div id="background2">
            <img src="images/salle-removebg-preview.png" alt="">
        </div>
    </main>

    <footer>
        <?php
        include_once('include/footer.php');
        ?>
    </footer>

</body>

</html>