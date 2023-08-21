<form action="" method="post" enctype="multipart/form-data">
  <div class="input-wrapper">
    <h3><label for="nom">Nom</label></h3>
    <input type="text" name="nom" value="<?=$utilisateur['nom']; ?>">
  </div>
  <div class="input-wrapper">
    <h3><label for="prenom">Prenom</label></h3>
    <input type="text" name="prenom" value="<?=$utilisateur['prenom']; ?>">
  </div>
  <div class="input-wrapper">
    <h3><label for="email">Email</label></h3>
    <input type="email" name="email" value="<?=$utilisateur['email']; ?>">
  </div>
  <div class="input-wrapper">
    <h3><label for="pseudo">Pseudo</label></h3>
    <input type="text" name="pseudo" value="<?=$utilisateur['pseudo']; ?>">
  </div>
  <div class="input-wrapper">
    <h3><label for="age">Age</label></h3>
    <input type="number" name="age" value="<?=$utilisateur['age']; ?>">
  </div>
  <div class="input-wrapper">
    <h3><label for="ville">Ville</label></h3>
    <input type="text" name="ville" value="<?=$utilisateur['ville']; ?>">
  </div>
  <div class="input-wrapper">
    <h3><label for="sexe">Sexe</label></h3>
    <select name="sexe" id="sexe">
      <option value="Homme">--Choisissez une option--</option>
      <option type="text"name="sexe" value="Homme">Homme</option>
      <option type="text" name="sexe" value="Femme">Femme</option>
      </option>
    </select>
  </div>
  <div class="input-wrapper">
    <h3><label for="photo">Choix de l'avatar:</label></h3>
    <input type="file" id="photo" name="photo">
  </div>
  <div class="input-wrapper">
    <h3><label>Nouveau mot de passe</label></h3>
    <input type="password" name="new" value="">
  </div>
  <div class="input-wrapper">
    <h3><label>Confirmez le nouveau mot de passe</label></h3>
    <input type="password" name="mdp" value="">
  </div>

    <input type="hidden" name="user_id" value="<?php echo $utilisateur['iduser']; ?>">
    <br><br>

    <center>
      <input type="reset" class="btn btn-primary" value="Réinitialiser">
      <input type="submit" class="btn btn-primary" name="edit" value="Mettre à jour">
    </center>


</form>
