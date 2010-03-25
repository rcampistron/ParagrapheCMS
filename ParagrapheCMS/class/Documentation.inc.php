<?php

/**
 * @date 19/01/2009
 * @class Documentation 
 * @brief Classe Documentation : sp&eacute;cifique IFIP
 * @details Cette classe hérite de la classe Paragraphe et donc de ses attributs et de ses méthodes
*/	


class Documentation extends Paragraphe {
	
	/**
	 * clé étrangère de la table if_type_doc
	 * 
	 */
	public $type_doc;
	/**
	 * Nom de type de documentation
	 * 
	 */
	public $nom_type_doc;
	/**
	 * nouveau type de doc
	 * 
	 */
	public $new_type_doc; 
	/**
	 *  titre en englais
	 * 
	 */
	public $titre_en;
	/**
	 * contenu en englais
	 * 
	 */
	public $contenu_en;
	/**
	 * Mots-clés
	 * 
	 */
	public $keyw; 
	/**
	 * Auteur de la documentation
	 * 
	 */
	public $auteur; 
	/**
	 * Date non format&eacute;e de la documentation
	 * 
	 */
	public $date_brute;
	/**
	 * Date au format dd/mm/YYYY
	 * 
	 */
	public $date;
	/**
	 * Date au format libre (provenant de la base IFIP)
	 * 
	 */
	public $date_libre; 
	/**
	 * Date pour trier les tableaux de résultats
	 * 
	 */
	public $anneeDoc; 
	/**
	 * Référence pour le panier
	 * 
	 */
	public $reference;
	/**
	 * Référence bibliographique
	 * 
	 */
	public $ref_biblio;
	/**
	 * Prix de la documentation
	 * 
	 */ 
	public $tarif;
	/**
	 * mot de passe pour ouvrir la doc 
	 * @deprecated n'est plus utilisée
	 * 
	 */
	public $pwd; 
	/**
	 * Poids utile uniquement pour les ouvrages de référence, sert à calculer les frais de port
	 * 
	 */
	public $poids;
	/**
	 * acces reservé aux professionnels - valeurs possibles "o" ou "n"
	 * 
	 */
	public $acces_res;
	/**
	 * Indique si la documentaton est publi&eacute;e ou non
	 * 
	 */
	public $publiee;
	/**
	 * @brief La documentation est &agrave; la une ou pas
	 * @details indique si une doc "Ouvrage de référence" est à la une dans la categ "Librairie" de "Documentation" - valeurs possibles "o" et "n"
	 * 
	 */
	public $une;
	public $listcateg = array();
	public $listsscateg = array(); 
	
	function creerDoc() {	
		if ($this->date) $date=formaterDate($this->date); else $date=0;  
	    mysql_query("INSERT INTO if_docs (numpara,type_doc,titre_en,contenu_en,auteur,ref_biblio,date,date_libre,reference,keyw,tarif,poids,pwd,acces_res,une,publiee) 
		VALUES ('$this->numpara','$this->type_doc','$this->titre_en','$this->contenu_en','$this->auteur','$this->ref_biblio','$date','$this->date_libre','$this->reference','$this->keyw','$this->tarif','$this->poids','$this->pwd','$this->acces_res','$this->une','$this->publiee')");
		
	}
	
	
	function modifierDoc() {
		if ($this->date) $date=formaterDate($this->date); else $date=0;   	   
	    mysql_query("UPDATE if_docs SET type_doc='$this->type_doc',titre_en='$this->titre_en',contenu_en='$this->contenu_en',auteur='$this->auteur', ref_biblio='$this->ref_biblio', date='$date', date_libre='$this->date_libre', reference='$this->reference', keyw='$this->keyw',tarif='$this->tarif', pwd='$this->pwd', poids='$this->poids', acces_res='$this->acces_res', une='$this->une', publiee='$this->publiee' WHERE numpara='$this->numpara'");
		mysql_query("DELETE FROM if_para_categ WHERE numpara='$this->numpara'");
	    mysql_query("DELETE FROM if_para_sscateg WHERE numpara='$this->numpara'");
	}
	
	function supprimerDoc() {	
	   mysql_query("DELETE FROM if_paragraphe WHERE numpara='$this->numpara'");
	   mysql_query("DELETE FROM if_docs WHERE numpara='$this->numpara'");
	   if ($this->numparafichier) mysql_query("DELETE FROM if_para_fichier WHERE numparafichier='$this->numparafichier'");
	   
	} 
	
	// Fonction qui ajoute un nouveau type de documentation
	function ajouterTypeDoc() {
		$max_num=SelectMax("type_doc","if_type_doc"); 
		$new_num_doc=$max_num+1;
		mysql_query("INSERT INTO if_type_doc (type_doc,nom) VALUES ('$new_num_doc','$this->new_type_doc')");
		return $new_num_doc;
	}
	
	function afficherCateg() {
		$result=mysql_query("SELECT numcateg FROM if_para_categ WHERE numpara='$this->numpara'");
		while ($row=mysql_fetch_row($result)) {
			  $laCateg=new Menu();
			  $laCateg->type="categorie";
			  $laCateg->nomkey="numcateg";
			  $laCateg->nummenu=$row[0];  
			  $laCateg->infosMenu();
			  $this->listcateg[]=$laCateg;
		} 
		if (count($this->listcateg)>=1) return true;
	}
	
	function afficherSscateg() {
		$result=mysql_query("SELECT numsscateg FROM if_para_sscateg WHERE numpara='$this->numpara'");
		while ($row=mysql_fetch_row($result)) {
			  $laSscateg=new Menu();
			  $laSscateg->type="sscateg";
			  $laSscateg->nomkey="numsscateg";
			  $laSscateg->nummenu=$row[0];  
			  $laSscateg->infosMenu();
			  $this->listsscateg[]=$laSscateg;
		} 
		if (count($this->listsscateg)>=1) return true;
	}
	
	function associerFormaCateg() {
		if (is_array($this->listcateg)) {
		   for ($i=0;$i<count($this->listcateg);$i++) {	 
		   		$categ=$this->listcateg[$i];
		   		mysql_query("INSERT INTO if_para_categ (numpara,numcateg) VALUES ('$this->numpara','$categ')");
		   }
		}
	}
	
	function associerFormaSscateg() {
		 if (is_array($this->listsscateg)) {
		   for ($i=0;$i<count($this->listsscateg);$i++) {
		   		$sscateg=$this->listsscateg[$i];
		   		mysql_query("INSERT INTO if_para_sscateg (numpara,numsscateg) VALUES ('$this->numpara','$sscateg')");
		   }
		}
	}
	 
	function infosDoc(){
		$row=SelectMultiple("if_v_doc","numpara",$this->numpara);
		$this->titrePara=miseEnForme($row["titre"]);	
		$this->contenuPara=miseEnForme($row["contenu"]);
		$this->type_doc=$row["type_doc"];
		$this->nom_type_doc=SelectSimple("nom","if_type_doc","type_doc",$row["type_doc"]);
		$this->titre_en=miseEnForme($row["titre_en"]);
		$this->contenu_en=miseEnForme($row["contenu_en"]);
		$this->auteur=$row["auteur"];
		$this->ref_biblio=$row["ref_biblio"];
		if ($row["date"]) {
			$this->date=date("d/m/Y",$row["date"]);
			$this->date_brute=$row["date"];
		}
		$this->date_libre=$row["date_libre"];
		//annee fabriquee a la volee
		if ($row["date_libre"]) $this->anneeDoc=substr($row["date_libre"],0,4);
		else if ($row["date"]) $this->anneeDoc=date("Y",$row["date"]);
		$this->reference=$row["reference"];
		$this->keyw=$row["keyw"];
		$this->tarif=$row["tarif"];
		$this->poids=$row["poids"];
		$this->pwd=$row["pwd"];
		$this->acces_res=$row["acces_res"];
		$this->une=$row["une"];
		$this->publiee=$row["publiee"];
	}
	
	function infosDocVersionCourte(){
		$result=mysql_query("SELECT date_libre,date FROM if_v_doc WHERE numpara='".$this->numpara."'");
		$row=mysql_fetch_array($result);
		//$row=SelectMultiple("if_v_doc","numpara",$this->numpara);
		if ($row["date_libre"]) $this->anneeDoc=substr($row["date_libre"],0,4);
		else if ($row["date"]) $this->anneeDoc=date("Y",$row["date"]);
		if ($row["date"]) $this->date_brute=$row["date"];
	}

	
}//fin de la classe documentation
?>