<?php  //Pour détruire la session et donc se déconnecter
session_start();
// $_SESSION = array();
session_destroy();
header("Location: connexion.php");
?>