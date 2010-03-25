<?php /* Date de cration:  */ 
/**
 *@date  18/12/2008
 *@class ListeUtilisateurs ListeUtilisateurs.inc.php
 * liste tous les utilisateurs du CMS.
**/


class ListeUtilisateurs implements IteratorAggregate {
/**
 * Tableau contenant la liste des utilisateurs 
 * 
 */
   public $utis = array();
    /**
     * R&eacute;cup&egrave;re la liste des utilisateurs pour l'afficher
     */
   function afficherListeUtis() {

	 $result=mysql_query("SELECT numuti FROM if_utilisateur ORDER BY nom,prenom"); 
	 while ($row=mysql_fetch_row($result)) {
	   	$unUti=new Utilisateur();	 
		$unUti->numuti=$row[0]; 
		$unUti->infosUti();
		$this->utis[]=$unUti;
	 } 
	 if (count($this->utis)>=1) return true;
   }
   
   function getIterator() {
   	  $iterator=new ListesIterator($this->utis);
	  return $iterator;
   }

}
?>
