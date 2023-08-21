<?php
// Connexion à la base de données
try {
    $bdd = new PDO('mysql:host=localhost;dbname=reseau_social2;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Vérification de la session
session_start();
if (!isset($_SESSION['iduser'])) {
    header('Location: index.php');
    exit();
}

// Récupération des données du formulaire
$idami = $_POST['idami'];
$texte = $_POST['texte'];

// Vérification de la validité des données
if (empty($idami) || empty($texte)) {
    echo 'Tous les champs sont obligatoires.';
} else {
    // Insertion du message dans la base de données
    $iduser = $_SESSION['iduser'];
    $req = $bdd->prepare('INSERT INTO Messages(iduser, idami, texte, date_creation) VALUES(:iduser, :idami, :texte, NOW())');
    $req->execute(array(
        'iduser' => $iduser,
        'idami' => $idami,
        'texte' => $texte
    ));

    // Redirection vers la page de gestion des messages avec l'ami
    header('Location: message.php?idami=' . $idami);
    exit();
}
?>
