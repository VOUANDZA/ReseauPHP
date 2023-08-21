<?php
// Définir la durée de vie du cookie de session à 1 heure
 ini_set('session.cookie_lifetime', 60 * 60);

session_start();

require_once("controleur\config_db.php");
require_once("controleur\controleur.class.php");
$unControleur = new Controleur($serveur, $bdd, $user, $mdp);

if (isset($_POST['delete']) && isset($_POST['iduser2'])) {
    $iduser1 = $_SESSION["iduser"];
    $iduser2 = $_POST["iduser2"];
    $tab = array('iduser' => $iduser1, 'idami' => $iduser2);
    var_dump($tab);
    $unControleur->delete('demandeami', $tab);
}


header("Location: profil.php");
exit();
?>
