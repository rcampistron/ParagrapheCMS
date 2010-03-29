<?php /* Date de cration: 08/12/2008 */ 
if ($creer_page) {//on vient de la création d'une page
?>
<div class="item" id="coltexteAdmin">
	<div class="sap-content">
		<div class="TabbedPanels">
  			<div class="TabbedPanelsContentGroup">
    			<div class="TabbedPanelsContent"> 
<?php
}// fin if ($creer_page)
?>
<fieldset>
<legend>Cr&eacute;er un nouveau paragraphe</legend>
<ol>
      <?php
	 /** Association des parag existants : mise en commentaire le 12/01/09
	 if (!$paragraphe) {
		 $listparas=new ListeParagraphes();
		 $nb_paras=$listparas->afficherListeParas();
		 if ($nb_paras) {
	  **/
		?>
		<!-- Mise en commentaire le 12/01/09 <legend><?php if ($creer_page) {?>Associer un Paragraphe pour la page "<?=$newPage->titrePage?>" <?php } else {?> Associer un paragraphe existant <?php }?></legend>-->
		<li>
	   <?php
		  //Association des parag existants : mise en commentaire le 12/01/09 foreach ($listparas as $paras) {		
		  ?>
		  	 <!-- Association des parag existants : mise en commentaire le 12/01/09
			 <input type="checkbox" id="checkbox" name="checkPara[]" value="<?=$paras->numpara?>" />&nbsp;&nbsp;
		 <label class="assoc" for="title">  <?php
		  	echo $paras->titrePara;
		  ?>  </label>
		  	 &nbsp;&nbsp;<select id="ordre" name="selectOrdrePara<?=$paras->numpara?>">
			  	<?php 
				for ($i=1; $i<=10; $i++) {	   
				?>
					<option value="<?=$i?>"><?=$i?></option>
				<?php
				}
				?>
			  </select>
			   &nbsp;&nbsp;
			   <select id="type" name="selectType<?=$paras->numpara?>">
			  	<option value="0">Aucune colonne</option>
				<option value="1">Colonne de gauche</option>
				<option value="2">Colonne de droite</option> 
				<option value="3">Contenu associ</option>
			  </select>  
			  &nbsp;&nbsp;
			  <input type="radio" id="radio" name="radioListe<?=$paras->numpara?>" value="li" /> <span class="radio">liste</span> 	<input type="radio" id="radio" name="radioListe<?=$paras->numpara?>" value="no" checked="checked"/> <span class="radio" >normal</span>
			  </li> 
		  	  <hr /><br />
			  -->
		  <?php
		  	//Association des parag existants : mise en commentaire le 12/01/09}	//fin de foreach ($listcateg as $menus)
		//}//fin if ($nb_paras) 
	//}//fin if (!$paragraphe)
	?> 
	
    
    
	<?php  
	unset($paras);
	include("admin/parag.php");
	?>
	<br />	
	<input id="button" name="validerParag" type="button" value="Valider" onClick="javascript:ajouteParag()"/>  
	<input type="hidden" name="paragraphe">
	<?php  
	if (!$creer_page) {//on est en modification de page
	?>
		<input type="hidden" name="action" value="ajouter_parag" />	 
	<?php
	}// fin if ($creer_page)
	?>

</fieldset>
<?php  
if ($creer_page) {//on vient de la cration d'une page
?>
	</div>
	</div>
	</div> 
	</div>	 
	</div>
<?php
}// fin if ($creer_page)
?>
