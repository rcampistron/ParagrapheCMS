<?php /* Date de création:  */ 
/**
 * @date 19/11/2008
 * @class Menu Menu.inc.php
 * @brief création, modification, suppression d'un menu
 * @details Un menu peut etre de type "Rubrique", "Categorie", ou "Sous-categorie"
 * 
**/	


class Menu {
   /**
    * num(Id) du menu
    * 
    */
    public $nummenu;
    /**
     * nom du menu
     * 
     */
	public $nomMenu; 
	/**
	 * Ordre d'affiche du menu
	 * 
	 */
	public $ordre;	
	public $affiche;	
	/**
	 * est-ce une rubrique, une catégorie, ou une sous-catégorie?
	 * 
	 */
	public $type;
	/**
	 * zone d'affichage, zone 1, zone 2, ou zone 3   
	 * 
	 */
	public $zone;
	/**
	 * nom de la clé primaire
	 * 
	 */
	public $nomkey;  
	/**
	 * n° de la clé étrangère
	 * 
	 */
	public $numfkey;
	/**
	 * 
	 * 
	 */
   	public $url;
   	/**
   	 * 
   	 * 
   	 */
	public $numpage;
	/**
	 * page d'accueil (en et fr) pour les liens FR et EN (en rubrique dans l'admin du CMS)
	 * 
	 */
	public $accueilPage;
	/**
	 * langue de la page d'accueil pour les liens FR et EN (en rubrique dans l'admin du CMS)
	 * 
	 */
	public $lgPage;
	public $champ;
	public $valeur;
	/**
	 * langue
	 * 
	 */
	public $lg;
	/**
	 * les contacts associés
	 * 
	 */
	public $listcontact = array(); 
	/**
	 * les formations associées
	 * 
	 */
	public $listforma = array();
	/**
	 * les docs associées
	 * 
	 */
	public $listdoc = array();
	/**
	 * tableau des docs des categ (pour transmission &agrave; afficherDocsSousCateg)
	 * 
	 */
	public $listdocnumpara = array(); 
	/**
	 * spécifique IFIP pour ajouter une fin de requete (moteur de recherche formations-ifip.php)
	 * 
	 */
	public $tri_date;
					
/**
 * Cr&eacute;er le menu en l'ins&eacute;rant dans la bdd 
 * @see Menu#afficherMenu(); 
 */		
	function creerMenu() {
		if ($this->type=="rubrique") {
			mysql_query("INSERT INTO if_".$this->type." (nom,ordre,zone,lg) VALUES ('$this->nomMenu','$this->ordre','$this->zone','$this->lg')");
			$this->nomkey="numrub";
		} else if ($this->type=="categorie") {
			mysql_query("INSERT INTO if_".$this->type." (numrub,nom,ordre,zone,lg) VALUES ('$this->numfkey','$this->nomMenu','$this->ordre','$this->zone','$this->lg')");
			$this->nomkey="numcateg";
		} else if ($this->type=="sscateg") {
			mysql_query("INSERT INTO if_".$this->type." (numcateg,nom,ordre,lg) VALUES ('$this->numfkey','$this->nomMenu','$this->ordre','$this->lg')");
			$this->nomkey="numsscateg";
		}
		$this->nummenu=mysql_insert_id();
		$this->afficherMenu();	
	}
	
	function afficherMenu() {
	   mysql_query("UPDATE if_".$this->type." SET affiche='$this->affiche' WHERE $this->nomkey='$this->nummenu'");
	}
	/**
	 * Modifie les infos concernant le menu 
	 */
	function modifierMenu() {
	   if ($this->type=="rubrique") {
			$this->nomkey="numrub";
			mysql_query("UPDATE if_".$this->type." SET nom='$this->nomMenu',ordre='$this->ordre',zone='$this->zone',lg='$this->lg' WHERE $this->nomkey='$this->nummenu'");
		} else if ($this->type=="categorie") {
			$this->nomkey="numcateg";
			mysql_query("UPDATE if_".$this->type." SET numrub='$this->numfkey',nom='$this->nomMenu',ordre='$this->ordre',zone='$this->zone',lg='$this->lg' WHERE $this->nomkey='$this->nummenu'"); 
		} else if ($this->type=="sscateg") {
			$this->nomkey="numsscateg";
			mysql_query("UPDATE if_".$this->type." SET numcateg='$this->numfkey',nom='$this->nomMenu',ordre='$this->ordre',lg='$this->lg' WHERE $this->nomkey='$this->nummenu'");
		}
		$this->afficherMenu(); 
	}
	
	/**
	 * Supprime un menu
	 */
	function supprimerMenu() {
		 if ($this->type=="rubrique") {
			$this->nomkey="numrub";
			mysql_query("UPDATE if_categorie SET $this->nomkey='0' WHERE $this->nomkey='$this->nummenu'");
		} else if ($this->type=="categorie") {
			$this->nomkey="numcateg";
			mysql_query("UPDATE if_sscateg SET $this->nomkey='0' WHERE $this->nomkey='$this->nummenu'");
		} else if ($this->type=="sscateg") {
			$this->nomkey="numsscateg";
		}
		
		mysql_query("DELETE FROM if_".$this->type." WHERE $this->nomkey='$this->nummenu'");
	}
    
	/**
	 * R&eacute;cup&egrave;re les infos concernant le menu 
	 */
	function infosMenu() {
		$row=SelectMultiple("if_".$this->type,$this->nomkey,$this->nummenu);
		$this->nomMenu=$row["nom"];
		$this->ordre=$row["ordre"];	
		$this->zone=$row["zone"];	
		$this->affiche=$row["affiche"];
		$this->lg=$row["lg"];
		if ($this->type=="categorie") $this->numfkey=$row["numrub"]; else if ($this->type=="sscateg") $this->numfkey=$row["numcateg"];	
		if ($row["numpage"]) {
			$lapage=new Page();
			$lapage->numpage=$row["numpage"];
			$lapage->infosPage();
			$this->url=$lapage->aliasPage;
			$this->numpage=$lapage->numpage;
			$this->accueilPage=$lapage->accueilPage;
			$this->lgPage=$lapage->lg;
		} 
	}
	/**
	 * Affiche la rubrique
	 */
	function afficheRub() {
		$row=SelectSimple("numrub","if_rubrique","ordre","1"," AND zone='2'");
		$this->nummenu=$row[0];	
		
	}
	/**
	 * D&eacute;termine s'il s'agit d'un menu 
	 */
	function isMenu() {
	 	$row=SelectMultiple("if_".$this->type,$this->champ,$this->valeur);
		return $row;
	}
	/**
	 * associe un menu  une page = publication 
	 */
	function associerPage() {
		if ($this->type=="categorie") $this->nomkey="numcateg";	 else if ($this->type=="rubrique") $this->nomkey="numrub"; else  $this->nomkey="numsscateg";
		 mysql_query("UPDATE if_".$this->type."	SET numpage='$this->numpage' WHERE $this->nomkey='$this->nummenu'");   
	}
	
	
	
		/**
		 * Affiche les contacts
		 * @param $referent prend le nom du r&eacute;f&eacute;rent en parametre optionel 
		 */
	function afficherContacts($referent="") {
		if ($this->type=="categorie"){
			 if ($referent) $result=mysql_query("SELECT if_cont_categ.numcontact FROM if_cont_categ,if_contacts WHERE numcateg='$this->nummenu' AND if_cont_categ.numcontact=if_contacts.numcontact AND referent='o'");	 
			 else $result=mysql_query("SELECT numcontact FROM if_cont_categ WHERE numcateg='$this->nummenu'");	 
		} else if ($this->type=="sscateg") {
			if ($referent) $result=mysql_query("SELECT if_cont_sscateg.numcontact FROM if_cont_sscateg,if_contacts WHERE numsscateg='$this->nummenu' AND if_cont_sscateg.numcontact=if_contacts.numcontact AND referent='o'");	 
			else $result=mysql_query("SELECT numcontact FROM if_cont_sscateg WHERE numsscateg='$this->nummenu'");	
		}
		 
		while ($row=mysql_fetch_row($result)) {
			  $leContact=new Contact();
			  $leContact->numcontact=$row[0];  
			  $leContact->infosContact();
			  $this->listcontact[]=$leContact;
		} 
		//if (count($this->listcontact)>=1) return true;
		return count($this->listcontact);
	}
	/**
	 *  pour afficher dans le moteur de recherche d'un contact
	 */
	function afficherContactsSousCateg() { 
		$result=mysql_query("SELECT numsscateg FROM if_sscateg WHERE numcateg='$this->nummenu'");
		while ($row=mysql_fetch_row($result)) {
			$res=mysql_query("SELECT numcontact FROM if_cont_sscateg WHERE numsscateg='$row[0]'");
			while ($riw=mysql_fetch_row($res)) {
				  $tab_contact[]=$riw[0];
			}
		}
		$tab_contact_unique=array_unique($tab_contact);
		for ($i=0;$i<count($tab_contact_unique);$i++) {
				  $leContact=new Contact();
				  $leContact->numcontact=$tab_contact_unique[$i];  
				  $leContact->infosContact();
				  $this->listcontact[]=$leContact;
		}
		
		//tri multidimentionnel sur tableau d'objets (la fonction de reference est dans fonctions.php)
		usort($this->listcontact, 'trierContacts');
		
		
		
	}
	
	
	
	/** 
	 * Affiche les formations
	 */
	
	function afficherFormations() {
		if ($this->type=="categ") {
			$result=mysql_query("SELECT if_para_categ.numpara FROM if_para_categ, if_v_form WHERE numcateg='$this->nummenu' AND if_para_categ.numpara=if_v_form.numpara AND if_v_form.enligne='o' $this->tri_date");// Requ&ecirc;te pour afficher les formations liées aux categ et sous-categ dans le contenu associé &agrave; droite 	
		} else if ($this->type=="categorie") {
			if ($this->nummenu) 
				$result=mysql_query("SELECT if_para_categ.numpara FROM if_para_categ, if_categorie, if_v_form WHERE if_para_categ.numpara=if_v_form.numpara AND if_categorie.numcateg='$this->nummenu' AND  if_para_categ.numcateg=if_categorie.numcateg AND if_v_form.enligne='o' $this->tri_date ORDER BY date_deb");	// Requ&ecirc;te utilisée par le moteur de recherche formations-ifip.php (site public) 
			else 
				$result=mysql_query("SELECT if_para_categ.numpara FROM if_para_categ, if_v_form WHERE if_para_categ.numpara=if_v_form.numpara AND if_v_form.enligne='o' GROUP BY if_para_categ.numpara ORDER BY date_deb");	// Requ&ecirc;te utilisée par le moteur de recherche formations-ifip.php (site public) 
		} else if ($this->type=="sscateg") {
			$result=mysql_query("SELECT if_para_sscateg.numpara FROM if_para_sscateg, if_v_form WHERE numsscateg='$this->nummenu' AND if_para_sscateg.numpara=if_v_form.numpara AND if_v_form.enligne='o' $this->tri_date");// Requ&ecirc;te utilisée par le moteur de recherche formations-ifip.php (site public) 
		}	

		while ($row=mysql_fetch_row($result)) {
			  $laForma=new Formation();
			  $laForma->numpara=$row[0];  
			  $laForma->infosFormation();
			  $this->listforma[]=$laForma;
		} 
		if (count($this->listforma)>=1) return true;
	}
	/**
	 * Affiche les documentations
	 */
	function afficherDocs() {
		if ($this->type=="categ") { 
			// docs liées aux categ (pour les fiches actions) = que des docs avec pdf
			$result=mysql_query("SELECT if_para_categ.numpara FROM if_para_categ, if_v_doc, if_para_fichier 
			WHERE numcateg='$this->nummenu' AND if_para_categ.numpara=if_v_doc.numpara 
			AND if_para_fichier.numpara=if_v_doc.numpara AND publiee='o' $this->tri_date ORDER BY date DESC");
		
		} else if ($this->type=="categorie") {
			// Requ&ecirc;te utilisée par le moteur de recherche publications-ifip-institut-du-porc.php (site public) 
			$result=mysql_query("SELECT if_para_categ.numpara FROM if_para_categ, if_categorie, if_v_doc 
			WHERE if_para_categ.numpara=if_v_doc.numpara AND if_categorie.numcateg='$this->nummenu' 
			AND  if_para_categ.numcateg=if_categorie.numcateg AND publiee='o' $this->tri_date ORDER BY date DESC");	
		
		} else if ($this->type=="sscat") {
			// Requ&ecirc;te pour afficher les documentations liées uniquement aux ss-categ (pour les fiches actions)
			$result=mysql_query("SELECT if_para_sscateg.numpara FROM if_para_sscateg, if_v_doc, if_para_fichier 
			WHERE numsscateg='$this->nummenu' AND if_para_sscateg.numpara=if_v_doc.numpara AND publiee='o' 
			AND if_para_fichier.numpara=if_v_doc.numpara $this->tri_date ORDER BY date DESC");
		
		} else if ($this->type=="sscateg") {
			// Requ&ecirc;te utilisée par le moteur de recherche publications-ifip-institut-du-porc.php 
			$result=mysql_query("SELECT if_para_sscateg.numpara FROM if_para_sscateg, if_v_doc 
			WHERE numsscateg='$this->nummenu' AND if_para_sscateg.numpara=if_v_doc.numpara 
			AND publiee='o' $this->tri_date ORDER BY date DESC");
		}
		
//echo "SELECT if_para_sscateg.numpara FROM if_para_sscateg, if_v_doc, if_para_fichier WHERE numsscateg='$this->nummenu' AND if_para_sscateg.numpara=if_v_doc.numpara AND publiee='o' AND if_para_fichier.numpara=if_v_doc.numpara $this->tri_date ";
		while ($row=mysql_fetch_row($result)) {
			  $laDoc=new Documentation();
			  $laDoc->numpara=$row[0];  
			  $laDoc->infosDoc();
			  $this->listdoc[]=$laDoc;
			  $this->listdocnumpara[]=$row[0];
		} 
		
		//print_r($this->listdocnumpara);
		//tri multidimentionnel sur tableau d'objets (la fonction de reference est dans fonctions.php)
		//usort($this->listdoc, 'trierDocs'); Mise en commentaire HC sept. 2009 car on utilise a nouveau le vrai champ date
		return count($this->listdoc) ; // modifié Henriette
		
		
	}
	/**
	 * @brief permet d'aller chercher toutes les docs liées &agrave; une categ + sscateg dans le moteur
	 * @details on vide le tableau des Docs de la catégorie sélectionnée (créé par afficherDocs() )
	 * car il faut éviter un effet mémoire.
	 */
	function afficherDocsSousCateg() {
		$this->listdoc=array();
		
		// récupération du tableau des docs de la categ sélectionnée (les numpara)
		$tab_docs_categ=$this->listdocnumpara;
		$tab_docs_sscateg=array();
		
		$result=mysql_query("SELECT numsscateg FROM if_sscateg WHERE numcateg='$this->nummenu'");
		while ($row=mysql_fetch_row($result)) {
			$res=mysql_query("SELECT if_para_sscateg.numpara FROM if_para_sscateg, if_v_doc WHERE numsscateg='$row[0]' 
			AND if_para_sscateg.numpara=if_v_doc.numpara AND publiee='o' $this->tri_date ORDER BY date,numpara DESC");
			if (mysql_num_rows($res)>0) {
			  while ($riw=mysql_fetch_row($res)) {
				  $tab_docs_sscateg[]=$riw[0];
			  } 
			} // fin if
			
		} // fin while
		$tab_des_docs=array_merge($tab_docs_categ, $tab_docs_sscateg);
		sort($tab_des_docs);
		$tab_des_docs=array_unique($tab_des_docs);
		$tab_des_docs=array_values($tab_des_docs); // reindexation
		
		for ($i=0;$i<count($tab_des_docs);$i++) {
				  $laDoc=new Documentation();
				  $laDoc->numpara=$tab_des_docs[$i];
				  $laDoc->infosDoc();
				  $this->listdoc[]=$laDoc;
		}
		
		//tri multidimentionnel sur tableau d'objets (la fonction de reference est dans fonctions.php
		usort($this->listdoc, 'trierDocs'); //fonction modifiee sept. 2009 pour tri sur le champ date et non plus annee
		//print_r($this->listdoc);
		if (count($this->listdoc)>1) return true;
		
	}
}

?>
