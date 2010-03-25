<?php /* Date de cration:  */ 
/**
 * @date 19/11/2008
 * @class ListePages ListePages.inc.php
 * liste toutes les pages
**/



class ListePages implements IteratorAggregate {

	/**
	 * Tableau conteant les pages
	 * 
	 */
   public $pages = array();
   
   /**
    * Affiche la liste des pages
    *  @return true si le tableau n'est pas vide
    */
   function afficherListePages() {
   	 //requete sql
	 $result=mysql_query("SELECT numpage FROM if_page ORDER BY titre");
	 while ($row=mysql_fetch_row($result)) {
	   	$unePage=new Page();
		/**$unePage->nomPageGoogle=$row["nom"];
		$unePage->titrePage=$row["titre"];	**/
		$unePage->numpage=$row[0];
		$unePage->infosPage();  
		$this->pages[]=$unePage;
	 }	
	 if (count($this->pages)>=1) return true;  
   }
   
   function getIterator() {
   	  $iterator=new ListesIterator($this->pages);
	  return $iterator;
   }

}
?>
