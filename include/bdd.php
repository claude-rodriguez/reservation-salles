<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=reservationsalles', 'root', '');
// $bdd = new PDO('mysql:host=localhost;dbname=claude-rodriguez_reservationsalles', 'claude', 'rodriguez');
$bdd ->setAttribute(PDO::ATTR_ERRMODE ,PDO::ERRMODE_WARNING);
?>