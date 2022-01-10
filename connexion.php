<?php
include_once("config/bdd.php");
// var_dump ($_SESSION);
if (isset($_POST['envoyer'])) {
    $login = htmlspecialchars($_POST['login']);
    $password = $_POST['password'];

    if (!empty($login) and !empty($password)) {
        $requeteutilisateur = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ?"); // Vérifier si le login est le même que dans la base de données
        $requeteutilisateur->execute(array($login));
        $result = $requeteutilisateur->fetchAll();
        if (count($result) > 0) {  // S'il n'y a pas de login trouvé dans la bdd, alors ça retourne "Mauvais Login"
            $sqlPassword = $result[0]['password'];
            if (password_verify($password, $sqlPassword)) { // Permet de vérifier si les 2 mots de passes sont identiques
                $_SESSION['id'] = $result[0]['id'];  //créé une session avec les éléments de la table utilisateurs
                $_SESSION['login'] = $result[0]['login'];
                header("Location: profil.php");   //Redirige sur la page profil
            } else {
                $erreur = "Mauvais login !";
            }
        } else {
            $erreur = "Mauvais mot de passe !";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset='utf-8'>
    <link rel="stylesheet" type="text/css" href="css/reservationsalles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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
        <div id="background2"> <img src="../reservation-salles/images/salle-removebg-preview.png" alt=""></div>
        <form id="form_ins" action="" method="post">
            <div style="color: red;">
                <?php
                if (isset($erreur)) {
                    echo @$erreur;
                }
                ?>
            </div>
            <table id="crtable_ins">
                <tr class="crtr_ins">
                    <td colspan="2">
                        <h2 id="cr_ins_h2">Connectez Vous</h2>
                    </td>
                </tr>
                <tr class="crtr_ins">
                    <td class="crtd_ins"><label class="label_input_ins" for="login">Login</label></td><br>
                    <td class="crtd_ins"><input class="label_input_ins" type="text" name="login" id="login" placeholder="Votre login" required></td>
                </tr>
                <tr class="crtr_ins">
                    <td class="crtd_ins"><label class="label_input_ins" for="pass">Password</label></td><br>
                    <td class="crtd_ins"><input class="label_input_ins" type="password" id="pass" name="password" minlength="2" placeholder="Your Password" required></td>
                </tr>
                <tr class="crtr_ins">
                    <td class="crtd_ins"><input class="label_input_ins" type="submit" name="envoyer" value="Envoyer le formulaire"></td>
                </tr>
            </table>
        </form>
        <div id="background2"> <img src="../reservation-salles/images/salle-removebg-preview.png" alt=""></div>
    </main>

    <footer>
        <?php
        include_once('include/footer.php');
        ?>
    </footer>

</body>

</html>