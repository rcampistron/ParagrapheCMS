<?php 
/**
* @date 23/01/2009 
* @class ListeCommandes ListeCommandes.inc.php
* liste toutes les commandes d'un client de la boutique.
**/

class ListeCommandes implements IteratorAggregate {
/**
 * Un tableau comprenant toutes les commandes 
 * 
 */
   public $commandes = array();
   /**
    * le num(id) du client
    * 
    */
   public $numclient;
   /**
    * @brief type de r&eacute;glement
    * @details valeurs possibles "ch" et "cb"
    * 
    */
   public $type_reg;
   /**
    * @brief &eacute;tat de la commande 
    * @details valeurs possibles: 0 = cr&eacute;&eacute;e, 1 = en attente de validation par l'admin, 2 = valid&eacute;e, 3 = exp&eacute;di&eacute;e, 4 = reçue
    * 
    */
   public $etat;
   /**
    * pour recherche sur la date
    * 
    */ 
   public $date_du;
   /**
    * pour recherche sur la date
    * 
    */
   public $date_au;
   /**
    * indique si on affiche la liste des inscriptions aux formations
    * 
    */
   public $formation;
   
   /**
    * Affiche la liste de commandes
    * @return renvoie true si le tableau n'est pas vide
    */
   
   function afficherListeCommandes() {
   	 //requete sql
	 $fin_req="";
	 if ($this->numclient) $fin_req.=" AND numclient='$this->numclient'";
	 if ($this->erreur_paiement) $fin_req.=" AND erreur_paiement='$this->erreur_paiement'";
	 if ($this->type_reg) $fin_req.=" AND tpereg='$this->type_reg'";
	 if ($this->date_du && $this->date_au) $fin_req.=" AND hcrea BETWEEN $this->date_du AND $this->date_au";
	 else if ($this->date_du) $fin_req.=" AND hcrea >= $this->date_du";
	 else if ($this->date_au) $fin_req.=" AND hcrea <= $this->date_au";
	 
	 /*if ($this->formation) $result=mysql_query("SELECT if_bo_com.numcom FROM if_bo_com,if_bo_detail WHERE if_bo_com.numcom=if_bo_detail.numcom AND if_bo_detail.designation='Inscription formation' $fin_req ORDER BY hcrea DESC");
	 else $result=mysql_query("SELECT if_bo_com.numcom FROM if_bo_com,if_bo_detail WHERE etat $this->etat $fin_req AND if_bo_com.numcom=if_bo_detail.numcom ORDER BY hcrea DESC");*/
	 if ($this->formation) { $result=mysql_query("SELECT if_bo_com.numcom FROM if_bo_com,if_bo_detail WHERE if_bo_com.numcom=if_bo_detail.numcom AND if_bo_detail.designation='Inscription formation' $fin_req ORDER BY hcrea DESC");
	 } else {
	 	//$result=mysql_query("SELECT if_bo_com.numcom FROM if_bo_com,if_bo_detail WHERE etat $this->etat $fin_req AND if_bo_com.numcom=if_bo_detail.numcom ORDER BY hcrea DESC"); 
		$result=mysql_query("SELECT if_bo_com.numcom FROM if_bo_com WHERE etat $this->etat $fin_req ORDER BY hcrea DESC"); 
	} 
	// echo "SELECT numcom FROM if_bo_com WHERE etat $this->etat $fin_req ORDER BY hcrea DESC";
	 while ($row=mysql_fetch_row($result)) {
		$uneCommande=new Commande();
		$uneCommande->numcom=$row[0];
		$uneCommande->infosCommande();
		$this->commandes[]=$uneCommande;
	 }
	 if (count($this->commandes)>=1) return true;
   }
   
   function getIterator() {
   	  $iterator=new ListesIterator($this->commandes);
	  return $iterator;
   }

}

?>
