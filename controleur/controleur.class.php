<?php

require_once("modele/modele.class.php");

class Controleur {

	private $unModele;


	public function __construct($server, $bdd, $user, $mdp) {
		$this->unModele = new Modele($server, $bdd, $user, $mdp);
	}

	public function setTable($uneTable) {
		$this->unModele->setTable($uneTable);
	}

	public function insert_inscription($tab){
		$this->unModele->insert_inscription($tab);
	}

	public function insert($tab){
		return $this->unModele->insert($tab);
	}

	public function insertf($iduser1, $iduser2){
		$this->unModele->insertf($iduser1, $iduser2);
	}

	public function delete($table, $tab) {
     $this->unModele->delete($table, $tab);
}

	public function edit($tab, $where) {
        $this->unModele->edit($tab, $where);
  }

	public function selectDemandeAmi($iduser) {
        return $this->unModele->selectDemandeAmi($iduser);
  	}

	public function selectWhere($chaine = "*", $where) {
        return $this->unModele->selectWhere($chaine, $where);
    }

		public function selectNbAmisCommuns($iduser1, $iduser2) {
	        return $this->unModele->selectNbAmisCommuns($iduser1, $iduser2);
	  	}
}
?>
