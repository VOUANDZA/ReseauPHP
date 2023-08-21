<?php
session_start();

require_once("controleur/config_db.php");
require_once("controleur/controleur.class.php");
$unControleur = new Controleur($serveur, $bdd, $user, $mdp);

// Traitement de l'inscription
if(isset($_POST['inscription'])) {
    $unControleur->setTable('utilisateur');
    $tab = array(
      "nom"=>$_POST["nom"],
      "prenom"=>$_POST["prenom"],
      "email"=>$_POST["email"],
      "age"=>$_POST["age"],
      "pseudo"=>$_POST["pseudo"],
      "ville"=>$_POST["ville"],
      "mdp"=>$_POST["mdp"],
    );
    $unControleur->insert_inscription($tab);
    header("Location: index.php");
    exit();
}
?>
