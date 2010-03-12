/**************************** general **************************************************************/
function checkFormatTel(num){
	var reg=new RegExp(" ", "g");
	num=num.replace(reg,"");
	var reg=new RegExp("[.]", "g");
	num=num.replace(reg,"");
	var reg=new RegExp("[,]", "g");
	num=num.replace(reg,"");
	
	var reg1=/^0[1-6]{1}[0-9]{8}$/;
	var reg3=/^(33|[+]33|0033)[1-6]{1}[0-9]{8}$/;
	var reg4=/^(33|[+]33|0033)870[0-9]{6}$/;
	
	mes=0;
	if (reg1.exec(num)==null){
	 	if (reg3.exec(num)==null) {
		   if (reg4.exec(num)==null) {
		   	  mes=1;
		   }
		}
	}
	return mes;
}

function checkFormatPort(num){
	var reg=new RegExp(" ", "g");
	num=num.replace(reg,"");
	var reg=new RegExp("[.]", "g");
	num=num.replace(reg,"");
	var reg=new RegExp("[,]", "g");
	num=num.replace(reg,"");
	
	var reg1=/^06{1}[0-9]{8}$/;
	var reg3=/^(33|[+]33|0033)6{1}[0-9]{8}$/;
	
	mes=0;
	if (reg1.exec(num)==null){
	 	if (reg3.exec(num)==null) {
		   	  mes=1;
		}
	}
	return mes;
}

function messagerie(adresse,taille) {
		mes=0;
	
		validelog = false;
		validedom = false;
		valideext = false;
		
		arob = adresse.lastIndexOf("@");
		login = adresse.substring(0,arob);
		
		pointfinal = adresse.lastIndexOf(".");
		extension = adresse.substring(pointfinal,taille);
		
		domaine = adresse.substring(arob+1,pointfinal);
		
		
		if ( login.length > 1 ) {
		validelog = true;
		} else {
		  validelog = false;
		}
		
		if ( domaine.length > 1 ) {
		validedom = true;
		} else {
			 validelog = false;
		}
		if ( pointfinal > -1 && (extension.length == 3 || extension.length == 4 || extension.length == 5) ) {
		   valideext = true;
		} else {
		  valideext = false;
		}
		
		if ( validelog == false || validedom == false || valideext == false) {
		   mes=1;
		  
		} 
		return mes;
}

/************************* page admin/ajouter-page ***********************************/
function ajoutePage() {
	if (!document.forms[0].textNomG.value) {
		alert("Veuillez saisir un nom de page Google !");
		document.forms[0].textNomG.focus();
	} else if (!document.forms[0].textTitre.value) {
		alert("Veuillez saisir le titre de la page !");
		document.forms[0].textTitre.focus();
	} else if (!document.forms[0].textAlias.value) {
	   alert("Veuillez saisir un alias pour la page !");
		document.forms[0].textAlias.focus();
	} else {
	   document.forms[0].submit(); 
	}

}

/************************* page admin/ajouter-parag ***********************************/
function AddLiens(numpara)
{
	if (numpara) {
		var cpt= eval("nextHiddenIndex"+numpara);  
		fileObj="lien" + cpt + "_" + numpara; 	
		eval(fileObj+'.style.display = document.all ? "block" : "table-row"'); 
		cpt++; 	
		eval("nextHiddenIndex"+numpara+"="+cpt);	 
		eval("document.forms[0].nbLiens" + numpara + ".value="+cpt); 
		if (cpt==10) eval("plusLiens" + numpara + ".style.display = 'none'");
	} else {
		var cpt= nextHiddenIndex;	 
		fileObj="lien" + cpt + "_";	 
		eval(fileObj+'.style.display = document.all ? "block" : "table-row"');
		nextHiddenIndex++; 	
		document.forms[0].nbLiens.value=nextHiddenIndex;	
		if (nextHiddenIndex==10) eval("plusLiens" + numpara + ".style.display = 'none'"); 
	}   
	
}


		
function AddPhotos(numpara)
{	
	if (numpara) {
		var cpt= eval("nextHiddenIndexP"+numpara);  
		fileObj="photo" + cpt + "_" + numpara; 	
		eval(fileObj+'.style.display = document.all ? "block" : "table-row"'); 
		cpt++; 	
		eval("nextHiddenIndexP"+numpara+"="+cpt);	 
		eval("document.forms[0].nbPhotos" + numpara + ".value="+cpt); 
		if (cpt==10) eval("plusPhotos" + numpara + ".style.display = 'none'");
	} else {
		var cpt= nextHiddenIndexP;	 
		fileObj="photo" + cpt + "_";	 
		eval(fileObj+'.style.display = document.all ? "block" : "table-row"');
		nextHiddenIndexP++; 	
		document.forms[0].nbPhotos.value=nextHiddenIndexP;	
		if (nextHiddenIndexP==10) eval("plusPhotos" + numpara + ".style.display = 'none'"); 
	}   
	
		   
}


		
function AddVideos(numpara)
{
	if (numpara) {
		var cpt= eval("nextHiddenIndexV"+numpara);  
		fileObj="video" + cpt + "_" + numpara; 	
		eval(fileObj+'.style.display = document.all ? "block" : "table-row"'); 
		cpt++; 	
		eval("nextHiddenIndexV"+numpara+"="+cpt);	 
		eval("document.forms[0].nbVideos" + numpara + ".value="+cpt); 
		if (cpt==10) eval("plusVideos" + numpara + ".style.display = 'none'");
	} else {
		var cpt= nextHiddenIndexV;	 
		fileObj="video" + cpt + "_";	 
		eval(fileObj+'.style.display = document.all ? "block" : "table-row"');
		nextHiddenIndexV++; 	
		document.forms[0].nbVideos.value=nextHiddenIndexV;	
		if (nextHiddenIndexV==10) eval("plusVideos" + numpara + ".style.display = 'none'"); 
	}   
	
}


		
function AddFichiers(numpara)
{
	if (numpara) {
		var cpt= eval("nextHiddenIndexF"+numpara);  
		fileObj="fichier" + cpt + "_" + numpara; 	
		eval(fileObj+'.style.display = document.all ? "block" : "table-row"'); 
		cpt++; 	
		eval("nextHiddenIndexF"+numpara+"="+cpt);	 
		eval("document.forms[0].nbFichiers" + numpara + ".value="+cpt); 
		if (cpt==10) eval("plusFichiers" + numpara + ".style.display = 'none'");
	} else {
		var cpt= nextHiddenIndexF;	 
		fileObj="fichier" + cpt + "_";	 
		eval(fileObj+'.style.display = document.all ? "block" : "table-row"');
		nextHiddenIndexF++; 	
		document.forms[0].nbFichiers.value=nextHiddenIndexF;	
		if (nextHiddenIndexF==10) eval("plusFichiers" + numpara + ".style.display = 'none'"); 
	}   
	
}


function ajouteParag() {
  for (i=1;i<=10;i++) {
	  err=0;
	  if (eval("document.forms[0].fileFich"+i+"_.value!=''") && eval("document.forms[0].textLibFich"+i+"_.value==''") ) {
		 err=1;
		 alert(eval("document.forms[0].textLibFich"+i+"_.value"));
		 break;
	  }
  }
	
  if (err==1) {
	 alert("Attention, vous devez saisir un libellé pour le fichier !"); 
  } else {
	  if (confirm("Souhaitez-vous saisir un autre paragraphe ?")) {
		document.forms[0].paragraphe.value=1;
	  } else {
	   document.forms[0].paragraphe.value='';
	  }
	   document.forms[0].submit();
  }

}

/************************* page admin/lister-page ***********************************/
function supPage() {
     cpt = 0;
	 i = 0;
	 while (i <= document.forms[0].elements.length-1) {
			if (document.forms[0].elements[i].name=='supPage[]' && document.forms[0].elements[i].checked==true) {
				cpt++;
			}
			i++;
	 }
	 
	 if (cpt==0){
	 	alert ("Veuillez sélectionner au moins une page !")
	} else {
	    if (confirm("Etes-vous certain de vouloir supprimer les pages?")) {
	 	document.forms[0].submit(); 
	  }
	}
	 
} 

/************************* page admin/parag.php ***********************************/
function conf_supAssoc(a,nom_contenu) {

if(confirm('ATTENTION : vous allez supprimer ' + nom_contenu + '.\nSi vous souhaitez effectuer cette suppression, cliquez sur OK sinon sur Annuler.')) {
	window.open("admin/"+a,'','toolbar=0,location=0,directories=0,menuBar=0,scrollbars=0,resizable=1,width=200,height=100');
	}
}

function fermer_fen(div) {
  
  eval("window.opener.document.getElementById('"+div+"').style.display = 'none'");	
  /**if (div=="div_pdf1") {
  	window.opener.document.getElementById('textPdf1').value="";
  } else if (div=="div_pdf2") {
  	window.opener.document.getElementById('textPdf2').value=""; 
  }	 else if (div=="div_fds") {  
  	 window.opener.document.getElementById('textDateFDS').value=""; 
  }**/
   this.close();
}

function popup(a) {
	window.open("admin/"+a,'','toolbar=0,location=0,directories=0,menuBar=0,scrollbars=0,resizable=1,width=400,height=500');
}
/************************* page admin/modifier-page.php ***********************************/
function afficher_paras() {
   li_paras_assoc.style.display = document.all ? "block" : "table-row";
   legend_para.style.display = document.all ? "block" : "table-row";
}

function afficher_new_paras() {
   li_paras_new1.style.display = document.all ? "block" : "table-row";
   li_paras_new2.style.display = document.all ? "block" : "table-row";
   li_paras_new3.style.display = document.all ? "block" : "table-row";
   li_paras_new4.style.display = document.all ? "block" : "table-row";
   legend_para1.style.display = document.all ? "block" : "table-row";
}  

/************************* page admin/ajouter-menu.php ***********************************/
function ajouteMenu() {
    if (!document.forms[0].textLibMenu.value) {
	    alert("Veuillez saisir un libellé !");
		document.forms[0].textLibMenu.focus();
	} else {
	   document.forms[0].submit(); 
	}

}


/************************* page admin/admin-site.php ***********************************/
function valideSite() {
    if (!document.forms[0].textUrl.value) {
	    alert("Veuillez saisir une url pour le site !");
		document.forms[0].textUrl.focus();
	} else if (!document.forms[0].textPath.value) {
	    alert("Veuillez saisir un chemin sur le serveur !");
		document.forms[0].textPath.focus();
	} else {
	   document.forms[0].submit(); 
	}
}

/************************* page admin/ajouter-uti.php ***********************************/
function valideUti() {
    if (!document.forms[0].textLogin.value) {
	    alert("Veuillez saisir un identifiant pour l'utilisateur !");
		document.forms[0].textLogin.focus();
	} else if (!document.forms[0].textPwd.value) {
	    alert("Veuillez saisir un mot de passe pour l'utilisateur !");
		document.forms[0].textPwd.focus();
	} else {
	   document.forms[0].submit(); 
	}
}

/************************* page admin/ajouter-contact.php ***********************************/
function valideCont() { 
    if (!document.forms[0].textNom.value) {
	    alert("Veuillez saisir un nom pour le contact !");
		document.forms[0].textNom.focus();
	} else if (document.forms[0].textEmail.value && messagerie(document.forms[0].textEmail.value,document.forms[0].textEmail.value.length)==1) {
	    alert("L'adresse e-mail n'est valide !");
		document.forms[0].textEmail.focus();
	} else {
	   document.forms[0].submit(); 
	}
}

/************************* page admin/ajouter-forma.php ***********************************/
function valideForma() { 
    if (!document.forms[0].textTitre.value) {
	    alert("Veuillez saisir un titre pour la formation !");
		document.forms[0].textTitre.focus();
	/**} else if (!document.forms[0].textDateDeb.value) {
	    alert("Veuillez saisir une date de début !");
		document.forms[0].textDateDeb.focus();**/
	} else {
	   document.forms[0].submit(); 
	}
}

/************************* page admin/ajouter-doc.php ***********************************/
function valideDoc() { 
    if (!document.forms[0].selectType.value && !document.forms[0].textNewType.value) {
	    alert("Veuillez saisir un type de documentation !");
		document.forms[0].selectType.focus();
	/**} else if (!document.forms[0].textDateDeb.value) {
	    alert("Veuillez saisir une date de début !");
		document.forms[0].textDateDeb.focus();**/
	} else {
	   document.forms[0].submit(); 
	}
}

/************************* page admin/ajouter-prof.php ***********************************/
function valideProf() { 
    if (!document.forms[0].textNom.value) {
	    alert("Veuillez saisir un nom !");
		document.forms[0].textNom.focus();
	} else if (!document.forms[0].textEmail.value) {
	    alert("Veuillez saisir une adresse e-mail !");
		document.forms[0].textEmail.focus();
	} else if (document.forms[0].textEmail.value && messagerie(document.forms[0].textEmail.value,document.forms[0].textEmail.value.length)==1) {
	    alert("L'adresse e-mail n'est pas valide !");
		document.forms[0].textEmail.focus();
	} else if (!document.forms[0].textPwd.value) {
	    alert("Veuillez saisir un mot de passe !");
		document.forms[0].textPwd.focus();
	} else {
	   document.forms[0].submit(); 
	}
}

/************************* page admin/modifier-client.php ***********************************/
function valideClient() { 
    if (!document.forms[0].textNom.value) {
	    alert("Veuillez saisir un nom !");
		document.forms[0].textNom.focus();
	} else if (!document.forms[0].textEmail.value) {
	    alert("Veuillez saisir une adresse e-mail !");
		document.forms[0].textEmail.focus();
	} else if (document.forms[0].textEmail.value && messagerie(document.forms[0].textEmail.value,document.forms[0].textEmail.value.length)==1) {
	    alert("L'adresse e-mail n'est pas valide !");
		document.forms[0].textEmail.focus();
	} else if (!document.forms[0].textPwd.value) {
	    alert("Veuillez saisir un mot de passe !");
		document.forms[0].textPwd.focus();
	} else {
	   document.forms[0].submit(); 
	}
}



/************************* page admin/modifier-com.php ***********************************/
function valideCommande() { 
	document.forms[0].action.value="modifier";
	document.forms[0].submit(); 
}

/************************* page admin/lister-com.php ***********************************/
function valideRech() {
	document.forms[0].action.value="rechercher";
	document.forms[0].submit();
}

/************************* page admin/ajouter-breve.php ***********************************/
function valideBreve() {
	if (!document.forms[0].textTitre.value) {
	    alert("Veuillez saisir un titre pour la brève !");
		document.forms[0].textTitre.focus();
	} else {
	   document.forms[0].submit(); 
	}
}

/************************* page admin/ajouter-actu.php ***********************************/
function valideActu() {
	if (!document.forms[0].textTitre.value) {
	    alert("Veuillez saisir un titre pour la brève !");
		document.forms[0].textTitre.focus();
	} else {
	   document.forms[0].submit(); 
	}
}


/************************* page admin/ajouter-arti.php ***********************************/
function valideArti() {
	if (!document.forms[0].textLibelle.value) {
	    alert("Veuillez saisir un libellé pour l'article !");
		document.forms[0].textLibelle.focus();
	} else {
	   document.forms[0].submit(); 
	}
}

/************************* page.php ***********************************/
function montrerFichesAction() {
	var i,args=montrerFichesAction.arguments; 
  	for (i=0; i<(args.length); i+=2) {   
		if (document.layers) {
			if (document[args[i]].visibility == 'show') {
				CacherCalque(args[i]);
				MontrerCalque(args[i+1]);
			} else  {
				MontrerCalque(args[i]);
				CacherCalque(args[i+1]);
			}
		} else if (document.all) {
			if (document.all[args[i]].style.visibility == 'visible' ) {
				CacherCalque(args[i]);
				MontrerCalque(args[i+1]);
			} else  {
				MontrerCalque(args[i]);
				CacherCalque(args[i+1]);
			}
		} else if (document.getElementById) {
			if (document.getElementById(args[i]).style.visibility == 'visible') {
				CacherCalque(args[i]);
				MontrerCalque(args[i+1]);
			} else  {
				MontrerCalque(args[i]);
				CacherCalque(args[i+1]);
			}
		}
   }
}


/************************* page spécifique contact.php ***********************************/
function envoyerMess(type) { 
    if (!document.forms[0].textPrenom.value) {
	    alert("Veuillez saisir un prénom !");
		document.forms[0].textPrenom.focus();
	} else if (!document.forms[0].textNom.value) {
	    alert("Veuillez saisir un nom !");
		document.forms[0].textNom.focus();
	} else if (!document.forms[0].textEmail.value) {
	    alert("Veuillez saisir un courriel !");
		document.forms[0].textEmail.focus();
	} else if (document.forms[0].textEmail.value && messagerie(document.forms[0].textEmail.value,document.forms[0].textEmail.value.length)==1) {
	    alert("L'adresse e-mail n'est pas valide !");
		document.forms[0].textEmail.focus();
	} else if (!document.forms[0].textSociete.value) {
	    alert("Merci de saisir le nom de votre société ou organisation.");
		document.forms[0].textSociete.focus();
	} else if (!document.forms[0].textAdr1.value) {
	    alert("L'adresse est obligatoire");
		document.forms[0].textAdr1.focus();
	} else if (!document.forms[0].textCp.value) {
	    alert("Le code postal est obligatoire");
		document.forms[0].textCp.focus();
	} else if (!document.forms[0].textVille.value) {
	    alert("Merci de préciser la ville.");
		document.forms[0].textVille.focus();
	} else if (!document.forms[0].selectPays.value) {
	    alert("Merci de préciser le pays.");
		document.forms[0].selectPays.focus();
	} else if (!document.forms[0].textTel.value) {
	    alert("Dans l'éventualité où nous aurions besoin d'échanger avec vous par téléphone,\nnous vous demandons d'indiquer votre numéro de téléphone.");
		document.forms[0].textTel.focus();
	} else if (!document.forms[0].textObjet.value) {
	    alert("Veuillez saisir un objet !");
		document.forms[0].textObjet.focus();
	} else if (!document.forms[0].textMess.value) {
	    alert("Vous pouvez écrire votre message");
		document.forms[0].textMess.focus();
	} else {
	   document.forms[0].submit(); 
	}
}

/************************ page spécifique panier-ifip-institut-du-porc.php ******************/
function ChangeValeur() { // parametres (champ,valeur) la valeur etant un entier ou un texte
  var args=ChangeValeur.arguments;
  for (j=0; j<(args.length); j+=2) {
  	var champ=eval('document.forms[0].'+args[j]);
	champ.value=args[j+1];	
  }
}

function confirmerCom() {
	document.forms[0].action.value="confirmerCom";
	document.forms[0].submit(); 
}

function creerCompte() { 
    if (!document.forms[0].textNom.value) {
	    alert("Veuillez saisir un nom !");
		document.forms[0].textNom.focus();
	} else if (!document.forms[0].textPrenom.value) {
	    alert("Veuillez saisir un prénom !");
		document.forms[0].textPrenom.focus();
	} else if (!document.forms[0].textSociete.value) {
	    alert("Veuillez préciser votre société");
		document.forms[0].textSociete.focus();
	} else if (!document.forms[0].textAdr1.value) {
	    alert("Veuillez préciser votre adresse");
		document.forms[0].textAdr1.focus();
	} else if (!document.forms[0].textVille.value) {
	    alert("Merci de saisir votre ville");
		document.forms[0].textVille.focus();
	} else if (!document.forms[0].textCp.value) {
	    alert("Veuillez saisir le code postal !");
		document.forms[0].textCp.focus();
	} else if (!document.forms[0].selectPays.value) {
	    alert("Merci de préciser votre pays");
		document.forms[0].selectPays.focus();
	} else if (!document.forms[0].textTel.value) {
	    alert("Veuillez saisir votre numéro de téléphone.");
		document.forms[0].textTel.focus();
	} else if (!document.forms[0].textEmail.value || (document.forms[0].textEmail.value && messagerie(document.forms[0].textEmail.value,document.forms[0].textEmail.value.length)==1)) {
	    alert("L'adresse e-mail n'est valide !");
		document.forms[0].textEmail.focus();
	} else if (!document.forms[0].textPwd.value) {
	    alert("Veuillez saisir un mot de passe !");
		document.forms[0].textPwd.focus();
	} else {
	   document.forms[0].action.value="creerCompte";
	   document.forms[0].submit(); 
	}
}

function validerLivraison() {
 var mesalerte="";
 if (!document.forms[0].textNom_f.value || !document.forms[0].textPrenom_f.value || !document.forms[0].textSociete_f.value 
	|| !document.forms[0].textAdr1_f.value || !document.forms[0].textCp_f.value || !document.forms[0].textVille_f.value 
	|| !document.forms[0].selectPays_f.value || !document.forms[0].textTel_f.value) {
	 mesalerte+="Les champs suivants sont obligatoires : \n";
	 if (!document.forms[0].textNom_f.value || !document.forms[0].textNom_l.value) mesalerte+="Nom \n";
	 if (!document.forms[0].textPrenom_f.value || !document.forms[0].textPrenom_l.value) mesalerte+="Prenom\n";
	 if (!document.forms[0].textSociete_f.value || !document.forms[0].textSociete_l.value) mesalerte+="Société\n";
	 if (!document.forms[0].textAdr1_f.value || !document.forms[0].textAdr1_l.value) mesalerte+="Adresse\n";
	 if (!document.forms[0].textCp_f.value || !document.forms[0].textCp_l.value) mesalerte+="Code postal\n";
	 if (!document.forms[0].textVille_f.value || !document.forms[0].textVille_l.value) mesalerte+="Ville\n";
	 if (!document.forms[0].selectPays_f.value || !document.forms[0].selectPays_l.value) mesalerte+="Pays\n";
	 if (!document.forms[0].textTel_f.value || !document.forms[0].textTel_l.value) mesalerte+="Telephone\n";
	 alert(mesalerte);
 } else {
	document.forms[0].action.value="validerLivraison";
	document.forms[0].submit(); 
 }
}

function validerReglement() {
	if (document.forms[0].cgv.checked==false)  alert("Veuillez lire et accepter les conditions generales de vente");
	else {
		document.forms[0].action.value="validerReg";
		document.forms[0].submit(); 
	}
	
}

function copierAdresse() {
	document.forms[0].textNom_f.value=document.forms[0].textNom_l.value;
	document.forms[0].textPrenom_f.value=document.forms[0].textPrenom_l.value;
	document.forms[0].textSociete_f.value=document.forms[0].textSociete_l.value;
	document.forms[0].textAdr1_f.value=document.forms[0].textAdr1_l.value;
	document.forms[0].textAdr2_f.value=document.forms[0].textAdr2_l.value;
	document.forms[0].textCp_f.value=document.forms[0].textCp_l.value;
	document.forms[0].textVille_f.value=document.forms[0].textVille_l.value;
	document.forms[0].selectPays_f.value=document.forms[0].selectPays_l.value;
	document.forms[0].textTel_f.value=document.forms[0].textTel_l.value;
	document.forms[0].textFax_f.value=document.forms[0].textFax_l.value;
}

/************************ page spécifique formation-inscription.php ******************/
function validerCpteForma() {
	if (!document.forms[0].textEmailCpte.value) {
	    alert("Veuillez saisir un email !");
		document.forms[0].textEmailCpte.focus();
	} else if (document.forms[0].textEmailCpte.value && messagerie(document.forms[0].textEmailCpte.value,document.forms[0].textEmailCpte.value.length)==1) {
	    alert("L'adresse e-mail n'est valide !");
		document.forms[0].textEmailCpte.focus();
	} else if (!document.forms[0].textPwdCpte.value) {
	    alert("Veuillez saisir un mot de passe !");
		document.forms[0].textPwdCpte.focus();
	} else {
	   document.forms[0].action.value="seConnecter";
	   document.forms[0].submit(); 
	}
}

function validerInscrForma(valeuraction) {
	if (!document.forms[0].textNom.value) {
	    alert("Veuillez saisir un nom !");
		document.forms[0].textNom.focus();
	} else if (!document.forms[0].textPrenom.value) {
	    alert("Veuillez saisir un prénom !");
		document.forms[0].textPrenom.focus();
	} else if (!document.forms[0].textSociete.value) {
	    alert("Veuillez préciser votre société");
		document.forms[0].textSociete.focus();
	} else if (!document.forms[0].textAdr1.value) {
	    alert("Veuillez préciser votre adresse");
		document.forms[0].textAdr1.focus();
	} else if (!document.forms[0].textVille.value) {
	    alert("Merci de saisir votre ville");
		document.forms[0].textVille.focus();
	} else if (!document.forms[0].textCp.value) {
	    alert("Veuillez saisir le code postal !");
		document.forms[0].textCp.focus();
	} else if (!document.forms[0].selectPays.value) {
	    alert("Merci de préciser votre pays");
		document.forms[0].selectPays.focus();
	} else if (!document.forms[0].textTel.value) {
	    alert("Veuillez saisir votre numéro de téléphone.");
		document.forms[0].textTel.focus();
	} else if (!document.forms[0].textEmail.value) {
	    alert("Veuillez saisir un email !");
		document.forms[0].textEmail.focus();
	} else if (document.forms[0].textEmail.value && messagerie(document.forms[0].textEmail.value,document.forms[0].textEmail.value.length)==1) {
	    alert("L'adresse e-mail n'est valide !");
		document.forms[0].textEmail.focus();
	} else if (valeuraction=='creerCompte') {
			if (!document.forms[0].textPwd.value) {
	    		alert("Veuillez saisir un mot de passe !");
				document.forms[0].textPwd.focus();
			} else {
	   			document.forms[0].action.value=valeuraction;
	   			document.forms[0].submit(); 
			}
	} else {
		document.forms[0].action.value=valeuraction;
	   	document.forms[0].submit(); 
	}
}

function validerInfosForma() {
   if (!document.forms[0].textRaison.value) {
	    alert("Veuillez saisir une raison sociale!");
		document.forms[0].textRaison.focus();	
 } else if (!document.forms[0].radioFonct.checked && !document.forms[0].textAutreFonct.value) {
	 	 alert("Veuillez renseigner votre fonction !");
 } else {
	   document.forms[0].action.value="sinscrire";
	   document.forms[0].submit(); 
	}
}

/************************ page spécifique veille-economique-internationale-production-viande-porc.php ******************/
function montrerBreve() {
	var i,args=montrerBreve.arguments; 
  	for (i=0; i<(args.length); i+=2) {   
		if (document.layers) {
			if (document[args[i]].visibility == 'show') {
				CacherCalque(args[i]);
				//MontrerCalque(args[i+1]);
			} else  {
				MontrerCalque(args[i]);
				//CacherCalque(args[i+1]);
			}
		} else if (document.all) {
			if (document.all[args[i]].style.visibility == 'visible' ) {
				CacherCalque(args[i]);
				//MontrerCalque(args[i+1]);
			} else  {
				MontrerCalque(args[i]);
				//CacherCalque(args[i+1]);
			}
		} else if (document.getElementById) {
			if (document.getElementById(args[i]).style.visibility == 'visible') {
				CacherCalque(args[i]);
				//MontrerCalque(args[i+1]);
			} else  {
				MontrerCalque(args[i]);
				//CacherCalque(args[i+1]);
			}
		}
   }
}

/************************ page spécifique moteur-recherche-publications-ifip.php ******************/
function montrerDoc() {
	var i,args=montrerDoc.arguments; 
  	for (i=0; i<(args.length); i+=2) {   
		if (document.layers) {
			if (document[args[i]].visibility == 'show') {
				CacherCalque(args[i]);
				//MontrerCalque(args[i+1]);
			} else  {
				MontrerCalque(args[i]);
				//CacherCalque(args[i+1]);
			}
		} else if (document.all) {
			if (document.all[args[i]].style.visibility == 'visible' ) {
				CacherCalque(args[i]);
				//MontrerCalque(args[i+1]);
			} else  {
				MontrerCalque(args[i]);
				//CacherCalque(args[i+1]);
			}
		} else if (document.getElementById) {
			if (document.getElementById(args[i]).style.visibility == 'visible') {
				CacherCalque(args[i]);
				//MontrerCalque(args[i+1]);
			} else  {
				MontrerCalque(args[i]);
				//CacherCalque(args[i+1]);
			}
		}
   }
}
/************************ page spécifique actualites-filiere-production-porc.php ******************/
function montrerActu() {
  	var i,args=montrerActu.arguments; 
	//document.getElementById(args[0]).innerText ="rr";
	//for (i=0; i<(args.length); i+=1) {   
		if (document.layers) {
			CacherCalque(args[0]); 
			MontrerCalque(args[1]);
		} else if (document.all) {
			CacherCalque(args[0]); 
			MontrerCalque(args[1]);
		} else if (document.getElementById) {
			CacherCalque(args[0]);
			MontrerCalque(args[1]);
		}
   //}
}

/************************ page spécifique publications-ifip-institut-du-porc.php ******************/
function MontrerCalque () { // parametres (calque1,calque2,...)
  var i,args=MontrerCalque.arguments; 
  for (i=0; i<(args.length); i+=1) {   
  	if (document.layers) {
    	document[args[i]].visibility = 'show';
		document[args[i]].height = '100%';
	} else if (document.all) {
		document.all[args[i]].style.visibility = 'visible';
		document.all[args[i]].style.height = '100%';
	} else if (document.getElementById) {
    	document.getElementById(args[i]).style.visibility = 'visible';
		document.getElementById(args[i]).style.height = '100%';
	}
  }
}

/************************ page spécifique extranet-pro.php ******************/
function validerEspPro() {
	if (!document.forms[0].textEmailCpte.value) {
	    alert("Veuillez saisir un email !");
		document.forms[0].textEmailCpte.focus();
	} else if (document.forms[0].textEmailCpte.value && messagerie(document.forms[0].textEmailCpte.value,document.forms[0].textEmailCpte.value.length)==1) {
	    alert("L'adresse e-mail n'est valide !");
		document.forms[0].textEmailCpte.focus();
	} else if (!document.forms[0].textPwdCpte.value) {
	    alert("Veuillez saisir un mot de passe !");
		document.forms[0].textPwdCpte.focus();
	} else {
	   document.forms[0].action.value="seConnecter";
	   document.forms[0].submit(); 
	}
}

function MontrerCalque2 () { // parametres (calque1,hauteur1,calque2,hauteur2,...) pour gerer une hauteur de div
  var i,args=MontrerCalque2.arguments; 
  for (i=0; i<(args.length); i+=2) {
  	if (document.layers) {
    	document[args[i]].visibility = 'show';
		document[args[i]].height = args[i+1];
	} else if (document.all) {
    	document.all[args[i]].style.visibility = 'visible';
		document.all[args[i]].style.height = args[i+1];
	} else if (document.getElementById) {
    	document.getElementById(args[i]).style.visibility = 'visible';
		document.getElementById(args[i]).style.height = args[i+1];
	}
  }
}

function CacherCalque () { // parametre (calque1,calque2,...)
  var i,args=CacherCalque.arguments;
  for (i=0; i<(args.length); i+=1) {
  	if (document.layers) {
    	document[args[i]].visibility = 'hide';
		document[args[i]].height = '0';
	} else if (document.all) {
    	document.all[args[i]].style.visibility = 'hidden';
		document.all[args[i]].style.height = '0';
	} else if (document.getElementById) {
    	document.getElementById(args[i]).style.visibility = 'hidden';
		document.getElementById(args[i]).style.height = '0';
  	}
  }
}


/****************** AJAX suggestion de contenu **************************************************************/

function getData(champ) { // 1 seul champ envoye et pas tout un formulaire
		var data1 = "";
		var valeur=eval('document.forms[0].'+champ+'.value');
		data1 += champ + "=" +escape(valeur);
		return data1;
}
function getMenuData(menu) { // 1 option d'un select envoye
		var data1 = "";
		var valeur=eval('document.forms[0].'+menu+'.options[document.forms[0].'+menu+'.selectedIndex].value');
		data1 += menu + "=" +escape(valeur);
		return data1;
}
function getFormData(form) { // tout le formulaire envoye
		var data1 = "";
		var form = document.getElementById(form);
		var elements = form.elements;
		for(var i=0; i<form.length; i++)
			{
				data1 += elements[i].name + "=" +escape(elements[i].value);
				if((i+1)<form.length)
					{
						data1+="&";
					}
			}
		return data1;
}

ancienneLongueurSaisie = 0 ;
function ajax(fichier, div, divattente,method, form, champ, menu) {
  
  if (champ!="null") MontrerCalque2(div,'150px');
  else MontrerCalque(div);

  var xhr=null;
  var data="null";
  if (form!="null" && champ=="null" && menu=="null") { // envoi de tout le formulaire
	if(method=="GET") {
		data=form;
		method="POST";
	} else {
		data = getFormData(form);
	}
  } else if (form=="null" && champ!="null" && menu=="null") { // envoi d'un seul champ input
	if(method=="GET") {
		data=champ;
		method="POST";
	} else {
		data = getData(champ);
	}
  } else if (form=="null" && champ=="null" && menu!="null") { // envoi d'une option d'un menu select
	if(method=="GET") {
		data=menu;
		method="POST";
	} else {
		data = getMenuData(menu);
	}
  }
// detection du navigateur pour la creation de l'objet XMLHttpRequest (soit l'acronyme xhr)

  if (champ!="null") {
	  	var saisie=eval('document.forms[0].'+champ+'.value');
	  	var longueurSaisie = saisie.length ;
	  	if (!longueurSaisie) CacherCalque(div);
	  
		CacherCalque(divattente);
		if (window.XMLHttpRequest) { // Firefox
			xhr = new XMLHttpRequest();
		} else if (window.ActiveXObject) { // Internet Explorer
			xhr = new ActiveXObject("Microsoft.XMLHTTP");
		} else {
			alert('Votre navigateur ne supporte pas Ajax');
		}
		
		xhr.onreadystatechange = function() {//retourne par xhr.send()
		//alert(xhr.readyState);
		 if (xhr.readyState==4) {
			
			if (document.getElementById) {
			 document.getElementById(div).innerHTML=xhr.responseText;
			} else {
			 	if (document.layers) {
				   document.div.innerHTML=xhr.responseText;
			  	} else {
				   document.all.div.innerHTML=xhr.responseText;
			  	}
			}
          
		 } //fin if (xhr.readyState==4)		
		}
	
		xhr.open( method, fichier, true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(data); 
	  
	  ancienneLongueurSaisie = longueurSaisie ;
  } else if (menu!="null") { // fin if (champ!="null")
	  if (window.XMLHttpRequest) { // Firefox
			xhr = new XMLHttpRequest();
		} else if (window.ActiveXObject) { // Internet Explorer
			xhr = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xhr.open( method, fichier, false);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.send(data); 
		if (document.getElementById) { // IE
			 document.getElementById(div).innerHTML=xhr.responseText;
		} else {
			 if (document.layers) {
				   document.div.innerHTML=xhr.responseText;
			  } else {
				   document.all.div.innerHTML=xhr.responseText;
				   ChangeValeur('totalpanier','0');
			  }
		}
  } // fin else if (menu!="null")
}

function fill() { // pas utilise
	//eval("document.forms[0].queryString"+z+".value='"+value1+"'");
	//eval("document.forms[0].c_commune"+z+".value='"+value2+"'");
	CacherCalque('suggestion');

}