<?php
// Connexion à la base de données
try {
    $bdd = new PDO('mysql:host=localhost;dbname=reseau_social2;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Vérification de la session
session_start();


// Récupération des informations de l'utilisateur connecté
$iduser = $_SESSION['iduser'];
$req = $bdd->prepare('SELECT * FROM Utilisateur WHERE iduser = ?');
$req->execute(array($iduser));
$utilisateur = $req->fetch();

// Récupération de la liste des amis
$req = $bdd->prepare('SELECT U.iduser, U.pseudo, U.photo FROM Utilisateur U INNER JOIN Friend F ON U.iduser = F.idami WHERE F.iduser = ?');
$req->execute(array($iduser));
$amis = $req->fetchAll();

// Si un ami a été sélectionné
if (isset($_GET['idami'])) {
    $idami = $_GET['idami'];
    $req = $bdd->prepare('SELECT iduser, pseudo FROM Utilisateur WHERE iduser = ?');
    $req->execute(array($idami));
    $ami = $req->fetch();

    // Récupération des messages échangés avec cet ami
    $req = $bdd->prepare('SELECT * FROM Messages WHERE (iduser = ? AND idami = ?) OR (iduser = ? AND idami = ?) ORDER BY date_creation ASC');
    $req->execute(array($iduser, $idami, $idami, $iduser));
    $messages = $req->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de <?php echo $_SESSION['pseudo']; ?></title>
    <!-- ................CUSTOM CSS LINK................... -->
    <link rel="stylesheet" href="css\style.css">
</head>

<body>
    <!-- .............START HEADER SECTION...................... -->
    <?php include('header.php'); ?>
    <!-- ................END HEADER SECTION......................... -->

              <!--.............. SIDEBAR.............. -->
              <div class="side-bar">

                <a href="home.php" class="menu-item" >
                    <span><img src="icon/house-door.svg" class="icon1"></span><h3>home</h3>
                </a>
                <a href="profil.php" class="menu-item " >
                    <span><img src="icon/joystick.svg" class="icon1"></span><h3>profil</h3>
                </a>
                <a class="menu-item active"  id="message">
                    <span><img src="icon/chat-left-dots.svg" class="icon1"></span><h3>message</h3>
                </a>
                <a class="menu-item " >
                    <span><img src="icon/bookmarks.svg" class="icon1"></span><h3>bookmarks</h3>
                </a>
                <a class="menu-item " id="themeMenu">
                    <span><img src="icon/palette.svg" class="icon1"></span><h3>theme</h3>
                </a>
                <label for="creatPost" class="btn btn-primary" >create post</label>

              </div>

            </div>
            <!-- =======MAIN MID======= -->
            <div class="main-mid">
                <!--..................feeds..start...............................-->
                <div class="feeds">
                    <div class="feed">
                        <div class="head">
                            <div class="user">
                              <div class="info">
                              <h1><center>Gestion des messages</h1>
                              <br>
                              <p>Utilisateur connecté : <?php echo $utilisateur['pseudo']; ?></p>
                              <br>
                              <h2>Liste des amis</h2>
                              <ul>
                                  <?php foreach ($amis as $ami): ?>
                                      <li><a href="?idami=<?php echo $ami['iduser']; ?>"><img class="la" src="<?php echo $ami['photo']; ?>" alt="Photo de <?php echo $ami['pseudo']; ?>" /><?php echo $ami['pseudo']; ?></a></li>
                                  <?php endforeach; ?>
                              </ul>

                              <?php if (isset($ami)): ?>
                                  <h2>Messages avec <?php echo $ami['pseudo']; ?></h2>
                                  <?php if (empty($messages)): ?>
                                      <p>Pas de messages.</p>
                                  <?php else: ?>
                                      <ul>
                                          <?php foreach ($messages as $message): ?>
                                              <li><?php echo $message['texte']; ?> (envoyé le <?php echo $message['date_creation']; ?>)</li>
                                          <?php endforeach; ?>
                                      </ul>
                                  <?php endif; ?>
                                  <form method="post" action="envoyer_message.php">
                                      <input type="hidden" name="idami" value="<?php echo $idami; ?>" />
                                      <p>
                                          <label for="texte">Message :</label>
                                          <input type="text" name="texte" id="texte" required />
                                      </p>
                                      <p><input type="submit" value="Envoyer" /></p>
                                  </form>
                              <?php endif; ?>
                            </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!--..................feeds.end................................-->
            </div>
        </div>
    </main>

    <!-- ................END MAINE SECTION......................... -->



    <!-- .............CUSTOM JS LINK...................... -->
    <script src="script.js"></script>
</body>
</html>
