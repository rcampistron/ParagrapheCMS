<?php

/**
*  @class ListeLiens
*  @date 19/11/2008
*  liste tous les liens.
**/

class ListeLiens implements IteratorAggregate {
/**
 * Un tableau contenant la liste des liens 
 * 
 */
	public $liens = array();
	/**
	 * num(id) du paragraphe
	 * 
	 */
   	public $numpara;
   	/**
   	 * @brief indique qu'on est dans l'admin du CMS
   	 * @details  valeur possible = 1 valeur possible = 0
   	 * 
   	 */
	public $admin; 
	/**R&eacute;cup&egrave;re la valeur de chaque propri&eacute;t&eacute; via la base et les initialise  afin de pouvoir l'afficher plus tard
	 * @return true si le tableau n'est pas vide 
	 */
   function afficherListeLiens() {
   		 $result=mysql_query("SELECT * FROM if_liens WHERE numpara='$this->numpara' ORDER BY ordre");
		 while ($row=mysql_fetch_array($result)) {
		   	$unLien=new Lien();	
			$afficheLien=true;
			 
			if ($row["numpage"] && !$this->admin) {//Le lien est une page existante interne, on est dans le site public => on recherche si la page est publiée
				$laPage=new Page();
				$laPage->numpage=$row["numpage"];
				$laPage->infosPage();
				if ($laPage->publiePage=='n') $afficheLien=false;
			} 
			
			if ($afficheLien) {
				$unLien->numlien=$row["numlien"];
				$unLien->libLien=$row["libelle"];
				$unLien->texteLien=miseEnForme($row["texte"]);
				$unLien->urlLien=$row["url"];
				$unLien->ordreLien=$row["ordre"];
				$unLien->fenLien=$row["fenetre"];
				$this->liens[]=$unLien;
			 }
	    }	
		if (count($this->liens)>=1) return true; 
   }
   
   function getIterator() {
   	  $iterator=new ListesIterator($this->liens);
	  return $iterator;
   }

}
?>
