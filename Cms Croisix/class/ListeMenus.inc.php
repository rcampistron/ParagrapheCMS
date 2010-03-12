<?php /* Date de creation:  */ 

/**
 * @class ListeMenus ListeMenus.inc.php
 * @date 19/11/2008
 * Classe ListeMenus : liste tous les menus de type "Rubrique", "Categorie", "Sous-categorie".
**/


class ListeMenus implements IteratorAggregate {
/**
 * Un tableau contenant les menus
 * 
 */
   public $menus = array();
   /**
    * type de menu 
    * 
    */
   public $type;
   /**
    * zone d'affichage d'un menu
    * 
    */
   public $zone;
   /**
    * nom de la cle primaire
    * 
    */
   public $nomkey;
   /**
    * numero de la cle etrangere 
    * 
    */  
   public $numfkey;
   /**
    * indique si on doit lister les menus affiches ou tous les menus
    * 
    */
   public $affiche;
   /**
    * langue
    * 
    */
   public $lg;
   /**
    * tri des menus (par ordre, par nom, ...)
    * 
    */
   public $ordre_req;
   /**
    * les menus amont
    * 
    */
   public $amont;
   /**
    * les menus aval
    * 
    */
   public $aval; 
   /**
    * Afficher la liste des menus
    * @return true si le tableau n'est pas vide 
    */
   
   function afficherListeMenus() {
   	 //requete sql dans table rubrique, categorie, souscateg suivant le type
	 if ($this->zone) {
	 	$fin_req=" WHERE zone='$this->zone' AND affiche='o'";  
		if ($this->numfkey) {
		  if ($this->type=="categorie") $fin_req.="	AND numrub='$this->numfkey'";
		  else if ($this->type=="sscateg") $fin_req.="	AND numcateg='$this->numfkey'";
		}
	 } else {
	 	if ($this->numfkey) {
		  if ($this->type=="categorie") {
		  		$fin_req=" WHERE numrub='$this->numfkey' ";
				if($this->amont && $this->aval) $fin_req.=" ";
				else if($this->aval) $fin_req.=" AND aval='o'";
				else if($this->amont) $fin_req.=" AND amont='o'";
		  }
		  else if ($this->type=="sscateg") $fin_req=" WHERE numcateg='$this->numfkey'";	 
		  if ($this->affiche) $fin_req.=" AND affiche='o'";
		} else {
		  $fin_req="";
		}
		
	 }
	 
	 //if (!$this->lg) $this->lg="fr";
	 if ($fin_req && $this->lg) $fin_req.=" AND lg='$this->lg'"; else if ($this->lg) $fin_req.=" WHERE lg='$this->lg'"; 
	 
	 if (!$this->ordre_req) $this->ordre_req="ordre";
	  
	 //if ($this->type=="sscateg") $result=mysql_query("SELECT $this->nomkey FROM if_".$this->type." $fin_req");
	// else $result=mysql_query("SELECT $this->nomkey FROM if_".$this->type." $fin_req ORDER BY ordre"); 
	 $result=mysql_query("SELECT $this->nomkey FROM if_".$this->type." $fin_req ORDER BY $this->ordre_req"); 
	 while ($row=mysql_fetch_row($result)) {
	   	$unMenu=new Menu();	 
		$unMenu->type=$this->type; 
		$unMenu->zone=$this->zone; 
		$unMenu->nomkey=$this->nomkey; 
		$unMenu->nummenu=$row[0]; 
		$unMenu->infosMenu();
		$this->menus[]=$unMenu;
	 } 
	 if (count($this->menus)>=1) return true;
   }
 /**
  * Affiche les menus 
  * @return true si le tableau de menus n'est pas vide 
  */

   function afficherLesMenus() {
     if ($this->numfkey) {
		if ($this->type=="categorie") 
			$req.="SELECT numcateg FROM if_categorie,if_page WHERE if_categorie.numrub='$this->numfkey' 
			AND if_page.numpage=if_categorie.numpage AND if_page.publiee='o' AND if_categorie.zone='3' ";
		else if ($this->type=="sscateg") 
			$req.="SELECT numsscateg FROM if_sscateg,if_page WHERE numcateg='$this->numfkey' 
			AND if_page.numpage=if_sscateg.numpage AND if_page.publiee='o'";	 
		if ($this->affiche) $req.=" AND affiche='o'";
		$req.=" ORDER BY ordre";
	  } else {
		  $req="";
	  }
	  $result=mysql_query($req);
	  while ($row=mysql_fetch_row($result)) {
	   	$unMenu=new Menu();	 
		$unMenu->type=$this->type; 
		$unMenu->zone=$this->zone; 
		$unMenu->nomkey=$this->nomkey; 
		$unMenu->nummenu=$row[0]; 
		$unMenu->infosMenu();
		$this->menus[]=$unMenu;
	 } 
	 if (count($this->menus)>=1) return true;
   }
   
   function getIterator() {
   	  $iterator=new ListesIterator($this->menus);
	  return $iterator;
   }

}
?>
