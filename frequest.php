<?php
session_start();
require_once("controleur\config_db.php");
require_once("controleur\controleur.class.php");
$unControleur = new Controleur($serveur, $bdd, $user, $mdp);

// Récupération de l'utilisateur à ajouter en ami
if (isset($_POST['iddest'])){
$idami =$_POST['iddest'];
$chaine ="*";
$where =array("iduser"=>$idami);
$unControleur->setTable("utilisateur");
$unAmi = $unControleur->selectWhere($chaine, $where);

// Vérification que l'utilisateur à ajouter en ami existe
if (!$unAmi) {
  header('Location: liste_utilisateurs.php');
  exit();
}

// Vérification que l'utilisateur n'est pas déjà ami avec la personne qu'il veut ajouter
$unControleur->setTable("friend");
$existe = $unControleur->selectwhere($chaine, array("iduser"=>$_SESSION['iduser'], "idami"=>$idami));

if ($existe) {
  header('Location: home.php');
  exit();
}

// Envoi de la demande d'ami
$unControleur->setTable("demandeami");
$unControleur->insert(array("iduser"=>$_SESSION['iduser'],"idami" =>$idami));
// problème d'invitation

header('Location: message.php');
exit();
}
?>
