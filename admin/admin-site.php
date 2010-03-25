<?php /* Date de création: 18/12/2008 */ 
$result=mysql_query("SELECT * FROM if_site");
$row=mysql_fetch_array($result);
?>
<div class="item" id="coltexteAdmin">
	<div class="sap-content">
	<div id="pageadmin">
	  <h2>D&eacute;crire le site</h2> 
	<fieldset>   
	<ol>
	    <li>
	      <label for="name">Url :</label>
	      <input id="name" type="text" name="textUrl" value="<?=$row["url"]?>"/>
	    </li>  
		<li>
	      <label for="name">Chemin sur le serveur :</label>
	      <input id="name" type="text" name="textPath" value="<?=$row["path"]?>"/>
	    </li>
		<li>
	      <label for="name">Pied de page :</label>
	      <textarea name="textPied"><?=miseEnFormeTextarea($row["pied_de_page"])?></textarea>
	    </li>  
	  </ol>	 
	<br />	
	<input id="button" name="validerSite" type="button" value="Valider" onClick="javascript:valideSite()"/>	  
  </fieldset>	  
  
 </div>
</div>
</div>
