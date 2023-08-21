<?php
session_start();
require_once("controleur\config_db.php");
require_once("controleur\controleur.class.php");
$unControleur = new Controleur($serveur, $bdd, $user, $mdp);

if (isset($_POST['connexion']))
  {
    $pseudo = $_POST['pseudo'];
    $mdp = $_POST['mdp'];
    //vérification dans la base
    $chaine ="*";
    $where =array("pseudo"=>$pseudo, "mdp"=>$mdp);
    $unControleur->setTable("utilisateur");
    $unUser = $unControleur->selectWhere($chaine, $where);
    if (isset($unUser['pseudo'])){
      $_SESSION['pseudo'] = $unUser['pseudo'];
      $_SESSION['iduser'] = $unUser['iduser'];;
      $_SESSION['nom'] = $unUser['nom'];
      $_SESSION['prenom'] = $unUser['prenom'];
      $_SESSION['email'] = $unUser['email'];
      $_SESSION['age'] = $unUser['age'];
      $_SESSION['ville'] = $unUser['ville'];
      $_SESSION['mdp'] = $unUser['mdp'];
      $_SESSION['photo'] = $unUser['photo'];

      header("Location: home.php");
    }else{
      $_SESSION['erreur_connexion'] = "Identifiants incorrect";
      header("Location: index.php");
      exit();
    }
  }
?>
