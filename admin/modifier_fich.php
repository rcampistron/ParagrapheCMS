<?php /* Date de création: 14/01/2009 */ 
include ("../connexion.php");
include ("../fonctions.php");
/*** Include des classes ****/	
require_once ("classes.php");

if ($action=="modif") {
	if ($numlien) {//modification du lien
		$modifLien=new Lien();
		$modifLien->numlien=$numlien;
		$modifLien->libLien=$textLibLien;
		$modifLien->texteLien=$textTexteLien;
		$modifLien->urlLien=$textUrlLien;
		$modifLien->fenLien=$radioFen; 
		$modifLien->ordreLien=$selectOrdreLien; 
		$modifLien->modifierLien();
		$mes="Le lien est modifié!";
		$fermer=1;
	
	} else if ($numfichier) {// modification du fichier
		
		$sauv_numfichier=$numfichier;		
		$modifParag=new Paragraphe();
		$modifParag->numparafichier=$numparafichier;
		//$modifParag->enleverFichier();
		
		 if ($selectFich || (isset($_FILES["fileFich"]['tmp_name']) && $_FILES["fileFich"]['tmp_name']!="")) {
				if ($selectFich) {// on associe un fichier existant
					  $modifParag->numfichier=$selectFich;
					  $newFichier=new Fichier();
					  $newFichier->numfichier=$selectFich;
					  $newFichier->infosFichier();
					  $nom_fichier=$newFichier->nomFichier; 
					  $modifParag->ordreFichier=$selectOrdreFich;
					  $modifParag->libFichier=$textLibFich;
					  $modifParag->modifierFichier(); 
				} else if (isset($_FILES["fileFich"]['tmp_name']) && $_FILES["fileFich"]['tmp_name']!="") { // on crée un fichier
				  $newFichier=new Fichier();
				  $nom_fichier=normaliza(basename($_FILES["fileFich"]['name']));
				  $newFichier->nomFichier=$nom_fichier;
				  $newFichier->tmp_name=$_FILES["fileFich"]['tmp_name'];
				  $newFichier->modif=1;// utile pour changer la valeur $chem="../"	
				  $numfichier=$newFichier->creerFichier();
				  
				  // On modifie ensuite le fichier du paragraphe
				  $modifParag->numfichier=$numfichier;
				  $modifParag->ordreFichier=$selectOrdreFich;
				  $modifParag->libFichier=$textLibFich;
				  $modifParag->modifierFichier(); 
				}
				
		 }//fin if ($selectFich || ...)
		
		$mes="Le fichier est modifié!";
		$fermer=1;
	
	} else if ($numphoto) {// modification de photo
		   	 
			 $sauv_numphoto=$numphoto;	 
			 $modifParag=new Paragraphe();
			 $modifParag->numparaphoto=$numparaphoto;
			 if ($selectPhoto || (isset($_FILES["filePhoto"]['tmp_name']) && $_FILES["filePhoto"]['tmp_name']!="")) {
					 if (isset($_FILES["filePhoto"]['tmp_name']) && $_FILES["filePhoto"]['tmp_name']!="") { // on crée une photo
					 
					  $newPhoto=new Photo();
					  $nom_photo=normaliza(basename($_FILES["filePhoto"]['name']));
					  $newPhoto->nomPhoto=$nom_photo;
					  $newPhoto->tmp_name=$_FILES["filePhoto"]['tmp_name'];
					  $newPhoto->taille=$radioTaille;
					  $newPhoto->modif=1;// utile pour changer la valeur $chem="../"
					  $numphoto=$newPhoto->creerPhoto();
					  
					  // On modifie ensuite la photo du paragraphe
					  $modifParag->numphoto=$numphoto;
					  $modifParag->ordrePhoto=$selectOrdrePhoto;
					  $modifParag->legPhoto=$textLegPh;
					  $modifParag->modifierPhoto(); 
					
					} else if ($selectPhoto) {// on associe une photo existante
						  $modifParag->numphoto=$selectPhoto;
						  $newPhoto=new Photo();
						  $newPhoto->numphoto=$selectPhoto;
						  $newPhoto->infosPhoto();
						  $nom_photo=$newPhoto->nomPhoto; 
						  $modifParag->ordrePhoto=$selectOrdrePhoto;
						  $modifParag->legPhoto=$textLegPh;
						  $modifParag->modifierPhoto(); 
					}
			 }//fin if ($selectPhoto || ...)
			 $mes="La photo est modifiée!";
			 $fermer=1;
			
	} else if ($numvideo) {// modification de vidéo
		   	 
			 $sauv_numvideo=$numvideo;	 
			 $modifParag=new Paragraphe();
			 $modifParag->numparavideo=$numparavideo;
			 if ($selectVideo || (isset($_FILES["fileVideo"]['tmp_name']) && $_FILES["fileVideo"]['tmp_name']!="")) {
					if ($selectVideo) {// on associe une vidéo existante
						  $modifParag->numvideo=$selectVideo;
						  $newVideo=new Video();
						  $newVideo->numvideo=$selectVideo;
						  $newVideo->infosVideo();
						  $nom_video=$newVideo->nomVideo; 
						  $modifParag->ordreVideo=$selectOrdreVideo;
						  $modifParag->legVideo=$textLegVi;
						  $modifParag->modifierVideo(); 
					} else if (isset($_FILES["fileVideo"]['tmp_name']) && $_FILES["fileVideo"]['tmp_name']!="") { // on crée une vidéo
					  $newVideo=new Video();
					  $nom_video=normaliza(basename($_FILES["fileVideo"]['name']));
					  $newVideo->nomVideo=$nom_video;
					  $newVideo->tmp_name=$_FILES["fileVideo"]['tmp_name'];
					  $newVideo->modif=1;// utile pour changer la valeur $chem="../"
					  $numvideo=$newVideo->creerVideo();
					  
					  // On modifie ensuite la vidéo du paragraphe
					  $modifParag->numvideo=$numvideo;
					  $modifParag->ordreVideo=$selectOrdreVideo;
					  $modifParag->legVideo=$textLegVi;
					  $modifParag->modifierVideo(); 
					}
			 }//fin if ($selectPhoto || ...)
			 $mes="La vidéo est modifiée!";
			$fermer=1;
	}//fin else if ($numphoto) 
}


if ($numlien) {
	$leLien=new Lien();
	$leLien->numlien=$numlien;
	$leLien->infosLien();
} else if ($numfichier) {
	$leFichier=new Fichier();
	$leFichier->numfichier=$numfichier;
	$leFichier->numparafichier=$numparafichier;
	$leFichier->infosFichier();
} else if ($numphoto) {
	$laPhoto=new Photo();
	$laPhoto->numphoto=$numphoto;
	$laPhoto->numparaphoto=$numparaphoto;
	$laPhoto->infosPhoto();
} else if ($numvideo) {
	$laVideo=new Video();
	$laVideo->numvideo=$numvideo;
	$laVideo->numparavideo=$numparavideo;
	$laVideo->infosVideo();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../css/ifip.css" type="text/css" media="screen" />	 
<script type="text/javascript" src="../java.js"> 	</script>
<title>Modification</title>
<?php 
include ("javascript.php");   
include ("styles.php");
?>
<script language="javascript1.2">
<?php
if ($fermer) {
	if ($numlien) {
?>
		var numlien="<?=$numlien?>";
		eval("window.opener.lien_id"+numlien+".innerText='<?=$textLibLien?>'");
		eval("window.opener.lien_name"+numlien+".href='<?=$textUrlLien?>'");
<?php
	} else if ($numfichier ) {//ce n'est pas une fiche associée à une formation, ni un fichier associé à une documentation
?>
		var numfichier="<?=$sauv_numfichier?>";
		eval("window.opener.fich_id"+numfichier+".innerText='<?=$nom_fichier?>'");
		eval("window.opener.fich_name"+numfichier+".href='fichiers/<?=$nom_fichier?>'");
<?php

	} else if ($numphoto) {
?>
		var numphoto="<?=$sauv_numphoto?>";
		eval("window.opener.ph_id"+numphoto+".innerText='<?=$nom_photo?>'");
		eval("window.opener.ph_name"+numphoto+".href='photos/<?=$nom_photo?>'");
<?php
	} else if ($numvideo) {
?>
		var numvideo="<?=$sauv_numvideo?>";
		eval("window.opener.vi_id"+numvideo+".innerText='<?=$nom_video?>'");
		eval("window.opener.vi_name"+numvideo+".href='videos/<?=$nom_video?>'");
<?php
	}
}//fin if ($fermer)
?>
</script>

</head>

<body class="popup" onload="<?php if ($fermer) echo "window.close();";?>">
<div id="container">
 <div id="pageadmin">
<form action="modifier_fich.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&spec=<?=$spec?>&numpage=<?=$numpage?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&cont=<?=$cont?>&lg=<?=$lg?>&action=modif" name="modifform" method="post" class="adminform" enctype="multipart/form-data">
<table width="100%">
	<tr>
		<td colspan="2">
		<fieldset>
		<legend>
		<?php
		if ($numlien) {
		?>
			Modification du lien
		<?php
		} else if ($numfichier) {
		?>
			Modification du fichier
		<?php
		} else if ($numphoto) {
		?>
			Modification d'une photo
		<?php
		}
		?>
		</legend>
		</fieldset>
		</td>
	</tr>
	<?php
	/*********************** Modification de lien **************************************************************/
	if ($numlien) {
	?>
		<tr>
			<td width="200">Libell&eacute; du lien :</td>
			<td><input id="lib" name="textLibLien" value="<?=$leLien->libLien?>"/> </td>
		</tr>
		<tr>
			<td>Texte du lien :</td>
			<td> <textarea name="textTexteLien"><?=$leLien->texteLien?></textarea></td>
		</tr>
		<tr>
			<td>Url du lien :</td>
			<td> <input id="url" name="textUrlLien" value="<?=$leLien->urlLien?>"/></td>
		</tr>
		<tr>
			<td>Ordre du lien :</td>
			<td>
				<select id="ordre" name="selectOrdreLien">
					<?php 
					for ($i=1; $i<=10; $i++) {	   
					?>
						<option value="<?=$i?>" <?php if ($leLien->ordreLien==$i) echo "selected='selected'";?>><?=$i?></option>
					<?php
					}
					?>
			  </select>
			</td>
		</tr>
		<tr>
			<td>Ouverture dans une nouvelle fenêtre ? :</td>
			<td> <input type="radio" id="radio" name="radioFen" value="o" <?php if ($leLien->fenLien=="o") echo "checked='checked'";?>><span class="radio">oui</span> 	<input type="radio" id="radio" name="radioFen" value="n" <?php if ($leLien->fenLien=="n") echo "checked='checked'";?>/> <span class="radio">non</span></td>
		</tr>
		<input type="hidden" name="numlien" value="<?=$numlien?>" />							
	<?php
	/*********************** Modification de fichier **************************************************************/
	} else if ($numfichier) {
		if (!$forma && !$doc) {//ce n'est pas une fiche formation, ni un fichier doc
	?>
	   <tr>
			<td>Libell&eacute; du fichier :</td>
			<td><input id="lib" name="textLibFich" value="<?=$leFichier->libFichier?>"/> </td>
		</tr>
		<?php
		}//fin if (!$forma) {//ce n'est pas une fiche formation 
		?>
		<tr>
			<td>Associer le fichier existant :</td>
			<td> 
				<select name="selectFich">	
					  <option></option>
					  <?php
						$listfichiers=new ListeFichiers(); 	   
						$listfichiers->afficherListeFichiers();
						foreach ($listfichiers as $fichiers) {
					  ?>
						   <option value="<?=$fichiers->numfichier?>" <?php if ($leFichier->numfichier==$fichiers->numfichier) echo "selected='selected'";?>><?=$fichiers->nomFichier?></option>
					  <?php
					  }//fin du foreach
					  ?> 
			  </select>	
			</td>
		</tr>
		<tr>
			<td>ou ajouter un fichier :</td>
			<td>  <input type="file" name="fileFich"  />	</td>
		</tr>
		<?php
		if (!$forma && !$doc) {//ce n'est pas une fiche formation ni un fichier doc
		?>
		<tr>
			<td>Ordre du fichier :</td>
			<td>
				<select id="ordre" name="selectOrdreFich">
					<?php 
					for ($i=1; $i<=10; $i++) {	   
					?>
						<option value="<?=$i?>" <?php if ($leFichier->ordreFichier==$i) echo "selected='selected'";?>><?=$i?></option>
					<?php
					}
					?>
			  </select>
			</td>
		</tr>
		<?php
		}//fin if (!$forma) {//ce n'est pas une fiche formation
		?>
		<input type="hidden" name="numfichier" value="<?=$numfichier?>" />	
		<input type="hidden" name="numparafichier" value="<?=$numparafichier?>" />
		<input type="hidden" name="forma" value="<?=$forma?>" />
		<input type="hidden" name="doc" value="<?=$doc?>" />
	<?php
	/*********************** Modification de photo **************************************************************/
	} else if ($numphoto) {
		if (!$doc) {//ce n'est pas un fichier doc
	?>
		<tr>
			<td>L&eacute;gende de la photo:</td>
			<td><input id="lib" name="textLegPh" value="<?=$laPhoto->legendePhoto?>"/> </td>
		</tr>
		<?php
		}//fin if (!$doc)
		?>
		<tr>
			<td>Associer la photo existante :</td>
			<td> 
				<select name="selectPhoto">	
					  <option></option>
					  <?php
						$listphotos=new ListePhotos(); 	   
						$listphotos->afficherListePhotos();
						foreach ($listphotos as $photos) {
					  ?>
						   <option value="<?=$photos->numphoto?>" <?php if ($laPhoto->numphoto==$photos->numphoto) echo "selected='selected'";?>><?=$photos->nomPhoto?></option>
					  <?php
					  }
					  ?>
			  </select>	
			</td>
		</tr>
		<tr>
			<td>ou ajouter une photo :</td>
			<td>  <input type="file" name="filePhoto"  />	</td>
		</tr>
		<?php
		if (!$doc) {//ce n'est pas un fichier doc
		?>
		<tr>
			<td>Ordre de la photo :</td>
			<td>
				<select id="ordre" name="selectOrdrePhoto">
					<?php 
					for ($i=1; $i<=10; $i++) {	   
					?>
						<option value="<?=$i?>" <?php if ($laPhoto->ordrePhoto==$i) echo "selected='selected'";?>><?=$i?></option>
					<?php
					}
					?>
			  </select>
			</td>
		</tr>
		<tr>
			<td>Taille du redimensionnement :</td>
			<td>    <input type="radio" name="radioTaille" id="radio" value="185" checked="checked"/> <span class="radio">185 px</span> 	<input type="radio" id="radio" name="radioTaille" value="385" /> <span class="radio">385 px (cette taille est utile pour les graphiques, etc...) </span> </td>
		</tr>
		<?php
		}
		?>
		<input type="hidden" name="numphoto" value="<?=$numphoto?>" />	
		<input type="hidden" name="numparaphoto" value="<?=$numparaphoto?>" />
	
	<?php
	/*********************** Modification de vidéo **************************************************************/
	} else if ($numvideo) {
	?>
	<tr>
			<td>L&eacute;gende de la vidéo:</td>
			<td><input id="lib" name="textLegVi" value="<?=$laVideo->legendeVideo?>"/> </td>
		</tr>
		<tr>
			<td>Associer la vid&eacute;o existante :</td>
			<td> 
				<select name="selectVideo">	
					  <option></option>
					  <?php
						$listvideos=new ListeVideos(); 	   
						$listvideos->afficherListeVideos();
						foreach ($listvideos as $videos) {
					  ?>
						   <option value="<?=$videos->numvideo?>" <?php if ($laVideo->numvideo==$videos->numvideo) echo "selected='selected'";?>><?=$videos->nomVideo?></option>
					  <?php
					  }
					  ?>
			  </select>	
			</td>
		</tr>
		<tr>
			<td>ou ajouter une vid&eacute;o :</td>
			<td>  <input type="file" name="fileVideo"  />	</td>
		</tr>
		<tr>
			<td>Ordre de la vid&eacute;o :</td>
			<td>
				<select id="ordre" name="selectOrdreVideo">
					<?php 
					for ($i=1; $i<=10; $i++) {	   
					?>
						<option value="<?=$i?>" <?php if ($laVideo->ordreVideo==$i) echo "selected='selected'";?>><?=$i?></option>
					<?php
					}
					?>
			  </select>
			</td>
		</tr>
		
		<input type="hidden" name="numvideo" value="<?=$numvideo?>" />	
		<input type="hidden" name="numparavideo" value="<?=$numparavideo?>" />
	
	
	<?php
	}//fin else if ($numvideo) {
	?>
	<tr>
		<td colspan="2">
		<input id="button" name="validerPage" type="button" value="Valider" onClick="javascript:document.forms[0].submit()"/>	
		</td>
	</tr>
</table>
</form>
</div>
</div>
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