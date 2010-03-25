<?php 
/**
 * @date 19/12/2008
 * @class Formation
 * @brief s&eacute;pcifique IFIP
 * @details Cette classe hérite de la classe Paragraphe et donc de ses attributs et de ses méthodes
**/	


class Formation extends Paragraphe {
	/**
	 * date formatée pour le site public
	 * 
	 */
	public $datedeb;
	/**
	 * date formatée pour le site public
	 * 
	 */
	public $datefin;
	/**
	 * date formatée pour l'admin CMS en modification
	 * 
	 */
	public $datedeb_admin;
	/**
	 * date formatée pour l'admin CMS en modification
	 * 
	 */
	public $datefin_admin;
	/**
	 * indique si la formation est en ligne - valeurs possibles "o" et "n"
	 * 
	 */
	public $enligne;
	/**
	 * indique si la formation est sur mesure ou pas (sur mesure = pas de dates)
	 * 
	 */
	public $surMesure;
	/**
	 * Liste les cat&eacute;gories 
	 * 
	 */
	public $listcateg = array();
	/**
	 * Liste les ss cat&eacute;gories
	 * 
	 */
	public $listsscateg = array();
	/**
	 * Pour l'inscription à une formation
	 * 
	 */
	public $numclient;
	/**
	 * Ins&egrave;re une formation dans la bdd
	 */
	
	function creerFormation() {	 
		if ($this->datedeb_admin) $datedeb_admin=formaterDate($this->datedeb_admin); else $datedeb_admin=0;  
		if ($this->datefin_admin) $datefin_admin=formaterDate($this->datefin_admin); else $datefin_admin=0;
	    mysql_query("INSERT INTO if_formations (numpara,sur_mesure,date_deb,date_fin,enligne) 
		VALUES ('$this->numpara','$this->surMesure','".$datedeb_admin."','".$datefin_admin."','$this->enligne')");		
	}
	
	/**
	 * Modifie une formation dans la base
	 */
	function modifierFormation() {	   
		if ($this->datedeb_admin) $datedeb_admin=formaterDate($this->datedeb_admin); else $datedeb_admin=0;  
		if ($this->datefin_admin) $datefin_admin=formaterDate($this->datefin_admin); else $datefin_admin=0;
	    mysql_query("UPDATE if_formations SET sur_mesure='$this->surMesure',date_deb='$datedeb_admin', date_fin='$datefin_admin', enligne='$this->enligne' WHERE numpara='$this->numpara'");
		mysql_query("DELETE FROM if_para_categ WHERE numpara='$this->numpara'");
	    mysql_query("DELETE FROM if_para_sscateg WHERE numpara='$this->numpara'");
	}
	/**
	 * Supprime une formation
	 */
	function supprimerFormation() {	
	   mysql_query("DELETE FROM if_paragraphe WHERE numpara='$this->numpara'");
	   mysql_query("DELETE FROM if_formations WHERE numpara='$this->numpara'");
	   mysql_query("DELETE FROM if_para_fichier WHERE numparafichier='$this->numparafichier'");
	   
	} 
	/**
	 * Affiche une cat&eacute;gories
	 */
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
	/**
	 * Affiche une ss cat&eacute;gorie
	 */
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
	/**
	 * Associer une formation &agrave; une cat&eacute;gorie
	 */
	function associerFormaCateg() {
		if (is_array($this->listcateg)) {
		   for ($i=0;$i<count($this->listcateg);$i++) {	 
		   		$categ=$this->listcateg[$i];
		   		mysql_query("INSERT INTO if_para_categ (numpara,numcateg) VALUES ('$this->numpara','$categ')");
		   }
		}
	}
	/**
	 * Associer une formation &agrave; une ss-cat&eacute;gorie
	 */
	function associerFormaSscateg() {
		 if (is_array($this->listsscateg)) {
		   for ($i=0;$i<count($this->listsscateg);$i++) {
		   		$sscateg=$this->listsscateg[$i];
		   		mysql_query("INSERT INTO if_para_sscateg (numpara,numsscateg) VALUES ('$this->numpara','$sscateg')");
		   }
		}
	}
	 /**
	  * R&eacute;cup&egrave;re les infos de la formation
	  */
	function infosFormation(){
		$row=SelectMultiple("if_v_form","numpara",$this->numpara);
		$this->titrePara=miseEnForme($row["titre"]);	
		$this->contenuPara=miseEnForme($row["contenu"]);
		if ($row["date_deb"]) $this->datedeb=iconv('ISO-8859-1', 'UTF-8',(strftime("%d %B %Y",$row["date_deb"])));
		if ($row["date_fin"]) $this->datefin=iconv('ISO-8859-1', 'UTF-8',(strftime("%d %B %Y",$row["date_fin"])));
		if ($row["date_deb"]) $this->datedeb_admin=date("d/m/Y",$row["date_deb"]);
		if ($row["date_fin"]) $this->datefin_admin=date("d/m/Y",$row["date_fin"]);
		$this->surMesure=$row["sur_mesure"];
		$this->enligne=$row["enligne"];
	} 
	/**
	 * Fonction qui envoie un mail à l'admin pour l'avertir d'une inscription à la formation
	 */
	
	function avertirAdmin() {
			if ($this->numclient) {
				$leClient=new Client();
				$leClient->numclient=$this->numclient;
				$leClient->infosClient();
				
				$corps.="Bonjour Catherine Verrecke,\n";
				$corps.= "Un client s'est inscrit une formation \"".$this->titrePara."\"\n";
				$corps.="----------------------------------------------\n";
				$corps.="FORMATION\n";
				$corps.="----------------------------------------------\n";
				$corps.="Intitulé : ".$this->titrePara."\n";
				$corps.="Date : ";
				if ($this->datefin) $corps.= " du ".$this->datedeb." au ".$this->datefin; else if ($this->datedeb && !$this->datefin) $corps.=" le ". $this->datedeb; else if ($this->surMesure=="o") $corps.= " sur mesure"; 
				
				$corps.="\n";
				$corps.="----------------------------------------------\n";
				$corps.="STAGIAIRE\n";
				$corps.="----------------------------------------------\n";
				$corps.=$leClient->nom." ".$leClient->prenom."\n";
				$corps.=$leClient->raison."\n";
				$corps.=$leClient->adr1."\n";
				$corps.=$leClient->adr2."\n";
				$corps.=$leClient->cp." ".$leClient->ville."\n";
				$corps.=utf8_encode(SelectSimple("pays","if_pays","numpays",$laLivraison["numpays_l"],""))."\n";
				$corps.="Tél. ".$leClient->tel."\n";
				$corps.="Fax. ".$leClient->fax."\n";
				
				$corps=nl2br(stripslashes($corps));
				
		
				$entete="Content-type: text/html; charset=UTF-8\nStatus: U\nReply-To: ".$leClient->email."\nFrom: ".$leClient->email;
				mail("catherine.vereecke@ifip.asso.fr","Inscription à la formation",$corps,$entete);
				mail("henriette.cuny@wanadoo.fr","Copie/Inscription à la formation",$corps,$entete);

			}
	}
	/**
	 * R&eacute;cup&egrave;re le nombre d'inscrit 
	 * @return le nombre d'inscrits 
	 */
	function nbInscrits() {
		$result=mysql_query("SELECT if_bo_detail.numpara FROM if_bo_detail, if_formations WHERE if_bo_detail.numpara='$this->numpara' AND if_bo_detail.numpara=if_formations.numpara AND sur_mesure='o' AND validee!='o' GROUP BY if_bo_detail.numcom");
		return mysql_numrows($result);
	}
	/**
	 * liste les inscrits
	 * @return renvoie un tableau contenant les infos des inscrits
	 */
	function listerInscrits() {
		$list_inscrits=array();
		
		$result=mysql_query("SELECT if_bo_detail.numcom FROM if_bo_detail, if_formations WHERE if_bo_detail.numpara='$this->numpara' AND if_bo_detail.numpara=if_formations.numpara AND sur_mesure='o' AND validee!='o' GROUP BY if_bo_detail.numcom");
		while ($row=mysql_fetch_row($result)) {
			// Recherche des articles
			$lePanier = new Panier();
			$lePanier->numcom=$row[0];
			$listeArt=$lePanier->listerArticlesForm();
			
			//Infos sur le client
			$inscrit = new Client();
			$inscrit->numclient=SelectSimple("numclient","if_bo_com","numcom",$row[0]);
			$inscrit->infosClient();
			
			$list_inscrits[]=array($inscrit,$listeArt);
		}
		
		return $list_inscrits;
	}
	/**
	 * Validation d'une formation 
	 * @param $url lien pour valider la formation
	 */
	function validerForma($url) {
		if ($this->datedeb_admin) $datedeb_admin=formaterDate($this->datedeb_admin); else $datedeb_admin=0;  
		if ($this->datefin_admin) $datefin_admin=formaterDate($this->datefin_admin); else $datefin_admin=0;
		//mysql_query("UPDATE if_formations SET sur_mesure='o', date_deb='$datedeb_admin', date_fin='$datefin_admin', validee='o' WHERE numpara='$this->numpara'");
		
		$this->infosFormation();
		
		//Envoi d'un mail à chaque inscrit
		$list_inscrits=$this->listerInscrits();
		for ($i=0; $i<count($list_inscrits);$i++) {
			$list_detail=$list_inscrits[$i];
			$leClient=$list_detail[0];
			$sesArticles=$list_detail[1];
			$sonDetail=$sesArticles[0];
			
			$corps= "Bonjour ".$leClient->prenom." ".$leClient->nom.",\n\nSuite à votre inscription à la formation \"".$this->titrePara."\", nous avons le plaisir de vous annoncer que celle-ci aura lieu";
			if ($datedeb_admin && $datefin_admin) $corps.=" du ".$this->datedeb_admin." au ".$this->datefin_admin;
			else if ($datedeb_admin) $corps.=" le ".$this->datedeb_admin;
			
			$corps.=".\n\nPour finaliser votre inscription, veuillez cliquer sur le lien suivant : \n\n";
			$corps.="http://".$url."/index.php?t6mpnh=".base64_encode("lien=".$sonDetail["numcom"]."&email=".$leClient->email."&pwd=".$leClient->pwd);
			$corps.="\n\nVous souhaitant bonne réception,\n\n";
			$corps.="----------------------\n";
			$corps.="www.ifip.asso.fr\n";
			$corps.="----------------------\n";
	
	        $entete="Content-type: text/plain; charset=UTF-8\nStatus: U\nReply-To: ifip@ifip.asso.fr\nFrom: www.ifip.asso.fr <ifip@ifip.asso.fr>";
			//mail($leClient->email,"Inscription à la formation \"".$this->titrePara."\"",$corps,$entete,"-f 'ifip@ifip.asso.fr'");
			mail($leClient->email,"Inscription à la formation \"".$this->titrePara."\"",$corps,$entete);		
		}
	}
	
}
?>
