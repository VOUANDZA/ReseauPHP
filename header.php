<nav>
		<div class="container nav-container">
  			<h2 class="logo">
    				CHAP<span>CHAP</span>
    		</h2>
				<form method="post" action="searchprofile.php">
    		<div class="search-bar">
    				<img src="icon/search.svg" class="icon2">
    				<input type="text" name="search" placeholder="recherche...">
						<input type="submit" value="valider">
    		</div>
			</form>
    		<div class="create">
    				<!--<label for="creatPost" class="btn btn-primary">update</label>-->
						<a href="logout.php"><button class="btn btn-primary">Déconnexion</button></a>
    				<div class="profile-phots">
    						<a href="profil.php"><img src="<?php echo $_SESSION['photo']; ?>" alt=""></a>
    				</div>
  			</div>
  	</div>
</nav>
    <!-- ................START MAIN SECTION......................... -->
<main>
		<div class="container main-container">
				<!--=======MAIN LEFT======== -->
				<div class="main-left">
					<div class="profile">
						<div class="profile-phots">
								<img src="<?php echo $_SESSION['photo']; ?>" alt="">
						</div>
						<div class="hendel">
								<h4><?php echo $_SESSION['pseudo'];?></h4>
								<p class="text-gry"><?php echo $_SESSION['email']; ?></p>
						</div>
					</div>
