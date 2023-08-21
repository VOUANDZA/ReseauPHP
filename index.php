<?php
session_start();

require_once("controleur\config_db.php");
require_once("controleur\controleur.class.php");
$unControleur = new Controleur($serveur, $bdd, $user, $mdp);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="css\logincss.css" />
    <title>inscription et connexion</title>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <!--Connexion-->
          <form method="post" action="connexion.php" id="connexion-form" class="sign-in-form">
            <h2 class="title">Connexion</h2>
            <div id="message"></div>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="pseudo" placeholder="Pseudo"/>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="mdp" placeholder="Mot de passe" />
            </div>
            <?php
                // Si une erreur de connexion a été stockée dans la variable de session
                if(isset($_SESSION['erreur_connexion'])) {
                  echo '<p class="error" style="color:red">' . $_SESSION['erreur_connexion'] . '</p>';
                  // Supprime l'erreur de la variable de session pour ne pas l'afficher plusieurs fois
                  unset($_SESSION['erreur_connexion']);
                }
            ?>
            <input type="submit" name="connexion" value="Se connecter" class="btn solid" />
            <p class="social-text">Se connecter avec</p>
            <div class="social-media">
              <a href="#" class="social-icon">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </form>
          <!--Inscription-->
          <form action="inscription.php" method="post" id="inscription-form" class="sign-up-form">
            <h2 class="title">Inscription</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="nom" placeholder="NOM" />
            </div>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="prenom" placeholder="Prenom" />
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email"  name="email" placeholder="Email" />
            </div>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="pseudo" placeholder="Pseudo" />
            </div>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="number" name="age" placeholder="Age" />
            </div>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="ville" placeholder="Ville" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="mdp" placeholder="Mot de passe" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="confirm_mdp" placeholder="Confirmer votre de passe" />
            </div>
            <div id="inscription-errors"></div>
              <!-- Affichage des erreurs -->
              <?php if(isset($_SESSION['errors'])): ?>
                  <div class="errors" style="color:red">
                      <ul>
                          <?php foreach($_SESSION['errors'] as $error): ?>
                              <li><?php echo $error; ?></li>
                          <?php endforeach; ?>
                      </ul>
                  </div>
                  <?php unset($_SESSION['errors']); ?>
              <?php endif; ?>
         <input type="submit" name="inscription" class="btn" value="S'inscrire" />

            <p class="social-text">S'inscrire sur la plateforme avec</p>
            <div class="social-media">
              <a href="#" class="social-icon">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </form>
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>Bienvenu sur le site chap chap</h3>
           <br>
            <button class="btn transparent" id="sign-up-btn">
            Inscription
            </button>
          </div>
          <img src="img/log.svg" class="image" alt="" />
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>Connectez  vous sur chap chap</h3>
            <p>

            </p>
            <button class="btn transparent" id="sign-in-btn">
             Connexion
            </button>
          </div>
          <img src="img/register.svg" class="image" alt="" />
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="app.js"></script>
  </body>
</html>
