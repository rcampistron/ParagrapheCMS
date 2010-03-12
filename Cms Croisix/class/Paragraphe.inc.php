<?php 

/**
 * @author Anne
 * @class Paragraphe Paragraphe.inc.php
 * @date 19/11/2008 *  
 * @brief G&egrave;re le traitement des paragraphes
 * @par Utilisation  * 
 * @details Classe Paragraphe : cr&eacute;ation, modification, suppression d'un Paragraphe
 * @par notes
 */

class Paragraphe {
	
	
	/**
	 *  @brief Num&eacute;ro du paragraphe
	 *  
	 *  On assigne un num&eacute;ro de paragrahe.
	 *  
	 */
	public $numpara;
	/**
	 * Titre du paragraphe 
	 */
	public $titrePara;
	/**
	 * Contenu du paragraphe 
	 */
	public $contenuPara;
	/**
	 * indique dans quelle colonne le paragraphe s'affiche
	 */
	public $colonnePara;
	/**
	 * 
	 * la liste  ( &agrave; voir) 
	 */
	public $listePara;
	/**
	 * 
	 * Ordre dans lequel le paragraphe est affich&eacute;
	 */
	public $ordrePara;
	/**
	 * 
	 * type de titre : h1 ou h2
	 */
	public $typeTitre;
	
	/**
	 * 
	 * num&eacute;ro de page
	 */
	public $numpage;
	/**
	 * 
	 *  moteur de recherche du site public
	 */
	public $recherche;
	
	/**
	 * 
	 * langue pour le moteur de recherche
	 */
	public $lg;
	
	
	/** 
	 * 
	 * num&eacute;ro du lien 
	 */
	public $numlien;
	/**
	 * 
	 *  
	 */
	public $libLien;
	/**
	 * 
	 * 
	 */
	public $texteLien;
	/**
	 * 
	 * 
	 */
	public $urlLien;
	/**
	 * 
	 * 
	 */
	public $ordreLien;
	
	// variables pour les photos
	/**
	 * 
	 * 
	 */
	public $numphoto;
	/**
	 * 
	 * 
	 */
	public $numparaphoto;
	/**
	 * 
	 * 
	 */
	public $ordrePhoto;
	/**
	 * 
	 * 
	 */
	public $legPhoto;
	/**
	 * 
	 * 
	 */
	// variables pour les vidéos
	public $numvideo;
	/**
	 * 
	 * 
	 */
	public $numparavideo;
	/**
	 * 
	 * 
	 */
	public $ordreVideo;
	/**
	 * 
	 * 
	 */
	public $legVideo;
	/**
	 * 
	 * 
	 */
	// variables pour les fichiers
	public $numfichier;
	/**
	 * 
	 * 
	 */
	public $numparafichier;
	/**
	 * 
	 * 
	 */
	public $ordreFichier;
	/**
	 * 
	 * 
	 */
	public $libFichier;
	
	/**
	 * Cette fonction rentre les donn&eacute;es dans la bdd
	 * @return Int Retourne L'id du paragraphe qui vient d'&ecirc;tre ins&eacute;r&eacute;
	 */
	function creerParagraphe() {
	    mysql_query("INSERT INTO if_paragraphe (titre,contenu) VALUES ('$this->titrePara','$this->contenuPara')");
		$this->numpara=mysql_insert_id();
		return $this->numpara;
	}
	/**
	 * Change le titre, le contenu du paragraphe selon l'id
	 */
	function modifierParagraphe() {
		mysql_query("UPDATE if_paragraphe SET titre='$this->titrePara', contenu='$this->contenuPara' WHERE numpara='$this->numpara'");
	}
	/**
	 * Supprime un paragraphe, ainsi que la photo et les liens
	 */
	function supprimerParagraphe() {
		mysql_query("DELETE FROM if_paragraphe WHERE numpara='$this->numpara'");
		mysql_query("DELETE FROM if_liens WHERE numpara='$this->numpara'");
		mysql_query("DELETE FROM if_para_photo WHERE numpara='$this->numpara'");
	}
	/**
	 * insertion dans la table d'association paragraphe-fichier 
	 */
	function associerFichier() {
	    mysql_query("INSERT INTO if_para_fichier (numpara,numfichier,libelle,ordre) 
		VALUES ('$this->numpara','$this->numfichier','$this->libFichier','$this->ordreFichier')"); 
	}
	/**
	 * Change l'entete du fichier, son id et son ordre
	 */
	function modifierFichier() {
	    mysql_query("UPDATE if_para_fichier SET numfichier='$this->numfichier', libelle='$this->libFichier', ordre='$this->ordreFichier' WHERE numparafichier='$this->numparafichier'"); 
	}
	/**
	 * suppression dans la table d'association paragraphe-fichier
	 */
	function enleverFichier() {
	   	 
	   mysql_query("DELETE FROM if_para_fichier WHERE numparafichier='$this->numparafichier'");
	}
	/**
	 * insertion dans la table d'association paragraphe-photo
	 */
	
	function associerPhoto() {	   
	   mysql_query("INSERT INTO if_para_photo (numpara,numphoto,ordre,legende) 
		VALUES ('$this->numpara','$this->numphoto','$this->ordrePhoto','$this->legPhoto')"); 
	}
	/**
	 * Modifie les propri&eacute;t&eacute;s d'une photo, change l'id, la l&eacute;gende, l'ordre 
	 */
	function modifierPhoto() {
	    mysql_query("UPDATE if_para_photo SET numphoto='$this->numphoto', legende='$this->legPhoto', ordre='$this->ordrePhoto' WHERE numparaphoto='$this->numparaphoto'"); 
	}
	/**
	 *  suppression dans la table d'association paragraphe-image
	 */
	
	function enleverPhoto() {
	  
	   mysql_query("DELETE FROM if_para_photo WHERE numparaphoto='$this->numparaphoto'");
	   //$result=mysql_query("SELECT numparaphoto FROM if_para_photo WHERE numphoto='$this->numphoto' AND numparaphoto!='$this->numparaphoto'");
	   $numparaphoto=SelectSimple("numparaphoto","if_para_photo","numphoto",$this->numphoto,"AND numparaphoto!='$this->numparaphoto'");
	   if (!$numparaphoto) {
	   	$supPhoto=new Photo();
		$supPhoto->numphoto=$this->numphoto;
		$supPhoto->modif="o";
		$supPhoto->supprimerPhoto();
	   }
	   
	}
	/**
	 * insertion dans la table d'association paragraphe-vid&eacute;o
	 */
	function associerVideo() {	   	
	   mysql_query("INSERT INTO if_para_video (numpara,numvideo,ordre,legende) 
		VALUES ('$this->numpara','$this->numvideo','$this->ordreVideo','$this->legVideo')"); 
	}
	
	function modifierVideo() {
	    mysql_query("UPDATE if_para_video SET numvideo='$this->numvideo', legende='$this->legVideo', ordre='$this->ordreVideo' WHERE numparavideo='$this->numparavideo'"); 
	}
	
	function enleverVideo() {
		//suppression dans la table d'association paragraphe-video 
		mysql_query("DELETE FROM if_para_video WHERE numparavideo='$this->numparavideo'");
	}
	
	
	/**
	 * Moteur de recherche 
	 */
	
	function rechercherPara() {
	
		/***** Les titres des pages *******************/
		//$this->recherche=utf8_encode($this->recherche);
		$result=mysql_query("SELECT numpage,titre,alias FROM if_page WHERE titre LIKE '%".$this->recherche."%' AND publiee='o' AND lg='$this->lg'");
		//echo "SELECT numpage,titre,alias FROM if_page WHERE titre LIKE '%".utf8_encode($this->recherche)."%' AND publiee='o'";
		while ($row=mysql_fetch_row($result)) {
			$point1="";
			$point2="";
			//on ne stocke que le mot entier trouvé - on ne stocke pas si c'est le morceau d'un mot
			$pos = stripos($row[1], $this->recherche); //stripos est insensible a la casse
			if ($pos!==false) {
				if ($pos===0) $afficher="oui"; // === important ici car strpos peut retourner 0 comme position, ce qui revient a !$pos
				else {
					$lettreavant=testerLettre(substr($row[1],($pos-1),1));
					if (count($lettreavant)>0) $afficher="non"; else $afficher="oui";
				}
				
				if ($afficher=="oui") {
				
					if ($pos===0) {
						$chaine=Majuscules(substr($this->recherche,0,1)).substr($this->recherche,1,strlen($this->recherche));
						$titre=str_replace($chaine,"<strong>".$chaine."</strong>",$row[1]);
					} else $titre=str_replace($this->recherche,"<strong>".$this->recherche."</strong>",$row[1]);
					$resultat[$row[0]]=array("type"=>"page","titre"=>$titre,"lien"=>$row[2],"texte"=>"");
				}
			}	 
					
				 
		}
		
		/*********** Les titres des paragraphes *******************/
		$result=mysql_query("SELECT if_page.numpage,if_page.titre,alias,if_paragraphe.contenu,if_paragraphe.titre 
		FROM if_page,if_paragraphe,if_page_para WHERE if_paragraphe.numpara=if_page_para.numpara AND if_page_para.numpage=if_page.numpage AND if_paragraphe.titre LIKE '%".$this->recherche."%' AND if_page.publiee='o' AND if_page.lg='$this->lg'");
		while ($row=mysql_fetch_row($result)) {
			if (!is_array($resultat) || !in_array($row[0],$resultat)) {
				$point1="";
				$point2="";
				//on ne stocke que le mot entier trouvé - on ne stocke pas si c'est le morceau d'un mot
				$pos = stripos($row[4], $this->recherche); //stripos est insensible a la casse
				if ($pos!==false) {
					if ($pos===0) $afficher="oui"; // === important ici 
					else {
						$lettreavant=testerLettre(substr($row[4],($pos-1),1));
						if (count($lettreavant)>0) $afficher="non"; else $afficher="oui";
					}
				
					if ($afficher=="oui") {
						
						if ($pos<200) {$deb=0; $int=$pos;} else {$deb=$pos-200; $int=200; $point1="...";}
						if ((strlen($row[4])-$pos)>200) $point2="...";
						$extrait=substr($row[4],$deb,($pos-$deb+200+strlen($this->recherche)));
						$extrait=str_replace($this->recherche,"<strong>".stripslashes($this->recherche)."</strong>",$extrait);
						$resultat[$row[0]]=array("type"=>"page","titre"=>$row[1],"lien"=>$row[2],"texte"=>$point1.$extrait.$point2);
						 
					 }
				}
			}
		}
		
		/*********** Les contenus des paragraphes *******************/
		$result=mysql_query("SELECT if_page.numpage,if_page.titre,alias,if_paragraphe.contenu FROM if_page,if_paragraphe,if_page_para WHERE if_paragraphe.numpara=if_page_para.numpara AND if_page_para.numpage=if_page.numpage AND if_paragraphe.contenu LIKE '%".$this->recherche."%' AND if_page.publiee='o' AND if_page.lg='$this->lg'");
		//echo "SELECT if_page.numpage,if_page.titre,alias,if_paragraphe.contenu FROM if_page,if_paragraphe,if_page_para WHERE if_paragraphe.numpara=if_page_para.numpara AND if_page_para.numpage=if_page.numpage AND if_paragraphe.contenu LIKE '%".utf8_encode($this->recherche)."%' AND if_page.publiee='o'";
		while ($row=mysql_fetch_row($result)) {

			 if ((!is_array($resultat) || !in_array($row[0],$resultat)) && !ereg("<iframe",$row[3])) {
			 //on ne prend pas les pages contenant un paragraphe contenant iframe
				$point1="";
				$point2="";
				//on ne stocke que le mot entier trouvé - on ne stocke pas si c'est le morceau d'un mot
				$pos = stripos($row[3], $this->recherche); //stripos est insensible a la casse
				if ($pos!==false) {
					if ($pos===0) $afficher="oui"; // === important ici 
					else {
						$lettreavant=testerLettre(substr($row[3],($pos-1),1));
						if (count($lettreavant)>0) $afficher="non"; else $afficher="oui";
					}
				
					if ($afficher=="oui") {
						if ($pos<200) {$deb=0; $int=$pos;} else {$deb=$pos-200; $int=200; $point1="...";}
						if ((strlen($row[1])-$pos)>200) $point2="...";
						$extrait=substr($row[3],$deb,($pos-$deb+200+strlen($this->recherche)));
						$extrait=str_replace($this->recherche,"<strong>".stripslashes($this->recherche)."</strong>",$extrait);
						$resultat[$row[0]]=array("type"=>"page","titre"=>$row[1],"lien"=>$row[2],"texte"=>$point1.$extrait.$point2);
					 
				 	}
				}
			}
		}
		

		/*********** Les titres des docs *******************/
		if ($this->lg=="fr") $result=mysql_query("SELECT numpara, titre, contenu,tarif,acces_res,keyw,auteur FROM if_v_doc WHERE titre LIKE '%".$this->recherche."%' AND publiee='o'");
		else if ($this->lg=="en") $result=mysql_query("SELECT numpara, titre_en, contenu_en,tarif,acces_res,keyw,auteur FROM if_v_doc WHERE titre_en LIKE '%".$this->recherche."%' AND publiee='o'");
		
		while ($row=mysql_fetch_row($result)) {
			if (!is_array($resultat) || !in_array("doc-".$row[0],$resultat)) {
				$point1="";
				$point2="";
				$pos=0;
				$pos = stripos($row[1], $this->recherche);
				
				if ($pos!==false) {
					if ($pos===0) $afficher="oui";
					else {
						$lettreavant=testerLettre(substr($row[1],($pos-1),1));
						if (count($lettreavant)>0) $afficher="non"; else $afficher="oui";
					}
				
					if ($afficher=="oui") { 
						$titre=str_replace($this->recherche,"<strong>".$this->recherche."</strong>",$row[1]);
						if (strlen($row[2])>200) $extrait=substr($row[2],0,200)."...";
						else $extrait=$row[2];
						$nom_fiche="";
						$fiche=new ListeFichiers();
						$fiche->numpara= $row[0]; 
						$fiche->afficherListeFichiers();
						foreach ($fiche as $fichiers) {
								$nom_fiche="ouverturepdf.php?file=".$fichiers->nomFichier;
								$poids_fiche=$fichiers->poidsFichier;
								break;	
						}
						$resultat["doc-".$row[0]]=array("type"=>"doc","titre"=>$titre,"lien"=>$nom_fiche,
						"texte"=>$extrait,"tarif"=>$row[3],"acces_res"=>$row[4],"numpara"=>$row[0],
						"keyw"=>$row[5],"auteurs"=>$row[6],"poids_fiche"=>$poids_fiche);
						 
					 }
				 }
			}
		}
		
		
		/*********** Les contenus des docs *******************/
		if ($this->lg=="fr") $result=mysql_query("SELECT numpara, titre, contenu,tarif,acces_res,keyw,auteur FROM if_v_doc WHERE contenu LIKE '%".$this->recherche."%' AND publiee='o'");
		else if ($this->lg=="en") $result=mysql_query("SELECT numpara, titre_en, contenu_en,tarif,acces_res,keyw,auteur FROM if_v_doc WHERE contenu_en LIKE '%".$this->recherche."%' AND publiee='o'");
		
		while ($row=mysql_fetch_row($result)) {
			 if (!is_array($resultat) || !in_array("doc-".$row[0],$resultat)) {
				$point1="";
				$point2="";
				$pos=0;
				$pos = stripos($row[2], $this->recherche);
				
				$lettreavant=testerLettre(substr($row[2],($pos-1),1));
				if (count($lettreavant)>0) $afficher="non"; else $afficher="oui";
				
				if ($afficher=="oui") { 
					if ($pos<200) {$deb=0; $int=$pos;} else {$deb=$pos-200; $int=200; $point1="...";}
					if ((strlen($row[2])-$pos)>200) $point2="...";
					$extrait=substr($row[2],$deb,($pos-$deb+200+strlen($this->recherche)));
					$extrait=str_replace($this->recherche,"<strong>".$this->recherche."</strong>",$extrait);
					$extrait=$point1.$extrait.$point2;
					 
					$nom_fiche="";
					$fiche=new ListeFichiers();
						$fiche->numpara= $row[0]; 
						$fiche->afficherListeFichiers();
						foreach ($fiche as $fichiers) {
							$nom_fiche="ouverturepdf.php?file=".$fichiers->nomFichier;
							$poids_fiche=$fichiers->poidsFichier;
							break;	
					}
					$resultat["doc-".$row[0]]=array("type"=>"doc","titre"=>$row[1],"lien"=>$nom_fiche,
					"texte"=>$extrait,"tarif"=>$row[3],"acces_res"=>$row[4],"numpara"=>$row[0],
					"keyw"=>$row[5],"auteurs"=>$row[6],"poids_fiche"=>$poids_fiche);
					 
				 }
			}
		}
		
		/*********** Les mots-cles des docs *******************/
		if ($this->lg=="fr") $result=mysql_query("SELECT numpara, titre, contenu,tarif,acces_res,keyw,auteur FROM if_v_doc WHERE keyw LIKE '%".$this->recherche."%' AND publiee='o'");
		else if ($this->lg=="en") $result=mysql_query("SELECT numpara, titre_en, contenu_en,tarif,acces_res,keyw,auteur FROM if_v_doc WHERE keyw LIKE '%".$this->recherche."%' AND publiee='o'");
		
		while ($row=mysql_fetch_row($result)) {
			 if (!is_array($resultat) || !in_array("doc-".$row[0],$resultat)) {
				$point1="";
				$point2="";
				$pos=0;
				$pos = stripos($row[5], $this->recherche);
				
				$lettreavant=testerLettre(substr($row[5],($pos-1),1));
				if (count($lettreavant)>0) $afficher="non"; else $afficher="oui";
				
				if ($afficher=="oui") {
					if (strlen($row[2])>200) $extrait=substr($row[2],0,200)."...";
					else $extrait=$row[2];
					$keyw=str_replace($this->recherche,"<strong>".$this->recherche."</strong>",$row[5]);
					 
					$nom_fiche="";
					$fiche=new ListeFichiers();
						$fiche->numpara= $row[0]; 
						$fiche->afficherListeFichiers();
						foreach ($fiche as $fichiers) {
							$nom_fiche="ouverturepdf.php?file=".$fichiers->nomFichier;
							$poids_fiche=$fichiers->poidsFichier;
							break;	
					}
					$resultat["doc-".$row[0]]=array("type"=>"doc","titre"=>$row[1],"lien"=>$nom_fiche,
					"texte"=>$extrait,"tarif"=>$row[3],"acces_res"=>$row[4],"numpara"=>$row[0],
					"keyw"=>$keyw,"auteurs"=>$row[6],"poids_fiche"=>$poids_fiche);
					 
				 }
			}
		}
		
		/*********** Les auteurs des docs *******************/
		if ($this->lg=="fr") $result=mysql_query("SELECT numpara, titre, contenu,tarif,acces_res,keyw,auteur FROM if_v_doc WHERE auteur LIKE '%".$this->recherche."%' AND publiee='o'");
		else if ($this->lg=="en") $result=mysql_query("SELECT numpara, titre_en, contenu_en,tarif,acces_res,keyw,auteur FROM if_v_doc WHERE auteur LIKE '%".$this->recherche."%' AND publiee='o'");
		
		while ($row=mysql_fetch_row($result)) {
			 if (!is_array($resultat) || !in_array("doc-".$row[0],$resultat)) {
				$point1="";
				$point2="";
				$pos=0;
				$pos = stripos($row[6], $this->recherche);
				
				$lettreavant=testerLettre(substr($row[6],($pos-1),1));
				if (count($lettreavant)>0) $afficher="non"; else $afficher="oui";
				
				if ($afficher=="oui") {
					if (strlen($row[2])>200) $extrait=substr($row[2],0,200)."...";
					else $extrait=$row[2];
					$auteurs=str_replace($this->recherche,"<strong>".$this->recherche."</strong>",$row[6]);
					 
					$nom_fiche="";
					$fiche=new ListeFichiers();
						$fiche->numpara= $row[0]; 
						$fiche->afficherListeFichiers();
						foreach ($fiche as $fichiers) {
							$nom_fiche="ouverturepdf.php?file=".$fichiers->nomFichier;
							$poids_fiche=$fichiers->poidsFichier;
							break;	
					}
					$resultat["doc-".$row[0]]=array("type"=>"doc","titre"=>$row[1],"lien"=>$nom_fiche,
					"texte"=>$extrait,"tarif"=>$row[3],"acces_res"=>$row[4],"numpara"=>$row[0],
					"keyw"=>$row[5],"auteurs"=>$auteurs,"poids_fiche"=>$poids_fiche);
					 
				 }
			}
		}
		
		return $resultat;
	}	
	
	function infosPara() {
		$row=SelectMultiple("if_paragraphe","numpara",$this->numpara);
		$this->titrePara=miseEnForme($row["titre"]);	
		$this->contenuPara=miseEnForme($row["contenu"]);
		$this->accueil=$row["accueil"];
		$row=SelectMultiple("if_page_para","numpara",$this->numpara,$fin_req=" AND numpage='$this->numpage'"); 
		$this->colonnePara=$row["colonne"];
		$this->ordrePara=$row["ordre"];
		$this->listePara=$row["liste"];
		$this->typeTitre=$row["type_titre"];
	}

}//fin de classe
?>
