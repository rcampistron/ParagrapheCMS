<?php /* Date de création: 11/12/2008 */  
/**
 * @file parag.php
 * @date 11/12/2008
 * @todo supprimer accordeon 
 * 
 */
if (!$cpt_acc) 	$cpt_acc=1;
if ($paras->numpara) {
?> 
	<script language="JavaScript" type="text/javascript">
	  
	  var nextHiddenIndex<?=$paras->numpara?> = 2; 
	  var nextHiddenIndexP<?=$paras->numpara?> = 2;	 
	  var nextHiddenIndexV<?=$paras->numpara?> = 2;
	  var nextHiddenIndexF<?=$paras->numpara?> = 2;
	  <?php 
			    //recupère le nombre de paragraphes
			    $nombrePara = new ListeParagraphes();
			    $nombrePara->numpage = $numpage;
			    $nombre_Para = $nombrePara->afficherListeParas();
			    $array[]=$paras->numpara;
	?>
	 
	   window.onload = function()
	    {
		for (i=1; i<<?php echo $array[0];?>; i++){
		window["oFCKeditor_"+i] = new FCKeditor('textCont<?=$paras->numpara?>') ;		 
	    window["oFCKeditor_"+i].ToolbarSet = 'Basic' ;
	    window["oFCKeditor_"+i].BasePath = 'admin/fckeditor/' ;
	    window["oFCKeditor_"+i].Height  = '600' ;
	    window["oFCKeditor_"+i].Width  = '400' ;
	    window["oFCKeditor_"+i].ReplaceTextarea();	
		}		 
	    } 
	   
	   	    
 
	</script>
<?php
} else {
?>	
	<script language="JavaScript" type="text/javascript">
	 var nextHiddenIndex = 2;  
	 var nextHiddenIndexP = 2; 
	 var nextHiddenIndexV = 2;
	 var nextHiddenIndexF = 2;
	</script>
<?php
}

$listphot=new ListePhotos(); 	   
$listphot->afficherListePhotos();
?>
	<script language="JavaScript" type="text/javascript">
	tab_photo = new Array();
<?php
$cpt_p=0;
foreach ($listphot as $photos) {
?>
	tab_photo["<?=$cpt_p?>"]="<?=$photos->nomPhoto?>";

<?php
	$cpt_p++;
}
?>
	</script>
        <li>
	      <label for="desc">Position du paragraphe :</label>
	      <select id="desc" name="selectType<?=$paras->numpara?>">
			<option>----------------------------------------------------</option>
			<option value="0" <?php if ($paras->colonnePara==0) echo "selected='selected'";?>>Contenu central en une colonne</option>
			<option>----------------------------------------------------</option>
			<option value="1" <?php if ($paras->colonnePara==1) echo "selected='selected'";?>>Colonne de gauche</option>
			<option value="2" <?php if ($paras->colonnePara==2) echo "selected='selected'";?>>Colonne de droite</option> 
			<option>----------------------------------------------------</option>
			<option value="3" <?php if ($paras->colonnePara==3) echo "selected='selected'";?>>Contenu associ&eacute;</option>
		  </select>
	    </li>
		<li>
	      <label for="titlePara">Titre du paragraphe :</label>
	      <textarea id="" name="textTitrePara<?=$paras->numpara?>"><?=miseEnFormeTextarea($paras->titrePara)?></textarea>
	    </li>
		<li>
	      <label for="title">Mise en forme du titre   :</label>
	      <input type="radio" id="radio" name="radioTypeTitre<?=$paras->numpara?>" value="h1" <?php if ($paras->typeTitre=="h1" || !$paras->numpara) echo "checked='checked'";?> /> 
	      <span class="radio">titre1 (sans trait) </span> 	
	      <input type="radio" id="radio" name="radioTypeTitre<?=$paras->numpara?>" value="h2" <?php if ($paras->typeTitre=="h2" ) echo "checked='checked'";?> /> 
	      <span class="radio">titre2</span>
		  <input type="radio" id="radio" name="radioTypeTitre<?=$paras->numpara?>" value="h3" <?php if ($paras->typeTitre=="h3" ) echo "checked='checked'";?> /> 
	      <span class="radio">titre3</span>
	    (avec trait) </li>
	    <li><!--  FCKEDITOR  -->
	      <label for="title">Contenu du paragraphe :</label>
	      <textarea name="textCont<?=$paras->numpara?>"><?=miseEnFormeTextarea($paras->contenuPara)?></textarea>
	    </li>
		 <li>
	      <label>La contenu du paragraphe est de type : </label>
		  <input type="radio" id="radio name="radioListe<?=$paras->numpara?>" value="li" <?php if ($paras->listePara=="li" ) echo "checked='checked'";?> /> 
		  <span class="radio">liste</span> 
		  <input type="radio" id="radio" name="radioListe<?=$paras->numpara?>" value="no" <?php if ($paras->listePara=="no" || !$paras->numpara) echo "checked='checked'";?> /> 
		  <span class="radio">normal</span>
	    </li>
		 <li>
	      <label for="ordrePara">Ordre du paragraphe :</label>
	      <select id="ordre" name="selectOrdre<?=$paras->numpara?>">
		  	<?php 
			for ($i=1; $i<=10; $i++) {	   
			?>
				<option value="<?=$i?>" <?php if ($paras->ordrePara==$i) echo "selected='selected'";?>><?=$i?></option>
			<?php
			}
			?>
		  </select>
	    </li>	
	 <?php
	  if ($paras->numpara) {//on est en modification
		//les liens
		$listliens=new ListeLiens();
		$listliens->numpara= $paras->numpara;
		$listliens->admin=1;
		$nb_liens=$listliens->afficherListeLiens();
		if ($nb_liens) {
		?> 
		<li>
	      <label for="lienstitle" >Les liens :</label> 
		  <?php
			foreach ($listliens as $liens) {
			?>
			     <p class="liens" id="li_liens<?=$liens->numlien?>">&nbsp;&nbsp;<a name="lien_name<?=$liens->numlien?>" id="lien_id<?=$liens->numlien?>" href="<?=$liens->urlLien?>" target="_blank"><? echo substr($liens->libLien,0,40);?>...</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:conf_supAssoc('pop_sup.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numlien=<?=$liens->numlien?>&div=li_liens<?=$liens->numlien?>','un lien')">supprimer le lien</a>&nbsp;&nbsp;<a href="javascript:popup('modifier_fich.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numlien=<?=$liens->numlien?>')">modifier le lien</a></p>
				  
			<?php
			}//fin du foreach ($listliens as $liens) 
			?>	
	    </li>	
		<?php		  
		}//fin if ($nb_liens)
		
		// les fichiers
		$listfichiers=new ListeFichiers();
		$listfichiers->numpara= $paras->numpara; 
		$nb_fichiers=$listfichiers->afficherListeFichiers();
		if ($nb_fichiers) {  
		?>
		 <li>
	      <label for="fichtitle">Les fichiers :</label> 
		  <?php
				foreach ($listfichiers as $fichiers) {
			?>
			      <p class="liens" id="li_fichiers<?=$fichiers->numfichier?>"><a name="fich_name<?=$fichiers->numfichier?>" id="fich_id<?=$fichiers->numfichier?>" href="ouverturepdf.php?file=<?=$fichiers->nomFichier?>" target="_blank"><?=$fichiers->nomFichier?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:conf_supAssoc('pop_sup.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numpara=<?=$paras->numpara?>&numfichier=<?=$fichiers->numfichier?>&numparafichier=<?=$fichiers->numparafichier?>&div=li_fichiers<?=$fichiers->numfichier?>','un fichier')">supprimer le fichier</a>&nbsp;&nbsp;<a href="javascript:popup('modifier_fich.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numfichier=<?=$fichiers->numfichier?>&numpara=<?=$paras->numpara?>&numparafichier=<?=$fichiers->numparafichier?>')">modifier le fichier</a></p>
				  
			<?php
				}//fin du foreach ($listfichiers as $fichiers)
				?> 
	    </li>	
		<?php		  
		}//fin if ($nb_fichiers)
		
		// les photos
		$listphotos=new ListePhotos();
		$listphotos->numpara= $paras->numpara; 
		$nb_photos=$listphotos->afficherListePhotos();
		if ($nb_photos) {
		?>	
		  <li>
	      <label for="photostitle">Les photos :</label> 
		  <?php
				foreach ($listphotos as $photos) {
			?>
			     <p class="liens" id="li_photos<?=$photos->numphoto?>"><a name="ph_name<?=$photos->numphoto?>" id="ph_id<?=$photos->numphoto?>" href="photos/<?=$photos->nomPhoto?>" target="_blank"><?=$photos->nomPhoto?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:conf_supAssoc('pop_sup.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numpara=<?=$paras->numpara?>&numphoto=<?=$photos->numphoto?>&numparaphoto=<?=$photos->numparaphoto?>&div=li_photos<?=$photos->numphoto?>','une photo')">supprimer</a>&nbsp;&nbsp;<a href="javascript:popup('modifier_fich.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numphoto=<?=$photos->numphoto?>&numpara=<?=$paras->numpara?>&numparaphoto=<?=$photos->numparaphoto?>')">modifier / mettre à jour </a></p>
				  
			     <?php
				}//fin du foreach ($listphotos as $photos) 
				?> 
	   	  </li>	
		<?php		  
		}//fin if ($nb_photos)
		
		//Les vid�os  
		$listvideos=new ListeVideos();
		$listvideos->numpara= $paras->numpara; 
		$nb_videos=$listvideos->afficherListeVideos();
		if ($nb_videos) {
		?>
		   <li>
		      <label for="videotitle">Les vid&eacute;os :</label> 
			  <?php
					foreach ($listvideos as $videos) {
				?>
				      <p class="liens" id="li_videos<?=$videos->numvideo?>"><a name="vi_name<?=$videos->numvideo?>" id="vi_id<?=$videos->numvideo?>" href="videos/<?=$videos->nomVideo?>" target="_blank"> <?=$videos->nomVideo?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:conf_supAssoc('pop_sup.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numpara=<?=$paras->numpara?>&numvideo=<?=$videos->numvideo?>&numparavideo=<?=$videos->numparavideo?>&div=li_videos<?=$videos->numvideo?>','une vidéo')">supprimer la vid&eacute;o</a>&nbsp;&nbsp;<a href="javascript:popup('modifier_fich.php?id=<?=$id?>&cnx=<?=$cnx?>&pg_admin=<?=$pg_admin?>&numvideo=<?=$videos->numvideo?>&numpara=<?=$paras->numpara?>&numparavideo=<?=$videos->numparavideo?>')">modifier la vidéo</a></p>
					  
				<?php
					}//fin du foreach ($listvideos as $videos) 
					?> 
    </li>	
		<?php		  
		}//fin if ($nb_videos)
		
	}//fin if ($paras->numpara)
	?>
	 <li id="li_acc">
	 <div id="Acc<?=$cpt_acc?>" class="Accordion">
	 	
		<div class="AccordionPanel">
		    <div class="AccordionPanelTab"><strong>Ajouter un lien :</strong></div>
	      <div class="AccordionPanelContent">
				  <ol>
				  <li id="lien1_<?=$paras->numpara?>">
				      <label for="flib1_<?=$paras->numpara?>">Libell&eacute; du lien *:</label>
				      <input id="lib1_<?=$paras->numpara?>" name="textLibLien1_<?=$paras->numpara?>"/> 
					   
					  <label for="ftexte1_<?=$paras->numpara?>">Texte du lien (si vous souhaitez pourvoir écrire un texte avant le lien) : </label>
				      <textarea name="textTexteLien1_<?=$paras->numpara?>"></textarea>
					  
					  <label for="furl1_<?=$paras->numpara?>">Url du lien :</label>
				      <input id="url1_<?=$paras->numpara?>" name="textUrlLien1_<?=$paras->numpara?>"/>	 
					  
					  <label for="fpage1_<?=$paras->numpara?>"><strong>Ou sélectionner une page du site</strong> (c'est mieux) :</label>
				       <select id="page1_<?=$paras->numpara?>" name="selectPage1_<?=$paras->numpara?>">
					  	<option value=""></option>
						<?php 
						$listpagesliens = new ListePages();
  						$listpagesliens->afficherListePages();
						foreach ($listpagesliens as $pages) {  
						?>
							<option value="<?=$pages->numpage?>"><?=$pages->titrePage?></option>
						<?php
						}
						?>
					  </select>
					   
					   
					  <label for="fdesc1_<?=$paras->numpara?>">Ordre du lien :</label>
				      <select id="ordre1_<?=$paras->numpara?>" name="selectOrdreLien1_<?=$paras->numpara?>">
					  	<?php 
						for ($i=1; $i<=10; $i++) {	   
						?>
							<option value="<?=$i?>"><?=$i?></option>
						<?php
						}
						?>
					  </select>
					  
					  <label for="ffen1_<?=$paras->numpara?>">Ouverture dans une nouvelle fenêtre ? :</label>
					  <input type="radio" id="radio" name="radioFen1_<?=$paras->numpara?>" value="o" ><span class="radio">oui</span> 	<input type="radio" id="radio" name="radioFen1_<?=$paras->numpara?>" value="n" checked='checked'/> <span class="radio">non</span>
					
					<?php
					for ($i=2; $i<=10; $i++) {
					?>
						
					<li id="lien<?=$i?>_<?=$paras->numpara?>" style="display:none">
					      <label for="flib<?=$i?>_<?=$paras->numpara?>">Libell&eacute; du lien :</label>
					      <input id="lib<?=$i?>_<?=$paras->numpara?>" name="textLibLien<?=$i?>_<?=$paras->numpara?>"/> 
						   
						  <label for="ftexte<?=$i?>_<?=$paras->numpara?>">Texte du lien :</label>
					      <textarea name="textTexteLien<?=$i?>_<?=$paras->numpara?>"></textarea>
						  
						  <label for="furl<?=$i?>_<?=$paras->numpara?>">Url du lien :</label>
					      <input id="url<?=$i?>_<?=$paras->numpara?>" name="textUrlLien<?=$i?>_<?=$paras->numpara?>"/>	 
						  
						  <label for="fpage<?=$i?>_<?=$paras->numpara?>">Ou sélectionner une page du site :</label>
						   <select id="page<?=$i?>_<?=$paras->numpara?>" name="selectPage<?=$i?>_<?=$paras->numpara?>">
							<option value=""></option>
							<?php 
							$listpagesliens = new ListePages();
							$listpagesliens->afficherListePages();
							foreach ($listpagesliens as $pages) {  
							?>
								<option value="<?=$pages->numpage?>"><?=$pages->titrePage?></option>
							<?php
							}
							?>
						  </select>
						  
						  <label for="fdesc<?=$i?>_<?=$paras->numpara?>">Ordre du lien :</label>
					      <select id="ordre<?=$i?>_<?=$paras->numpara?>" name="selectOrdreLien<?=$i?>_<?=$paras->numpara?>">
						  	<?php 
							for ($j=1; $j<=10; $j++) {	   
							?>
								<option value="<?=$j?>"><?=$j?></option>
							<?php
							}
							?>
						  </select>
						  
						  <label for="ffen<?=$i?>_<?=$paras->numpara?>">Ouverture dans une nouvelle fenêtre ? :</label>
					  <input type="radio" id="radio" name="radioFen<?=$i?>_<?=$paras->numpara?>" value="o" ><span class="radio">oui</span> 	<input type="radio" id="radio" name="radioFen<?=$i?>_<?=$paras->numpara?>" value="n" checked='checked'/> <span class="radio">non</span>
				    </li> 
					<?php
					} //fin du for
					?> 
					 <li id="plusLiens<?=$paras->numpara?>">
					  <label for="fdesc"><a href="javascript:AddLiens(<?=$paras->numpara?>)">[+ de liens]</a></label>
					</li> 
			</ol>
	      </div> 
		</div> 
		
		<div class="AccordionPanel">
				<div class="AccordionPanelTab"><strong>Associer une photo :</strong></div>
			    	<div class="AccordionPanelContent">
					  <ol>
							<li id="photo1_<?=$paras->numpara?>">
						      <label for="fleg1_<?=$paras->numpara?>">L&eacute;gende de la photo :</label>
						      <input id="leg1_<?=$paras->numpara?>" name="textLegPh1_<?=$paras->numpara?>"/> 
							  <?php
							    $listphotos=new ListePhotos(); 	   
								$b=$listphotos->afficherListePhotos();
								if ($b) { 
							  ?>
							  <label for="fphot1_<?=$paras->numpara?>">Associer la photo existante:</label>
							  <select name="selectPhoto1_<?=$paras->numpara?>">	
								  <option></option>
								  <?php
									foreach ($listphotos as $photos) {
										$nb_photos=$photos->countPhotos();
								  ?>
								  	   <option value="<?=$photos->numphoto?>"><?php echo $photos->nomPhoto; if ($nb_photos>=1) echo " (déjà utilisée)";?></option>
								  <?php
								  }
								  ?> 
							  </select>	
							  <?php
							  }//fin if ($b)
							  ?>
							  <label for="fphoto1_<?=$paras->numpara?>"><?php if ($b) echo "<strong>OU</strong> ajouter une ";?>	photo :</label>
						      <input type="file" name="filePhoto1_<?=$paras->numpara?>"  />	   
							  
							  <label for="fdescPhoto1_<?=$paras->numpara?>">Ordre de la photo :</label>
						      <select id="ordrePhoto1_<?=$paras->numpara?>" name="selectOrdrePhoto1_<?=$paras->numpara?>">  
							  	<?php 
								for ($i=1; $i<=10; $i++) {	   
								?>
									<option value="<?=$i?>"><?=$i?></option>
								<?php
								}
								?>
							  </select>	
							  <label for="taillePhoto1_<?=$paras->numpara?>">Taille du redimensionnement (<strong>jpg</strong>):<br />
Pas de tiff ! Gif non redimensionné </label>
							  <input type="radio" name="radioTaille1_<?=$paras->numpara?>" id="radio" value="185" checked="checked"/> <span class="radio">185 px</span> 	<input type="radio" id="radio" name="radioTaille1_<?=$paras->numpara?>" value="385" /> <span class="radio">385 px (cette taille est utile pour les graphiques, etc...) </span> 
					    </li> 
							 
							 <?php
							for ($i=2; $i<=10; $i++) {
							?> 
							  <li id="photo<?=$i?>_<?=$paras->numpara?>" style="display:none">
						      <label for="fleg<?=$i?>_<?=$paras->numpara?>">L&eacute;gende de la photo :</label>
						      <input id="leg<?=$i?>_<?=$paras->numpara?>" name="textLegPh<?=$i?>_<?=$paras->numpara?>"/> 
							  <?php
							    $listphotos=new ListePhotos(); 	   
								$b=$listphotos->afficherListePhotos();
								if ($b) { 
							  ?>
							  <label for="fphot<?=$i?>_<?=$paras->numpara?>">Associer la photo existante:</label>
							  <select name="selectPhoto<?=$i?>_<?=$paras->numpara?>">	
								  <option></option>
								  <?php
									foreach ($listphotos as $photos) {
										$nb_photos=$photos->countPhotos();
								  ?>
								  	   <option value="<?=$photos->numphoto?>"><?php echo $photos->nomPhoto; if ($nb_photos>=1) echo " (déjà utilisée)";?></option>
								  <?php
								  }
								  ?> 
							  </select>	
							  <?php
							  }//fin if ($b)
							  ?>
							  <label for="fphoto<?=$i?>_<?=$paras->numpara?>"><?php if ($b) echo "ou ajouter une ";?>	photo :</label>
						      <input type="file" name="filePhoto<?=$i?>_<?=$paras->numpara?>"  />	   
							  
							  <label for="fdescPhoto<?=$i?>_<?=$paras->numpara?>">Ordre de la photo :</label>
						      <select id="ordrePhoto<?=$i?>_<?=$paras->numpara?>" name="selectOrdrePhoto<?=$i?>_<?=$paras->numpara?>">  
							  	<?php 
								for ($j=1; $j<=10; $j++) {	   
								?>
									<option value="<?=$j?>"><?=$j?></option>
								<?php
								}
								?>
							  </select>	
							  <label for="taillePhoto<?=$i?>_<?=$paras->numpara?>">Taille du redimensionnement :</label>
							  <input type="radio" name="radioTaille<?=$i?>_<?=$paras->numpara?>" id="radio" value="185" checked="checked"/> <span class="radio">185 px</span> 	<input type="radio" id="radio" name="radioTaille<?=$i?>_<?=$paras->numpara?>" value="385" /> <span class="radio">385 px (cette taille est utile pour les graphiques, etc...) </span> 
							 </li> 
							<?php
							}//fin for ($i=2; $i<=10; $i++) 
							?> 
							  <li id="plusPhotos<?=$paras->numpara?>">
							  <label for="fdescPhot"><a href="javascript:AddPhotos(<?=$paras->numpara?>)">[+ de photos]</a></label>
							</li>
					  </ol>
		  </div>
	   </div> 
				 
			<div class="AccordionPanel">
				<div class="AccordionPanelTab"><strong>Associer une vid&eacute;o :</strong></div>
			    	<div class="AccordionPanelContent">
					  <ol>
					  	 <li id="video1">
						      <label for="flegvideo1_<?=$paras->numpara?>">L&eacute;gende de la vid&eacute;o :</label>
						      <input id="legvideo1_<?=$paras->numpara?>" name="textLegVi1_<?=$paras->numpara?>"/> 
							  <?php
							    $listvideos=new ListeVideos(); 	   
								$b=$listvideos->afficherListeVideos();
								if ($b) { 
							  ?>
							  <label for="flegVid1_<?=$paras->numpara?>">Associer la vid&eacute;o existante:</label>
							  <select name="selectVideo1_<?=$paras->numpara?>">	
								  <option></option>
								  <?php
									foreach ($listvideos as $videos) {
								  ?>
								  	   <option value="<?=$videos->numvideo?>"><?=$videos->nomVideo?></option>
								  <?php
								  }
								  ?> 
							  </select>	
							  <?php
							  }//fin if ($b)
							  ?>
							  <label for="fvideo1_<?=$paras->numpara?>"><?php if ($b) echo "ou ajouter une ";?>	vid&eacute;o (flv):</label>
						      <input type="file" name="fileVideo1_<?=$paras->numpara?>"  />	   
							  
							  <label for="fdescVideo1_<?=$paras->numpara?>">Ordre de la vid&eacute;o :</label>
						      <select id="ordreVideo1_<?=$paras->numpara?>" name="selectOrdreVideo1_<?=$paras->numpara?>">  
							  	<?php 
								for ($i=1; $i<=10; $i++) {	   
								?>
									<option value="<?=$i?>"><?=$i?></option>
								<?php
								}
								?>
							  </select>
					    </li> 
							 
							 <?php
							for ($i=2; $i<=10; $i++) {
							?> 
							  <li id="video<?=$i?>_<?=$paras->numpara?>" style="display:none">
						      <label for="fflegVideo<?=$i?>_<?=$paras->numpara?>">L&eacute;gende de la vid&eacute;o :</label>
						      <input id="legVideo<?=$i?>_<?=$paras->numpara?>" name="textLegVi<?=$i?>_<?=$paras->numpara?>"/> 
							  <?php
							    $listvideos=new ListeVideos(); 	   
								$b=$listvideos->afficherListeVideos();
								if ($b) { 
							  ?>
							  <label for="flegVid<?=$i?>_<?=$paras->numpara?>">Associer la vid&eacute;o existante:</label>
							  <select name="selectVideo<?=$i?>_<?=$paras->numpara?>">	
								  <option></option>
								  <?php
									foreach ($listvideos as $videos) {
								  ?>
								  	   <option value="<?=$videos->numvideo?>"><?=$videos->nomVideo?></option>
								  <?php
								  }
								  ?> 
							  </select>	
							  <?php
							  }//fin if ($b)
							  ?>
							  <label for="fvideo<?=$i?>_<?=$paras->numpara?>"><?php if ($b) echo "ou ajouter une ";?>	vid&eacute;o :</label>
						      <input type="file" name="fileVideo<?=$i?>_<?=$paras->numpara?>"  />	   
							  
							  <label for="fdescVideo<?=$i?>_<?=$paras->numpara?>">Ordre de la vid&eacute;o :</label>
						      <select id="ordreVideo<?=$i?>_<?=$paras->numpara?>" name="selectOrdreVideo<?=$i?>_<?=$paras->numpara?>">  
							  	<?php 
								for ($j=1; $j<=10; $j++) {	   
								?>
									<option value="<?=$j?>"><?=$j?></option>
								<?php
								}
								?>
							  </select>
							 </li> 
							<?php
							}//fin for ($i=2; $i<=10; $i++) 
							?> 
							  <li id="plusVideos<?=$paras->numpara?>">
							  <label for="fdescVid"><a href="javascript:AddVideos(<?=$paras->numpara?>)">[+ de vid&eacute;o]</a></label>
							</li>  
					  </ol>
			  </div>
	   </div>	 
			   
			<div class="AccordionPanel">
				<div class="AccordionPanelTab"><strong>Associer un fichier :</strong></div>
			    	<div class="AccordionPanelContent">
					  <ol>
					  	 <li id="fichier1_<?=$paras->numpara?>">
						      <?php
							    /**
								désactivé le 28/01/09
								$listfichiers=new ListeFichiers(); 	   
								$b=$listfichiers->afficherListeFichiers();
								if ($b) { 
								**/
							  ?>
							  <label for="flibf1_<?=$paras->numpara?>">Libell&eacute; du fichier *:</label>
					     	 <input id="libf1_<?=$paras->numpara?>" name="textLibFich1_<?=$paras->numpara?>"/> 
							 <!--
							 désactivé le 28/01/09
							  <label for="flegFich1_<?=$paras->numpara?>">Associer le fichier existant :</label>
							  <select name="selectFich1_<?=$paras->numpara?>">	
								  <option></option>
								  <?php
									foreach ($listfichiers as $fichiers) {
								  ?>
								  	   <option value="<?=$fichiers->numfichier?>"><?=$fichiers->nomFichier?></option>
								  <?php
								  }
								  ?> 
							  </select>	
							  <?php
							  //}//fin if ($b)
							  ?>
							  -->
							  <label for="ffichier1_<?=$paras->numpara?>">Ajouter un fichier :</label>
						      <input type="file" name="fileFich1_<?=$paras->numpara?>"  />	   
							  
							  <label for="fdescFichier1_<?=$paras->numpara?>">Ordre du fichier :</label>
						      <select id="ordreFichier1_<?=$paras->numpara?>" name="selectOrdreFich1_<?=$paras->numpara?>">  
							  	<?php 
								for ($i=1; $i<=10; $i++) {	   
								?>
									<option value="<?=$i?>"><?=$i?></option>
								<?php
								}
								?>
							  </select>
					    </li> 
							 
							 <?php
							for ($i=2; $i<=10; $i++) {
							?> 
							  <li id="fichier<?=$i?>_<?=$paras->numpara?>" style="display:none">
						     
							  <?php
							    /**
								désactivé le 28/01/09
								$listfichiers=new ListeFichiers(); 	   
								$b=$listfichiers->afficherListeFichiers();
								if ($b) { 
								**/
							  ?>
							   <label for="flibf<?=$i?>_<?=$paras->numpara?>">Libell&eacute; du fichier :</label>
					     	 <input id="libf<?=$i?>_<?=$paras->numpara?>" name="textLibFich<?=$i?>_<?=$paras->numpara?>"/> 
							  <!--
							 désactivé le 28/01/09
							  <label for="leg<?=$i?>_<?=$paras->numpara?>">Associer le fichier existant :</label>
							  <select name="selectFich<?=$i?>_<?=$paras->numpara?>">	
								  <option></option>
								  <?php
									foreach ($listfichiers as $fichiers) {
								  ?>
								  	   <option value="<?=$fichiers->numfichier?>"><?=$fichiers->nomFichier?></option>
								  <?php
								  }
								  ?> 
							  </select>
							  -->	
							  <?php
							  //}//fin if ($b)
							  ?>
							  <label for="ffichier<?=$i?>_<?=$paras->numpara?>">Ajouter un fichier :</label>
						      <input type="file" name="fileFich<?=$i?>_<?=$paras->numpara?>"  />	   
							  
							  <label for="fdescFichier<?=$i?>_<?=$paras->numpara?>">Ordre du fichier :</label>
						      <select id="ordreFichier<?=$i?>_<?=$paras->numpara?>" name="selectOrdreFich<?=$i?>_<?=$paras->numpara?>">  
							  	<?php 
								for ($j=1; $j<=10; $j++) {	   
								?>
									<option value="<?=$j?>"><?=$j?></option>
								<?php
								}
								?>
							  </select>
							 </li> 
							<?php
							}//fin for ($i=2; $i<=10; $i++) 
							?> 
							  <li id="plusFichiers<?=$paras->numpara?>">
							  <label for="fdescFich"><a href="javascript:AddFichiers(<?=$paras->numpara?>)">[+ de fichiers]</a></label>
							</li>
					  </ol>
			  </div>
			</div>
	 </div><!--fin <div class="AccordionPanel">	-->	   
	</li> 
   
	 
	
 
  <?php
  if (!$paras->numpara) {
  ?>
  	  <input type="hidden" name="nbLiens" value="1">
	  <input type="hidden" name="nbPhotos" value="1">  
	  <input type="hidden" name="nbVideos" value="1">
	  <input type="hidden" name="nbFichiers" value="1">
  
  <?php
  } else {
  ?>
  	  <input type="hidden" name="nbLiens<?=$paras->numpara?>" value="1">
	  <input type="hidden" name="nbPhotos<?=$paras->numpara?>" value="1">  
	  <input type="hidden" name="nbVideos<?=$paras->numpara?>" value="1">
	  <input type="hidden" name="nbFichiers<?=$paras->numpara?>" value="1">
  <?php
  }
  ?>
