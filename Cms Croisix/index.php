<?php
/**
 * @mainpage CMS CROISIX
 * @section Introduction 
 * 
 * Voici la documentation du CMS croisix 
 * 
 * @section utilisation 
 * 
 * 
 * 
 */

/**
 * 
 * Index: initialise le site
 * @author Anne
 * @package www
 * @date 19/11/2008 
 *
 *
 * On inclut le fichier cnnexion.php contenant les diff�rentes 
 * infos de connexions puis on d�marre la session
 */
include ("connexion.php");
session_start();


/**
 * On récupère le chemin serveur contenu dans la bdd
 */

$result=mysql_query("SELECT * FROM if_site");
$res_site=mysql_numrows($result);
$if_site=mysql_fetch_array($result);
$chem=$if_site["path"];	  //$chem="/home/web/croisix/ifip.croisix.com/www/";
/**
 * On inclut toutes les fonctions utiles et surtout on r�cup�re les variables POST et GET gr�ce � cet include
 */
include ("fonctions.php");

/**
 * Ici, l'utilisateur a voulu rentrer des variables GET non valides
 * on vide sa session et on le redirige vers l'accueil
 * @todo (un message de feedback serait intéressant)
 */
function unsetSession(){
	unset($_SESSION['numcom']); 
	unset($_SESSION['numclient']);
	unset($_SESSION['numprof']);
	header("Location:http://www.ifip.asso.fr");
}




function verifPage(String $typePage){


		
}
/**********************************************
Controle sur les variables
**********************************************/
/**
 * On vérifie s'il s'agit d'une page spécifique, c'est à dire si la 
 * page est une page unique.
 * Détermine si la variale globale de type GET $spec n'a pas été tapée directement dans l'adresse
 * On vérifie tout d'abord si la variable $spec n'est pas vide et qu'elle existe. Puis on vérifie si 
 * spec est diffèrent de toutes les pages spécifiques.
 * Si le contenu de spec ne corresponf a rien c'est qu'on a essayé de rentrer une variable factice dans la barre d'adresse
 */
if (
	isset($spec) && $spec && ($spec!="actualites-filiere-production-porc"  
 && $spec!="catalogue-ifip-institut-du-porc" && $spec!="compte-ifip" && $spec!="compte-ifip-profil" && $spec!="contact" 
 && $spec!="equipes-ifip" && $spec!="extranet-pro" && $spec!="formation-inscription" && $spec!="formations-ifip" 
 && $spec!="panier-ifip-institut-du-porc" && $spec!="publications-ifip-institut-du-porc" && $spec!="rechercher-ifip" 
 && $spec!="veille-economique-internationale-production-viande-porc" && $spec!="oublie" && $spec!="includes/home")
) {
 	$spec="";
	unsetSession();
}
/**
 * ici on applique le même raisonnement pour $pg_admin
 */
if (isset($pg_admin) && $pg_admin && ($pg_admin!="accueil" && $pg_admin!="admin-site" && $pg_admin!="ajouter-actu" 
&& $pg_admin!="ajouter-arti" 
 && $pg_admin!="ajouter-breve" && $pg_admin!="ajouter-contact" && $pg_admin!="ajouter-doc" 
 && $pg_admin!="ajouter-forma" && $pg_admin!="ajouter-menu" && $pg_admin!="ajouter-page" && $pg_admin!="ajouter-parag" 
 && $pg_admin!="ajouter-prof" && $pg_admin!="ajouter-uti" && $pg_admin!="content" 
 && $pg_admin!="lister-actu" && $pg_admin!="lister-arti" 
 && $pg_admin!="lister-breve" && $pg_admin!="lister-client" && $pg_admin!="lister-com" && $pg_admin!="lister-contact" 
 && $pg_admin!="lister-doc" && $pg_admin!="lister-formation" && $pg_admin!="lister-inscri" && $pg_admin!="lister-menu" 
 && $pg_admin!="lister-page" && $pg_admin!="lister-prof" && $pg_admin!="lister-uti" && $pg_admin!="modifier-client" 
 && $pg_admin!="modifier-com" && $pg_admin!="modifier-page" && $pg_admin!="modifier-parag"))
{
 	$pg_admin="";
	unsetSession();
}
/**
 * Toutes les variable GET sont vérifiées.
 * A savoir, si elles ne sont pas vides, et ont le typage adéquat. 
 *  
 */
if (
	(isset($numpage) && $numpage && !is_numeric($numpage)) || 
	(isset($numrub) && $numrub && !is_numeric($numrub)) || 
	(isset($numcateg) && $numcateg && !is_numeric($numcateg)) || 
	(isset($numsscateg) && $numsscateg && !is_numeric($numsscateg)) || 
	(isset($numpara) && $numpara && !is_numeric($numpara)) || 
	(isset($numdoc) && $numdoc && !is_numeric($numdoc)) || 
	(isset($numcontact) && $numcontact && !is_numeric($numcontact)) || 
	(isset($numpays) && $numpays && !is_numeric($numpays)) || 
	(isset($lg) && $lg && $lg!="fr" && $lg!="en") || 
	(isset($date_br) && $date_br && !is_numeric($date_br)) || 
	(isset($dom) && $dom && !is_numeric($dom)) || 
	(isset($ssdom) && $ssdom && !is_numeric($ssdom)) || 
	(isset($type) && $type && $type!="accespro" && $type!="infosformation" && $type!="rubrique" && $type!="categorie" 
	&& $type!="sscateg") || 
	(isset($decon) && $decon && $decon!='1') || 
	(isset($deconclient) && $deconclient && $deconclient!='o') ||
	(isset($deconpro) && $deconpro && $deconpro!='o') 
) {
		unsetSession();

}

include ("includes/classes.php");
/**
 * gestion de l'envoi des mails (il faut que ces fonctions soient directement
 * dans index.php si on veut utiliser les classes dans les fonctions)
 * */ 
include ("fonctions_mails.php"); 
/**
 * On teste si le login est bon.
 * Si la variable existe, on créé un nouvel objet utilisateur avec l'id passée en param comme id.
 * On voit si l'id renvoyée est un chiffre alors on procède à la vérification de session
 * @see Utilisateur.inc.php#Verif_Session()  
 */
if ($id) {
  $uti=new Utilisateur();
  $uti->id=$id;
  if(is_numeric($id)) {
  	$verifsession=$uti->Verif_Session($id,$cnx);  
  	if ($verifsession=='0') { //pas bon donc retour automatique
		header("Location: ../");
  	}
  } else {
		header("Location: ../");
  }
}
/* 
 * On vérifie si on est dans le moteur de recherche
 * 
 */
if ($moteur_rech || $rech_site_suite) {
	if ($rech_site_suite) $rech_site=$rech_site_suite ;
	if ($rech_site) {
		$parag=new Paragraphe();
		$parag->recherche=$rech_site;
		$parag->lg=$lg;
		$resultats=$parag->rechercherPara();
		//print_r($resultats);
		$spec="rechercher-ifip";
	}
	//Array ( [0] => Array ( [numpage] => 44 [titre] => Résultats des élevages de porcs [lien] => resultats-economiques-elevages-de-porc.html [texte] => ) [1] => Array ( [numpage] => 56 [titre] => Expertise Génétique des porcs [lien] => genetique-races-porcs.html [texte] => ) [2] => Array ( [numpage] => 91 [titre] => Alimentation post-sevrage et des porcs charcutiers [lien] => alimentation-porcs-post-sevrage-et-charcutiers.html [texte] => ) ) 
}
/**
 * Si on est identifié et que la variable pg_admin =ajouter page alors l'utilisateur 
 * veut ajouter une page. Avant d'ajouter la page on vérifie bien que le champ titre page google est rempli 
 * puis on procède à l'ajout.
 * 
 *  
 */
if ($id) {
/* ************* On ajoute une page
 * **************************************** */
if ($pg_admin=="ajouter-page") {
   if ($textNomG) {
   		$newPage=new Page();   
		$newPage->aliasPage=$textAlias.".html";
		if ($newPage->verifierAlias()) {
			$newPage->lg=$selectLg;  
			$newPage->nomPageGoogle=$textNomG;
			$newPage->titrePage=$textTitre;
	   		$newPage->descrPage=$textDescr;
			$newPage->keywPage=$textKeyw;
			$newPage->nomFichier=$textFichier;
			$newPage->id_c=$id;
			$newPage->accueilPage=$radioAccueil;
			$newPage->accueilSite=$radioAccueilSite;  
			if ($selectPhoto) {
			  $newPage->numphoto=$selectPhoto;
			} else if (isset($_FILES["filePhoto"]['tmp_name']) && $_FILES["filePhoto"]['tmp_name']!="") {
			  $newPhoto=new Photo();
			  $newPhoto->nomPhoto=basename($_FILES["filePhoto"]['name']);
			  $newPhoto->tmp_name=$_FILES["filePhoto"]['tmp_name'];
			  $newPage->numphoto=$newPhoto->creerPhoto();
			}
			$newPage->publiePage=$radioPubliee;		 
			
			$numpage=$newPage->creerPage();// on cree la page	   
			
			if (is_array($selectMenu)) {//on associe la page à un ou plusieurs menus
			  reset($selectMenu);
			  while(list(,$val) = each($selectMenu)) {
			  		  $list_menu=explode("-",$val);
					  $leMenu=new Menu();
					  $leMenu->nummenu=$list_menu[0];
					  $leMenu->type=$list_menu[1];
					  $leMenu->numpage=$numpage;
					  $leMenu->associerPage(); 	 
			  }//Fin du while
			}
			
			if ($radioPubliee=="o") $newPage->creerAlias();
			$creer_page=1;
			$pg_admin="ajouter-parag";
		} else {
		   $mes="Attention, le nom du fichier existe déjà. Vous devez choisir un autre nom pour cette page.";
		}
   }
/* ************* On ajoute un paragraphe lors de la création de la page (pg="ajouter-parag") ou 
 ************* en modification de page (action="ajouter_parag") ****************
 **************************************************************** */
} else if ($pg_admin=="ajouter-parag" || $action=="ajouter_parag") {
   //if ($textCont || is_array($checkPara)) {
   	   	   $newParag=new Paragraphe();	
	   //if ($textTitrePara) { //on cree un nouveau paragraphe
		   $newParag->titrePara=$textTitrePara;
		   $newParag->contenuPara=$textCont;
		   $numpara=$newParag->creerParagraphe();	// On crée le paragraphe
		   
		   $laPage=new Page();
		   $laPage->numpage=$numpage;
		   $laPage->id_m=$id;
		   $laPage->numpara=$numpara;
		   $laPage->ordre=$selectOrdre;  
		   $laPage->colonne=$selectType;
		   $laPage->liste=$radioListe;
		   $laPage->typeTitre=$radioTypeTitre;
		   $laPage->ajouterParagraphe();  // On l'ajoute à la page
		   
		   for ($i=1;$i<=$nbLiens;$i++) { // On traite l'ajout de liens
			 $valUrl="textUrlLien".$i."_";
			 $valPage="selectPage".$i."_";
			 if ($$valUrl || $$valPage) {
			 		$valLib="textLibLien".$i."_";
					$valTexte="textTexteLien".$i."_";
					$valOrdre="selectOrdreLien".$i."_";
					$valFen="radioFen".$i."_";
					$newLien=new Lien(); 
					$newLien->numpara=$numpara;
					$newLien->libLien=$$valLib;
					$newLien->texteLien=$$valTexte;
					if ($$valPage) {
						$pageLien= new Page();
						$pageLien->numpage=$$valPage;
						$pageLien->infosPage();
						$newLien->numpage=$$valPage;
						$newLien->urlLien=$pageLien->aliasPage;
					 } else {
					 	$newLien->urlLien=	$$valUrl;
					 }
					$newLien->fenLien=$$valFen; 
					$newLien->ordreLien=$$valOrdre; 
					$newLien->creerLien();
			 }//fin if ($$valUrl)
		   }//fin du for
		   
		    for ($i=1;$i<=$nbPhotos;$i++) { // On traite l'association de photos
			 $valSelect="selectPhoto".$i."_";;
			 $valFile="filePhoto".$i."_";;
			 if ($$valSelect || (isset($_FILES[$valFile]['tmp_name']) && $_FILES[$valFile]['tmp_name']!="")) {
			 		$valLeg="textLegPh".$i."_";
					$valOrdre="selectOrdrePhoto".$i."_";
					$valTaille="radioTaille".$i."_"; 
					if ($$valSelect) {// on associe une photo existante
						  $newParag->numphoto=$$valSelect;
						  $newParag->ordrePhoto=$$valOrdre;
						  $newParag->legPhoto=$$valLeg;
						  $newParag->associerPhoto(); 
					} else if (isset($_FILES[$valFile]['tmp_name']) && $_FILES[$valFile]['tmp_name']!="") { // on cr�e une photo
					  $newPhoto=new Photo();
					  $newPhoto->nomPhoto=normaliza(basename($_FILES[$valFile]['name']));
					  $newPhoto->tmp_name=$_FILES[$valFile]['tmp_name'];
					  $newPhoto->taille=$$valTaille;
					  $numphoto=$newPhoto->creerPhoto();
					  
					  // On associe ensuite la photo au paragraphe
					  $newParag->numphoto=$numphoto;
					  $newParag->ordrePhoto=$$valOrdre;
					  $newParag->legPhoto=$$valLeg;
					  $newParag->associerPhoto(); 
					}
					
			 }//fin if ($$valSelect || $$valFile)
		   }//fin du for
		   
		   for ($i=1;$i<=$nbVideos;$i++) { // On traite l'association de vidéos
			 $valSelect="selectVideo".$i."_";
			 $valFile="fileVideo".$i."_";
			 
			 if ($$valSelect || (isset($_FILES[$valFile]['tmp_name']) && $_FILES[$valFile]['tmp_name']!="")) {
			 		$valLeg="textLegVi".$i."_";
					$valOrdre="selectOrdreVideo".$i."_";
					if ($$valSelect) {// on associe une vidéo existante
						  $newParag->numvideo=$$valSelect;
						  $newParag->ordreVideo=$$valOrdre;
						  $newParag->legVideo=$$valLeg;
						  $newParag->associerVideo(); 
					} else if (isset($_FILES[$valFile]['tmp_name']) && $_FILES[$valFile]['tmp_name']!="") { // on cree une video
					  $newVideo=new Video();
					  $newVideo->nomVideo=normaliza(basename($_FILES[$valFile]['name']));
					  $newVideo->tmp_name=$_FILES[$valFile]['tmp_name'];
					  $numvideo=$newVideo->creerVideo();
					  
					  // On associe ensuite la vidéo au paragraphe
					  $newParag->numvideo=$numvideo;
					  $newParag->ordreVideo=$$valOrdre;
					  $newParag->legVideo=$$valLeg;
					  $newParag->associerVideo(); 
					}
					
			 }//fin if ($$valSelect || $$valFile)
		   }//fin du for
		   
		    for ($i=1;$i<=$nbFichiers;$i++) { // On traite l'association de fichiers
			 //$valSelect="selectFich".$i."_";
			 $valFile="fileFich".$i."_";
			 
			 if (isset($_FILES[$valFile]['tmp_name']) && $_FILES[$valFile]['tmp_name']!="") {
					$valOrdre="selectOrdreFich".$i."_";
					$valLib="textLibFich".$i."_";
					  $newFichier=new Fichier();
					  $newFichier->nomFichier=normaliza(basename($_FILES[$valFile]['name']));
					  $newFichier->tmp_name=$_FILES[$valFile]['tmp_name'];	
					  $numfichier=$newFichier->creerFichier();
					  
					  // On associe ensuite le fichier au paragraphe
					  $newParag->numfichier=$numfichier;
					  $newParag->ordreFichier=$$valOrdre;
					  $newParag->libFichier=$$valLib;
					  $newParag->associerFichier(); 
					
			 }//fin if ($$valSelect || $$valFile)
		   }//fin du for
	   //}//fin if ($textTitrePara)
	   
	   /* * Association des parag existants : mise en commentaire le 12/01/09 car cela perturbe Claude 
	   if (is_array($checkPara)) {//On associe un paragraphe existant	  
	   	   reset($checkPara);
		   while(list(,$val) = each($checkPara)) {
		   	  $ordrepara="selectOrdrePara".$val;
			  $colpara="selectType".$val;
			  $listepara="radioListe".$val;
			  $laPage=new Page();
			  $laPage->numpage=$numpage;
			  $laPage->numpara=$val;
			  $laPage->ordre=$$ordrepara;
			  $laPage->colonne=$$colpara;
			  $laPage->liste=$$listepara;
			  $laPage->ajouterParagraphe();  // On l'ajoute � la page
		   }//fin du while
	   }//fin if (is_array($checkPara))
	   * */
	   
	   if (!$action) {//on est en création de page
	   		if (!$paragraphe) $pg_admin="lister-page";	else $creer_page=1;	   
	   } else {	//on est en modification de page
	   	    if (!$paragraphe) $onglet="mod_para"; else $onglet="aj_para";  
	   } 
   //}//fin if ($textTitrePara || is_array($checkPara))  
   
/* ************* On liste les pages = tableau de bord soit a partir du menu "Les pages", soit a partir du menu "Gerer la publication" ********************* */
} else if ($pg_admin=="lister-page") {
  
  if ($numpageP) {//on publie ou pas la page
  	$publiPage=new Page();
	$publiPage->numpage= $numpageP;
	if ($publiee=="o") $publiPage->publiePage="n"; else $publiPage->publiePage="o";
	$publiPage->publierPage();
	$mes="La publication de la page est modifiée";
	$publi=1;
  }	 else if ($supPage) {// suppression de la page
  	 $laPage=new Page();
	 $laPage->numpage=$supPage;
	 $laPage->supprimerPage(); 
	 $mes="La page a été supprimée ainsi que les liens vers cette page (champs de type liens uniquement - attention, pas les 
	 liens écrits directement dans le texte d'un paragraphe";
  }
  
/* ************* On visualise une page en mod admin = > on a les onglets "voir", "modifier parametres generaux", "modifier les paragraphes", etc...******** */
} else if ($pg_admin=="content") { 
  if ($action=="modifier_page") { //on modifie les paramètres généraux de la page
   if ($textNomG) {
	   // Infos de la page	  
	   $modifPage = new Page();	 
	   $modifPage->numpage=$numpage; 
	   $modifPage->aliasPage=$textAlias;
	    
	   if ($modifPage->verifierAlias()) {
		   $modifPage->nomPageGoogle=$textNomG;
		   $modifPage->lg=$selectLg;  
		   $modifPage->titrePage=$textTitre;
		  	$modifPage->descrPage=$textDescr;
			$modifPage->keywPage=$textKeyw;
			$modifPage->id_m=$id;
			$modifPage->accueilPage=$radioAccueil; 
			$modifPage->accueilSite=$radioAccueilSite; 	 
			$modifPage->nomFichier=$textFichier;
			if ($selectPhoto) {
			  $modifPage->numphoto=$selectPhoto;
			} else if (isset($_FILES["fileModifPhoto"]['tmp_name']) && $_FILES["fileModifPhoto"]['tmp_name']!="") {
			  $newPhoto=new Photo();
			  $newPhoto->nomPhoto=basename($_FILES["fileModifPhoto"]['name']);
			  $newPhoto->tmp_name=$_FILES["fileModifPhoto"]['tmp_name'];
			  $modifPage->numphoto=$newPhoto->creerPhoto();
			}
			$modifPage->publiePage=$radioPubliee;
		    $modifPage->modifierPage();	
			
			if (is_array($selectMenu)) {//on associe la page à un ou plusieurs menus
			  reset($selectMenu);
			  while(list(,$val) = each($selectMenu)) {
			  		  $list_menu=explode("-",$val);
					  $leMenu=new Menu();
					  $leMenu->nummenu=$list_menu[0];
					  $leMenu->type=$list_menu[1];
					  $leMenu->numpage=$numpage;
					  $leMenu->associerPage(); 	 
			  }//Fin du while
			}
			$modifPage->creerAlias();
		    $onglet="voir";
		} else { //fin if ($modifPage->verifierAlias())
		   $mes="Attention, le nom du fichier existe déjà. Vous devez choisir un autre nom pour cette page.";
		}
		 
   }//fin if ($textNomG)  
   
	/* ************* On modifie un paragraphe **************************************************************** */
	} else if ($action=="modifier_parag") {
		//Les paragraphes
		$modifPage = new Page();
	    $modifPage->numpage=$numpage;
		$modifPage->id_m=$id; 
		$listparas=new ListeParagraphes();	
		$listparas->numpage=$numpage; 
		$listparas->afficherListeParas();
		foreach ($listparas as $paras) {
		   $sup="checkSupPara".$paras->numpara;
		   if ($$sup) {//on supprime le paragraphe
		   		$modifPage->numpara=$paras->numpara;
				$modifPage->enleverParagraphe();
		   } else {	//on modifie le paragraphe
		   		   $paras->titrePara=${"textTitrePara".$paras->numpara};
				   $paras->contenuPara=${"textCont".$paras->numpara};
				   $paras->modifierParagraphe();	// On modifie le paragraphe
				   
				   $modifPage->numpara=$paras->numpara;
				   $modifPage->ordre=${"selectOrdre".$paras->numpara};  
				   $modifPage->colonne=${"selectType".$paras->numpara};
				   $modifPage->liste=${"radioListe".$paras->numpara}; 
				   $modifPage->typeTitre=${"radioTypeTitre".$paras->numpara}; 
				   $modifPage->modifierParagraphe();  // On modifie l'association à la page

				   for ($i=1;$i<=${"nbLiens".$paras->numpara};$i++) { // On traite l'ajout de liens
					 $valUrl="textUrlLien".$i."_".$paras->numpara;
					 $valPage="selectPage".$i."_".$paras->numpara;
					 if ($$valUrl || $$valPage) {
					 		$valLib="textLibLien".$i."_".$paras->numpara;
							$valTexte="textTexteLien".$i."_".$paras->numpara;
							$valOrdre="selectOrdreLien".$i."_".$paras->numpara;
							$valFen="radioFen".$i."_".$paras->numpara;
							$newLien=new Lien(); 
							$newLien->numpara=$paras->numpara;
							$newLien->libLien=$$valLib;
							$newLien->texteLien=$$valTexte;
							if ($$valPage) {
								$pageLien= new Page();
								$pageLien->numpage=$$valPage;
								$pageLien->infosPage();
								$newLien->numpage=$$valPage;
								$newLien->urlLien=$pageLien->aliasPage;
							 } else {
								$newLien->urlLien=	$$valUrl;
							 }
							$newLien->fenLien=$$valFen; 
							$newLien->ordreLien=$$valOrdre; 
							$newLien->creerLien();
					 }//fin if ($$valUrl)
				   }//fin du for
				   
				    for ($i=1;$i<=${"nbPhotos".$paras->numpara};$i++) { // On traite l'association de photos
					 $valSelect="selectPhoto".$i."_".$paras->numpara;
					 $valFile="filePhoto".$i."_".$paras->numpara;
					 $valTaille="radioTaille".$i."_".$paras->numpara;
					 if ($$valSelect || (isset($_FILES[$valFile]['tmp_name']) && $_FILES[$valFile]['tmp_name']!="")) {
					 		$valLeg="textLegPh".$i."_".$paras->numpara;
							$valOrdre="selectOrdrePhoto".$i."_".$paras->numpara;
							if ($$valSelect) {// on associe une photo existante
								  $paras->numphoto=$$valSelect;
								  $paras->ordrePhoto=$$valOrdre;
								  $paras->legPhoto=$$valLeg;	 
								  $paras->associerPhoto(); 
							} else if (isset($_FILES[$valFile]['tmp_name']) && $_FILES[$valFile]['tmp_name']!="") { // on cr�e une photo
							  $newPhoto=new Photo();
							  $newPhoto->nomPhoto=normaliza(basename($_FILES[$valFile]['name']));
							  $newPhoto->tmp_name=$_FILES[$valFile]['tmp_name'];
							  $newPhoto->taille=$$valTaille;
							  $numphoto=$newPhoto->creerPhoto();
							  
							  // On associe ensuite la photo au paragraphe
							  $paras->numphoto=$numphoto;
							  $paras->ordrePhoto=$$valOrdre;
							  $paras->legPhoto=$$valLeg;
							  $paras->associerPhoto(); 
							}
							
					 }//fin if ($$valSelect || $$valFile)
				   }//fin du for
				   
				   for ($i=1;$i<=${"nbVideos".$paras->numpara};$i++) { // On traite l'association de vidéos
					 $valSelect="selectVideo".$i."_".$paras->numpara;
					 $valFile="fileVideo".$i."_".$paras->numpara;
					 
					 if ($$valSelect || (isset($_FILES[$valFile]['tmp_name']) && $_FILES[$valFile]['tmp_name']!="")) {
					 		$valLeg="textLegVi".$i."_".$paras->numpara;
							$valOrdre="selectOrdreVideo".$i."_".$paras->numpara;
							if ($$valSelect) {// on associe une vidéo existante
								  $paras->numvideo=$$valSelect;
								  $paras->ordreVideo=$$valOrdre;
								  $paras->legVideo=$$valLeg;
								  $paras->associerVideo(); 
							} else if (isset($_FILES[$valFile]['tmp_name']) && $_FILES[$valFile]['tmp_name']!="") { // on crée une vidéo
							  $newVideo=new Video();
							  $newVideo->nomVideo=normaliza(basename($_FILES[$valFile]['name']));
							  $newVideo->tmp_name=$_FILES[$valFile]['tmp_name'];
							  $numvideo=$newVideo->creerVideo();
							  
							  // On associe ensuite la vid�o au paragraphe
							  $paras->numvideo=$numvideo;
							  $paras->ordreVideo=$$valOrdre;
							  $paras->legVideo=$$valLeg;
							  $paras->associerVideo(); 
							}
							
					 }//fin if ($$valSelect || $$valFile)
				   }//fin du for
				   
				    for ($i=1;$i<=${"nbFichiers".$paras->numpara};$i++) { // On traite l'association de fichiers
						 $valFile="fileFich".$i."_".$paras->numpara;
						 if (isset($_FILES[$valFile]['tmp_name']) && $_FILES[$valFile]['tmp_name']!="") {
								$valOrdre="selectOrdreFich".$i."_".$paras->numpara;
								$valLib="textLibFich".$i."_".$paras->numpara;
								  $newFichier=new Fichier();
								  $newFichier->nomFichier=normaliza(basename($_FILES[$valFile]['name']));
								  $newFichier->tmp_name=$_FILES[$valFile]['tmp_name'];	
								  $numfichier=$newFichier->creerFichier();
								  
								  // On associe ensuite la vidéo au paragraphe
								  $paras->numfichier=$numfichier;
								  $paras->ordreFichier=$$valOrdre;
								  $paras->libFichier=$$valLib;
								  $paras->associerFichier(); 
								
						 }//fin if (isset($_FILES[$valFile]['tmp_name']) && $_FILES[$valFile]['tmp_name']!="")
				   }//fin du for
		   }//fin du else
		}//fin du foreach ($listparas as $paras)
		$onglet="mod_para";  
	}//fin 	if ($action=="modifier_parag")  
	 
/* ************* On ajoute ou on modifie un menu **************************************************************** */
} else if ($pg_admin=="ajouter-menu") {
   if ($textLibMenu) {
   	   $newMenu = new Menu();  
	   $newMenu->type=$cont;
	   $newMenu->nummenu=$nummenu;	
	   $newMenu->nomMenu=$textLibMenu;
   	   $newMenu->zone=$selectZoneMenu;
	   $newMenu->ordre=$selectOrdreMenu;
	   $newMenu->affiche=$radioAffich;
	   $newMenu->lg=$selectLg;
	   //$newMenu->nomFichier=$textFichier;
	   //$newMenu->nomAlias=$textAliasFichier;
	   if ($selectRub) $newMenu->numfkey=$selectRub;
	   else if ($selectCat) $newMenu->numfkey=$selectCat;
	   if (!$nummenu) $newMenu->creerMenu(); else  $newMenu->modifierMenu();   
	   if (!$nummenu) $mes="Le menu est créé"; else $mes="Le menu est modifié !";	 
	   $pg_admin="lister-menu";
   }		
   
/* ************* On liste les menus ********************* */
} else if ($pg_admin=="lister-menu") {  
   if ($affic) {//On affiche ou pas le menu
   	   $leMenu = new Menu();
	   if ($numrub) {
	   	  $leMenu->type="rubrique";  
		  $leMenu->nomkey="numrub";
		  $leMenu->nummenu=$numrub;
	   } else if ($numcateg) {
	   	  $leMenu->type="categorie"; 
		  $leMenu->nomkey="numcateg"; 
		  $leMenu->nummenu=$numcateg;
	   } else {
	   	  $leMenu->type="sscateg";
		  $leMenu->nomkey="numsscateg";	
		  $leMenu->nummenu=$numsscateg;
	   }
	   if ($affic=="o") $leMenu->affiche="n"; else $leMenu->affiche="o";
	   $leMenu->afficherMenu();  		
   } else if ($supMenu) {//on supprime le menu (si admin)
   		$leMenu = new Menu();
		$leMenu->nummenu=$supMenu;
		$leMenu->type=$type; 
		$leMenu->supprimerMenu();
		$mes="Le menu est supprimé !";
   }   
   
/* ************* Decrire le site ********************* */
} else if ($pg_admin=="admin-site") {  
   if ($textUrl) {
		if ($res_site>0) {					
			mysql_query("UPDATE if_site SET url='$textUrl', path='$textPath', pied_de_page='$textPied'");
		} else {
		   mysql_query("INSERT INTO if_site	(url,path,pied_de_page) VALUES ('$textUrl','$textPath','$textPied')");
		}
		$mes="Les paramètres sont enregistrés";
   } 	 
   
/* ************* Liste des utilisateurs du backoffice (de l'admin) ********************* */
} else if ($pg_admin=="lister-uti") {
  if ($act) {
  	$modifUti = new Utilisateur();
	$modifUti->numuti=$numuti;
	if ($act=="o") $modifUti->actif="n"; else $modifUti->actif="o";
	$modifUti->activerUti();  	
  }	
  
/* ************* Ajouter un utilisateur ********************* */
} else if ($pg_admin=="ajouter-uti") {
   if ($textLogin) {
   	   $newUti = new Utilisateur();	
	   $newUti->nom=$textNom;
	   $newUti->prenom=$textPrenom;	
	   $newUti->login=$textLogin;
	   $newUti->pwd=$textPwd;
	   $newUti->admin=$radioAdmin;	 
	   $newUti->actif=$radioActif;	
	   $newUti->numuti=$numuti;  
	   if (!$numuti) $newUti->creerUti(); else $newUti->modifierUti();
	   if (!$numuti) $mes="L\'utilisateur est créé"; else $mes="L\'utilisateur est modifié !";
   } 
   
/* ************* Lister les contacts ********************* */
} else if ($pg_admin=="lister-contact") {
  if ($supcont) {
   	$supCont = new Contact();
	$supCont->numcontact=$supcont;
	$supCont->supprimerContact();
	$mes="Le contact est supprimé !";	
  } 
   
/* ************* Ajouter un contact ********************* */
} else if ($pg_admin=="ajouter-contact") {
   if ($textNom) {
   	   $newCont = new Contact();	
	   $newCont->nom=$textNom;
	   $newCont->prenom=$textPrenom;	
	   $newCont->genre=$selectGenre;
	   $newCont->login=$textLogin;
	   $newCont->email=$textEmail;
	   $newCont->tel=$textTel;	 
	   $newCont->fax=$textFax;	
	   $newCont->gsm=$textGsm;
	   $newCont->fonction=$textFonction;
	   $newCont->referent=$radioRefe;		
	   $newCont->numcontact=$numcontact;
	   
	   if (is_array($selectCateg)) {
	   	  $newCont->listcateg=$selectCateg;
	   } 
	    if (is_array($selectSscateg)) {	
	   	  $newCont->listsscateg=$selectSscateg;
	   }   
	   if (!$numcontact) $newCont->creerContact(); else $newCont->modifierContact();
	   if (!$numcontact) $mes="Le contact est créé"; else $mes="Le contact est modifié!";	
	   $pg_admin="lister-contact";
   }

/* ************* Lister les formations ********************* */
} else if ($pg_admin=="lister-formation") {
  if ($supform) {
   	$supForm = new Formation();
	$supForm->numpara=$supform;
	$supForm->numparafichier=$numparafichier;
	$supForm->supprimerFormation();
	$mes="La formation est supprimée !";	
  } 
   
/* ************* Ajouter ou modifier une formation ********************* */
} else if ($pg_admin=="ajouter-forma") {
   if ($textTitre) {
   	   $cree=0;
   	   $newForma = new Formation();	
	   $newForma->titrePara=$textTitre;	
	   $newForma->contenuPara=$textCont;
	   $newForma->datedeb_admin=$textDateDeb;	
	   $newForma->datefin_admin=$textDateFin;
	   $newForma->surMesure=$radioMesure;
	   $newForma->enligne=$radioEnligne;
	   $newForma->numpara=$numpara;
	   if (!$numpara) {
	   	 $numpara=$newForma->creerParagraphe(); 
		 $newForma->creerFormation(); 
		 $cree=1;
	   } else {
	   	 $newForma->modifierParagraphe();
		 $newForma->modifierFormation();
	   } 
	   
	   if (is_array($selectCateg)) {
	   	  $newForma->listcateg=$selectCateg;
		  $newForma->associerFormaCateg();
	   } 
	    if (is_array($selectSscateg)) {	
	   	  $newForma->listsscateg=$selectSscateg;
		  $newForma->associerFormaSscateg();
	   }  
	   
	   
	   if ($selectFich || (isset($_FILES["fileFiche"]['tmp_name']) && $_FILES["fileFiche"]['tmp_name']!="")) {
			if ($selectFich) {// on associe une fiche formation existante
				  $newForma->numfichier=$selectFich;
				  $newForma->associerFichier(); 
			} else if (isset($_FILES["fileFiche"]['tmp_name']) && $_FILES["fileFiche"]['tmp_name']!="") { // on crée une formation
			  $newFiche=new Fichier();
			  $newFiche->nomFichier=normaliza(basename($_FILES["fileFiche"]['name']));
			  $newFiche->tmp_name=$_FILES["fileFiche"]['tmp_name'];	
			  $numfichier=$newFiche->creerFichier();
			  
			  // On associe ensuite la fiche à la formation
			  $newForma->numfichier=$numfichier;
			  $newForma->associerFichier(); 
			}
	 }//fin if ($selectFich || (isset($_FILES["fileFiche"]['tmp_name']) && $_FILES["fileFiche"]['tmp_name']!=""))
			 
	   if ($cree) $mes="La formation est créée"; else $mes="La formation est modifiée !";	
	   $pg_admin="lister-formation";
   }//fin if ($textTitre)

/* ************* Lister les documentations ********************* */
} else if ($pg_admin=="lister-doc") {
  if ($supdoc) {
   	$supDoc = new Documentation();
	$supDoc->numpara=$supdoc;
	$supDoc->numparafichier=$numparafichier;
	$supDoc->supprimerDoc();
	$mes="La documentation est supprimée !";	
  } 
   
/* ************* Ajouter ou modifier une documentation ********************* */
} else if ($pg_admin=="ajouter-doc") {
   if ($annuler) $pg_admin="lister-doc";
   else if ($selectType || $textNewType) {
   	   $cree=0;
   	   $newDoc = new Documentation();	
	   if ($textNewType) {
	   	$newDoc->new_type_doc=$textNewType;
		$type_doc=$newDoc->ajouterTypeDoc();
		$newDoc->type_doc=$type_doc;
	   } else {
	   	$newDoc->type_doc=$selectType;	
	   }
	   $newDoc->titrePara=$textTitreFr;
	   $newDoc->titre_en=$textTitreEn;	
	   $newDoc->contenuPara=$textContFr;
	   $newDoc->contenu_en=$textContEn;
	   $newDoc->auteur=$textAuteur;	
	   $newDoc->ref_biblio=$textRefBib;	
	   $newDoc->date=$textDate;
	   $newDoc->date_libre=$textDateLibre;
	   $newDoc->reference=$textRef;
	   $newDoc->keyw=$textKeyw;
	   $newDoc->tarif=$textTarif;
	   $newDoc->poids=$textPoids;
	   //désactivé le 13/03/2009 $newDoc->pwd=$textPwd;
	   $newDoc->acces_res=$radioAcces;
	   $newDoc->publiee=$radioPubliee;
	   $newDoc->une=$radioUne;
	   $newDoc->numpara=$numpara;
	   
	   if (!$numpara) {
	   	 $numpara=$newDoc->creerParagraphe(); 
		 $newDoc->creerDoc(); 
		 $cree=1;
	   } else {
	   	 $newDoc->modifierParagraphe();
		 $newDoc->modifierDoc();
	   } 
	   
	   if (is_array($selectCateg)) {
	   	  $newDoc->listcateg=$selectCateg;
		  $newDoc->associerFormaCateg();
	   } 
	    if (is_array($selectSscateg)) {	
	   	  $newDoc->listsscateg=$selectSscateg;
		  $newDoc->associerFormaSscateg();
	   }  
	   
	   
	   // Le fichier
	   if ($selectFich || (isset($_FILES["fileFiche"]['tmp_name']) && $_FILES["fileFiche"]['tmp_name']!="")) {
			if ($selectFich) {// on associe un fichier doc existant
				  $newDoc->numfichier=$selectFich;
				  $newDoc->associerFichier(); 
			} else if (isset($_FILES["fileFiche"]['tmp_name']) && $_FILES["fileFiche"]['tmp_name']!="") { // on crée une formation
			  $newFiche=new Fichier();
			  $newFiche->nomFichier=normaliza(basename($_FILES["fileFiche"]['name']));
			  $newFiche->tmp_name=$_FILES["fileFiche"]['tmp_name'];	
			  $numfichier=$newFiche->creerFichier();
			  
			  // On associe ensuite la fiche à la formation
			  $newDoc->numfichier=$numfichier;
			  $newDoc->associerFichier(); 
			}
	 }//fin if ($selectFich || (isset($_FILES["fileFiche"]['tmp_name']) && $_FILES["fileFiche"]['tmp_name']!=""))
	  
	  // La vignette (dont redimensionnement automatique des .jpg)
	 if ($selectPhoto || (isset($_FILES["filePhoto"]['tmp_name']) && $_FILES["filePhoto"]['tmp_name']!="")) {
				if ($selectPhoto) {// on associe une photo existante
					  $newDoc->numphoto=$selectPhoto;
					  $newDoc->associerPhoto(); 
				} else if (isset($_FILES["filePhoto"]['tmp_name']) && $_FILES["filePhoto"]['tmp_name']!="") { // on crée une photo
				  $newPhoto=new Photo();
				  $newPhoto->nomPhoto=normaliza(basename($_FILES["filePhoto"]['name']));
				  $newPhoto->tmp_name=$_FILES["filePhoto"]['tmp_name'];
				  $valTaille="120";
				  $newPhoto->taille=$$valTaille;
				  $numphoto=$newPhoto->creerPhoto();
				  
				  // On associe ensuite la vignette à la documentation
				  $newDoc->numphoto=$numphoto;
				  $newDoc->associerPhoto(); 
				}
				
		 }//fin if ($selectPhoto || (isset($_FILES["filePhoto"]['tmp_name']) && $_FILES["filePhoto"]['tmp_name']!="")) 
					 		 
	   if ($cree) $mes="La documentation est créée"; else $mes="La documentation est modifiée !";	
	   $numpara="";
	   $pg_admin="lister-doc"; 
   }//fin  else if ($selectType || $textNewType)

/* ************* Lister les professionnels ********************* */
} else if ($pg_admin=="lister-prof") {
  if ($numclient && $actif) {
  	$leClient= new Client();
	$leClient->numclient=$numclient;
	if ($actif=="o") $leClient->actif="n"; else $leClient->actif="o"; 
	$leClient->activerClient();
  } else if ($supprof) {
   	$supProf = new Client();
	$supProf->numclient=$supprof;
	$supProf->supprimerClient();
	$mes="Le professionnel est supprimé !";	
  } 
   
/* ************* Ajouter ou modifier un professionnel ********************* */
} else if ($pg_admin=="ajouter-prof") {
  if ($textNom) {
   	   $newProf = new Client();	
	   $newProf->raison=$textRaison;
	   $newProf->nom=$textNom;
	   $newProf->prenom=$textPrenom;
	   $newProf->email=$textEmail;
	   $newProf->pwd=$textPwd;
	   $newProf->actif=$radioActif;
	   $newProf->amont=$checkAmont;
	   $newProf->aval=$checkAval;
	   $newProf->adr1=$textAdr1;
	   $newProf->adr2=$textAdr2;
	   $newProf->cp=$textCp;
	   $newProf->ville=$textVille;
	   $newProf->pays=$selectPays;//numpays
	   $newProf->tel=$textTel;
	   $newProf->fax=$textFax;
	   $newProf->professionnel="o";
	   $newProf->numclient=$numclient;
	     
	   //note : attention $mes est en return de creerClient() et modifierClient() (a cause du site public)
	   //penser donc a gerer les ecrasements eventuels de variables
	   //par exemple : on ne veut pas $mes issu de modifierClient()
	   if (!$numclient) $mes=$newProf->creerClient(); else $newProf->modifierClient(); 
	   if (!$numclient && !$mes) $mes="Le professionnel est créé"; else if (!$numclient && $mes) $mes=$mes; else $mes="Le professionnel est modifié!";	
	   $pg_admin="lister-prof";
   
  } 

/* ************* Lister les clients ********************* */
} else if ($pg_admin=="lister-client") {
  if ($numclient && $actif) {
  	$leClient= new Client();
	$leClient->numclient=$numclient;
	if ($actif=="o") $leClient->actif="n"; else $leClient->actif="o"; 
	$leClient->activerClient();
  } else if ($supclient) {
   	$supClient = new Client();
	$supClient->numclient=$supclient;
	$supClient->supprimerClient();
	$mes="Le client est supprimé !";	
  } 
   
/* ************* Modifier un client ********************* */
} else if ($pg_admin=="modifier-client") {
  if ($textNom) {
   	   $modifClient = new Client();	
	   $modifClient->raison=$textRaison;
	   $modifClient->civilite=$selectCiv;
	   $modifClient->nom=$textNom;
	   $modifClient->prenom=$textPrenom;
	   $modifClient->fonction=$textFonction;
	   $modifClient->adr1=$textAdr1;
	   $modifClient->adr2=$textAdr2;
	   $modifClient->cp=$textCp;
	   $modifClient->ville=$textVille;
	   $modifClient->pays=$selectPays;
	   $modifClient->tel=$textTel;
	   $modifClient->fax=$textFax;
	   $modifClient->gsm=$textGsm;
	   $modifClient->email=$textEmail;
	   $modifClient->pwd=$textPwd;
	   $modifClient->actif=$radioActif;
	   $modifClient->numclient=$numclient;
	     
	   $modifClient->modifierClient();
	   $mes="Le client est modifié!";	
	   $pg_admin="lister-client";
   
  }     

/* ************* Lister les professionnels ********************* */
} else if ($pg_admin=="lister-prof") {
  if ($numclient && $actif) {
  	$leClient= new Client();
	$leClient->numclient=$numclient;
	if ($actif=="o") $leClient->actif="n"; else $leClient->actif="o"; 
	$leClient->activerClient();
  } else if ($supprof) {
   	$supProf = new Client();
	$supProf->numclient=$supprof;
	$supProf->supprimerClient();
	$mes="Le professionnel est supprimé !";	
  } 
   
/* ************* Ajouter ou modifier une brève internationale ********************* */
} else if ($pg_admin=="ajouter-breve") {
  if ($textTitre) {
   	   $newBreve = new Breve();	
	   $newBreve->titrePara=$textTitre;
	   $newBreve->contenuPara=$textCont;
	   $newBreve->date_breve=$textDate;
	   if (!$selectPays) $newBreve->numpays=0; else $newBreve->numpays=$selectPays;
	   $newBreve->source=$textSource;
	   
	   if (!$numpara) {
	   	$numpara=$newBreve->creerParagraphe(); 
		$newBreve->creerBreve(); 
		$cree=1;
	   } else {
	   	 $newBreve->numpara=$numpara;
		 $newBreve->modifierParagraphe();
		$newBreve->modifierBreve();
	   }
	   if ($cree) $mes="La brève est créée"; else $mes="La brève est modifiée!";	
	   $pg_admin="lister-breve";
   
  } 
  
/* ************* Lister les brèves internationales ********************* */
} else if ($pg_admin=="lister-breve") {
  if ($supbreve) {
   	$supBreve = new Breve();
	$supBreve->numpara=$supbreve;
	$supBreve->supprimerBreve();
	$mes="La brève est supprimée !";	
  } 

/* ************* Ajouter ou modifier une brève d'actualité ********************* */
} else if ($pg_admin=="ajouter-actu") {
  if ($textTitre) {
   	   $newActu = new Actualite();	
	   $newActu->titrePara=$textTitre;
	   $newActu->contenuPara=$textCont;
	   $newActu->accueil=$radioAccueil;
	   $newActu->date_actu=$textDate;
	   
	   if (!$numpara) {
	   	$numpara=$newActu->creerParagraphe(); 
		$newActu->creerActu(); 
		$cree=1;
	   } else {
	   	 $newActu->numpara=$numpara;
		 $newActu->modifierParagraphe();
		 $newActu->modifierActu();
	   }
	   
	   //Le lien 
		 if ($textUrlLien) {
				$newLien=new Lien(); 
				$newLien->numpara=$numpara;
				$newLien->libLien=$textLibLien;
				$newLien->texteLien=$textTexteLien;
				$newLien->urlLien=$textUrlLien;
				$newLien->fenLien=$radioFen; 
				$newLien->creerLien();
		 }
	  
	  // La vignette
	 if ($selectPhoto || (isset($_FILES["filePhoto"]['tmp_name']) && $_FILES["filePhoto"]['tmp_name']!="")) {
			if ($selectPhoto) {// on associe une photo existante
				  $newActu->numphoto=$selectPhoto;
				  $newActu->legPhoto=$textLegPh;
				  $newActu->associerPhoto(); 
			} else if (isset($_FILES["filePhoto"]['tmp_name']) && $_FILES["filePhoto"]['tmp_name']!="") { // on cr�e une photo
			  $newPhoto=new Photo();
			  $newPhoto->nomPhoto=normaliza(basename($_FILES["filePhoto"]['name']));
			  $newPhoto->tmp_name=$_FILES["filePhoto"]['tmp_name'];
			  // Quelle taille pour la vignette ? $newPhoto->taille=$$valTaille;
			  $numphoto=$newPhoto->creerPhoto();
			  
			  // On associe ensuite la vignette à l'actualité
			  $newActu->numphoto=$numphoto;
			  $newActu->legPhoto=$textLegPh;
			  $newActu->associerPhoto(); 
			}
			
	 }//fin if ($selectPhoto || (isset($_FILES["filePhoto"]['tmp_name']) && $_FILES["filePhoto"]['tmp_name']!="")) 
	   
	   if ($cree) $mes="La brève d\'actualité est créée"; else $mes="La brève d\'actualité est modifiée!";	
	   $pg_admin="lister-actu";
   
  } 
  
/* ************* Lister les brèves d'actualité ********************* */
} else if ($pg_admin=="lister-actu") {
  if ($supactu) {
	$supActu = new Actualite();
	$supActu->numpara=$supactu;
	$supActu->supprimerActu();
	$mes="La brève d\'actualité est supprimée !";	
  } 

/* ************* Ajouter ou modifier un article ********************* */
} else if ($pg_admin=="ajouter-arti") {
  if ($textLibelle) {
   	   $newArti = new Article();	
	   $newArti->libelle=$textLibelle;
	   
	   if (!$numarticle) {
		$newArti->creerArti(); 
		$cree=1;
	   } else {
	   	 $newArti->numarticle=$numarticle;
		 $newArti->modifierArti();
	   }
	   
	   if ($cree) $mes="L\'article est créé !"; else $mes="L\'article est modifié !";	
	   $pg_admin="lister-arti";
   
  } 
  
/* ************* Lister les articles ********************* */
} else if ($pg_admin=="lister-arti") {
  if ($suparti) {
	$supArti = new Article();
	$supArti->numarticle=$suparti;
	$supArti->supprimerArti();
	$mes="L\'article est supprimé !";	
  } 
  
/* ************* Voir/modifier une commande ********************* */
} else if ($pg_admin=="modifier-com") {
  if ($action=="modifier") {
  	$modifCom=new Commande();
	$modifCom->numcom=$numcom;
	$modifCom->etat=$selectEtat;
	$modifCom->suivi_coliposte=$textColiposte;   
	$modifCom->modifierCommandeAdmin();
	$modifCom->infosCommande();
	// envoi du mail
	if ($selectEtat=="2") { //commande validee (a reception du cheque / ou du virement)
		$leClient = new Client();
		$leClient->numclient = $modifCom->numclient;
		$leClient->infosClient();
		EnvoiMailCommandeChequeValidee($numcom,$leClient->email,"");
		$mes="La commande est modifiée ! Un mail de confirmation de la réception du chèque a été envoyé au client";
	} else if ($selectEtat=="3") { // commande expediee
		$leClient = new Client();
		$leClient->numclient = $modifCom->numclient;
		$leClient->infosClient();
		EnvoiMailCommandeExpediee($numcom,$leClient->email,"");
		$mes="La commande est modifiée ! Un mail de d'expédition a été envoyé au client";
	} else if ($selectEtat=="4") { // commande archivee
		$leClient = new Client();
		$leClient->numclient = $modifCom->numclient;
		$leClient->infosClient();
		$mes="La commande a été archivée";
	}
	//$mes="La commande est modifiée !";
	$pg_admin="lister-com";
  } else if ($action=="annuler") {
  	$pg_admin="lister-com";
  }

/* ************* Lister les commandes ********************* */
} else if ($pg_admin=="lister-com") {
  if ($supcom) {
  	$modifCom=new Commande();
	$modifCom->numcom=$supcom;	   
	$modifCom->supprimerCommande();
	$mes="La commande est supprimée !";
	$pg_admin="lister-com";
  } 

/* ************* Lister les inscriptions aux formations ********************* */
} else if ($pg_admin=="lister-inscri") {
  if ($valide) {
  	$laForma=new Formation();
	$laForma->numpara=$valide;//N° de la formation
	$laForma->datedeb_admin=$textDateDeb;
	$laForma->datefin_admin=$textDateFin;
	$laForma->validerForma($if_site["url"]);
	
	//Mise à jour des montants HT et TTC (IFIP => montantHT=montantTTC)
	$list_inscrits=$laForma->listerInscrits();
	for ($i=0; $i<count($list_inscrits);$i++) {
		$list_detail=$list_inscrits[$i];
		$sesArticles=$list_detail[1];
		for ($j=0; $j<count($sesArticles);$j++) {
			$sonDetail=$sesArticles[$j];
			$tarif="textTarif".$sonDetail["numcom"];
			$laCom = new Commande();
			$laCom->numcom=$sonDetail["numcom"];
			$laCom->montantHT=$$tarif;
			$laCom->montantTTC=$$tarif;
			$laCom->modifierCommandeForma();
		}
	}
	
	$mes="La formation est validée !";
  } 

/* ************* On se déconnecte **************************************************************** */
} else if ($decon) {
	$uti->deconnecte();
	mysql_close();
	HEADER("Location: admin/index.php");
}
/* ************* On se déconnecte de l'espace pro ********************************************************* */

} else if ($deconpro || $deconclient) { // fin if ($id)
	unset($_SESSION['numprof']);
	unset($_SESSION['numclient']);

//Toutes les pages spécifiques
} else if ($spec) { // fin if ($id) else if ($deconpro)
       
/* ************* Page spécifique contact.php du site public pour envoyer un courriel **************************************************************** */
 if ($spec=="contact") {
	if ($action=="seConnecter") {
		$client=new Client();
		$client->email=$textEmailCpte;
		$client->pwd=$textPwdCpte;
		$mes=$client->connecte();
		$client->numclient=$_SESSION['numclient'];
		$client->infosClient();
		if ($mes) $action="";
	}
	if ($textMess) {
		$leContact= new Contact();
		if($numcontact) $leContact->numcontact=$numcontact;
		else $leContact->numcontact="15";  //15 = siege social ifip
		$leContact->infosContact();
		
		$prenom=Majuscules(strip_tags($textPrenom));
		$nom=Majuscules(strip_tags($textNom));
		$societe=Majuscules(strip_tags($textSociete));
		$ville=Majuscules(strip_tags($textVille));
		$pays=utf8_encode(SelectSimple("pays","if_pays","numpays",$selectPays));
		$objet=Majuscules(strip_tags($textObjet));
		
		$corps.="Bonjour ".$leContact->prenom." ".$leContact->nom.",<br />";
		$corps.="Voici un message en provenance de ifip.asso.fr<br /><br />";
		$corps.="-------------------------------------------------------------<br />";
		$corps.="DEMANDEUR : ".$prenom." ".$nom."<br />";
		if ($societe) $corps.="SOCIETE / ORGANISME : ".$societe."<br />";
		if ($textAdr1) $corps.="ADRESSE : <br />".$textAdr1."<br />";
		if ($textAdr2) $corps.=$textAdr1."<br />";
		$corps.=$textCp." ".$ville."<br />".$pays."<br />";
		if ($textTel) $corps.="TEL : ".$textTel."<br />";
		if ($textFax) $corps.="FAX : ".$textFax."<br />";
		if ($textEmail) $corps.="email : ".$textEmail."<br />";
		$corps.="-------------------------------------------------------------<br />";
		$corps.=$textMess;
		
		//EnvoiMail($recipients,$From,$Bcc,$To,$ReturnPath,$ReplyTo,$Subject,$corps)
		if ($leContact->email) EnvoiMail($leContact->email,$prenom." ".$nom." <".($textEmail).">","",$leContact->email,$textEmail,$textEmail,$objet,$corps);
		EnvoiMail("henriette.cuny@croisix.net",$prenom." ".$nom." <".($textEmail).">","","henriette.cuny@croisix.net",$textEmail,$textEmail,$objet,$corps);
		$mes="Nous vous remercions pour votre message qui a bien été envoyé à ".$leContact->prenom." ".$leContact->nom;
		
	}	
	
/* ************* Page spécifique catalogue-ifip-institut-du-porc.php du site public pour ajouter une documentation au panier **************************************************************** */
} else if ($spec=="catalogue-ifip-institut-du-porc") {
	/* *if ($numdoc && $textQte) {
		$laDoc=new Documentation();
		$laDoc->numpara=$numdoc;
		$laDoc->infosDoc();
		$ajoutPanier= new Panier();
		if ($_SESSION['numcom']) $ajoutPanier->numcom=$_SESSION['numcom'];
		$ajoutPanier->ajouterArticle($numdoc,$textQte,$laDoc->reference,$laDoc->tarif);
		if (!$_SESSION['numcom'])  $_SESSION['numcom']=$ajoutPanier->numcom;
		$spec="panier-ifip-institut-du-porc";
	}* */

/* ************* Page spécifique panier-ifip-institut-du-porc.php du site public pour visualiser le panier **************************************************************** */
} else if ($spec=="panier-ifip-institut-du-porc") {
	/* ***************** ETAPE 1 ************************************************************** */
	
	if ($numdoc && $textQte && !$action) {
		$laDoc=new Documentation();
		$laDoc->numpara=$numdoc;
		$laDoc->infosDoc();
		
		$ajoutPanier= new Panier();
		if ($_SESSION['numcom']) $ajoutPanier->numcom=$_SESSION['numcom'];
		for ($i=0;$i<1;$i++) $ajoutPanier->ajouterArticle($numdoc,"Achat documentation",$textQte,$laDoc->reference,$laDoc->tarif,0);
		if (!$_SESSION['numcom'])  $_SESSION['numcom']=$ajoutPanier->numcom;
		
 
 	} else if ($supArt) {// On supprime un article du panier
		$supPanier=new Panier();
		$supPanier->numdetail=$supArt;
		$supPanier->supprimerArticle();
		
	} else if ($action=="maj") {//on met à jour la quantité d'articles dans le panier
		$modifPanier=new Panier();
		$modifPanier->numcom=$_SESSION['numcom'];
		$list_art=$modifPanier->listerArticles();
		for ($i=0;$i<count($list_art);$i++) {
			$article=$list_art[$i];
			$modifQte="textQte".$article["numdetail"];
			$modifPanier->numdetail=$article["numdetail"];
			$modifPanier->miseAJourQteArticle($$modifQte);
		}
		$mes="Votre panier a été mis à jour";
	
	} else if ($action=="confirmerCom") {//clic sur bouton Etape2
		$laCom= new Commande();
		$laCom->numcom=$_SESSION['numcom'];
		if (!$prix) {//Ce n'est pas un article créé à la volée
			$laCom->pays=$selectPays;
			$laCom->modifierPays();
		}
		//if ($_SESSION['numclient']) $etape=3; else $etape=2;
		//if (($prix &&!$_SESSION['numclient'])  || !$_SESSION['numclient']) $etape=2; else $etape=3;
		if (!$_SESSION['numclient']) $etape=2;
		else if ($_SESSION['numclient'] && $prix) { unset($_SESSION['numclient']); $etape=2;}
		else $etape=3;

	/* ***************** ETAPE 2 ******************************************************************** */	
	} else if ($action=="seConnecter") {// Connexion du client
		$client=new Client();
		$client->email=$textEmailCpte;
		$client->pwd=$textPwdCpte;
		$mes=$client->connecte();

		if (!$mes) {
			$client->infosClient();
			if (!$prix) {//Ce n'est pas un article créé à la volée
				$etape=3;		
			} else {//C'est un article créé à la volée => redirection vers le choix du paiement
				$lePanier=new Panier();
				$lePanier->numcom=$_SESSION['numcom'];
				
				$laCom=new Commande();
				$laCom->numcom=$_SESSION['numcom'];
				$laCom->numclient=$_SESSION['numclient'];
				$laCom->modifierCommande(); //association de la commande au client
				$etape=4;
				
			}//fin if ($prix)
		} else {
			  $etape=2;
		}
	} else if ($action=="creerCompte") {// Créer compte du client
		$client=new Client();
		$client->raison=$textSociete;
		$client->nom=$textNom;
		$client->prenom=$textPrenom;
		$client->civilite=$selectCiv;
		$client->adr1=$textAdr1;
		$client->adr2=$textAdr2;
		$client->cp=$textCp;
		$client->ville=$textVille;
		$client->pays=$selectPays;
		$client->tel=$textTel;
		$client->fax=$textFax;
		$client->email=$textEmail;
		$client->pwd=$textPwd;
		$client->actif="o";
		$mes=$client->creerClient();
		if (!$mes) {
			$client->connecte();
			$client->infosClient();
			if (!$prix) {//Ce n'est pas un article créé à la volée
				$etape=3;
			} else {//C'est un article créé à la volée => redirection vers choix du paiement
				$lePanier=new Panier();
				$lePanier->numcom=$_SESSION['numcom'];
				
				$laCom=new Commande();
				$laCom->numcom=$_SESSION['numcom'];
				$laCom->numclient=$_SESSION['numclient'];
				$laCom->modifierCommande(); //association de la commande au client
				$etape=4;
				
				// Insérer ici redirection vers la banque 
				
				/* * En retour de banque:
				1. Utiliser la méthode $laCom->validerCommandeCB($CHAMP200,$CHAMP901,$CHAMP904,$CHAMP201) de l'objet Commande pour modifier la commande dans la BD 
				2. Envoyer un mail au client - le mail peut être envoyé directement dans la méthode validerCommandeCB() de l'objet Commande ou bien dans l'objet Client (méthode à créer)
				3. Envoyer un mail à l'admin IFIP
				4. unset($_SESSION['numcom']);
				* */
			}//fin if ($prix)
		}
	/* ***************** ETAPE 3 ******************************************************************** */	
	} else if ($action=="validerLivraison") {// Valide les infos sur la livraison et la Facturation
		$laCom= new Commande();
		$laCom->numclient=$_SESSION['numclient'];
		$laCom->numcom=$_SESSION['numcom'];
		$numpays=$laCom->getNumPays();
		$laCom->modifierCommande(); //association de la commande au client
		
		$leClient=new Client();
		$leClient->numclient=$_SESSION['numclient'];
		
		$laCom->nom_f=$textNom_f;
		$laCom->prenom_f=$textPrenom_f;
		$laCom->tel_f=$textTel_f;
		$laCom->fax_f=$textFax_f;
		$laCom->raison_f=$textSociete_f;
		$laCom->adr1_f=$textAdr1_f;
		$laCom->adr2_f=$textAdr2_f;
		$laCom->cp_f=$textCp_f;
		$laCom->ville_f=$textVille_f;
		$laCom->pays_f=$selectPays_f;
		
		/* On ne met plus à jour les infos du client a partir des infos de facturation
		$leClient->nom=$textNom_f;
		$leClient->prenom=$textPrenom_f;
		$leClient->tel=$textTel_f;
		$leClient->fax=$textFax_f;
		$leClient->raison=$textSociete_f;
		$leClient->adr1=$textAdr1_f;
		$leClient->adr2=$textAdr2_f;
		$leClient->cp=$textCp_f;
		$leClient->ville=$textVille_f;
		$leClient->pays=$selectPays_f;
		
		$leClient->actif="o";
		$leClient->modifierClient();
		*/
		
		$laCom->nom_l=$textNom_l;
		$laCom->prenom_l=$textPrenom_l;
		$laCom->tel_l=$textTel_l;
		$laCom->fax_l=$textFax_l;
		$laCom->raison_l=$textSociete_l;
		$laCom->adr1_l=$textAdr1_l;
		$laCom->adr2_l=$textAdr2_l;
		$laCom->cp_l=$textCp_l;
		$laCom->ville_l=$textVille_l;
		$laCom->pays_l=$selectPays_l;
		
		if ($numpays!=$selectPays_l) {
			$laCom->pays=$selectPays_l;
			$laCom->modifierPays();
		}
		$laCom->enregistrerLivraison(); //enregistrement des infos de livraison facturation
		
		//la commande se transforme eventuellement en demande de devis
		$lePanier=new Panier();
		$lePanier->numcom=$_SESSION['numcom'];
		$lePanier->pays=$laCom->getNumPays();
		$lePanier->infosPanier();
		if ($lePanier->pays!="247" && $lePanier->totalPoids!="0,00") {
			$laCom->montantHT=$lePanier->totalHT;
			$laCom->montantTTC=$lePanier->totalTTC;
			$laCom->fraisPort=$lePanier->fraisPort;
			$laCom->totalPoids=$lePanier->totalPoids;
			$montantDevis=$lePanier->totalTTC;
			
			$laCom->enregistrerDemandeDevis();
				
			//envoi du mail de demande de devis
			$clientValide=new Client();
   			$clientValide->numclient=$_SESSION['numclient'];
   			$clientValide->infosClient(); 
											
			EnvoiMailDevis($_SESSION['numcom'],$clientValide->email,$montantDevis);
			$etape=6;
		} else $etape=4;// !!!IMPORTANT : cette variable va modifier l'action du form general qui va aller vers paiement.php
						// 				  au lieu de index.php comme pour les autres etapes
		
	/* ***************** ETAPE 4 ******************************************************************** */	
	} else if ($trans) { // attention, la partie ci-dessous s'execute apres lecture de paiement.php		
		// On est oblige a cause du fonctionnement specifique au Credit Agricole (lancement de leur exécutable)
		
			if($auto) { // règlement par cb, si il y a un numero d'autorisation
			
			// VERIFICATION DE LA SIGNATURE DU PAIEMENT		
		
			//require("pbxtestsign.lib.php");
			//$CheckSig = pbxtestsign($auto,"pubkey.pem");
				
			//if( $CheckSig == 1 ) { //la signature du paiement est bonne, il s'agit bien de e-transaction
			
			
			// pour eviter d'envoyer le mail 2 fois en cas de retour sur le site
			//on recupere le numbq pour voir si la transaction a deja ete enregistree dans la base
			// si c'est le cas pas besoin d'enregistrer une 2eme fois et d'envoyer le mail une 2eme fois	
			 $numbq=SelectSimple("numbq","if_bo_bq","numcom",$ref,"");
			 
			 if($numbq=="") {
				$laComValide= new Commande();
				$laComValide->numcom=$ref;			
				$laComValide->etat="2";
				$laComValide->numerop=$trans;
				$laComValide->auto=$auto;
				$laComValide->montant=$montant;
				$laComValide->validerCommandeCBBanque();//enregistrement dans la table banque
															
				$clientValide=new Client();
   				$clientValide->numclient=SelectSimple("numclient","if_bo_com","numcom",$ref,"");
   				$clientValide->infosClient(); 
											
				EnvoiMailCommande($laComValide->numcom,$clientValide->email,'o');											
																						
				$pageSpecMonCompte=new Page();
				$pageSpecMonCompte->pageSpecifique("compte-ifip");
			 }
		//}  else { // la signature n'est pas bonne, donc bug ou piratage
			//echo "clé invalide";
			/*$laComValide= new Commande();
			$laComValide->numcom=$_SESSION['numcom'];
			$laComValide->numclient=$_SESSION['numclient'];		
											
			$clientValide=new Client();
   			$clientValide->numclient=$_SESSION['numclient'];
   			$clientValide->infosClient(); 
											
			EnvoiMailCommande($laComValide->numcom,$clientValide->email,'');
			$laComValide->supprimerCommande();		
		}*/
			
			} else { // fin if ($auto)
					$laComValide= new Commande();
					$laComValide->numcom=$ref;		
											
					$clientValide=new Client();
   					$clientValide->numclient=SelectSimple("numclient","if_bo_com","numcom",$ref,"");
   					$clientValide->infosClient(); 
											
					EnvoiMailCommande($laComValide->numcom,$clientValide->email,'');
					//$laComValide->supprimerCommande();
					$laComValide->erreur="oui";
					$laComValide->validerCommandeCBErreur();		
			}
		//Les infos concernant le panier (total du panier HT, total du panier TTC) sont dans l'objet Panier (classe Panier.inc.php) pour les docs et dans l'objet Commande (classe Commande.inc.php pour les formations) - voir Reglement par chèque ci- dessous
			
			/* * Achat de docs
			$lePanier=new Panier();
			$lePanier->numcom=$_SESSION['numcom'];
			$lePanier->infosPanier();
			$montantHT=lePanier->totalHT;
			$montantTTC=$lePanier->totalTTC;
			$laCom= new Commande();
			$laCom->numcom=$_SESSION['numcom'];
			$laCom->numclient=$_SESSION['numclient'];
			$laCom->montantTTC=$montantTTC;
			$laCom->montantHT=$montantHT;
			$laCom->fraisPort=lePanier->fraisPort;
			etc...
			* */
			
			/* * Réglement de la formation = if ($forma)
			$laCom= new Commande();
			$laCom->numclient=$_SESSION['numclient'];
			$laCom->numcom=$_SESSION['numcom'];
			$laCom->infosCommande();
			$montantTTC=$laCom->montantTTC;
			etc..
			* */
			
			/* * Les infos concernant le client sont dans l'objet Client (classe Client.inc.php)
			$leClient->numclient=$_SESSION['numclient'];
			$leClient->infosClient();
			$leClient->nom;
			$leClient->prenom;
			$leClient->$raison;
			etc...
			* */
			
			// Insérer ici redirection vers la banque 
			
			/* * En retour de banque:
			1. Utiliser la méthode $laCom->validerCommandeCB($CHAMP200,$CHAMP901,$CHAMP904,$CHAMP201) de l'objet Commande pour modifier la commande dans la BD 
			2. Envoyer un mail au client - le mail peut être envoyé directement dans la méthode validerCommandeCB() de l'objet Commande ou bien dans l'objet Client (méthode à créer)
			3. Envoyer un mail à l'admin IFIP
			4. unset($_SESSION['numcom']);
			* */	
			
	} else if ($action=="validerReg"){//règlement par chèque ou virement (dans panier-ifip transmis dans paiement.php)
			
			if ($radioReg=="ch" || $radioReg=="vi") {
				$laCom= new Commande();
				$laCom->numclient=$_SESSION['numclient'];
				$laCom->numcom=$_SESSION['numcom'];
			
			
				if ($forma) {//Le client règle une formation suite au mail reçu par l'admin
					$laCom->infosCommande();
					$montantCh=$laCom->montantTTC;
					//$laCom->montantTTC=$laCom->montantTTC; // modif julien decembre 2009
					if ($radioReg=="ch") $laCom->validerCommandeCheque();
					else if ($radioReg=="vi") $laCom->validerCommandeVirement();//ajout HC janvier 2010 : paiement par virement
					
				} else {//Le client règle des docs (ouvrage,article, etc...)
					$numpays=$laCom->getNumPays();
					$lePanier=new Panier();
					$lePanier->numcom=$_SESSION['numcom'];
					$lePanier->pays=$numpays;
					$lePanier->infosPanier();
					$laCom->montantHT=$lePanier->totalHT;
					$laCom->montantTTC=$lePanier->totalTTC;
					$laCom->fraisPort=$lePanier->fraisPort;
					$montantCh=$lePanier->totalTTC;
				
					//envoi du mail de confirmation de commande
					$clientValide=new Client();
   					$clientValide->numclient=$_SESSION['numclient'];
   					$clientValide->infosClient(); 
					
					if ($radioReg=="ch") $laCom->validerCommandeCheque();
					else if ($radioReg=="vi") $laCom->validerCommandeVirement();
											
					if ($radioReg=="ch") EnvoiMailCommandeCheque($_SESSION['numcom'],$clientValide->email,$montantCh);
					else if ($radioReg=="vi") EnvoiMailCommandeVirement($_SESSION['numcom'],$clientValide->email,$montantCh);
				
				}
			
				
				$etape=4;
			} //fin du if radioreg=ch
		//}
	
	}

/* ************* Page spécifique formation-inscription.php du site public pour s'inscrire à une formation **************************************************************** */
} else if ($spec=="formation-inscription") {
	if ($action=="seConnecter") {
		$client=new Client();
		$client->email=$textEmailCpte;
		$client->pwd=$textPwdCpte;
		$mes=$client->connecte();
		$client->numclient=$_SESSION['numclient'];
		$client->infosClient();
		if ($mes) $action="";
		
	} else if ($action=="creerCompte") {
		$client=new Client();
		$client->civilite=$selectCiv;
		$client->nom=$textNom;
		$client->prenom=$textPrenom;
		$client->raison=$textSociete;
		$client->adr1=$textAdr1;
		$client->adr2=$textAdr2;
		$client->cp=$textCp;
		$client->ville=$textVille;
		$client->pays=$selectPays;
		$client->tel=$textTel;
		$client->fax=$textFax;
		$client->email=$textEmail;
		$client->pwd=$textPwd;
		$client->actif="o";

		$mes=$client->creerClient();
		if ($mes) $action="";
		
	} else if ($action=="sinscrire") {
		$leClient=new Client();
		$leClient->numclient=$_SESSION['numclient'];
		$leClient->infosClient();//infos du client pour ne pas écraser nom, prénom, civilité
		$leClient->raison=$textRaison;
		$leClient->adr1=$textAdr1;
		$leClient->adr2=$textAdr2;
		$leClient->cp=$textCp;
		$leClient->ville=$textVille;
		$leClient->pays=$selectPays;
		$leClient->tel=$textTel;
		$leClient->gsm=$textGsm;
		$leClient->fax=$textFax;
		if ($textAutreFonct) $leClient->fonction=$textAutreFonct; else $leClient->fonction=$radioFonct;
		$leClient->modifierClient();
		
		$laForma=new Formation();
		$laForma->numpara=$numpara;
		$laForma->infosFormation();
		$ajoutPanier= new Panier();
		$ajoutPanier->numclient=$_SESSION['numclient'];
		$ajoutPanier->ajouterArticle($numpara,"Inscription formation","1",$laForma->titrePara,"");
		if ($checkVeille) $ajoutPanier->ajouterArticle($numpara,$checkVeille,"1",$laForma->titrePara,"");
		if ($checkDiner) $ajoutPanier->ajouterArticle($numpara,$checkDiner,"1",$laForma->titrePara,"");
		if ($checkPendant) $ajoutPanier->ajouterArticle($numpara,$checkPendant,"1",$laForma->titrePara,"");
		if ($textPedag && $textPedagTva) $ajoutPanier->ajouterArticle($numpara,"facturer pédagogie à ".$textPedag." tva=".$textPedagTva,"1",$laForma->titrePara,"");
		if ($textHeberg && $textHebergTva) $ajoutPanier->ajouterArticle($numpara,"facturer hébergement à ".$textHeberg." tva=".$textHebergTva,"1",$laForma->titrePara,"");
		
		//On avertit l'administrateur de l'inscription
		$laForma->numclient=$_SESSION['numclient'];
		$laForma->avertirAdmin();
	}

/* ************* Page spécifique extranet-pro.php du site public pour s'inscrire à l'espace professionnel **************************************************************** */
} else if ($spec=="extranet-pro") {
	if ($action=="seConnecter") {
		$leProf= new Client();
		$leProf->email=$textEmailCpte;
		$leProf->pwd=$textPwdCpte;
		$leProf->professionnel="o";
		$mes=$leProf->connecte();
		$leProf->numclient=$_SESSION['numprof'];
		$leProf->infosClient();
		
		if ($numdoc) {// L'utilisateur vient de la Base Documentaire Ifip, le document est en accès réservé aux professionnels et il est payant => après connexion, il sera redirigé vers le panier
			//Modif HC juillet 2009, il n'y a plus de redirection vers le panier afin que le pro puisse consulter le resume
			$numpara=$numdoc; //on repart sur numpara car c'est ce qui permet l'affichage du detail d'une doc
			/*
			$laDoc=new Documentation();
			$laDoc->numpara=$numdoc;
			$laDoc->infosDoc();
			$ajoutPanier= new Panier();
			if ($_SESSION['numcom']) $ajoutPanier->numcom=$_SESSION['numcom'];
			$ajoutPanier->ajouterArticle($numdoc,"Achat documentation",1,$laDoc->reference,$laDoc->tarif);
			if (!$_SESSION['numcom'])  $_SESSION['numcom']=$ajoutPanier->numcom;
			$pageSpec=new Page();
			$pageSpec->pageSpecifique("panier-ifip-institut-du-porc.php");
			$spec=$pageSpec->nomFichier;
			$numrub=$pageSpec->numrub;
			$numcateg=$pageSpec->numcateg;
			$numsscateg=$pageSpec->numsscateg;
			$numpage=$pageSpec->numpage;
			*/
		}
		
	}

/* ************* Page spécifique compte-ifip.php du site public pour accéder à son compte ou s'inscrire **************************************************************** */
} else if ($spec=="compte-ifip") {
	if ($action=="seConnecter") {
		$client=new Client();
		$client->email=$textEmailCpte;
		$client->pwd=$textPwdCpte;
		$mes=$client->connecte();
		$client->numclient=$_SESSION['numclient'];
		$client->infosClient();
		if ($mes) $action="";
	}  else if ($action=="creerCompte") {
		$client=new Client();
		$client->civilite=$selectCiv;
		$client->nom=$textNom;
		$client->prenom=$textPrenom;
		$client->raison=$textSociete;
		$client->adr1=$textAdr1;
		$client->adr2=$textAdr2;
		$client->cp=$textCp;
		$client->ville=$textVille;
		$client->pays=$selectPays;
		$client->tel=$textTel;
		$client->fax=$textFax;
		$client->email=$textEmail;
		$client->pwd=$textPwd;
		$client->actif="o";

		$mes=$client->creerClient();
		if ($mes) $action="";
		
	} 
/* ************* Page spécifique compte-ifip.php du site public pour accéder à son compte ou s'inscrire **************************************************************** */
} else if ($spec=="compte-ifip-profil") {
	if ($action=="modifierCompte") {
		$modifClient = new Client();	
		$modifClient->raison=$textSociete;
		$modifClient->civilite=$selectCiv;
		$modifClient->nom=$textNom;
		$modifClient->prenom=$textPrenom;
		$modifClient->fonction=$textFonction;
		$modifClient->adr1=$textAdr1;
		$modifClient->adr2=$textAdr2;
		$modifClient->cp=$textCp;
		$modifClient->ville=$textVille;
		$modifClient->pays=$selectPays;
		$modifClient->tel=$textTel;
		$modifClient->fax=$textFax;
		$modifClient->email=$textEmail;
		//$modifClient->pwd=$textPwd;
		$modifClient->actif="o";
		$modifClient->numclient=$_SESSION['numclient'];
	    
		$modifClient->modifierClient();
   
  }
	
/* ************* Page spécifique oublie.php du site public pour mot de passe oublié **************************************************************** */
} else if ($spec=="oublie") {
	if ($textLoginOublie) {
		$oubliClient= new Client();
		$oubliClient->email=$textLoginOublie;
		if ($type=="accespro") $oubliClient->professionnel="o";
		$mes=$oubliClient->envoyerPwd();
		
		if ($prix) {//cas d'un article crée à la volée (l'utilisateur vient de la page panier-ifip-institut-du-porc.php)
			$pageSpec=new Page();
			$pageSpec->pageSpecifique("panier-ifip-institut-du-porc");
			$spec=$pageSpec->nomFichier;
			$numrub=$pageSpec->numrub;
			$numcateg=$pageSpec->numcateg;
			$numsscateg=$pageSpec->numsscateg;
			$numpage=$pageSpec->numpage;
			$etape=2;
		}
	}
	      
} //fin if ($spec=="oublie") 

} else if ($t6mpnh) { // fin if ($spec) => lien direct vers le panier pour l'inscription définitive à la formation (ce lien apparait dans le mail envoyé au client lorque l'admin a validé les dates de la formation sur mesure (méthode validerForma($url) de l'objet Formation)
    
		
	$args=explode("&",base64_decode($t6mpnh));
	foreach($args as $arg) {
		$parts=explode("=",$arg);
		if ($parts[0]=="lien") $lien=$parts[1]; else if ($parts[0]=="email") $email=$parts[1]; else if ($parts[0]=="pwd") $pwd=$parts[1];
	} 
	
	$leClient= new Client();
	$leClient->email=$email;
	$leClient->pwd=$pwd;
	$numcli=$leClient->getNumclient();
	
	$laCom= new Commande();
	$laCom->numcom=$lien;
	$laCom->infosCommande();
	if ($numcli==$laCom->numclient) {//on vérifie que la commande correspond bien au client
		$_SESSION['numcom']=$lien;
		
		//Connexion du client à son compte
		$leClient->connecte();
		
		//Redirection vers le panier
		$pageSpec=new Page();
		$pageSpec->pageSpecifique("panier-ifip-institut-du-porc");
		$spec=$pageSpec->nomFichier;
		$numrub=$pageSpec->numrub;
		$numcateg=$pageSpec->numcateg;
		$numsscateg=$pageSpec->numsscateg;
		$numpage=$pageSpec->numpage;
		$etape=4;//Réglement
	} else {
		$mes="Désolé, vous ne pouvez pas vous connecter à votre compte !";
	}
} else if ($numarticle) {// => lien direct vers le panier pour régler un article 
	
	if ($prix) {		
		//Infos sur l'article
		$arti= new Article();
		$arti->numarticle=$numarticle;
		
		if ($arti->infosArti()) {
				
			//On ajoute au panier
			$ajoutPanier= new Panier();
			$ajoutPanier->ajouterArticle($numarticle,$arti->libelle,"1","",$prix,"1");
					  
			//Redirection vers le panier
			$pageSpec=new Page();
			$pageSpec->pageSpecifique("panier-ifip-institut-du-porc");
			$spec=$pageSpec->nomFichier;
			$numrub=$pageSpec->numrub;
			$numcateg=$pageSpec->numcateg;
			$numsscateg=$pageSpec->numsscateg;
			$numpage=$pageSpec->numpage;
		} else {
			$mes="Désolé, cet article n\'existe plus !";
			$accueilP=new Page();
			$accueilP->lg=$lg;
			$numpage=$accueilP->rechercherAccueil();
			$spec="includes/home";
		}
	} else {//pas de prix dans l'url
		$accueilP=new Page();
		$accueilP->lg=$lg;
		$numpage=$accueilP->rechercherAccueil();
		$spec="includes/home";
	}
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
<?php

if ($numpage) {//$numpage est initialise par la regle d'ecriture dans .htaccess (accueil : numpage=86)
    $accueilPage=new Page();
	$accueilPage->lg=$lg;
	$numpage_accueil=$accueilPage->rechercherAccueil();
	if  ($numpage_accueil==$numpage && !$pg_admin) {
		$accueilPage->numpage=$numpage;
		$accueilPage->infosPage();
		echo $accueilPage->nomPageGoogle;
		$accueil=1;
	} else {
		$titrePage = new Page();
		$titrePage->numpage=$numpage;
		$titrePage->infosPage();
		echo $titrePage->nomPageGoogle;
	}
} 

?>
</title> 
<META NAME="keywords" CONTENT="<?php if ($numpage && $accueil) echo $accueilPage->keywPage; else if ($numpage) echo $titrePage->keywPage;?>">
<META NAME="description" CONTENT="<?php if ($numpage && $accueil) echo $accueilPage->descrPage; else if ($numpage) echo $titrePage->descrPage; ?>">
<!-- Lien vers feuille de style pour Dreamweaver qui ne gere pas bien le inlude("styles.php") -->
<link rel="stylesheet" href="css/ifip.css" type="text/css" media="screen" />
<link rel="shortcut icon" href="http://www.ifip.asso.fr/favicon.ico" />
<?php 
include ("javascript.php");   
include ("styles.php");
?>	 
</head>

<body>
<form action="
	<? 
	// changement de l'action du form au moment du choix de paiement
	
	if ($etape=="4") { 										 
	?>
	paiement.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&spec=<?=$spec?>&numpage=<?=$numpage?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&cont=<?=$cont?>&lg=<?=$lg?>&action=<?=$action?>
	<? 
	} else { 
	?>
	index.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&spec=<?=$spec?>&numpage=<?=$numpage?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&cont=<?=$cont?>&lg=<?=$lg?>
	<? 
	} 
	?>" name="testform" method="post" class="adminform" enctype="multipart/form-data">

<!-- menu principal Zone 2 (zone1 traite dans header.php et homeheadr.php-->
<div id="menugeneral">
<ul id="MenuBarTop" class="MenuBarHorizontal">

			<?php
			//rubriques principales (zone 2)
			$listrub=new ListeMenus(); 	  
			$listrub->type="rubrique";
			$listrub->nomkey="numrub";
			$listrub->zone="2";	  
			$listrub->lg=$lg;
			$listrub->afficherListeMenus();	  
			foreach ($listrub as $menus) {				
			?>
			
				<li><a href="<?php if ($id) echo "index.php?id=$id&cnx=$cnx&pg_admin=content&numpage=$menus->numpage&numrub=$menus->nummenu&onglet=voir"; else echo $menus->url;?>" class="<? if ($menus->nummenu==$numrub) echo"actif";?>"><?php echo $menus->nomMenu;?></a>
	
			<?php
				//Categories
				$listcategmenu=new ListeMenus(); 	  
				$listcategmenu->type="categorie";
				$listcategmenu->nomkey="numcateg";
				$listcategmenu->zone="3";
				$listcategmenu->numfkey=$menus->nummenu; // c'est le numrub de ce menu
				$listcategmenu->lg=$lg;  
				$listcategmenu->afficherListeMenus();
			?>
				<ul>
			<?php	
				foreach ($listcategmenu as $menus) {
					$numcatmenu=$menus->nummenu;
			?>
					
					<li>
					<a href="<?php if ($id) echo "index.php?id=$id&cnx=$cnx&pg_admin=content&numpage=$menus->numpage&numrub=$menus->nummenu&numcateg=$numcatmenu&onglet=voir"; else echo $menus->url;?>" class="MenuBarItemSubmenu"><?=$menus->nomMenu?></a>
					</li>
					
			<?php
				} // fin du foreach (categ)	
			?>
					</ul>
				</li>
			<?php
			} //fin du foreach
			?>
		</ul> 
</div>
<!-- fin du menu principal -->

<div id="container">
<!-- debut header -->
<?php if ($numpage && $accueil) { // c'est la page d'accueil du site (en FR ou en EN) ?>
<div id="indexHeader" class="line"><?php include ("includes/homeheader.php"); ?></div>
<?php } else { // les autres pages ?>
<div id="header" class="line"><?php include ("includes/header.php"); ?></div>
<?php } ?>
<!-- end of header -->



<!-- breadcrumbs = chemin -->
<?php 
if (!$accueil) { // pas de chemin en page d'accueil
?>
	<div class="line">	  	
		  <div class="item" id="breadcrumbs">
			<div class="sap-content">
			<?php
			//var_dump ($get_array );
			//bouton de deconnexion de la session
			if ($_SESSION["numclient"]) {
			?>
			<div class="breadcrumbs" style="float:right;width:150px;text-align:right;padding-right:15px;" ><a href="index.php?spec=<?=$spec?>&numpage=<?=$numpage?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&lg=<?=$lg?>&deconclient=o" class="deconnexion">Se déconnecter</a></div>
			<?php
			}
			?>
			<div><p class="breadcrumbs"><a href="<?=$pageAccueil->url?>">Accueil Ifip</a> > <!--rubrique > sous rubrique > page-->
			<?php
			if ($numrub) {
				$menuRub=new Menu();
				$menuRub->type="rubrique";
				$menuRub->nomkey="numrub";
				$menuRub->nummenu=$numrub;
				$menuRub->infosMenu();
				echo "<a href='".$menuRub->url."'>".$menuRub->nomMenu."</a> ";
				if ($numcateg) echo "> ";
			}
			
			if ($numcateg) {
				$menuCat=new Menu();
				$menuCat->type="categorie";
				$menuCat->nomkey="numcateg";
				$menuCat->nummenu=$numcateg;
				$menuCat->infosMenu();
				echo "<a href='".$menuCat->url."'>".$menuCat->nomMenu."</a> ";
				if ($numsscateg) echo "> "; 
			}
			
			if ($numsscateg) {
				$menuSscat=new Menu();
				$menuSscat->type="sscateg";
				$menuSscat->nomkey="numsscateg";
				$menuSscat->nummenu=$numsscateg;
				$menuSscat->infosMenu();
				echo "<a href='".$menuSscat->url."'>".$menuSscat->nomMenu."</a>";
			}
			?>
			</p>
				</div>
				</div>
		  </div>
	</div>
<?php
}//fin if (!$accueil) 
?>


<!-- accueil - notez que l'on n'encadre pas par une div class="line" car il y a 2 div line dans home.php -->
<?php 
if ($accueil) {
	if ($pg_admin && file_exists("admin/".$pg_admin.".php")) include ("admin/".$pg_admin.".php"); 
	else if ($spec && file_exists($spec.".php")) include ($spec.".php"); else include ("includes/page.php");  
}

?>

<!-- les autres pages -->
<?php
if (!$accueil) {
?>
<div class="line">

		<!-- the left menu column -->
		<div class="item" id="menu_gauche">
			 <?php include ("includes/menu.php"); ?>
		</div>

	<!-- the content : les div class="item" sont dedans -->
	<?php
	if ($pg_admin && file_exists("admin/".$pg_admin.".php")) include ("admin/".$pg_admin.".php"); 
	else if ($spec && file_exists($spec.".php")) include ($spec.".php"); else include ("includes/page.php");    
	?>																																				<!---fin div class="line"--->    
</div> 

<?php
}//fin if (!$accueil)
?>

<!-- the footer -->
<div class="line">
	<div id="footer" class="item">
		<div class="sap-content">
 		 <?php include ("includes/footer.php"); ?>
		</div>
	</div>
</div>

<!-- fin container -->
</div> 
<input type="hidden" name="numdoc" value="<?=$numdoc?>" />
<input type="hidden" name="moteur_rech" /><!-- indique que l'on recherche un ou plusieurs mots dans le moteur de recherche du site public - valeur possible "1"-->
</form>
<!-- gestion des onglets et du menu general par Spry -->
<script language="JavaScript" type="text/javascript">
<?php  
if ($pg_admin=="content") {
?>
	var tp1 = new Spry.Widget.TabbedPanels("tp1", { defaultTab: <? if ($onglet=="voir") echo"0";  else if ($onglet=="mod_page") echo"1"; else if ($onglet=="mod_para") echo"2"; else if ($onglet=="aj_para") echo"3"; else echo"0";?> });
<?php
}  
if ($onglet=="mod_para") {
?>
	var Acc0= new Spry.Widget.Accordion("Acc0", { useFixedPanelHeights: false, defaultPanel: -1 });
<?php
}
 
if ($cpt_acc) {	  
if ($cpt_acc>1) $cpt_acc=$cpt_acc-1;
?>
	 //var Acc1 = new Spry.Widget.Accordion("Acc1", { useFixedPanelHeights: false, defaultPanel: -1 }); 
<?php
	for ($i=1; $i<=$cpt_acc; $i++) {
?>
		var Acc<?=$i?> = new Spry.Widget.Accordion("Acc<?=$i?>", { useFixedPanelHeights: false, defaultPanel: -1 });
<?php
	} //fin du for
}//fin if ($cpt_acc) 
?>
	<!-- Menu general du site -->
	var MenuBarTop = new Spry.Widget.MenuBar("MenuBarTop", {imgDown:"", imgRight:""});
</script>
<!-- Google Analytics -->
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-1769043-13");
pageTracker._trackPageview();
} catch(err) {}</script>
</body>
<?php
if ($mes) {
echo"<script language=\"javascript1.2\"><!--\n";
echo"alert('$mes');\n";
echo"// --></script>";
}
?>
</html>
<?php
mysql_close();
?>
