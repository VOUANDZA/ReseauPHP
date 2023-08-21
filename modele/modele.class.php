<?php

class Modele {

	private $pdo;
	private $uneTable;

	public function __construct($server, $bdd, $user, $mdp) {
		$this->pdo = null;
		try {
			$this->pdo = new PDO("mysql:host=".$server.";dbname=".$bdd, $user, $mdp);
		} catch (PDOException $e) {
			die("Erreur de connexion à la base de données : " . $e->getMessage());
		}
	}

  public function setTable($uneTable){
		   $this->uneTable = $uneTable;
	}

	public function insert_inscription($tab) {
			if ($this->pdo != null) {
				$champs = array();
				$donnees = array();
				foreach ($tab as $key=>$value) {
					$champs[] = ":".$key;
					$donnees[":".$key] = $value;
				}
				$chaine = implode(",", $champs);
				$requete = "INSERT INTO ".$this->uneTable." (nom, prenom, email, age, pseudo, ville, mdp, photo) VALUES (:nom, :prenom, :email, :age, :pseudo, :ville, :mdp, 'img/default-avatar.png')";
				$insert = $this->pdo->prepare($requete);
				$insert->execute($donnees);
			} else {
				return null;
			}
		}

		public function insertf($iduser, $idami) {
    if ($this->pdo != null) {
        $requete = "INSERT INTO Friend (iduser, idami) VALUES (:iduser, :idami)";
        $insert = $this->pdo->prepare($requete);
        $insert->execute(array(':iduser' => $iduser, ':idami' => $idami));
    } else {
        return null;
    }
}

public function delete($table, $tab) {
    $sql = "DELETE FROM $table WHERE ";
    $conditions = array();
    foreach ($tab as $key => $value) {
        $conditions[] = "$key = :$key";
    }
    $sql .= implode(" AND ", $conditions);
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($tab);
		if (!$stmt->execute($tab)) {
    var_dump($stmt->errorInfo());
    exit();
}
}


  public function edit($tab, $where) {
        if ($this->pdo != null) {
            $champs = array();
			$donnees = array();
			foreach ($tab as $key=>$value) {
				$champs[] = $key . " = :".$key;
				$donnees[":".$key] = $value;
			}
			$chaine = implode(",", $champs);
            $champsWhere = array();
            foreach ($where as $key=>$value) {
				$champsWhere[] = $key." = :".$key;
				$donnees[":".$key] = $value;
			}
			$chaineWhere = implode(" AND ", $champsWhere);
            $requete ="UPDATE ".$this->uneTable." SET ".$chaine." WHERE ".$chaineWhere;
            $update = $this->pdo->prepare($requete);
            $update->execute($donnees);
        } else {
            return null;
        }
    }

		public function selectWhere($chaine, $where) {
			if ($this->pdo != null) {
	            $champs = array();
				$donnees = array();
				foreach ($where as $key=>$value) {
					$champs[] = $key." = :".$key;
					$donnees[":".$key] = $value;
				}
				$chaineWhere = implode(" AND ", $champs);
				$requete = "SELECT ".$chaine." FROM ".$this->uneTable." WHERE ".$chaineWhere;
	            $select = $this->pdo->prepare($requete);
	            $select->execute($donnees);
	            return $select->fetch();
			} else {
				return null;
			}
		}

		function password_hash($password) {
  	$options = [
    'cost' => 12,
  		];
  	$hash = password_hash($password, PASSWORD_BCRYPT, $options);
  	return $hash;
			}

		public function selectDemandeAmi($iduser) {
			$requete = $this->pdo->prepare("SELECT * FROM demandeami WHERE iduser = :iduser");
			$requete->bindParam(":iduser", $iduser);
			$requete->execute();
			return $requete->fetchAll(PDO::FETCH_ASSOC);
		}

		public function selectNbAmisCommuns($iduser1, $iduser2) {
		    $requete = "SELECT nbAmisCommuns FROM amis_communs WHERE iduser = $iduser1 AND idami = $iduser2";
		    $resultat = $this->pdo->query($requete);
		    if($resultat !== false && $resultat->rowCount() > 0){
		        $nbAmisCommuns = $resultat->fetchColumn(); // récupère la première colonne du premier enregistrement
		        return $nbAmisCommuns;
		    }
		    return 0; // si aucun résultat, retourne 0
		}

}
 ?>
