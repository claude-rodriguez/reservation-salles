<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta charset='utf-8'>
    <link rel="stylesheet" type="text/css" href="../css/reservationsalles.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    
    <header>
        <div id="crheaderdiv">
            <div id="crheaderdivh1">
                <h1 class="text-light">Salles de réunion</h1>
            </div>
            <nav id="crheadernav">
                <tr>
                    <td>
                        <a class="cra" href="index.php">Accueil</a>
                        <a class="cra" href="planning.php">Planning</a>
                        <a class="cra" href="reservation-form.php">Réservation</a>
                        <a class="cra" href="profil.php">Profil</a>                           
                        <a class="cra" href="connexion.php">Connexion</a> 
                        <p  id="p_header"><?php echo "Bonjour " .$_SESSION["login"] ?></p>
                        <td class="nav-item">
                            <form id="form_header" class="ml-5 my-2 d-flex align-items-center" action="" method="get">
                                <input id="input_header" class="btn btn-danger " name="off" type="submit" value="Se déconnecter">
                            </form>
                    </td>                         
                    </td>                       
                </tr>
            </nav>           
        </div>
        
    </header>

</body>

</html>
<?php
// déconnexion
if (isset($_GET['off'])) {

    session_destroy();
    header('location: index.php');
}

?>