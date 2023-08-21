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
                    <span><img src="icon/chat-left-dots.svg" class="icon1"></span><h3>message</h3>
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
                            <div class="user">
                                <div class="profile-phots">
                                    <img src="<?php echo $utilisateur['photo']; ?>" alt="Avatar de <?php echo $utilisateur['pseudo']; ?>">
                                </div>
                                <div class="info">
                                    <h3>Profil de <?php echo $utilisateur['pseudo']; ?></h3>
                                    <strong><?php echo $utilisateur['email']; ?></strong>
                                    <div class="avatar">

                                    <p>Nom : <?php echo $utilisateur['nom']; ?></p>
                                    <p>Prénom : <?php echo $utilisateur['prenom']; ?></p>
                                    <p>Email : <?php echo $utilisateur['email']; ?></p>
                                    <p>Âge : <?php echo $utilisateur['age']; ?> ans</p>
                                    <p>Sexe : <?php echo $utilisateur['sexe'] ?></p>
                                    <p>Ville : <?php echo $utilisateur['ville']; ?></p>

                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="feed">

                          <center><h2>Modifier le profil</h2></center>
                          <br><br>
                          <?php
                          require_once("vue\updateProfil.php");

                          if (isset($_POST['edit'])) {
                            // Vérifier si un nouveau mot de passe a été saisi
                            if (!empty($_POST['new'])) {
                                // Générer le hachage du nouveau mot de passe
                                $mdp_hache = password_hash($_POST['new'], PASSWORD_DEFAULT);

                                // Mettre à jour le champ 'mdp' dans la base de données avec le nouveau mot de passe haché
                                $tab = array('mdp' => $mdp_hache);
                            } else {
                                // Si aucun nouveau mot de passe n'a été saisi, mettre à jour les autres champs sans changer le mot de passe
                                $tab = array(
                                    'nom' => $_POST['nom'],
                                    'prenom' => $_POST['prenom'],
                                    'email' => $_POST['email'],
                                    'age' => $_POST['age'],
                                    'pseudo' => $_POST['pseudo'],
                                    'ville' => $_POST['ville'],
                                    'sexe' => $_POST['sexe']
                                );
                            }

                            // Vérifier si un fichier a été sélectionné
                            if (!empty($_FILES['photo']['name'])) {
                                // Enregistrer le chemin du fichier dans la base de données
                                $dossier = 'img/';
                                $fichier = basename($_FILES['photo']['name']);
                                $chemin = $dossier . $fichier;
                                $tab['photo'] = $chemin;

                                // Vérifier si le fichier est bien une image
                                $extension = strtolower(pathinfo($chemin, PATHINFO_EXTENSION));
                                $verif = array('jpg', 'jpeg', 'png', 'gif');
                                if (!in_array($extension, $verif)) {
                                    die('Erreur : le fichier n\'est pas une image.');
                                }

                                // Enregistrer le fichier dans le dossier "img/"
                                if (move_uploaded_file($_FILES['photo']['tmp_name'], $chemin)) {
                                    echo 'Le fichier a été enregistré dans le dossier "img/"';
                                } else {
                                    echo 'Erreur : impossible d\'enregistrer le fichier.';
                                }
                            }

                            // Mettre à jour l'utilisateur dans la base de données
                            $unControleur->setTable("utilisateur");
                            $where = array('iduser' => $utilisateur['iduser']);
                            $unControleur->edit($tab, $where);
                        }
                         ?>
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
                        <!-- <h6 class="pr-requst">request(4)</h6> -->
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
                    <div class="firend-requests">
                      <h4>Friend Requests</h4>
                      <?php
                      $res = $unControleur->selectDemandeAmi($_SESSION['iduser']);
                      if ($res != null) {
                          // Récupération de l'utilisateur associé à l'iduser de la demande d'ami
                          $unControleur->setTable("utilisateur");

                          foreach ($res as $r) {
                              $iduser2 = $r['idami'];
                              $use = $unControleur->selectWhere("*", array('iduser' => $iduser2));
                              $nbAmisCommuns = $unControleur->selectNbAmisCommuns($_SESSION['iduser'], $iduser2);
                              ?>

                              <div class="request">
                                  <div class="info">
                                      <div class="profile-phots">
                                          <img src="img/<?php echo $use['photo']; ?>" alt="">
                                      </div>
                                      <div class="request-body">
                                          <h5><?php echo $use['nom']." ".$use['prenom']; ?></h5>
                                          <p class="text-gry"><?php echo $nbAmisCommuns; ?> mutual friends</p>
                                      </div>
                                  </div>
                                  <div class="action">
                                    <form method="post" action="add_demandeami.php">
                                      <button class="btn btn-primary" name="add" type="submit">Accept</button>
                                      <input type="hidden" name="iduser2" value="<?= $iduser2 ?>">
                                    </form>
                                    <form method="post" action="delete_demandeami.php">
                                      <button class="btn btn-primary" name="delete" type="submit">Delete</button>
                                      <input type="hidden" name="iduser2" value="<?= $iduser2 ?>">
                                    </form>
                                  </div>
                              </div>

                          <?php
                          }
                      } else {
                          echo "<p>No friend requests.</p>";
                      }
                      ?>
                  </div>
                </div>
                <!--firend request
                 -->
            </div>
        </div>
    </main>

    <!-- ................END MAINE SECTION......................... -->



    <!-- .............CUSTOM JS LINK...................... -->
    <script src="script.js"></script>
</body>
</html>
