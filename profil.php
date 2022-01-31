<?php
include_once("config/bdd.php");
// var_dump ($_SESSION);



if (isset($_SESSION['id']) && $_SESSION['id'] > 0) {
    $requtilisateur = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
    $requtilisateur->execute(array($_SESSION['id']));
    $infoutilisateur = $requtilisateur->fetch();
} else {
    header('Location: connexion.php');
}

if (isset($_POST['newlogin']) && !empty($_POST['newlogin']) && $_POST['newlogin'] != $infoutilisateur['login']) {
    $login = $_POST['newlogin'];
    $requetelogin = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ?"); // Vérifier encore une fois si le login existe déjà 
    $requetelogin->execute(array($login));
    $loginexist = $requetelogin->rowCount();

    if ($loginexist !== 0) {
        $msg = "Le login existe déjà !";
    } else { // Créer une nouvelle session avec le nouveau login
        $newlogin = htmlspecialchars($_POST['newlogin']);
        $insertlogin = $bdd->prepare("UPDATE utilisateurs SET login = ? WHERE id = ?");
        $insertlogin->execute(array($newlogin, $_SESSION['id']));
        $_SESSION['login'] = $newlogin;
		$bonMsg = "Modification envoyée !";


    }
}
if (isset($_POST['newpassword']) && !empty($_POST['newpassword']) && isset($_POST['confirm_password']) && !empty($_POST['confirm_password'])) { //Confirmation des 2 mdp
    $mdp1 = $_POST['newpassword'];
    $mdp2 = $_POST['confirm_password'];

    if ($mdp1 == $mdp2) {
        $hachage = password_hash($mdp1, PASSWORD_BCRYPT);
        $insertmdp = $bdd->prepare("UPDATE utilisateurs SET password = ? WHERE id = ?");
        $insertmdp->execute(array($hachage, $_SESSION['id']));
		$bonMsg = "Modification envoyée !";

    } else {
        $msg = "Vos mots de passes ne correspondent pas !";
    }
}

if (isset($_POST['newlogin']) && $_POST['newlogin'] == $infoutilisateur['login'] && empty($msg) && empty($bonMsg)) {
    header('Location: profil.php');
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bitter:wght@200&display=swap" rel="stylesheet">
    <meta charset="UTf-8">
    <link rel="stylesheet" href="css/reservationsalles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Sansita+Swashed&display=swap" rel="stylesheet">
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
        <div id="background1"> <img src="images/salle-removebg-preview.png" alt=""></div>
        <form id="form_ins" action="" method="post">
            <div style="color: red;">
                <?php

                if (isset($msg)) {
                    echo $msg;
                }
				else {
					echo $bonMsg;
				}
                ?>
            </div>
            <table id="crtable_ins">

                <tr class="crtr_ins">
                    <td colspan="2">
                        <h2 id="cr_ins_h2">Changez Votre Profil</h2>
                    </td>
                </tr>
                <tr class="crtr_ins">
                    <td class="crtd_ins"><label class="label_input_ins" for="newlogin">New Login</label></td><br>
                    <td class="crtd_ins"><input class="label_input_ins" type="text" name="newlogin" id="newlogin" value="<?php echo $_SESSION["login"] ?>" required></td>
                </tr>

                <tr class="crtr_ins">
                    <td class="crtd_ins"><label class="label_input_ins" for="pass">New Password</label></td><br>
                    <td class="crtd_ins"><input class="label_input_ins" type="password" id="pass" name="newpassword" minlength="2" placeholder="Your New Password" required></td>
                </tr>

                <tr class="crtr_ins">
                    <td class="crtd_ins"><label class="label_input_ins" for="confirmpass">Confirm New Password</label></td><br>
                    <td class="crtd_ins"><input class="label_input_ins" type="password" id="confirmpass" name="confirm_password" minlength="2" placeholder="Confirm New Password " required></td>
                </tr>

                <tr class="crtr_ins">
                    <td class="crtd_ins"><input class="btn btn-primary" type="submit" name="envoyer" value="Envoyer le formulaire"></td>
                </tr>

            </table>
        </form>
        <div id="background2"> <img src="images/salle-removebg-preview.png" alt=""></div>

    </main>

    <footer>
        <?php
        include_once('include/footer.php');
        ?>
    </footer>

</body>

</html>
