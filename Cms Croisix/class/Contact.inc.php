<?php /* Date de cration: 19/11/2008 */ 
/**
 *@date 19/11/2008
 *@class Contact Contact.inc.php
 *@brief Gestion des contacts 
 *@details Cr&eacute;ation, modification, suppression d'un contact
 **/

class Contact {
   	/**
   	 * num(id) du contact 
   	 * 
   	 */
    public $numcontact;
    /**
     * nom du contact
     * 
     */
    public $nom;
    /**
     * Pr&eacute;nom du contact 
     * 
     */
	public $prenom;
	/**
	 * Genre du contact
	 * 
	 */
	public $genre;	
	/**
	 * Fonction professionelle du contact 
	 * 
	 */
	public $fonction;
	/**
	 * Email du contact
	 * 
	 */
	public $email;
	/**
	 * Nu&eacute;m&eacute;ro de t&eacute;l&eacute;phone du contact
	 * 
	 */
	public $tel; 
	/**
	 * Num&eacute;ro de fax du contact
	 * 
	 */
	public $fax;
	/**
	 * Num&eacute;ro gsm du contact
	 * 
	 */
	public $gsm;
	/**
	 * @brief indique si le contact est un contact referent 
	 * @details valeurs possibles "o" et "n"
	 * 
	 */
	public $referent;
	/**
	 * Tableau listant les cat&eacute;gories
	 * 
	 */
	public $listcateg = array();
	/**
	 * Tableau listant les sous-cat&eacute;gories
	 * 
	 */
	public $listsscateg = array();
	/**
	 * Cr&eacute;er un contact dans la base 
	 * @return renvoie le num(id) du contact
	 */
	function creerContact() {
	   
		mysql_query("INSERT INTO if_contacts (nom,prenom,genre,fonction,email,tel,fax,gsm,referent) VALUES ('$this->nom','$this->prenom','$this->genre','$this->fonction','$this->email','$this->tel','$this->fax','$this->gsm','$this->referent')");
		$this->numcontact=mysql_insert_id();
		$this->associerContactCateg();
		$this->associerContactSscateg();
		return $this->numcontact; 
	}
	/**
	 * Modifie un contact dans la bdd
	 */
	function modifierContact() {
	   mysql_query("UPDATE if_contacts SET nom='$this->nom',prenom='$this->prenom',genre='$this->genre',fonction='$this->fonction',email='$this->email',tel='$this->tel',fax='$this->fax',gsm='$this->gsm',referent='$this->referent' WHERE numcontact='$this->numcontact'");
	   mysql_query("DELETE FROM if_cont_categ WHERE numcontact='$this->numcontact'"); 
	   mysql_query("DELETE FROM if_cont_sscateg WHERE numcontact='$this->numcontact'");
	   $this->associerContactCateg();
	   $this->associerContactSscateg();
	}
	/**
	 * Supprime un contact de la bdd
	 */
	function supprimerContact() {
	   mysql_query("DELETE FROM if_contacts WHERE numcontact='$this->numcontact'");
	   mysql_query("DELETE FROM if_cont_categ WHERE numcontact='$this->numcontact'"); 
	   mysql_query("DELETE FROM if_cont_sscateg WHERE numcontact='$this->numcontact'");
	}
	/**
	 * Associe un contact &agrave; une cat&eacute;gorie
	 */
	function associerContactCateg() {
		if (is_array($this->listcateg)) {
		   for ($i=0;$i<count($this->listcateg);$i++) {	 
		   		$categ=$this->listcateg[$i];
		   		mysql_query("INSERT INTO if_cont_categ (numcontact,numcateg) VALUES ('$this->numcontact','$categ')");
		   }
		}
	}
	/**
	 * Associe un contact &agrave; une ss cat&eacute;gorie
	 */
	function associerContactSscateg() {
		 if (is_array($this->listsscateg)) {
		   for ($i=0;$i<count($this->listsscateg);$i++) {
		   		$sscateg=$this->listsscateg[$i];
		   		mysql_query("INSERT INTO if_cont_sscateg (numcontact,numsscateg) VALUES ('$this->numcontact','$sscateg')");
		   }
		}
	}
	/**
	 * R&eacute;cup&egrave;re toutes les informations concernant un contact
	 */
	function infosContact() {
		$row=SelectMultiple("if_contacts","numcontact",$this->numcontact);
		$this->nom=$row["nom"];
		$this->prenom=$row["prenom"];
		$this->genre=$row["genre"];
		$this->fonction=$row["fonction"]; 
		$this->email=$row["email"];	 
		$this->tel=$row["tel"];	
		$this->fax=$row["fax"];	
		$this->gsm=$row["gsm"];
		$this->referent=$row["referent"];
	}
	/**
	 * Affiche la cat&eacute;gorie associ&eacute; au contact
	 * @return renvoie true si pas d'erreur
	 * @see Menu
	 */
	function afficherCateg() {
		$result=mysql_query("SELECT numcateg FROM if_cont_categ WHERE numcontact='$this->numcontact'");
		while ($row=mysql_fetch_row($result)) {
			  $laCateg=new Menu();
			  $laCateg->type="categorie";
			  $laCateg->nomkey="numcateg";
			  $laCateg->nummenu=$row[0];  
			  $laCateg->infosMenu();
			  $this->listcateg[]=$laCateg;
		} 
		if (count($this->listcateg)>=1) return true;
	}
	/**
	 * Affiche la ss-cat&eacute;gorie associ&eacute; au contact
	 * @return renvoie true si pas d'erreur
	 */
	function afficherSscateg() {
		$result=mysql_query("SELECT numsscateg FROM if_cont_sscateg WHERE numcontact='$this->numcontact'");
		while ($row=mysql_fetch_row($result)) {
			  $laSscateg=new Menu();
			  $laSscateg->type="sscateg";
			  $laSscateg->nomkey="numsscateg";
			  $laSscateg->nummenu=$row[0];  
			  $laSscateg->infosMenu();
			  $this->listsscateg[]=$laSscateg;
		} 
		if (count($this->listsscateg)>=1) return true;
	}
}

?>
