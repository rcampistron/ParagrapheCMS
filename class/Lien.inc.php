<?php 
/**
 * @date 19/11/2008
 * @class Lien
 * @file Lien.inc.php
 * @author Anne
 * @package www_classes
 * @brief cr&eacute;ation, modification, suppression d'un lien
 * 
 */

class Lien { 
/**
 * Contient le num(id) du lien
 * 
 */
    public $numlien;
    /**
     * Contient le libell&eacute; du lien 
     * 
     */
	public $libLien;
	/**
	 * Contient le texte du lien
	 * 
	 */
	public $texteLien;
	/**
	 * Contient l'ordre du lien
	 * 
	 */
	public $ordreLien;
	/**
	 * Contient l'url du lien
	 * 
	 */
	public $urlLien;
	/**
	 * indique si le lien doit s'ouvrir dans une nouvelle fenÃªtre
	 * 
	 */
	public $fenLien;
	/**
	 * Contient le num&eacute;ro(id) de paragraphe
	 * 
	 */
	public $numpara;
	/**
	 * Contient le num&eacute;ro(id) de la page dans le cas où le lien est une page interne
	 * 
	 */
	public $numpage;
	
	/**
	 * Fonction qui va cr&eacute;er le lien, et les ins&eacute;rer dans la base
	 */
	function creerLien() {
	   if (!$this->numpage) $this->numpage=0;
	   mysql_query("INSERT INTO if_liens (numpara,libelle,texte,url,numpage,fenetre,ordre) 
		VALUES ('$this->numpara','$this->libLien','$this->texteLien','$this->urlLien','$this->numpage','$this->fenLien','$this->ordreLien')");
		
	}
	/**
	 * Fonction qui va supprimer le lien de la base
	 */
	function supprimerLien() {
	   mysql_query("DELETE FROM if_liens WHERE numlien='$this->numlien'");	 
	}
	/**
	 * Fonction qui va modifier le lien de la base
	 */
	function modifierLien() {
	    if (!$this->numpage) $this->numpage=0;
	   mysql_query("UPDATE if_liens SET libelle='$this->libLien', texte='$this->texteLien', url='$this->urlLien', numpage='$this->numpage', fenetre='$this->fenLien', ordre='$this->ordreLien' WHERE numlien ='$this->numlien'");
	}	
	/**
	 * R&eacute;cup&egrave;re les infos concernant le lien
	 */
	function infosLien() {
		if ($this->numlien) {
			$row=SelectMultiple("if_liens","numlien",$this->numlien);
			$this->libLien=$row["libelle"];
			$this->texteLien=miseEnForme($row["texte"]);
			$this->urlLien=$row["url"];
			$this->ordreLien=$row["ordre"];
			$this->fenLien=$row["fenetre"];
			
		}
	}
	
}

?>
