<?php /* Date de cration: 19/11/2008 */ 
/**
Classe Paragraphe : cr&eacute;ation, modification, suppression d'un Paragraphe
**/	


class Paragraphe {
	
	// variables pour le paragraphe
	public $numpara;
	public $titrePara;
	public $contenuPara;
	public $colonnePara;
	public $listePara;
	public $ordrePara;
	public $typeTitre;//type de titre : h1 ou h2
	public $numpage;
	public $recherche;//moteur de recherche du site public
	public $lg;//langue pour le moteur de recherche
	
	// variables pour les liens
	public $numlien;
	public $libLien;
	public $texteLien;
	public $urlLien;
	public $ordreLien;
	
	// variables pour les photos
	public $numphoto;
	public $numparaphoto;
	public $ordrePhoto;
	public $legPhoto;
	
	// variables pour les vid&eacute;os
	public $numvideo;
	public $numparavideo;
	public $ordreVideo;
	public $legVideo;
	
	// variables pour les fichiers
	public $numfichier;
	public $numparafichier;
	public $ordreFichier;
	public $libFichier;
	
	function creerParagraphe() {
	    mysql_query("INSERT INTO if_paragraphe (titre,contenu) VALUES ('$this->titrePara','$this->contenuPara')");
		$this->numpara=mysql_insert_id();
		return $this->numpara;
	}
	
	function modifierParagraphe() {
		mysql_query("UPDATE if_paragraphe SET titre='$this->titrePara', contenu='$this->contenuPara' WHERE numpara='$this->numpara'");
	}
	
	function supprimerParagraphe() {
		mysql_query("DELETE FROM if_paragraphe WHERE numpara='$this->numpara'");
		mysql_query("DELETE FROM if_liens WHERE numpara='$this->numpara'");
		mysql_query("DELETE FROM if_para_photo WHERE numpara='$this->numpara'");
	}
	
	function associerFichier() {
	   //insertion dans la table d'association paragraphe-fichier 
	    mysql_query("INSERT INTO if_para_fichier (numpara,numfichier,libelle,ordre) 
		VALUES ('$this->numpara','$this->numfichier','$this->libFichier','$this->ordreFichier')"); 
	}
	
	function modifierFichier() {
	    mysql_query("UPDATE if_para_fichier SET numfichier='$this->numfichier', libelle='$this->libFichier', ordre='$this->ordreFichier' WHERE numparafichier='$this->numparafichier'"); 
	}
	
	function enleverFichier() {
	   //suppression dans la table d'association paragraphe-fichier	 
	   mysql_query("DELETE FROM if_para_fichier WHERE numparafichier='$this->numparafichier'");
	}
	
	function associerPhoto() {
	   //insertion dans la table d'association paragraphe-photo
	   mysql_query("INSERT INTO if_para_photo (numpara,numphoto,ordre,legende) 
		VALUES ('$this->numpara','$this->numphoto','$this->ordrePhoto','$this->legPhoto')"); 
	}
	
	function modifierPhoto() {
	    mysql_query("UPDATE if_para_photo SET numphoto='$this->numphoto', legende='$this->legPhoto', ordre='$this->ordrePhoto' WHERE numparaphoto='$this->numparaphoto'"); 
	}
	
	function enleverPhoto() {
	   //suppression dans la table d'association paragraphe-image 
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
	
	function associerVideo() {
	   //insertion dans la table d'association paragraphe-vido	
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
	
	function rechercherPara() {
	
		/***** Les titres des pages *******************/
		$result=mysql_query("SELECT numpage,titre,alias FROM if_page WHERE titre LIKE '%".utf8_encode($this->recherche)."%' AND publiee='o' AND lg='$this->lg'");
		//echo "SELECT numpage,titre,alias FROM if_page WHERE titre LIKE '%".utf8_encode($this->recherche)."%' AND publiee='o'";
		while ($row=mysql_fetch_row($result)) {
			 $point1="";
			 $point2="";
			 $pos = strpos($row[1], $this->recherche);
			// echo "numpppppppppppppppppppppppppp=".$pos ;
			 if ($pos) {
				 if ($pos<200) {$deb=0; $int=$pos;} else {$deb=$pos-200; $int=200; $point1="...";}
				 if ((strlen($row[1])-$pos)>200) $point2="...";
				 $extrait=substr($row[1],$deb,($pos-$deb+200+strlen($this->recherche)));
				 $extrait=str_replace($this->recherche,"<strong>".stripslashes($this->recherche)."</strong>",$extrait);
				 //$resultat[]=array("titre"=>$row[1],"lien"=>$row[2],"texte"=>$point1.$extrait.$point2);
				 $resultat[$row[0]]=array("type"=>"page","titre"=>$row[1],"lien"=>$row[2],"texte"=>"");
				 
			 }
		}
		
		/*********** Les titres des paragraphes *******************/
		$result=mysql_query("SELECT if_page.numpage,if_page.titre,alias,if_paragraphe.contenu FROM if_page,if_paragraphe,if_page_para WHERE if_paragraphe.numpara=if_page_para.numpara AND if_page_para.numpage=if_page.numpage AND if_paragraphe.titre LIKE '%".utf8_encode($this->recherche)."%' AND if_page.publiee='o' AND if_page.lg='$this->lg'");
		//echo "SELECT if_page.numpage,if_page.titre,alias,if_paragraphe.contenu FROM if_page,if_paragraphe,if_page_para WHERE if_paragraphe.numpara=if_page_para.numpara AND if_page_para.numpage=if_page.numpage AND if_paragraphe.contenu LIKE '%".utf8_encode($this->recherche)."%' AND if_page.publiee='o'";
		while ($row=mysql_fetch_row($result)) {
			 if (!is_array($resultat) || !in_array($row[0],$resultat)) {
				 $point1="";
				 $point2="";
				 $pos = strpos($row[3], $this->recherche);
				 if ($pos) {
					 if ($pos<200) {$deb=0; $int=$pos;} else {$deb=$pos-200; $int=200; $point1="...";}
					 if ((strlen($row[1])-$pos)>200) $point2="...";
					 $extrait=substr($row[3],$deb,($pos-$deb+200+strlen($this->recherche)));
					 $extrait=str_replace($this->recherche,"<strong>".stripslashes($this->recherche)."</strong>",$extrait);
					 $resultat[$row[0]]=array("type"=>"page","titre"=>$row[1],"lien"=>$row[2],"texte"=>$point1.$extrait.$point2);
					 
				 }
			}
		}
		
		/*********** Les contenus des paragraphes *******************/
		$result=mysql_query("SELECT if_page.numpage,if_page.titre,alias,if_paragraphe.contenu FROM if_page,if_paragraphe,if_page_para WHERE if_paragraphe.numpara=if_page_para.numpara AND if_page_para.numpage=if_page.numpage AND if_paragraphe.contenu LIKE '%".utf8_encode($this->recherche)."%' AND if_page.publiee='o' AND if_page.lg='$this->lg'");
		//echo "SELECT if_page.numpage,if_page.titre,alias,if_paragraphe.contenu FROM if_page,if_paragraphe,if_page_para WHERE if_paragraphe.numpara=if_page_para.numpara AND if_page_para.numpage=if_page.numpage AND if_paragraphe.contenu LIKE '%".utf8_encode($this->recherche)."%' AND if_page.publiee='o'";
		while ($row=mysql_fetch_row($result)) {
			 if (!is_array($resultat) || !in_array($row[0],$resultat)) {
				 $point1="";
				 $point2="";
				 $pos = strpos($row[3], $this->recherche);
				 if ($pos) {
					 if ($pos<200) {$deb=0; $int=$pos;} else {$deb=$pos-200; $int=200; $point1="...";}
					 if ((strlen($row[1])-$pos)>200) $point2="...";
					 $extrait=substr($row[3],$deb,($pos-$deb+200+strlen($this->recherche)));
					 $extrait=str_replace($this->recherche,"<strong>".stripslashes($this->recherche)."</strong>",$extrait);
					 $resultat[$row[0]]=array("type"=>"page","titre"=>$row[1],"lien"=>$row[2],"texte"=>$point1.$extrait.$point2);
					 
				 }
			}
		}
		
	
		/*********** Les titres des docs *******************/
		if ($this->lg=="fr") $result=mysql_query("SELECT numpara, titre, contenu,tarif,acces_res FROM if_v_doc WHERE titre LIKE '%".utf8_encode($this->recherche)."%' AND publiee='o'");
		else if ($this->lg=="en") $result=mysql_query("SELECT numpara, titre_en, contenu_en,tarif,acces_res FROM if_v_doc WHERE titre_en LIKE '%".utf8_encode($this->recherche)."%' AND publiee='o'");
		
		while ($row=mysql_fetch_row($result)) {
			if (!is_array($resultat) || !in_array("doc-".$row[0],$resultat)) {
				 $point1="";
				 $point2="";
				 $pos = strpos($row[1], $this->recherche);
				 if ($pos) {
					 if ($pos<200) {$deb=0; $int=$pos;} else {$deb=$pos-200; $int=200; $point1="...";}
					 if ((strlen($row[1])-$pos)>200) $point2="...";
					 $extrait=substr($row[1],$deb,($pos-$deb+200+strlen($this->recherche)));
					 $extrait=str_replace($this->recherche,"<strong>".stripslashes($this->recherche)."</strong>",$extrait);
					 
					 $nom_fiche="";
					 $fiche=new ListeFichiers();
						$fiche->numpara= $row[0]; 
						$fiche->afficherListeFichiers();
						foreach ($fiche as $fichiers) {
							$nom_fiche="fichiers/".$fichiers->nomFichier;
							break;	
						}
					 $resultat["doc-".$row[0]]=array("type"=>"doc","titre"=>$row[1],"lien"=>$nom_fiche,"texte"=>"","tarif"=>$row[3],"acces_res"=>$row[4]);
					 
				 }
			}
		}
		
		
		/*********** Les contenus des docs *******************/
		if ($this->lg=="fr") $result=mysql_query("SELECT numpara, titre, contenu,tarif,acces_res FROM if_v_doc WHERE contenu LIKE '%".utf8_encode($this->recherche)."%' AND publiee='o'");
		else if ($this->lg=="en") $result=mysql_query("SELECT numpara, titre_en, contenu_en,tarif,acces_res FROM if_v_doc WHERE contenu_en LIKE '%".utf8_encode($this->recherche)."%' AND publiee='o'");
		
		while ($row=mysql_fetch_row($result)) {
			 if (!is_array($resultat) || !in_array("doc-".$row[0],$resultat)) {
				 $point1="";
				 $point2="";
				 $pos = strpos($row[1], $this->recherche);
				 if ($pos) {
					 if ($pos<200) {$deb=0; $int=$pos;} else {$deb=$pos-200; $int=200; $point1="...";}
					 if ((strlen($row[1])-$pos)>200) $point2="...";
					 $extrait=substr($row[1],$deb,($pos-$deb+200+strlen($this->recherche)));
					 $extrait=str_replace($rechercher,"<strong>".stripslashes($this->recherche)."</strong>",$extrait);
					 
					  $nom_fiche="";
					 $fiche=new ListeFichiers();
						$fiche->numpara= $row[0]; 
						$fiche->afficherListeFichiers();
						foreach ($fiche as $fichiers) {
							$nom_fiche="fichiers/".$fichiers->nomFichier;
							break;	
						}
					 $resultat["doc-".$row[0]]=array("type"=>"doc","titre"=>$row[1],"lien"=>$nom_fiche,"texte"=>"","tarif"=>$row[3],"acces_res"=>$row[4]);
					 
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
