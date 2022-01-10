<?php  //Pour détruire la session et donc se déconnecter
if(!isset(session_start())){
session_start();
}
// $_SESSION = array();
session_destroy();
header("Location: connexion.php");
?>