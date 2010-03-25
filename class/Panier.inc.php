<?php /* Date de cration: 22/01/2009 */ 
/**
 * @class Panier Panier.inc.php
 * @date 22/01/2009
 * création, modification d'un panier lié &agrave; la boutique du site public
* */

class Panier {
	/**
	 * n° de la commande
	 * 
	 */
	public $numcom;
	/**
	 * n° de la ligne détail de la comman
	 * 
	 */
	public $numdetail;
	/**
	 * nombre d'article dans le panier
	 * 
	 */
	public $nbarticle; // 
	/**
	 * Montant total HT du Panier sans les frais de livraison
	 * 
	 */
	public $totalHTsansPort;
	/**
	 * Montant total HT du Panier
	 * 
	 */
	public $totalHT;
	/**
	 * Montant total TTC du Panier
	 * 
	 */
	public $totalTTC;
	/**
	 * Montant total de la tva du Panier
	 * 
	 */
	public $totalTva;//
	/**
	 * Poids total mis en forme
	 * 
	 */
	public $totalPoids;//
	/**
	 * Poids total
	 * 
	 */
	public $totalPoidsbrut;//
	/**
	 * Frais de port du Panier
	 * 
	 */
	public $fraisPort;
	/**
	 * Num(id) du client 
	 * 
	 */
	public $numclient;	
	/**
	 * Pays de livraison (numpays)
	 * 
	 */
	public $pays;
	/**
	 * indique si c'est un article créé &agrave; la volée (spécifique IFIP) - valeurs possibles = "o"
	 * 
	 */
	public $article;
	/**
	 * ????
	 */
	function expressContenu() {
		$contenu=array();
		$contenu=array("numcom"=>$this->numcom);
	}
	/**
	 *  Ajoute un article dans le panier
	 */
	
	function ajouterArticle($numarticle,$designation,$quantite,$reference,$prix_vente,$article="") {
		$laCom = new Commande();
		if (!$this->numcom) {
			if ($this->numclient) $laCom->numclient=$this->numclient;// inscription &agrave; une formation
			$this->numcom=$laCom->creerCommande();// Si la commande n'est pas créée, on la créée
		} 
		if (!$this->numclient) $_SESSION['numcom']=$this->numcom;//on n'est pas dans l'inscription &agrave; une formation 
		
		$designation=str_replace("\"","",str_replace("'","''",stripslashes($designation)));
		$reference=str_replace("\"","",str_replace("'","''",stripslashes($reference)));
		
		
		if ($article) mysql_query("INSERT INTO if_bo_detail (numcom,numarticle,designation,qte,prix_vente) 
		VALUES ('$this->numcom','$numarticle','$designation','$quantite','$prix_vente')");
		// C'est l'ajout d'un article autre que 1 doc ou 1 formation
		
		else {
			mysql_query("INSERT INTO if_bo_detail (numcom,numpara,designation,reference,qte,prix_vente) 
			VALUES ('$this->numcom','$numarticle','$designation','$reference','$quantite','$prix_vente') ");
		
			//Resolution bug Firefox qui execute plusieurs fois la requete !!!
			$result=mysql_query("SELECT numdetail FROM if_bo_detail WHERE numpara='".$numarticle."' AND numcom='".$this->numcom."' ORDER BY numdetail");
			if (mysql_num_rows($result)>1) {
				while($row=mysql_fetch_row($result)) {
					$tab_numdetail[]=$row[0];
				}
				reset ($tab_numdetail);
				if(count($tab_numdetail)>1) {
					for ($i=0;$i<(count($tab_numdetail)-1);$i++) {
						mysql_query("DELETE FROM if_bo_detail WHERE numdetail='".$tab_numdetail[$i]."'");
					}
				}
			}
		}
			
		
	}
	/**
	 * Supprime un article dans le panier
	 */
	function supprimerArticle() {
		mysql_query("DELETE FROM if_bo_detail WHERE numdetail='$this->numdetail'");
	}
	
	/**
	 * Met &agrave; jour la quantité d'un article sélectionné dans le Panier
	 * @param unknown_type $quantite quantit&eacute; d&eacute;sir&eacute; pour cet article
	 */
	function miseAJourQteArticle($quantite) {
		mysql_query("UPDATE if_bo_detail SET qte='".$quantite."' WHERE numdetail='".$this->numdetail."'");
	}
	/**
	 * Initialise les informations relatives au panierafin de les afficher par la suite
	 */
	function infosPanier() {
		$totalHT=0;
		$totalPoids=0; 
		$tva=str_replace(",",".",SelectSimple("ttva","if_bo_com","numcom",$this->numcom));
		$result=mysql_query("SELECT * FROM if_bo_detail WHERE numcom='$this->numcom' AND designation!='Inscription formation'");
		while ($row=mysql_fetch_array($result)) {
			$totalHT+=str_replace(",",".",$row["qte"])*str_replace(",",".",$row["prix_vente"]);
			$this->nbarticle++;
			$poids=SelectSimple("poids","if_docs","numpara",$row["numpara"]); 
			$totalPoids+=$poids;
			if ($row["numarticle"]) $this->article="o";
			
		}
		
		/* HC 28 mai 2009 - frais de ports gérés maintenant pour France uniquement et selon total commande - voir ci-dessous
		if ($totalPoids) {
			//Calcul des frais de port
			if ($this->pays) {
				$zone=SelectSimple("zone","if_pays","numpays",$this->pays); 
			} else {
				$zone=1;
			}
			$tarif=SelectSimple("tarif","if_tarifs_ports","zone",$zone," AND $totalPoids BETWEEN poids_min AND poids_max");
			if ($tarif) $this->fraisPort=str_replace(".",",",$tarif); 
		}
		*/
		
		$this->totalPoidsbrut=$totalPoids;
		$this->totalHTsansPort=number_format($totalHT,2,","," ");
		//$this->totalHT=number_format($totalHT,2,","," "); //important de faire ce number_format ici
		
		//$this->totalHT=number_format($totalHT,2,",",""); //important de faire ce number_format ici MODIF JULIEN DECEMBRE 2009 POUR LE CALCUL DU PRIX TOTAL
		// ON NE PEUT PAS FAIRE DE CALCUL AVEC PAR EX 1 850 EUROS MAIS 1850 EUROS
		
		$this->totalHT=$totalHT; // nouvelle rectification, pas besoin de faire un number format tant que le calcul n'est pas fini.......
		
		//Calcul des frais de port - uniquement sur les produits qui ont un poids
		if ($this->pays==247 && $totalPoids) {//France
			if ($this->totalHT<15) $this->fraisPort="5";
			else if ($this->totalHT>=15 && $this->totalHT<=35) $this->fraisPort="7";
			else if ($this->totalHT>35) $this->fraisPort="0";
		} else if ($this->pays!=247 && $totalPoids)  {//preparation pour le futur
			$this->fraisPort="0";
		} else {
			$this->fraisPort="0";
		}
		
		
		$this->totalHT=$this->totalHT+$this->fraisPort;
		//$this->totalTva=number_format(($totalHT * ($tva / 100)),2,","," ");
		$this->totalTva=0; // pas de TVA pour IFIP
		//$this->totalTTC=number_format(($totalHT * (1 + ($tva / 100))+$tarif),2,","," "); // NON pas de TVA pour IFIP
		
		$this->totalHT=number_format($this->totalHT,2,","," ");
		
		$this->totalTTC=$this->totalHT;
		$this->fraisPort=number_format($this->fraisPort,2,","," ");
		$this->totalPoids=number_format(($totalPoids/1000),2,","," ");

		
		//$this->totalTTC+=$tarif;
	}
	/**
	 * Liste les articles de la commande 
	 * @return renoie un tableau contenant la liste des articles de la commande
	 */
	function listerArticles() {
		$list_article=array();
		$result = mysql_query("SELECT * FROM if_bo_detail WHERE numcom='$this->numcom' AND designation!='Inscription formation' AND numpara!='0'");
		while ($row=mysql_fetch_array($result)) {
		   $article["numdetail"]=$row["numdetail"];
		   $article["numpara"]=$row["numpara"];
		   $doc = new Documentation();
		   $doc->numpara=$row["numpara"];
		   $doc->infosDoc();
		   $article["titre"]=$doc->titrePara;
		   $article["reference"]=$row["reference"];
		   $article["qte"]=$row["qte"];	 
		   $article["prix_vente"]=number_format(str_replace(",",".",$row["prix_vente"]),2,","," ");
		   $article["prix_total"]=number_format((str_replace(",",".",$row["prix_vente"])*$row["qte"]),2,","," "); 
		   
		   $list_article[]=$article;
		}
		
		return $list_article;
	 }
	 /**
	  * Liste les articles de la formation 
	  * @return renvoie un tableau contenant tous les articles de la formation
	  */
	 
	 function listerArticlesForm() {
		$list_article=array();
		$result = mysql_query("SELECT * FROM if_bo_detail WHERE numcom='$this->numcom'");
		while ($row=mysql_fetch_array($result)) {
		   $article["numdetail"]=$row["numdetail"];
		   $article["numcom"]=$row["numcom"];
		   $article["numpara"]=$row["numpara"];
		   $article["designation"]=$row["designation"];
		   $article["montantTTC"]=SelectSimple("montantTTC","if_bo_com","numcom",$this->numcom);
		   $list_article[]=$article;
		}
		
		return $list_article;
	 }
	 /**
	  * Liste les articles crées &agrave; la volée
	  */
	  
	 function listerArticlesCrees() {
		$list_article=array();
		$result = mysql_query("SELECT * FROM if_bo_detail WHERE numcom='$this->numcom'");
		while ($row=mysql_fetch_array($result)) {
		   $article["numdetail"]=$row["numdetail"];
		   $article["numcom"]=$row["numcom"];
		   $article["numarticle"]=$row["numarticle"];
		   $article["designation"]=$row["designation"];
		    $article["prix_vente"]=number_format(str_replace(",",".",$row["prix_vente"]),2,","," ");
		   $list_article[]=$article;
		}
		
		return $list_article;
	 }
	 
}//fin de classe

?>
