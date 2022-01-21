<?php
session_start();

function connexion(){
    
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=claude-rodriguez_reservationsalles', 'claude13', 'claude13');
        $bdd ->setAttribute(PDO::ATTR_ERRMODE ,PDO::ERRMODE_EXCEPTION);
        return $bdd;
        } 
    catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
}
}
$bdd = connexion();
