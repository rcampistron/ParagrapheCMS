<?php /* Date de cration: 23/01/2009 */ 
// Page Panier
$laPage = new Page();
if ($textQte) {
	$laPage->pageSpecifique("panier-ifip-institut-du-porc");
} else {
	$laPage->numpage=$numpage;
	$laPage->infosPage();
}
$laPage->infosColonnes(); 


if ($laPage->nomPageGoogle) { 
		if ($_SESSION['numcom']) {
			$lePanier=new Panier();
			$lePanier->numcom=$_SESSION['numcom'];
			if (!$selectPays) $selectPays="247";//France metropolitaine
			if ($selectPays) $lePanier->pays=$selectPays;
			$lePanier->infosPanier();
			
		}
		


//*******************GESTION DE LA VALIDATION DE LA COMMANDE ETRANSACTION AVEC L'URL HHTP DE RETOUR
/*if($trans) {
	if($auto) { //si il n'y a un numero d'autorisation
		// VERIFICATION DE LA SIGNATURE DU PAIEMENT
		//echo "test";
		
		//require("pbxtestsign.lib.php");
		//$CheckSig = pbxtestsign($auto,"pubkey.pem");
				
		//if( $CheckSig == 1 ) { //la signature du paiement est bonne, il s'agit bien de e-transaction
			//echo "clé valide";
			//mysql_query("UPDATE if_bo_com SET etat='2' WHERE numcom='29'");
			$laComValide= new Commande();
			$laComValide->numcom=$ref;			
			$laComValide->etat="2";
			$laComValide->numerop=$trans;
			$laComValide->auto=$auto;
			$laComValide->montant=$montant;
			$laComValide->validerCommandeCBBanque();
											
			$clientValide=new Client();
   			$clientValide->numclient=SelectSimple("numclient","if_bo_com","numcom",$ref,"");
   			$clientValide->infosClient(); 
											
			EnvoiMailCommande($laComValide->numcom,$clientValide->email,'o');											
																						
			$pageSpecMonCompte=new Page();
			$pageSpecMonCompte->pageSpecifique("compte-ifip");
		
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
	/*} else { //il n'y a pas $auto (autorisation) donc erreur dans le paiement
		
			$laComValide= new Commande();
			$laComValide->numcom=$ref;				
											
			$clientValide=new Client();
   			$clientValide->numclient=SelectSimple("numclient","if_bo_com","numcom",$ref,"");
   			$clientValide->infosClient(); 
											
			EnvoiMailCommande($laComValide->numcom,$clientValide->email,'');
			$laComValide->supprimerCommande();
	} 
}*/
?>
<div class="item" id="coltexte785">
		   <div class="sap-content">
				<!-- item 1 585 pixels wide or 385 pixels wide -->
				<p class="titre785"><?=$laPage->titrePage?></p>
				<!-- Affichage contenu non dynamique (provenant du CMS) -->
				<?php
				if ($_SESSION['numcom']) {
				//Mise en commentaire pour simplification
				//if (($_SESSION['numcom'] && !$lePanier->article) || ($_SESSION['numcom'] && $lePanier->article && $prix)) {
				?>
						
							<?php
							if($_SESSION['numclient']) {
								$client=new Client();
								$client->numclient=$_SESSION['numclient'];
								$client->infosClient();
							?>
							<table width="600" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td colspan="4" class="sansmarge"><h2 class="supprmarge sanstrait"><?=$client->prenom;?> <?=$client->nom;?>,</h2></td>
                              </tr>
                            </table>
							<?php	
							
							
							}
							?>
							<?php
							if (!$etape) {// Etape 1 : Panier
							?>
								
							<?php
								if ($numarticle && $prix) {//c'est un article (lien direct depuis le mail)
							?>	
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
										<td colspan="4" class="sansmarge"><h2 class="supprmarge sanstrait">Voici votre référence à régler en ligne </h2></td>
						  </tr>
						  <tr class="entete"><td colspan="4"></td></tr>
									<tr class="entete">
									  <td width="30%"><div align="left">Désignation</div></td>
									  <td width="21%"><div align="left">Prix € </div></td>
										<td colspan="2"></td>
									</tr>
									<tr>
									  <td>&nbsp;</td>
									  <td>&nbsp;</td>
									  <td colspan="2"></td>
						  </tr>
									<?php
									$list_articles=array();
									$list_articles=$lePanier->listerArticlesCrees();
									for ($i=0;$i<count($list_articles);$i++) {
										$article=$list_articles[$i];
									?>
										<tr>
											<td><?=$article["designation"]?></td>
											<td><?=$article["prix_vente"]?> €<input type="hidden" name="prix" value="<?=$prix?>" /></td>
											<td colspan="2"></td>
										</tr>
									<?php
									}//fin du for
									?>
			 </table>
								
							<?php	
								} else {//if ($numarticle && $prix)
							?>
							
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td colspan="4" class="sansmarge"><h2 class="supprmarge sanstrait">Voici votre sélection</h2></td>
									</tr>
									<tr class="entete"><td colspan="4"></td></tr>
									<tr class="entete">
									  <td width="30%"><div align="left">Désignation</div></td>
										<td><div align="left">Prix € </div></td>
									  <td width="27%"><div align="left">Qté</div></td>
										<td width="22%"></td>
									</tr>
									<tr>
									  <td>&nbsp;</td>
									  <td>&nbsp;</td>
									  <td>&nbsp;</td>
									  <td></td>
						  </tr>
									<?php
									$list_articles=array();
									$list_articles=$lePanier->listerArticles();
									for ($i=0;$i<count($list_articles);$i++) {
										$article2=$list_articles[$i];
									?>
										<tr>
											<td><?=$article2["titre"]." - Réf : ".$article2["reference"]?></td>
											<td><?=$article2["prix_vente"]?> €</td>
											<td><span class="public"><input id="textQte<?=$article2["numdetail"]?>" name="textQte<?=$article2["numdetail"]?>" value="<?=$article2["qte"]?>" class="etroit"/></span></td>
											<td><a href="javascript:if (confirm('ATTENTION: vous allez supprimer un article.\nSi vous souhaitez effectuer cette suppression, cliquez sur OK, sinon Annuler')) {document.location='index.php?numpage=<?=$laPage->numpage?>&spec=<?=$spec?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numdoc=<?=$paras->numpara?>&lg=<?=$lg?>&supArt=<?=$article2["numdetail"]?>'}">supprimer</a></td>
										</tr>
									<?php
									}//fin du for
									?>
										<tr><td colspan="4">&nbsp;</td></tr>
										<tr class="entete" height="1"><td colspan="4"></td></tr>
										<tr>
											<td>TOTAL</td>
											<td><?=$lePanier->totalHTsansPort?> &euro;</td>
											<td></td>
											<td></td>
										</tr>
									<tr>
										<td colspan="4"><div align="left"> <br />
										<input type="button" class="bouton" onclick="javascript:document.forms[0].action.value='maj';document.forms[0].submit();" value="Mettre à jour le panier"/>
										  <br />
										&nbsp;</div></td>
									</tr>
									<tr>
									  <td colspan="4" class="sansmarge"><h2 class="supprmarge sanstrait">Informations de livraison</h2>									  </td>
					 			  </tr>
								  <tr class="entete"><td colspan="4"></td></tr>
									<tr><td colspan="4">&nbsp;</td></tr>
									<tr>
										<td>Pays de livraison :</td>
										<td colspan="3">
											<!-- Remplace par code ci-dessous
											<select name="selectPays" class="public" onchange="location='index.php?numpage=<?=$laPage->numpage?>&spec=<?=$spec?>&numrub=<?=$numrub?>&numcateg=<?=$numcateg?>&numsscateg=<?=$numsscateg?>&numdoc=<?=$paras->numpara?>&lg=<?=$lg?>&selectPays='+this.value">
											-->
											<select name="selectPays" id="selectPays" class="public" onchange="ajax('fonctions_ajax2.php?numpage=<?=$numpage?>&amp;spec=<?=$spec?>&amp;numrub=<?=$numrub?>&amp;numcateg=<?=$numcateg?>&amp;numsscateg=<?=$numsscateg?>&amp;lg=<?=$lg?>&amp;id=<?=$id?>', 'fraisport', '','POST', 'null', 'null','selectPays');">
											<option>------------------------------------------------------------</option>
											<option value="247" <?php if (!$selectPays) echo "selected='selected'";?>>France metropolitaine</option>
											<option>------------------------------------------------------------</option>
											<?php
											$result = mysql_query("SELECT * FROM if_pays ORDER BY pays");
											while ($row=mysql_fetch_array($result)) {
											?>
												<option value="<?=$row['numpays']?>" <?php if ($selectPays==$row['numpays'] || (!$selectPays && $row['numpays']==247)) echo "selected='selected'";?>><?=utf8_encode($row['pays'])?></option>
											<?php
											}//fin du while
											?>
											</select>
									 	</td>
									</tr>
									</table>
									<div id="fraisport">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
									  <td width="30%">Poids :</td>
										<td colspan="3">
										<?=$lePanier->totalPoids?>&nbsp;Kg
										</td>
									</tr>
									<tr>
										<td>Frais de port :</td>
										<td colspan="3">
										<strong><?=$lePanier->fraisPort;?> &euro;</strong>
										<?php
										if ($lePanier->pays=="247" && $lePanier->fraisPort=="0,00") {
										?>
											<br />
											Livraison gratuite pour toute commande supérieure à 35 € ou pour les documents à télécharger en ligne après paiement
										<?php
										}
										?>
										</td>
									</tr>
									<tr><td colspan="4"></td></tr>
									<tr><td colspan="4">&nbsp;</td></tr>
							<tr class="entete"><td colspan="4"></td></tr>
							<tr><td colspan="4">&nbsp;</td></tr>
							<tr>
								<td><strong>TOTAL</strong>  :</td>
								<td colspan="3"><strong><input name="totalpanier" value="<?=$lePanier->totalHT;?> &euro;" /></strong>
								</td>
							</tr>
							</table>
							</div>
							<?php
							}// fin if ($numarticle && $prix) else
							?>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <td colspan="4">&nbsp;</td>
							  </tr>
							<tr>
								<td width="30%">
								<?php
								$pageBdd = new Page();
								$pageBdd->pageSpecifique("catalogue-ifip-institut-du-porc");
								?>
									<input type="button" class="bouton" onclick="javascript:location='index.php?numpage=<?=$pageBdd->numpage?>&spec=<?=$pageBdd->nomFichier?>&numrub=<?=$pageBdd->numrub?>&numcateg=<?=$pageBdd->numcateg?>&numsscateg=<?=$pageBdd->numsscateg?>'" value="Retour au catalogue" />							  </td>
								<td colspan="3">
								<input type="button" class="bouton" onclick="javascript:confirmerCom()" value="Valider le panier &gt;&gt;" />
								</td>
							</tr>
							</table>
							<?php
							/* -------------------------- ETAPE 2 --------------------------------------------------------- */
							} else if ($etape==2) {// Etape 2 : compte client
								$laCom=new Commande();
								$laCom->numcom=$_SESSION['numcom'];
								$laCom->infosCommande();
								
							?>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td colspan="2" class="sansmarge"><h1 class="sansmarge">Etape 2</h1></td>
								</tr>
								<tr>
									<td colspan="2" class="sansmarge"><strong>Merci de vous identifier avec votre compte IFIP ou de créer un compte</strong><br />
								  <br /></td>
								</tr>
								<tr>
									<td colspan="2" class="sansmarge">N° de commande : <strong><?=$laCom->getNumCom()?></strong><br />
								  <?php
								  if ($lePanier->article!="o") {
								  ?>
								  Livraison : 
								  <?php
								  	if ($lePanier->totalPoids=="0,00") echo"Documents à télécharger après paiement;";
								  	else echo $laCom->nom_pays;
								  }
								  ?><br />
							      <br /></td>
								</tr>
								<tr>
									<td colspan="2" class="sansmarge"><h2 class="supprmarge">Vous êtes enregistré ? Identifiez-vous
								  </h2></td>
								</tr>
								<tr>
								  <td width="25%"><div align="right">Votre email de connexion&nbsp;:&nbsp;</div></td>
								  <td width="75%"><input  name="textEmailCpte" class="public"/></td>
								</tr>
								<tr>
									<td><div align="right">Votre mot de passe&nbsp;:&nbsp;</div></td>
									<td><input type="password" name="textPwdCpte" class="public" /></td>
								</tr>
								<tr>
								  <td><div align="right"></div></td>
								  <td><a href="index.php?spec=oublie&amp;numrub=<?=$numrub?>&amp;numcateg=<?=$numcateg?>&amp;numsscateg=<?=$numsscateg?>&amp;lg=<?=$lg?>&amp;prix=<?=$prix?>">Mot de passe oublié ?</a></td>
								  </tr>
								<tr>
								  <td>&nbsp;</td>
								  <td><input type="button" class="bouton" onclick="javascript:document.forms[0].action.value='seConnecter';document.forms[0].submit();" value="Se connecter" /></td>
								  </tr>
								<tr>
								  <td><br /></td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td colspan="2" class="sansmarge"><h2 class="supprmarge">Vous n'êtes pas enregistré ? Inscrivez-vous</h2></td>
								</tr>
								<tr>
									<td><div align="right">Civilité&nbsp;:&nbsp;</div></td>
									<td>
										<select name="selectCiv">
											<option>-</option>
											<option value="Mr">Mr</option>
											<option value="Mme">Mme</option>
											<option value="Mlle">Mlle</option>
										</select>									</td>
								</tr>
								<tr>
									<td><div align="right">Nom<em>*</em>&nbsp;:&nbsp;</div></td>
									<td><input type="text" name="textNom" class="public"/></td>
								</tr>
								<tr>
									<td><div align="right">Prénom<em>*</em>&nbsp;:&nbsp;</div></td>
									<td><input type="text" name="textPrenom" class="public" /></td>
								</tr>
								<tr>
									<td><div align="right">Société<em>*</em>&nbsp;:&nbsp;</div></td>
									<td><input type="text" name="textSociete" class="public" /></td>
								</tr>
								<tr>
									<td><div align="right">Adresse<em>*</em>&nbsp;:&nbsp;</div></td>
									<td><input type="text" name="textAdr1" class="public" /></td>
								</tr>
								<tr>
									<td></td>
									<td><input type="text" name="textAdr2" class="public" /></td>
								</tr>
								<tr>
									<td><div align="right">Code postal<em>*</em>&nbsp;:&nbsp;</div></td>
									<td><input type="text" name="textCp" class="public" /></td>
								</tr>
								<tr>
									<td><div align="right">Ville<em>*</em>&nbsp;:&nbsp;</div></td>
									<td><input type="text" name="textVille" class="public" /></td>
								</tr>
								<tr>
									<td><div align="right">Pays * &nbsp;:&nbsp;</div></td>
									<td>
									<select name="selectPays" class="public">	
									<?php
									$result = mysql_query("SELECT * FROM if_pays ORDER BY pays");
									while ($row=mysql_fetch_array($result)) {
									?>
										<option value="<?=$row['numpays']?>" <?php if ($row['numpays']==$laCom->numpays) echo "selected='selected'"; ?>><?=utf8_encode($row['pays'])?></option>
									<?php
									}//fin du while
									?>
									</select>									</td>
								</tr>
								<tr>
									<td><div align="right">Téléphone<em>*</em>&nbsp;:&nbsp;</div></td>
									<td><input type="text" name="textTel" class="public" /></td>
								</tr>
								<tr>
									<td><div align="right">Fax&nbsp;:&nbsp;</div></td>
									<td><input type="text" name="textFax" class="public" /></td>
								</tr>
								<tr>
									<td><div align="right">Email<em>*</em>&nbsp;:&nbsp;</div></td>
									<td><input type="text" name="textEmail" class="public" /></td>
								</tr>
								<tr>
									<td><div align="right">Mot de passe<em>*</em>&nbsp;:&nbsp;</div></td>
									<td><input type="password" name="textPwd" class="public" /></td>
								</tr>
								<tr>
									<td></td>
									<td><input type="button" class="bouton" onclick="javascript:creerCompte()" value="Créer un compte" /></td>
								</tr>
								
								</table><input type="hidden" name="prix" value="<?=$prix?>" />
							<?php
							/* -------------------------- ETAPE 3 --------------------------------------------------------- */
							} else if ($etape==3) {// Etape 3 : facturation et livraison
								$laCom=new Commande();
								$laCom->numcom=$_SESSION['numcom'];
								$laCom->infosCommande();
								if ($action!="seConnecter" && $action!="creerCompte") {
									$client=new Client();
									$client->numclient=$_SESSION['numclient'];
									$client->infosClient();
								}
							?>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td colspan="2"><h1 class="sansmarge">Etape 3 </h1></td>
								</tr>
								<tr>
									<td colspan="2">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="2">Veuillez indiquer une adresse de livraison et de facturation (celles-ci peuvent être différentes).</td>
								</tr>
								<tr>
									<td><strong>N° de commande</strong> : <?=$laCom->getNumCom()?></td>
									<td>&nbsp;</td>
								</tr>
								<tr>
								  <td>&nbsp;</td>
								  <td><input type="checkbox" name="checkCopier" onclick="javascript:copierAdresse()" class="checkbox" />&nbsp;<strong>Copier l'adresse de livraison </strong></td>
								  </tr>
								<tr>
									<td>
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td colspan="2"><h2 class="supprmarge sanstrait">Livraison</h2></td>
											</tr>
											<tr>
												<td>Nom</td>
												<td><input type="text" name="textNom_l" value="<?=$client->nom?>" class="public" /></td>
											</tr>
											<tr>
												<td>Prénom</td>
												<td><input type="text" name="textPrenom_l" value="<?=$client->prenom?>" class="public"/></td>
											</tr>
											<tr>
												<td>Société</td>
												<td><input type="text" name="textSociete_l" value="<?=$client->raison?>"  class="public"/></td>
											</tr>
											<tr>
												<td>Adresse</td>
												<td><input type="text" name="textAdr1_l" value="<?=$client->adr1?>" class="public"/></td>
											</tr>
											<tr>
												<td></td>
												<td><input type="text" name="textAdr2_l" value="<?=$client->adr2?>" class="public" /></td>
											</tr>
											<tr>
												<td>Code postal</td>
												<td><input type="text" name="textCp_l" value="<?=$client->cp?>" class="public" /></td>
											</tr>
											<tr>
												<td>Ville</td>
												<td><input type="text" name="textVille_l" value="<?=$client->ville?>" class="public" /></td>
											</tr>
											<tr>
												<td>Pays</td>
												<td>
												<select name="selectPays_l" class="public">	
												<?php
												$result = mysql_query("SELECT * FROM if_pays ORDER BY pays");
												while ($row=mysql_fetch_array($result)) {
												?>
													<option value="<?=$row['numpays']?>" <?php if ($laCom->numpays==$row['numpays']) echo "selected='selected'";?>><?=utf8_encode($row['pays'])?></option>
												<?php
												}//fin du while
												?>
												</select>												</td>
											</tr>
											<tr>
												<td>Téléphone</td>
												<td><input type="text" name="textTel_l" value="<?=$client->tel?>" class="public"/></td>
											</tr>
											<tr>
											  <td>Fax</td>
											  <td><input name="textFax_l" type="text" class="public" id="textFax_l" value="<?=$client->fax?>"/></td>
										  </tr>
										</table>									</td>
									<td>
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td colspan="2"><h2 class="supprmarge sanstrait">Facturation</h2></td>
											</tr>
											<tr>
												<td>Nom</td>
												<td><input type="text" name="textNom_f" value="" class="public" /></td>
											</tr>
											<tr>
												<td>Prénom</td>
												<td><input type="text" name="textPrenom_f" value="" class="public"/></td>
											</tr>
											<tr>
												<td>Société</td>
												<td><input type="text" name="textSociete_f" value="" class="public"/></td>
											</tr>
											<tr>
												<td>Adresse</td>
												<td><input type="text" name="textAdr1_f" value="" class="public"/></td>
											</tr>
											<tr>
												<td></td>
												<td><input type="text" name="textAdr2_f" value="" class="public" /></td>
											</tr>
											<tr>
												<td>Code postal</td>
												<td><input type="text" name="textCp_f" value="" class="public" /></td>
											</tr>
											<tr>
												<td>Ville</td>
												<td><input type="text" name="textVille_f" value="" class="public" /></td>
											</tr>
											<tr>
												<td>Pays</td>
												<td>
												<select name="selectPays_f" class="public" >
												<option>Sélectionnez</option>	
												<?php
												$result = mysql_query("SELECT * FROM if_pays ORDER BY pays");
												while ($row=mysql_fetch_array($result)) {
												?>
													<option value="<?=$row['numpays']?>" ><?=utf8_encode($row['pays'])?></option>
												<?php
												}//fin du while
												?>
												</select>												</td>
											</tr>
											<tr>
												<td>Téléphone</td>
												<td><input type="text" name="textTel_f" value="" class="public" /></td>
											</tr>
											<tr>
												<td>Fax</td>
												<td><input type="text" name="textFax_f" value="" class="public" /></td>
											</tr>
										</table>									</td>
								</tr>
								<tr>
									<td colspan="2"><input type="button" class="bouton" onclick="javascript:validerLivraison()" value="Confirmer la commande" /></td>
								</tr>
</table>
							<?php
							/*-------------------------- ETAPE 4 --------------------------------------------------------*/
							} else if ($etape==4) {//fin else if ($etape==3) : type de réglement
							?>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<?php
								if (!$radioReg) {
							?>
									<?php
									if ($lien) {//lien direct vers le panier pour l'inscription définitive à la formation (ce lien apparait dans le mail envoyé au client lorque l'admin a validé les dates de la formation sur mesure (méthode validerForma() de l'objet Formation)
									if ($_SESSION['numcom']) {
										$list_article=$lePanier->listerArticlesForm();
										$laForma=new Formation();
										$laForma->numpara=$list_article[0]["numpara"];
										$laForma->infosFormation();
									}
									?>
										<tr>
											<td colspan="2"><strong>Réglement de la formation "<?=$laForma->titrePara?>"</strong></td>
										</tr>
										<tr>
											<td><strong>Tarif : </strong></td>
											<td><strong><?=$list_article[0]["montantTTC"]?> €</strong><br /><br /></td>
										</tr>
										<input type="hidden" name="forma" value="1" />
									<?php
									} else { // fin de if ($lien)
									?>
										<tr>
									<td colspan="2"><h1 class="sansmarge">Etape 4 </h1></td>
								</tr>
									<?php
									}
									?>
									<tr>
										<td width="150">
										Vous souhaitez régler par :</td>
									  <td>
									    <input type="radio" class="radio" name="radioReg" value="ch" checked="checked"/>
								      &nbsp;chèque (banque française uniquement) </td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>
										  <input type="radio"  class="radio" name="radioReg" value="vi" />
									    &nbsp;virement bancaire 										<br />
                                        
                                        
									    &nbsp;</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>                                  
                                          <input type="hidden" name="totalTTC" value="<?=$lePanier->totalTTC?>" />
										  <input type="radio"  class="radio" name="radioReg" value="cb" />
									    &nbsp;carte bancaire	-	paiement	en	ligne	sécurisé	Crédit	Agricole		<br />
                                        
                                        
									    &nbsp;</td>
									</tr>
									<tr>
									  <td>&nbsp;</td>
									  <td>&nbsp;</td>
							  </tr>
									<tr>
									  <td>&nbsp;</td>
									  <td><input type="checkbox" name="cgv" class="checkbox" value="1" />
									  J'ai lu et j'accepte les conditions générales de ventes : <a href="cgv-formations-ifip-institut-du-porc.pdf" target="_blank">cgv formations ifip</a> - <a href="cgv-publications-ifip-institut-du-porc.pdf" target="_blank">cgv publications</a> </td>
							  </tr>
									<tr>
									  <td>&nbsp;</td>
									  <td>
                                      <!-- ******************************************************************** 
									  Ce bouton pointe vers paiement.php au lieu de panier-ifip...php 
									  (cf.condition sur la valeur de action dans form#admin de index.php)
									  On est oblige a cause du fonctionnement specifique au Credit Agricole
									  (lancement de leur exécutable)
									  ******************************************************************** 
									  -->
									  <input type="button" class="bouton" onclick="javascript:validerReglement()" value="Procéder au paiement" name="bouton_paiement" />                                      </td>
							  </tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									
									<?php
								} else if ($paiement=="ok" && $radioReg=="cb"){ // fin if (!$radioReg)
									?>
										<tr>
											<td colspan="2" class="sansmarge"><h1 class="sansmarge">Etape 5 </h1></td>
										</tr>	
										<tr>
										  <td colspan="2" class="sansmarge"><strong>Nous vous remercions pour votre commande qui a bien été enregistrée par l'Ifip - Institut du porc<br />
									      et pour laquelle le paiement en ligne par carte bancaire a été validé.</strong><br />
									      <br />
										    2 mails viennent d'être envoyés à l'adresse <?=$client->email?><br />
									        - Un ticket de confirmation de votre paiement bancaire.<br />
										      - 
									        Un mail récapitulatif de votre commande. <br /> 
										    										<br />
											<br />
                                            <?php
											$pageSpecMonCompte=new Page();
											$pageSpecMonCompte->pageSpecifique("compte-ifip");
											?>											
											<strong>Si vous avez acheté des documents téléchargeables en ligne, nous vous invitons à vous rendre dans la rubrique <a href="index.php?spec=<?=$pageSpecMonCompte->nomFichier?>&numpage=<?=$pageSpecMonCompte->numpage?>&numrub=<?=$pageSpecMonCompte->numrub?>&numcateg=<?=$pageSpecMonCompte->numcateg?>&numsscateg=<?=$pageSpecMonCompte->numsscateg?>&lg=<?=$pageSpecMonCompte->lg?>">Mon Compte</a> (accessible en haut et à droite de toutes les pages du site)&nbsp; et à cliquer sur le détail de votre commande. <br />
											Si vous avez acheté des ouvrages ou CD-Rom envoyés par courrier postal, ceux-ci sont en cours de préparation par nos services. </strong><br />
											<br />
											Cordialement,<br />
											Brigitte Laval <br />
											l'IFIP, Institut du Porc<br />
											Service Editions<br />
149 rue de Bercy<br />
75595 Paris Cedex 12<br />
											<br />
										  <br /></td>
										</tr>
							<?php
										unset($_SESSION['numcom']);
									
								/******************   Paiement refuse **************************************/
								} else if($paiement=="refuse" && $radioReg=="cb"){
									?>
										<tr>
											<td colspan="2" class="sansmarge"><h1 class="sansmarge">Etape 5 </h1></td>
										</tr>	
										<tr>
										  <td colspan="2" class="sansmarge">Une erreur est survenue lors du paiement en ligne de votre panier ou votre paiement a été refusé. <br />
										    Pour plus de sécurité, votre panier a été réinitialisé. <br />
										    Merci de recommencer votre choix de documents.<br />
										    <br />
										    <a href="publications-ifip-institut-du-porc.html">Consulter la base de données documentaire</a><br /> 
										    										<br />
											<br />
											
											
											Cordialement,<br />
											Brigitte Laval <br />
											l'IFIP, Institut du Porc<br />
											Service Editions<br />
149 rue de Bercy<br />
75595 Paris Cedex 12<br />
											<br />
										  <br /></td>
										</tr>
                                        
                                        <? unset($_SESSION['numcom']); 
										
								/******************   Paiement annule **************************************/
								} else if($paiement=="annule" && $radioReg=="cb"){
									?>
										<tr>
											<td colspan="2" class="sansmarge"><h1 class="sansmarge">Etape 5 </h1></td>
										</tr>	
										<tr>
										  <td colspan="2" class="sansmarge">L'opération de paiment bancaire en ligne a été annulée selon votre demande.<br /> 
										    Pour plus de sécurité, votre panier a été réinitialisé. <br />
Merci de recommencer votre choix de documents.<br />
<br />
<a href="publications-ifip-institut-du-porc.html">Consulter la base de données documentaire</a><br /> 
										    										<br />
											<br />
											
											
											Cordialement,<br />
											Brigitte Laval<br />
											l'IFIP, Institut du Porc<br />
											Service Editions<br />
149 rue de Bercy<br />
75595 Paris Cedex 12<br />
											<br />
										  <br /></td>
										</tr>
                                        
                                         <? 
										 //$laCom= new Commande();
										 //$laCom->numcom=$_SESSION['numcom'];
										 //$laCom->supprimerCommande();?>
                                         <? unset($_SESSION['numcom']); 
									
								/******************   Cheque **************************************/
								} else if ($radioReg=="ch") { // paiement par chèque ?>
                           <tr>
											<td colspan="2" class="sansmarge"><h1 class="sansmarge">Etape 5 </h1></td>
							  </tr>	
										<tr>
										  <td colspan="2" class="sansmarge">
										  Nous vous remercions pour votre commande qui a bien été enregistrée par l'Institut.<br />
										    Un mail de confirmation vient de vous être envoyé à l'adresse 
										      <?=$client->email?>.
									        <br /> 
										    <br />
										    Veuillez adresser un chèque bancaire d'un montant de 
									        <?=$montantCh?> 
									        € à l'adresse suivante :<br />
									        <br />
											<strong>Ifip	-	Institut	du	porc</strong><br />
											A l'attention de Brigitte LAVAL <br />
											Service Editions<br />
											149 rue de Bercy<br />
											75595 Paris Cedex 12											<br />
											<br />
											<?php
											$pageSpecMonCompte=new Page();
											$pageSpecMonCompte->pageSpecifique("compte-ifip");
											?>
											<strong>Après réception de votre chèque de paiement, un mail de validation de votre commande sera envoyé à l'adresse 
											<?=$client->email?>. </strong><br />
											<strong>Si vous avez acheté des documents téléchargeables en ligne, vous pourrez alors vous rendre dans la rubrique <a href="index.php?spec=<?=$pageSpecMonCompte->nomFichier?>&amp;numpage=<?=$pageSpecMonCompte->numpage?>&amp;numrub=<?=$pageSpecMonCompte->numrub?>&amp;numcateg=<?=$pageSpecMonCompte->numcateg?>&amp;numsscateg=<?=$pageSpecMonCompte->numsscateg?>&amp;lg=<?=$pageSpecMonCompte->lg?>">Mon Compte</a> (accessible en haut et à droite de toutes les pages du site) et cliquer sur le détail de votre commande. </strong><br />
											<br />
											Cordialement,<br />
											Brigitte Laval <br />
											l'IFIP, Institut du Porc<br />
											<br />
										  <br /></td>
										</tr>
                                        
                           <? unset($_SESSION['numcom']); 
						      /******************   Virement **************************************/
								} else if ($radioReg=="vi") { // paiement par virement bancaire ?>
                           <tr>
											<td colspan="2" class="sansmarge"><h1 class="sansmarge">Etape 5 </h1></td>
							  </tr>	
										<tr>
										  <td colspan="2" class="sansmarge">
										    <p>Nous vous remercions pour votre commande qui a bien été enregistrée par l'Institut.<br />
										    Un mail de confirmation vient de vous être envoyé à l'adresse 
										      <?=$client->email?>
										      .
									          <br /> 
										      <br />
										    Veuillez nous adresser un virement bancaire d'un montant de 
									        <?=$montantCh?> 
									        €.<br />
									        <br />
											<strong>Coordonnées bancaires de l'IFIP-Institut du porc :</strong><br />
											<strong> <br />
										    </strong><a href="coordonnees-bancaires-ifip.pdf" target="_blank">Télécharger les coordonnées bancaires </a><strong><br />
										  Crédit Agricole<br />
										    </strong>26, quai de la 
Rapée - 75596 Paris Cedex 12 </p>
										    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td colspan="4"><div align="center"><strong>Domiciliation</strong></div>                                                  <div align="center"></div>                                                  <div align="center"></div>                                                  <div align="center"></div></td>
                                              </tr>
                                              <tr>
                                                <td colspan="4"><div align="center"><strong>CRCA PARIS C AFF RENNES</strong></div></td>
                                              </tr>
                                              <tr>
                                                <td><div align="center">18206</div></td>
                                                <td><div align="center">00280</div></td>
                                                <td><div align="center">00220411001</div></td>
                                                <td><div align="center">14</div></td>
                                              </tr>
                                              <tr>
                                                <td><div align="center">Banque</div></td>
                                                <td><div align="center">Guichet</div></td>
                                                <td><div align="center">N° de compte </div></td>
                                                <td><div align="center">Clé RIB </div></td>
                                              </tr>
                                            </table>										    
										    <p>&nbsp;</p>
										    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td><div align="center"><strong>I</strong>nternational <strong>B</strong>ank <strong>A</strong>ccount <strong>N</strong>umber<br />
                                                    <strong>FR76&nbsp;1820&nbsp;&nbsp;6002&nbsp;&nbsp;8000&nbsp;&nbsp;2204&nbsp;1100&nbsp;&nbsp;114</strong><br />
                                                    <strong>B</strong>ank <strong>I</strong>dentifier <strong>C</strong>ode<br />
                                                    <strong>AGRIFRPP882</strong></div></td>
                                              </tr>
                                            </table>
										    <p><br />
										      <br />
									          <br />
									          <?php
											$pageSpecMonCompte=new Page();
											$pageSpecMonCompte->pageSpecifique("compte-ifip");
											?>
									          <strong>Après réception de votre virement bancaire, un mail de validation de votre commande sera envoyé à l'adresse 
									          <?=$client->email?>
									          . </strong><br />
										      <strong>Si vous avez acheté des documents téléchargeables en ligne, vous pourrez alors vous rendre dans la rubrique <a href="index.php?spec=<?=$pageSpecMonCompte->nomFichier?>&amp;numpage=<?=$pageSpecMonCompte->numpage?>&amp;numrub=<?=$pageSpecMonCompte->numrub?>&amp;numcateg=<?=$pageSpecMonCompte->numcateg?>&amp;numsscateg=<?=$pageSpecMonCompte->numsscateg?>&amp;lg=<?=$pageSpecMonCompte->lg?>">Mon Compte</a> (accessible en haut et à droite de toutes les pages du site) et cliquer sur le détail de votre commande. </strong><br />
										      <br />
										      Cordialement,<br />
										      Brigitte Laval <br />
										      l'IFIP, Institut du Porc<br />
										      Service Editions<br />
149 rue de Bercy<br />
75595 Paris Cedex 12 <br />
										      <br />
									          <br />
								            </p>									      </td>
										</tr>
                                        
                           <? unset($_SESSION['numcom']);
						   		} // fin 
						   ?>
							</table>
							<?php
							/*-------------------------- ETAPE 6 --------------------------------------------------------*/
							} else if ($etape==6) {//fin else if ($etape==4) : demande de devis
							?>
							<h1 class="sansmarge">Etape 4 </h1>
							<br />
							Nous vous remercions pour votre demande qui nous a bien été transmise pour une estimation  des frais de livraison sur votre pays. <br />
							Un mail de confirmation vient d'être envoyé à l'adresse <?=$client->email?>.<br />
							Vous recevrez dans les prochains jours un mail précisant le coût de la livraison. <br />
							<br />
							<br />
							<span class="sansmarge">Cordialement,<br />
Brigitte Laval <br />
l'IFIP, Institut du Porc<br />
Service Editions<br />
149 rue de Bercy<br />
75595 Paris Cedex 12</span><br />
			 <br />
							<?php
								unset($_SESSION['numcom']);
							} // fin else if ($etape==6)
							?>
				<?php
				} else {//fin if ($_SESSION['numcom'])
				?>
<p><strong>Votre panier est vide</strong><br />
  Vous pouvez par exemple, <a href="publications-ifip-institut-du-porc.html">consulter la base de données documentaire</a> <br />
  pour connaître les publications disponibles à la vente et à la consultation .					</p>
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
					<br />
				<?php
				}
				?>
				<input type="hidden" name="action" id="action" />
				<!-- Fin affichage contenu non dynamique (provenant du CMS) -->
				
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	</div>
</div>			
<?php

}//fin if ($laPage->nomPageGoogle)
?>