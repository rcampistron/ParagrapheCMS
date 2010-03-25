<?php /* Date de cr&eacute;ation: 19/11/2008 */ 
/**
 * @date 19/11/2008
 * @class ListeFichiers ListeFichiers.inc.php
 * liste tous les fichiers.
**/
class ListeFichiers implements IteratorAggregate {
/**
 * Un tableau contenant les fichiers 
 * @return true si le tableau n'est pas vide 
 */
   public $fichiers = array();
   public $numpara;
   function afficherListeFichiers() {
   	 //requete sql
	 
	 if ($this->numpara) {
	 	 $result=mysql_query("SELECT numfichier,libelle,ordre,numparafichier FROM if_para_fichier WHERE numpara='$this->numpara' ORDER BY ordre");
		 //echo "SELECT numfichier,libelle,ordre,numparafichier FROM if_para_fichier WHERE numpara='$this->numpara' ORDER BY ordre";
		 while ($row=mysql_fetch_row($result)) {
		   	$unFichier=new Fichier();
			$unFichier->numfichier=$row[0];
			$unFichier->libFichier=$row[1];
			$unFichier->ordreFichier=$row[2];
			$unFichier->numparafichier=$row[3];
			$unFichier->infosFichier();  
			$this->fichiers[]=$unFichier;
		 }
	 } else {
		 $result=mysql_query("SELECT numfichier FROM if_fichier ORDER BY nom_fichier");
		 while ($row=mysql_fetch_row($result)) {
		   	$unFichier=new Fichier();
			$unFichier->numfichier=$row[0];
			$unFichier->infosFichier();  
			$this->fichiers[]=$unFichier;
		 }
	 }
	 if (count($this->fichiers)>=1) return true;
   }
   
   function getIterator() {
   	  $iterator=new ListesIterator($this->fichiers);
	  return $iterator;
   }

}
?>
