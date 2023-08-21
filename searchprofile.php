<?php
// Définir la durée de vie du cookie de session à 1 heure
 ini_set('session.cookie_lifetime', 60 * 60);

session_start();

require_once("controleur\config_db.php");
require_once("controleur\controleur.class.php");
$unControleur = new Controleur($serveur, $bdd, $user, $mdp);

try {
    $bdd = new PDO('mysql:host=localhost;dbname=reseau_social2;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

  $iduser = $_SESSION['iduser'];
  $req = $bdd->prepare('SELECT * FROM Utilisateur WHERE iduser = ?');
  $req->execute(array($iduser));
  $utilisateur = $req->fetch();

  // Récupération de la liste des amis
  $req = $bdd->prepare('SELECT U.iduser, U.pseudo, U.photo FROM Utilisateur U INNER JOIN Friend F ON U.iduser = F.idami WHERE F.iduser = ?');
  $req->execute(array($iduser));
  $amis = $req->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de <?php echo $utilisateur['pseudo']; ?></title>
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
                <a class="menu-item active" >
                    <span><img src="icon/joystick.svg" class="icon1"></span><h3>profil</h3>
                </a>
                <a href="message.php" class="menu-item"  id="message">
                    <span> <small class="count">3</small> <img src="icon/chat-left-dots.svg" class="icon1"></span><h3>message</h3>
                </a>
                <a class="menu-item ">
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
                          <div class="info">
                          <?php
                            // Vérification de l'envoi du formulaire
                            if (isset($_POST['search'])) {

                              // Récupération du pseudo ou email saisi
                              $search = $_POST['search'];

                              // Requête pour récupérer l'utilisateur correspondant au pseudo ou email saisi
                              $requete = $bdd->prepare('SELECT * FROM utilisateur WHERE pseudo = :pseudo OR email = :email');
                              $requete->bindParam(':pseudo', $search);
                              $requete->bindParam(':email', $search);
                              $requete->execute();
                              $sp = $requete->fetch(PDO::FETCH_ASSOC);

                              // Si un utilisateur correspondant a été trouvé, affichage de sa page profil
                              if ($sp) {
                                  // Affichage du profil de l'utilisateur
                                  echo '<h1>Profil de '.$sp['pseudo'].'</h1>';
                                  echo '<img src="'.$sp['photo'].'" alt="Avatar de '.$sp['pseudo'].'">';
                                  echo '<p>Nom : '.$sp['nom'].'</p>';
                                  echo '<p>Prénom : '.$sp['prenom'].'</p>';
                                  echo '<p>Email : '.$sp['email'].'</p>';
                                  echo '<p>Ville : '.$sp['ville'].'</p>';

                                  if ($_SESSION['iduser'] != $sp['iduser']) {
                                      echo '<form method="post" action="frequest.php">';
                                      echo '<input type="hidden" name="iddest" value="'.$sp['iduser'].'">';
                                      echo '<button type="submit">Envoyer une demande d\'ami</button>';
                                      echo '</form>';
                              } else {
                                  // Affichage d'un message d'erreur si aucun utilisateur correspondant n'a été trouvé
                                  echo 'Aucun utilisateur correspondant au pseudo ou email saisi n\'a été trouvé.';
                              }
                            }
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                <!--..................feeds.end................................-->
            </div>
             <!-- =======MAIN RIGHT======= -->
            <div class="main-right">
                <div class="messages" id="message-box">
                    <div class="message-heading">
                        <h4>message</h4><span><img src="icon/pencil-square.svg" class="icon1"></span>
                    </div>
                    <!-- messagecategory -->
                    <div class="category">
                        <h6 class="active">friends</h6>
                        <h6 class="pr-requst">request(4)</h6>
                    </div>
                    <!-- messgae -->
                    <?php foreach ($amis as $ami): ?>
                      <div class="message">
                          <div class="profile-phots">
                              <div class="ac"></div>
                              <img src="<?php echo $ami['photo']; ?>" alt="">
                          </div>
                          <div class="messgae-body">
                              <h5><?php echo $ami['pseudo']; ?></h5>
                              <p class="text-gry">En ligne.</p>
                          </div>
                      </div>
                    <?php endforeach; ?>
                    </div>
                </div>
                <!--firend request
                <div class="firend-requests">
                    <h4>request</h4>
                    <div class="request">
                        <div class="info">
                            <div class="profile-phots">
                                <img src="img/f1.png" alt="">
                            </div>
                            <div class="request-body">
                                <h5>adam fight</h5>
                                <p class="text-gry">10 mutual firend</p>
                            </div>
                        </div>
                        <div class="action">
                            <button class="btn btn-primary" id="add">accept</button>
                            <button class="btn btn" id="del">delete</button>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </main>

    <!-- ................END MAINE SECTION......................... -->



    <!-- .............CUSTOM JS LINK...................... -->
    <script src="script.js"></script>
</body>
</html>
