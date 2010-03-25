<?php
/**
 *Classe Page : création, modification, suppression d'une Page
 *@file Page.inc.php
 *@author Anne
 *@date 19/11/2008
 */




class Page {
	/**
	 * Id de la page
	 */
	public $numpage;
	/**
	 * nom pour le r&eacute;f&eacute;rencement
	 */
	public $nomPageGoogle;
	/**
	 * titre de la page
	 */
	public $titrePage;
	/**
	 * Description de la page
	 */
	public $descrPage;
	/**
	 * Mots-cl&eacute;s de la page
	 */
	public $keywPage;
	/**
	 * Alias de la page
	 */
	public $aliasPage;
	/**
	 * heure de cr&eacute;ation de la page
	 */
	public $hcreaPage;
	/**
	 * heure de modification de la page
	 */
	public $hmodifPage;
	/**
	 *
	 */
	public $publiePage;
	/**
	 *  indique si c'est une page d'accueil d'une rubrique
	 */
	public $accueilPage;
	/**
	 *  @brief indique si c'est la page d'accueil du site
	 *  @details prends "o" ou "n" comme valeur
	 */
	public $accueilSite;
	/**
	 * Id de la photo dans la BDD
	 */
	public $numphoto;
	/**
	 *  utilisateur qui a créé la page
	 */
	public $id_c;
	/**
	 *  utilisateur qui a modifié la page
	 */
	public $id_m;
	/**
	 * auteur de la page (créée ou modifiée)
	 */
	public $auteur;
	/**
	 * n du paragraphe
	 */
	public $numpara;
	/**
	 * ordre du paragraphe dans la page
	 */
	public $ordre;
	/**
	 * colonne du paragraphe dans la page
	 */
	public $colonne;
	/**
	 * indique si le contenu du paragraphe	est de type liste ou normal
	 */
	public $liste;
	/**
	 * indique si le titre du paragraphe est de type h1 ou h2
	 */
	public $typeTitre;
	public $numrub;
	public $numcateg;
	public $numsscateg;
	public $list_numrub = array();
	public $list_numcateg  = array();
	public $list_numsscateg = array();
	/**
	 * pas de colonne
	 */
	public $C0;
	/**
	 * colonne	de gauche
	 */
	public $C1;
	/**
	 * colonne	de droite
	 */
	public $C2;
	/**
	 * contenu associé
	 */
	public $C3;
	/**
	 * contenu associé
	 */
	public $nomPhoto;
	/**
	 * nom du fichier spcifique IFIP (ex : formations-ifip.php)
	 */
	public $nomFichier;
	/**
	 * langue
	 */
	public $lg;

	/**
	 * insere les enregistrements li&egrave;s aux propri&eacute;t&eacute;s de la page dans la BDD
	 * @return renvoie l'id de la page
	 */
	function creerPage() {

		mysql_query("INSERT INTO if_page (nom,titre,description,keywords,alias,accueil,accueil_site, iduti_c,hcrea,numphoto,specifique,lg)
		VALUES ('$this->nomPageGoogle','$this->titrePage','$this->descrPage','$this->keywPage','$this->aliasPage','$this->accueilPage','$this->accueilSite','$this->id_c','".time()."','$this->numphoto','$this->nomFichier','$this->lg')");
		$this->numpage=mysql_insert_id();
		$this->publierPage();

		return $this->numpage;
	}
	/**
	 * v&eacute;rifie l'alias (&agrave; d&eacute;velopper)
	 * @return renvoie un Bool&eacute;en
	 */
	function verifierAlias() {
		if (!$this->numpage) $row=SelectSimple("numpage","if_page","alias",$this->aliasPage);
		else   $row=SelectSimple("numpage","if_page","alias",$this->aliasPage," AND numpage!='$this->numpage'");
		if (!$row[0]) return	true;
	}
	/**
	 * Permet de d&eacute;terminer si nous avons affaire &agrave; une page de type accueil
	 * @return int renvoie l'index associ&eacute; &agrave; la page
	 */
	function  rechercherAccueil() {
		$numpage=SelectSimple("numpage","if_page","accueil_site","o"," AND publiee='o' AND lg='$this->lg'");
		return $numpage;

	}
	/**
	 * Permet de r&eacute;cup&eacute;rer le num (id) de la page
	 * @return int renvoie l'index associ&eacute; &agrave; la page
	 */
	function  rechercherNumPage() {
		$numpage=SelectSimple("numpage","if_page","alias",$this->aliasPage);
		return $numpage;
		 
	}
	/**
	 * mise &agrave; jour des liens - recuperation de ancienAlias au cas ou numpage n'est pas renseign&eacute; dans if_liens
	 * @see Page#creerAlias()
	 */
	function publierPage() {
		if ($this->publiePage=="n") {
			$result=mysql_query("SELECT alias FROM if_page WHERE numpage='$this->numpage'");
			$row=mysql_fetch_row($result);
			$ancienAlias=$row[0];
			 
			$res=mysql_query("SELECT numlien FROM if_liens WHERE numpage='$this->numpage' OR url='$ancienAlias'");
			if (mysql_num_rows($res)>0) {
				while ($row=mysql_fetch_row($res)) {
					mysql_query("DELETE FROM if_liens WHERE numlien='$row[0]' ");
				}
			}
			mysql_query("UPDATE if_rubrique SET numpage=0 WHERE numpage='$this->numpage'");
			mysql_query("UPDATE if_categorie SET numpage=0 WHERE numpage='$this->numpage'");
			mysql_query("UPDATE if_sscateg SET numpage=0 WHERE numpage='$this->numpage'");
		}
		mysql_query("UPDATE if_page SET publiee='$this->publiePage' WHERE numpage='$this->numpage'");
		$this->creerAlias();
	}
	/**
	 * Va se charger de l'url rewriting, en &eacute;crivant dans le htaccess
	 */
	function creerAlias() {
		$fp = fopen($chem.".htaccess","w+");
		if (flock($fp, LOCK_EX)) { // pose un verrou exclusif
			fwrite($fp, "#--------------------------------------------------\n");
			fwrite($fp, "# Repertoire : racine\n");
			fwrite($fp, "#--------------------------------------------------\n");
			fwrite($fp, "\n");
			fwrite($fp, "# Le serveur doit suivre les liens symboliques :\n");
			fwrite($fp, "Options +FollowSymlinks\n");
			fwrite($fp, "\n");
			fwrite($fp, "# Activation du module de reecriture d'URL :\n");
			fwrite($fp, "RewriteEngine on\n");
			fwrite($fp, "\n");
			fwrite($fp, "#--------------------------------------------------\n");
			fwrite($fp, "# Regles de reecriture d'URL :\n");
			fwrite($fp, "#--------------------------------------------------\n");
			fwrite($fp, "\n");
			 
			$result=mysql_query("SELECT numpage,alias,specifique,accueil_site FROM if_page WHERE publiee='o'");
			while ($row=mysql_fetch_row($result)) {
				$menu_attache=false;// booléen pour traiter le cas de la page d'accueil liée à aucune rubrique, catég, sous-catég
				$res=mysql_query("SELECT if_categorie.numrub,if_categorie.numcateg,if_sscateg.numsscateg FROM if_categorie,if_sscateg WHERE if_sscateg.numpage='$row[0]' AND if_sscateg.numcateg=if_categorie.numcateg");
				while ($riw=mysql_fetch_row($res)) {
					if ($row[2]) fwrite($fp, "RewriteRule ^".$row[1]."$	index.php?numpage=".$row[0]."&spec=".$row[2]."&numrub=".$riw[0]."&numcateg=".$riw[1]."&numsscateg=".$riw[2]." [L]"."\n");
					else fwrite($fp, "RewriteRule ^".$row[1]."$	index.php?numpage=".$row[0]."&numrub=".$riw[0]."&numcateg=".$riw[1]."&numsscateg=".$riw[2]." [L]"."\n");
					$menu_attache=true;// indique que la page est liée à une sous-catég
				}
				$res=mysql_query("SELECT numrub,numcateg FROM if_categorie WHERE numpage='$row[0]'");
				while ($riw=mysql_fetch_row($res)) {
					if ($row[2]) fwrite($fp, "RewriteRule ^".$row[1]."$	index.php?numpage=".$row[0]."&spec=".$row[2]."&numrub=".$riw[0]."&numcateg=".$riw[1]." [L]"."\n");
					else fwrite($fp, "RewriteRule ^".$row[1]."$	index.php?numpage=".$row[0]."&numrub=".$riw[0]."&numcateg=".$riw[1]." [L]"."\n");
					$menu_attache=true;// indique que la page est liée à une catégorie
				}
				$res=mysql_query("SELECT numrub FROM if_rubrique WHERE numpage='$row[0]'");
				while ($riw=mysql_fetch_row($res)) {
					if ($row[2]=="home") $row[2]="includes/home&lg=fr"; else if ($row[2]=="home_en") $row[2]="includes/home_en&lg=en";
					if ($row[2]) fwrite($fp, "RewriteRule ^".$row[1]."$	index.php?numpage=".$row[0]."&spec=".$row[2]."&numrub=".$riw[0]." [L]"."\n");
					else fwrite($fp, "RewriteRule ^".$row[1]."$	index.php?numpage=".$row[0]."&numrub=".$riw[0]." [L]"."\n");
					$menu_attache=true;// indique que la page est liée à une rubrique
				}

				//cas de la page d'accueil qui n'est pas liée (RewriteRule ^$	/index.php?numpage=86&spec=home&numrub=13 [L])
				if ($row[3]=="o" && !$menu_attache) {
					if ($row[2]=="home") $row[2]="includes/home&lg=fr"; else if ($row[2]=="home_en") $row[2]="includes/home_en&lg=en";
					fwrite($fp, "RewriteRule ^".$row[1]."$	index.php?numpage=".$row[0]."&spec=".$row[2]." [L]"."\n");
						
				}

			} //fin du while ($row=mysql_fetch_row($result))

			// Si une categorie n'a pas de page associée, on recherche la page eventuelle de la sous-catgorie pour l'associer
			// à la categorie.
			$result=mysql_query("SELECT numpage,numcateg,numrub FROM if_categorie WHERE numpage='0'");
			while ($row=mysql_fetch_row($result)) {
				$res=mysql_query("SELECT if_sscateg.numpage,numsscateg,alias FROM if_sscateg,if_page WHERE if_sscateg.numpage=if_page.numpage AND publiee='o' AND numcateg='$row[1]' ORDER BY if_sscateg.ordre");
				if (mysql_num_rows($res)>0) {
					$riw=mysql_fetch_row($res);
					if ($riw[0]) {
						fwrite($fp, "RewriteRule ^".$riw[2]."$	index.php?numpage=".$riw[0]."&numrub=".$row[2]."&numcateg=".$row[1]."&numsscateg=".$riw[1]." [L]"."\n");
						mysql_query("UPDATE if_categorie SET numpage='".$riw[0]."' WHERE numcateg='$row[1]'");
					}
				} // fin if (mysql_num_rows($res)>0)
			}//fin  while ($row=mysql_fetch_row($result))

			flock($fp, LOCK_UN); // lib&eacute;re le verrou
		}
		fclose($fp);
	}
	/**
	 * appeler cette methode en 1er :
	 * @see Page#supprimerPage()
	 * mise &agrave;� jour des liens - recup de ancienAlias au cas ou numpage n'est pas renseign&eacute; dans if_liens - ajout hc
	 */
	function modifierPage() {
		$this->publierPage();
		$result=mysql_query("SELECT alias FROM if_page WHERE numpage='$this->numpage'");
		$row=mysql_fetch_row($result);
		$ancienAlias=$row[0];

		$res=mysql_query("SELECT numlien FROM if_liens WHERE numpage='$this->numpage' OR url='$ancienAlias'");
		if (mysql_num_rows($res)>0) {
			while ($row=mysql_fetch_row($res)) {
				mysql_query("UPDATE if_liens SET url='$this->aliasPage' WHERE numlien='$row[0]' ");
			}
		}


		mysql_query("UPDATE if_page SET nom='$this->nomPageGoogle',titre='$this->titrePage', description='$this->descrPage', keywords='$this->keywPage',
	   alias='$this->aliasPage', accueil='$this->accueilPage', accueil_site='$this->accueilSite', iduti_m='$this->id_m', hmodif='".time()."',
	   numphoto='$this->numphoto',specifique='$this->nomFichier',lg='$this->lg' WHERE numpage='$this->numpage'");
		mysql_query("UPDATE if_rubrique SET numpage=0 WHERE numpage='$this->numpage'");
		mysql_query("UPDATE if_categorie SET numpage=0 WHERE numpage='$this->numpage'");
		mysql_query("UPDATE if_sscateg SET numpage=0 WHERE numpage='$this->numpage'");

	}
	/**
	 * Va supprimer la page
	 */
	function supprimerPage() {
		$this->publierPage(); // appeler cette methode en 1er afin de pouvoir mettre à jour les liens dans publierPage() //provient de l'appel direct à la méthode publierPage( ) dans index.php (if ($pg_admin=="lister-page")
		mysql_query("DELETE FROM if_page WHERE numpage='$this->numpage'");
		mysql_query("UPDATE if_rubrique SET numpage=0 WHERE numpage='$this->numpage'");
		mysql_query("UPDATE if_categorie SET numpage=0 WHERE numpage='$this->numpage'");
		mysql_query("UPDATE if_sscateg SET numpage=0 WHERE numpage='$this->numpage'");
		mysql_query("UPDATE if_page_para SET numpage=0 WHERE numpage='$this->numpage'");
		//suppression des liens (pas de tout le paragraphe) - ajout hc
		$result=mysql_query("SELECT alias FROM if_page WHERE numpage='$this->numpage'");
		$row=mysql_fetch_row($result);
		$aliasPageSupprimee=$row[0];
		$res=mysql_query("SELECT numlien FROM if_liens WHERE numpage='$this->numpage' OR url='$aliasPageSupprimee'");
		if (mysql_num_rows($res)>0) {
			while ($row=mysql_fetch_row($res)) {
				mysql_query("DELETE FROM if_liens WHERE numlien='$row[0]' ");
			}
		}


	}

	/**
	 * Rajoute un paragraphe &agrave; la page
	 */

	function ajouterParagraphe() {
		mysql_query("INSERT INTO if_page_para (numpage,numpara,ordre,colonne,liste,type_titre) VALUES ('$this->numpage','$this->numpara','$this->ordre','$this->colonne','$this->liste','$this->typeTitre')");
		mysql_query("UPDATE if_page SET iduti_m='$this->id_m', hmodif='".time()."' WHERE numpage='$this->numpage'");
	}
	/**
	 * Enl&egrave;ve un paragraphe &agrave; la page
	 */

	function enleverParagraphe() {
		mysql_query("DELETE FROM if_page_para WHERE numpage='$this->numpage' AND numpara='$this->numpara'");
		mysql_query("UPDATE if_page SET iduti_m='$this->id_m', hmodif='".time()."' WHERE numpage='$this->numpage'");
	}
	/**
	 * Modifie un paragraphe
	 */

	function modifierParagraphe() {
		mysql_query("UPDATE if_page_para SET ordre='$this->ordre', colonne='$this->colonne', liste='$this->liste', type_titre='$this->typeTitre' WHERE numpage='$this->numpage' AND numpara='$this->numpara'");
		mysql_query("UPDATE if_page SET iduti_m='$this->id_m', hmodif='".time()."' WHERE numpage='$this->numpage'");
		 
	}
	/**
	 * Enl&egrave;ve une photo associ&eacute; &agrave; un paragraphe
	 */
	function enleverPhoto() {
		mysql_query("UPDATE if_page SET numphoto='0' WHERE numpage='$this->numpage'");
	}

	/**
	 *  Recherche le num&eacute;ro de la page sp&eacute;cifique
	 *  @param $nom_fichier prend en argument le nom de fichier associ&eacute;
	 *  @see Page#infosPage()
	 */
	function pageSpecifique($nom_fichier) {
		$nump=SelectSimple("numpage","if_page","specifique",$nom_fichier);
		$this->numpage=$nump;
		$this->infosPage();
	}
	/**
	 * Va r&eacute;p&eacute;rer toutes les infos concernant la page.
	 * Va remplir toutes les propriétés de l'objet page pas leur équivalent dans la Bdd.
	 */
	function infosPage() {
		if ($this->numpage) {
			$row=SelectMultiple("if_page","numpage",$this->numpage);
		} else {
			$row=SelectMultiple("if_page","accueil_site","o","AND publiee='o' AND lg='$this->lg'");
			$this->numpage=$row["numpage"];
		}
		$this->lg=$row["lg"];
		$this->nomPageGoogle=$row["nom"];
		$this->titrePage=miseEnForme($row["titre"]);
		$this->descrPage=$row["description"];
		$this->keywPage=$row["keywords"];
		$this->aliasPage=$row["alias"];
		$this->hcreaPage=$row["hcrea"];
		$this->hmodifPage=$row["hmodif"];
		$this->publiePage=$row["publiee"];
		$this->accueilPage=$row["accueil"];
		$this->accueilSite=$row["accueil_site"];
		$this->id_c=$row["iduti_c"];
		$this->id_m=$row["iduti_m"];
		if ($row["iduti_m"]) $riw=SelectMultiple("if_utilisateur","iduti",$row["iduti_m"]);
		else  $riw=SelectMultiple("if_utilisateur","iduti",$row["iduti_c"]);
		$this->auteur=$riw["prenom"]." ".$riw["nom"];
		$this->nomFichier=$row["specifique"];

		//La bandeau photo de la page
		$laPhoto=new Photo();
		$laPhoto->numphoto=$row["numphoto"];
		$laPhoto->infosPhoto();
		$this->nomPhoto=$laPhoto->nomPhoto;

		//A quelles rubriques, catégories, et sous-catégories est liée la page ?
		$leMenu=new Menu();
		$leMenu->type="sscateg";
		$leMenu->champ="numpage";
		$leMenu->valeur=$this->numpage;
		$row=$leMenu->isMenu();

		$result=mysql_query("SELECT if_categorie.numrub,if_sscateg.numcateg,if_sscateg.numsscateg FROM if_categorie,if_sscateg WHERE if_sscateg.numpage='$this->numpage' AND if_sscateg.numcateg=if_categorie.numcateg");
		if (mysql_numrows($result)>0) {
			while ($row=mysql_fetch_row($result)) {
				$this->list_numsscateg[]=$row[2];
				$this->numsscateg=$row[2];
				$this->numcateg=$row[1];
				$this->numrub=$row[0];
			}
		}

		$result=mysql_query("SELECT numrub,numcateg FROM if_categorie WHERE numpage='$this->numpage'");
		if (mysql_numrows($result)>0) {
			while ($row=mysql_fetch_row($result)) {
				$this->list_numcateg[]=$row[1];
				if (!$this->numcateg) $this->numcateg=$row[1];
				if (!$this->numrub) $this->numrub=$row[0];
			}
		}
			
		$result=mysql_query("SELECT numrub FROM if_rubrique WHERE numpage='$this->numpage'");
		if (mysql_numrows($result)>0) {
			while ($row=mysql_fetch_row($result)) {
				$this->list_numrub[]=$row[0];
				if (!$this->numrub) $this->numrub=$row[0];
			}//fin du while
		} //fin du if
			
	}//fin function infosPage()

	function infosColonnes() {
		$result=mysql_query("SELECT	colonne FROM if_page_para WHERE numpage='$this->numpage' GROUP BY colonne");
		if (mysql_numrows($result)>0) {
			while ($row=mysql_fetch_row($result)) {
				if ($row[0]==0) $this->C0=true;
				else if ($row[0]==1) $this->C1=true;
				else if ($row[0]==2) $this->C2=true;
				else $this->C3=true;
			}
		} else {
			$this->C0=true;
		}
	}
}

?>
