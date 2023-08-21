<?php
// Définir la durée de vie du cookie de session à 1 heure
 ini_set('session.cookie_lifetime', 60 * 60);

session_start();

require_once("controleur/config_db.php");
require_once("controleur/controleur.class.php");
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
    <title>CHAP CHAP</title>
    <!-- ................CUSTOM CSS LINK................... -->
    <link rel="stylesheet" href="css\style.css">
</head>
<body>
    <!-- .............START HEADER SECTION...................... -->
    <?php include('header.php'); ?>
    <!-- ................END HEADER SECTION......................... -->

              <!--.............. SIDEBAR.............. -->
              <div class="side-bar">

                <a class="menu-item active" >
                    <span><img src="icon/house-door.svg" class="icon1"></span><h3>home</h3>
                </a>
                <a href="profil.php" class="menu-item " >
                    <span><img src="icon/joystick.svg" class="icon1"></span><h3>profil</h3>
                </a>
                <a href="message.php" class="menu-item"  id="message">
                    <span><img src="icon/chat-left-dots.svg" class="icon1"></span><h3>message</h3>
                </a>
                <a class="menu-item">
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
                <form class="creatPost">
                    <div class="profile-phots">
                        <img src="<?php echo $_SESSION['photo']; ?>" alt="">
                    </div>
                   <div class="text-post">
                      <input type="text" placeholder="Partagez vos pensées <?php echo $_SESSION['pseudo']?> !" class="creatPost">
                   </div>

                   <div>
                       <input type="submit" value="post" class="btn btn-primary">
                   </div>
                </form>

                <!--..................feeds..start...............................-->
                <?php require_once("feed.php"); ?>
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
                         <a href="?idami=<?php echo $ami['iduser']; ?>">
                           <div class="profile-phots">
                               <div class="ac"></div>
                               <img src="<?php echo $ami['photo']; ?>" alt="">
                           </div>
                           <div class="messgae-body">
                               <h5><?php echo $ami['pseudo']; ?></h5>
                               <p class="text-gry">En ligne.</p>
                             </a>
                           </div>
                       </div>
                     <?php endforeach; ?>
                     </div>
                 </div>
        </div>
    </main>

    <!--................. THEME CUSTOMIZE.START............. -->
    <div class="theme">
        <div class="card">
            <h2>CUSTOMIZE yuor site</h2>
            <p class="text-gry">manage your font, color, and backgroud</p>


            <!--........... FONT-SIZE........... -->
            <div class="font-siz">
                <div>
                    <h6>aa</h6>
                    <div class="choose-font-size">
                        <span class="font1"></span>
                        <span class="font2 active"></span>
                        <span class="font3"></span>
                        <span class="font4"></span>
                        <span class="font5"></span>
                    </div>
                    <h3>aa</h3>
                </div>
            </div>

            <!--.................. COLOR................ -->
        <div class="color">
            <h3>color</h3>
            <div class="choose-color">
                <span class="color1"></span>
                <span class="color2"></span>
                <span class="color3 active"></span>
                <span class="color4"></span>
                <span class="color5"></span>
            </div>
        </div>

        <!--.............BACKGROUND.............. -->
        <div class="background">
            <h3>backgorund</h3>
            <div class="chosse-backgorund">
                <div class="bg1 active">
                    <span></span>
                    <h5 class="bg1">light</h5>
                </div>
                <div class="bg2">
                    <span></span>
                    <h5 class="bg2">dark</h5>
                </div>
                <div class="bg3">
                    <span></span>
                    <h5 class="bg3">black</h5>
                </div>
            </div>
        </div>

        </div>
    </div>
    <!--.............THEME CUSTOMIZE.END...... -->
    <!-- ................END MAINE SECTION......................... -->



    <!-- .............CUSTOM JS LINK...................... -->
    <script src="script.js"></script>
</body>
</html>
