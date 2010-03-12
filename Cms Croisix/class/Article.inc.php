<?php 
/**
 * @class Article Article.inc.php
 * @date 30/03/2009
*  @brief Spécifique IFIP.
*  @details Articles de la boutique crées &agrave; la volée.
*  
**/	


class Article {
	
/**
 * Contient l'id de l'article.
 * 
 */
/**
 * Contient le libell&eacute; de l'article.
 * 
 */
	public $numarticle;
	public $libelle;
	
	/**
	 * Cr&eacute;e l'article.
	 */
	function creerArti() {	
	    mysql_query("INSERT INTO if_articles (libelle) VALUES ('$this->libelle')");
		
	}
	
	/**
	 * Modifie l'article.
	 */
	function modifierArti() {
	    mysql_query("UPDATE if_articles SET libelle='$this->libelle' WHERE numarticle='$this->numarticle'");
		
	}
	/**
	 * Supprime l'article.
	 */
	function supprimerArti() {	
	   mysql_query("DELETE FROM if_articles WHERE numarticle='$this->numarticle'");
	} 
	
	/**
	 * R&eacute;cup&egrave;re les infos de l'article.
	 * @return  Renvoie true s'il a bien trouv&eacute; un article
	 */	 
	function infosArti(){
		$row=SelectMultiple("if_articles","numarticle",$this->numarticle);
		$this->libelle=$row["libelle"];	
		if ($row["numarticle"]) return true;
	} 

	
}

?>
