<?php 
/**
 * @date 19/03/2009
 * @class Actualite Actualite.inc.php
 * @brief Cette classe g&egrave;re les actualit&eacute;s
 * @details Cette classe hérite de la classe Paragraphe
 * et donc de ses attributs et de ses méthodes
 */
class Actualite extends Paragraphe {
	
/**
 *  Date de l'actu formatée (d/m/Y)
 */
	public $date_actu;
/**
 *  Date de l'actu date de l'actu non formatée (format mktime)
 */
	public $datebrut;
/**
 *  Indique si l'actu est en page d'accueil - valeurs possibles "o" et "n"
 */
	public $accueil; 
	
/**
 * Cr&eacute;&eacute; les actualit&eacute;s en les ins&eacute;rant dans la base
 */
	function creerActu() {	
		if ($this->date_actu) $date=formaterDate($this->date_actu); else $date=0;   	    
	    mysql_query("INSERT INTO if_actus (numpara,date,accueil) 
		VALUES ('$this->numpara','$date','$this->accueil')");
		
	}
/**
 * Modifie les actualit&eacute;s
 */	

	function modifierActu() {
		if ($this->date_actu) $date=formaterDate($this->date_actu); else $date=0;   	   
	    mysql_query("UPDATE if_actus SET date='$date',accueil='$this->accueil' WHERE numpara='$this->numpara'");
		
	}
/**
 * Supprime une actualit&eacute;
 */
	function supprimerActu() {	
	   $this->supprimerParagraphe();
	   mysql_query("DELETE FROM if_actus WHERE numpara='$this->numpara'");
	} 
/** 
 * Va r&eacute;cup&eacute;rer les infos des actus
 */
	function infosActu(){
		$row=SelectMultiple("if_v_actu","numpara",$this->numpara);
		$this->titrePara=miseEnForme($row["titre"]);	
		$this->contenuPara=miseEnForme($row["contenu"]);
		$this->date_actu=date("d/m/Y",$row["date"]);
		$this->datebrut=$row["date"];
		$this->accueil=$row["accueil"];
	} 

	
}

?>