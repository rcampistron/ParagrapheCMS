<?php

/**
 * @date 09/02/2009
 * @class Breve Breve.inc.php
 * @brief Spécifique IFIP
 * @details Cette classe hérite de la classe Paragraphe et donc de ses attributs et de ses méthodes.
 * Elle va g&eacute;rer les br&ecirc;ves, leurs cr&eacute;ations, leurs modifications et leurs supressions.
*/	


class Breve extends Paragraphe {
	
/**
 * Date de la brève formatée (d/m/y).
 * 
 */
	public $date_breve;
/**
 * Date de la brève non formatée (format mktime)
 * 
 */
	public $datebrut;
/**
 * n° du pays associé
 * 
 */

	public $numpays; 
	/**
	 *  nom du pays associé
	 * 
	 */
	public $nom_pays;
	/**
	 * source de la brève
	 * 
	 */
	public $source;
	/**
	 * Cr&eacute;er la br&egrave;ve en l'ins&egrave;rant dans la base
	 */
	function creerBreve() {	
		if ($this->date_breve) $date=formaterDate($this->date_breve); else $date=0;   	    
	    mysql_query("INSERT INTO if_breves (numpara,date,numpays,source) 
		VALUES ('$this->numpara','$date','$this->numpays','$this->source')");
		}
	
	/**
	 * Modifie la breve 
	 */
	function modifierBreve() {
		if ($this->date_breve) $date=formaterDate($this->date_breve); else $date=0;   	   
	    mysql_query("UPDATE if_breves SET date='$date',numpays='$this->numpays', source='$this->source' WHERE numpara='$this->numpara'");
		//mysql_query("DELETE FROM if_para_categ WHERE numpara='$this->numpara'");
	    //mysql_query("DELETE FROM if_para_sscateg WHERE numpara='$this->numpara'");
	}
	/**
	 * Supprime la br&egrave;ve 
	 */
	function supprimerBreve() {	
	   mysql_query("DELETE FROM if_paragraphe WHERE numpara='$this->numpara'");
	   mysql_query("DELETE FROM if_breves WHERE numpara='$this->numpara'");
	   if ($this->numparafichier) mysql_query("DELETE FROM if_para_fichier WHERE numparafichier='$this->numparafichier'");
	   
	} 
	/**
	 * Liste les dates de toutes les br&egrave;ves
	 */
	function listerDates() {
		$result=mysql_query("SELECT date FROM if_breves ORDER BY date DESC"); 
		while ($row=mysql_fetch_row($result)) {
			$dat=mktime(0,0,0,date("m",$row[0]),1,date("Y",$row[0]));
		    if ( !is_array($list_date) || (is_array($list_date) && !in_array($dat,$list_date)) ) $list_date[]=$dat;
		}
		return $list_date;
	}
	
	/* function afficherCateg() {
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
	}*/
	 /**
	  * Affiche les infos de la br&egrave;ve
	  */
	function infosBreve(){
		$row=SelectMultiple("if_v_breve","numpara",$this->numpara);
		$this->titrePara=miseEnForme($row["titre"]);	
		$this->contenuPara=miseEnForme($row["contenu"]);
		$this->date_breve=date("d/m/Y",$row["date"]);
		$this->datebrut=$row["date"];
		$this->numpays=$row["numpays"];
		$this->nom_pays=SelectSimple("pays","if_pays","numpays",$row["numpays"]);
		$this->source=$row["source"];
	} 

	
}
?>