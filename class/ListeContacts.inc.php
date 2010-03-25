<?php 
/**
 * @date 19/11/2008
 * @class ListeContacts ListeContacts.inc.php
 * liste tous les contacts
**/

class ListeContacts implements IteratorAggregate {
/**
 * Tableau contenant les contacts 
 * 
 */
   public $contacts = array();
   /** 
    * num(id) de la cat&eacute;gorie
    * 
    */
   public $numcateg;
   /**
    * num(id) de la ss-cat&eacute;gorie
    * 
    */
   public $numsscateg;
   
    /**
    * Affiche la liste de contacts
    * @return renvoie true si le tableau des contacts n'est pas vide
    */
   
   function afficherListeContacts() {
   	 //requete sql
	 if ($this->numcateg) {
	 	 $result=mysql_query("SELECT numcontact FROM if_cont_categ WHERE numcateg='$this->numcateg'");
		 while ($row=mysql_fetch_row($result)) {
		   	$unContact=new Contact();
			$unContact->numcontact=$row[0];
			$unContact->infosContact();  
			$this->contacts[]=$unContact;
		 }
	 } else {
		 $result=mysql_query("SELECT numcontact FROM if_contacts ORDER BY nom");
		 while ($row=mysql_fetch_row($result)) {
		   	$unContact=new Contact();
			$unContact->numcontact=$row[0];
			$unContact->infosContact();  
			$this->contacts[]=$unContact;
		 }
	 }
	 if (count($this->contacts)>=1) return true;
   }
   
   function getIterator() {
   	  $iterator=new ListesIterator($this->contacts);
	  return $iterator;
   }

}
?>
