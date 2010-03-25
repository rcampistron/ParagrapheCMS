<?php /* Date de cration: 06/01/2009 */ 
$laPage = new Page(); 
if ($numpage) {
	$laPage->numpage=$numpage;
	$laPage->infosPage(); 
	$laPage->infosColonnes(); 
}

?>
<table id="pageadmin">
 <tr>
 <th colspan="2">Tableau de bord des paragraphes</th>
  <hr /></tr>
  <?php
  /*--- Zone de recommendations particulieres d'utilisation du CMS ------------------------------------------*/
  //Actualites
  if($numpage=="120") {
  ?>
  Pour les <strong>actualités</strong>, utilisez le <a href="index.php?pg_admin=lister-actu&id=<?=$id?>&cnx=<?=$cnx?>2">module spécifique de gestion des actualités</a>.<br />
  Vous pourrez ainsi gérer l'affichage de chaque actualité en page d'accueil le cas échéant.<br />
  Les paragraphes ci-dessous peuvent être utilisés pour ajouter du contenu complémentaire par exemple dans la colonne contributive.
  <hr />
  <?php
  } // fin if($numpage=="120")
  //Brèves internationales
  if($numpage=="84") {
  ?>
  Pour les <strong>brèves de veille économique internationale</strong>, utilisez le <a href="index.php?pg_admin=lister-breve&id=<?=$id?>&cnx=<?=$cnx?>2">module spécifique des brèves</a>.
  <br />
  Les paragraphes ci-dessous peuvent être utilisés pour ajouter du contenu complémentaire par exemple dans la colonne contributive.
  <hr />
  <?php
  } // fin if($numpage=="84")
  ?>
  

  <tr>
	 <td>Position <br />du paragraphe<span style="padding-left:20px;">Ordre</span> <span style="padding-left:20px;">Titre</span></td></tr><tr><td>
	<div id="Acc0" class="Accordion">
	  <?php	 
	$cpt_acc=0;	 
	$listparas0=new ListeParagraphes();	
	if ($numpage) {
		$listparas0->numpage=$laPage->numpage; 
		$listparas0->colonne=0;//pas de colonne	 
		$listparas0->afficherListeParas();
	}
	if ($listparas0){ 
		reset($listparas0);	
		foreach ($listparas0 as $paras) {
	?>
	  <div class="AccordionPanel">
    <div class="AccordionPanelTab"><!--&nbsp;&nbsp;&nbsp;&nbsp;<?php if ($laPage->C0) echo "aucune colonne"; else if ($laPage->C1) echo "colonne de gauche"; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$paras->ordrePara?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if ($paras->titrePara) echo supprimeRC($paras->titrePara); else echo "Paragraphe sans titre";?>-->
	&nbsp;&nbsp;<?php if ($laPage->C0) echo "aucune colonne"; else if ($laPage->C1) echo "colonne de gauche"; ?><span class="admin"><?=$paras->ordrePara?></span><span class="admin2"><?php if ($paras->titrePara) echo supprimeRC($paras->titrePara); else echo "Paragraphe sans titre";?></span>
	</div>
    <div class="AccordionPanelContent">
		 <ol>
			 <li>
		      <label for="title">Supprimer le paragraphe :</label>
		      <input id="checkbox" type="checkbox" name="checkSupPara<?=$paras->numpara?>" value="<?=$paras->numpara?>">
		    </li>
		     <?php
			include("parag.php");
			?>
	    </ol>
    </div>
  </div> 
  <?php	
	  	$cpt_acc++;
	  }	//fin du foreach   
  }//fin if ($listparas0)
  
  if ($numpage) {
	  $listparas1=new ListeParagraphes();	
	  $listparas1->numpage=$laPage->numpage;
	  $listparas1->colonne=1; //colonne de gauche
	  $listparas1->afficherListeParas();
  } 
  if ($listparas1) {
		reset($listparas1);	
		foreach ($listparas1 as $paras) {
	?>
  	  <div class="AccordionPanel">
    <div class="AccordionPanelTab">&nbsp;&nbsp;<?php  echo "colonne de gauche"; ?><span class="admin"><?=$paras->ordrePara?></span><span class="admin2"><?php if ($paras->titrePara) echo supprimeRC($paras->titrePara); else echo "Paragraphe sans titre";?></span></div>
    <div class="AccordionPanelContent">
		 <ol>
			 <li>	
		      <label for="title">Supprimer le paragraphe :</label>
		      <input id="checkbox" type="checkbox" name="checkSupPara<?=$paras->numpara?>" value="<?=$paras->numpara?>">
		    </li>
		     <?php
			include("parag.php");
			?>
	    </ol>
    </div>
  </div> 
  <?php	  
  	$cpt_acc++;
  	}	//fin du foreach
  }//fin if ($listparas1)
  
  if ($numpage) {
	  $listparas2=new ListeParagraphes();	
	  $listparas2->numpage=$laPage->numpage;
	  $listparas2->colonne=2;//colonne de droite
	  $listparas2->afficherListeParas();
  } 
  if ($listparas2) {
		reset($listparas2);	
		foreach ($listparas2 as $paras) {
	?>
  	  <div class="AccordionPanel">
    <div class="AccordionPanelTab">&nbsp;&nbsp;<?php  echo "colonne de droite"; ?><span class="admin"><?=$paras->ordrePara?></span><span class="admin2"><?php if ($paras->titrePara) echo supprimeRC($paras->titrePara); else echo "Paragraphe sans titre";?></span></div>
    <div class="AccordionPanelContent">
		 <ol>
			 <li>
		      <label for="title">Supprimer le paragraphe :</label>
		      <input id="checkbox" type="checkbox" name="checkSupPara<?=$paras->numpara?>" value="<?=$paras->numpara?>">
		    </li>
		     <?php
			include("parag.php");
			?>
	    </ol>
    </div>
  </div> 
  <?php	  
  	$cpt_acc++;
  	}	//fin du foreach
  }//fin if ($listparas2)
 
  if ($numpage) {
	  $listparas3=new ListeParagraphes();	
	  $listparas3->numpage=$laPage->numpage;
	  $listparas3->colonne=3;//contenu associé
	  $listparas3->afficherListeParas();
  } 
  if ($listparas3) {
		reset($listparas3);	
		foreach ($listparas3 as $paras) {
	?>
  	  <div class="AccordionPanel">
    <div class="AccordionPanelTab">&nbsp;&nbsp;<?php  echo "contenu associé"; ?><span class="admin"><?=$paras->ordrePara?></span><span class="admin2"><?php if ($paras->titrePara) echo supprimeRC($paras->titrePara); else echo "Paragraphe sans titre";?></span></div>
    <div class="AccordionPanelContent">
		 <ol>
			 <li>
		      <label for="title">Supprimer le paragraphe :</label>
		      <input id="checkbox" type="checkbox" name="checkSupPara<?=$paras->numpara?>" value="<?=$paras->numpara?>">
		    </li>
		     <?php
			include("parag.php");
			?>
	    </ol>
    </div>
  </div> 
  <?php	  
  	$cpt_acc++;
  	}	//fin du foreach
  }//fin if ($listparas2)
  ?>
  </div>  
   
  	<?php 
	if ($listparas1 || listparas2 || listparas3) {
	?>
	    <input type="hidden" name="action" value="modifier_parag" />
		<input id="button" name="ModifierParag" type="button" value="Valider" onClick="javascript:document.forms[0].submit()"/>
	<?php
	}
	?>

</td></tr></table><br class="clearall" /><br />