<?php /* Date de création: 30/03/2009*/ 

/**
 * @class ListeArticles : liste tous les articles.
 * @date 30/03/2009
 * 
 * 
**/

class ListeArticles implements IteratorAggregate {
	/**
	 * Un tableau contenant les articles
	 */
	public $articles = array();
	/**
	 * Contient le num(id) de l'article
	 * 
	 */
   	public $numarticle;
   	
   	/**
 * Liste les articles
 * 
 * @author R&eacute;mi
 *
 */
	
   function afficherListeArticles() {
   		 $result=mysql_query("SELECT * FROM if_articles ORDER BY libelle");
		 while ($row=mysql_fetch_array($result)) {
		   	$unArticle=new Article();	
			$unArticle->numarticle=$row["numarticle"];
			$unArticle->infosArti();
			$this->articles[]=$unArticle;
	    }	//fin du while	
		if (count($this->articles)>=1) return true; 
   }
   
   function getIterator() {
   	  $iterator=new ListesIterator($this->articles);
	  return $iterator;
   }

}
?>