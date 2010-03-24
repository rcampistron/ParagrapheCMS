<?php function ajouterPara() {
   	   	   $newParag=new Paragraphe();	
	  	   $newParag->titrePara=$_POST['textTitrePara'];
		   $newParag->contenuPara=$_POST['textCont'];
		   $numpara=$newParag->creerParagraphe();			   
		   $laPage=new Page();
		   $laPage->numpage=$_GET['numpage'];
		   $laPage->id_m=$_GET['id'];
		   $laPage->numpara=$numpara;
		   $laPage->ordre=$_POST['selectOrdre'];  
		   $laPage->colonne=$_POST['selectType'];
		   $laPage->liste=$_POST['radioListe'];
		   $laPage->typeTitre=$_POST['radioTypeTitre'];
		   $laPage->ajouterParagraphe();  // On l'ajoute à la page
		   
		   for ($i=1;$i<=$_POST['nbLiens'];$i++) { // On traite l'ajout de liens
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
	     
	   if (!$action) {//on est en création de page
	   		if (!$paragraphe) $pg_admin="lister-page";	else $creer_page=1;	   
	   } else {	//on est en modification de page
	   	    if (!$paragraphe) $onglet="mod_para"; else $onglet="aj_para";  
	   } 
}
    ?>