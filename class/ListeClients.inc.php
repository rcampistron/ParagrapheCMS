<?php  
/**
 * @date 28/01/2009
 * @class ListeClients ListeClients.inc.php
 * liste tous les clients de type professionnels.
**/

class ListeClients implements IteratorAggregate {
/**
 * Un tableau contenant la liste des clients
 * 
 */
   public $clients = array();
   /**
    * @brief indique si c'est un professionnel 
    * @details valeurs possibles "o" ou vide
    * 
    */
   public $profes;
   /**
    * Affiche la liste des clients
    * @return renvoie true si le tableau des clients n'est pas vide
    */
   function afficherListeClients() {
   	 
	 if ($this->profes) $fin_req=" profes='o'"; else $fin_req=" profes!='o'";
	 $result=mysql_query("SELECT numclient FROM if_bo_client WHERE $fin_req ORDER BY raison, nom ");
	 while ($row=mysql_fetch_row($result)) {
		$unClient=new Client();
		$unClient->numclient=$row[0];
		$unClient->infosClient();  
		$this->clients[]=$unClient;
	 }
	
	 if (count($this->clients)>=1) return true;
   }
   
   function getIterator() {
   	  $iterator=new ListesIterator($this->clients);
	  return $iterator;
   }

}
?>