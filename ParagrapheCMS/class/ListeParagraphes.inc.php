<?php 

/**
 * @class ListeParagraphes
 * @date 19/11/2008
 * @brief Sp&eacute;cifique IFIP
 * @details liste toutes les formations, toutes les documentations, toutes les breves internationales
 * 
 * 
**/

class ListeParagraphes  implements IteratorAggregate {
/**
 * Tableau contenant les paragraphes
 * 
 */
	public $paras = array();
	public $parascourt = array();
	/**
	 * num(id) de la page
	 * 
	 */
    public $numpage;
    /**
     * colonne ?
     */
	public $colonne;
	/**
	 * sp&eacute;cifique IFIP - indique si le paragraphe est de type "formation"
	 * 
	 */
	public $formation; //
	/**
	 * sp&eacute;cifique IFIP pour formation en fonction de la date
	 * 
	 */
	public $tri_date;// 
	/**
	 * sp&eacute;cifique IFIP pour ajouter une fin de requete documentation
	 * 
	 */
	public $req_doc;
	/**
	 * sp&eacute;cifique IFIP - indique si le paragraphe est de type "documentation"
	 * 
	 */
	public $doc; 
	/**
	 * sp&eacute;cifique IFIP - pour ne stocker que les ann&eacute;es dans le tableau des docs
	 * 
	 */
	public $docvcourte; 
	/**
	 * docs - pour tronquer le tableau paras
	 * 
	 */
	public $borneinf;
	/**
	 * docs - pour tronquer le tableau paras
	 * 
	 */
	public $bornesup;
	/**
	 * en cas de requete courte (tableau tronqu&eacute; selon les bornes inf et sup)
	 * 
	 */
	public $nbdocs; 
	/**
	 * sp&eacute;cifique IFIP - indique si le paragraphe est de type "br&egrave;ve"
	 * 
	 */
	public $breve; 
	/**
	 * sp&eacute;cifique IFIP pour creer la requete "br&egrave;ve" (pas de commande SQL WHERE d'&eacute;crite ci-dessous)
	 * 
	 */
	public $req_breve;
	/**
	 * Actualit&eacute;s ou br&egrave;ves d'actualit&eacute;s (IFIP) - indique si le paragraphe est de type "actualit&eacute;"
	 * 
	 */
	public $actu;
	/**
	 * pour actualit&eacute;s ou br&egrave;ves d'actualit&eacute;s 
	 * 
	 */
	public $req_actu;
	/**
	 * affiche la liste des paragraphes 
	 * @return si on voit les docs on retourne le nombre de doc, sinon on retourne le nombre de paragraphes
	 */
	
   function afficherListeParas() {
   	 //requete sql
	 if ($this->numpage) {// Liste des paragraphes li&eacute;s &agrave; la page 
	 	if (isset($this->colonne)) $fin_req="AND colonne='$this->colonne'"	;
	 	$result=mysql_query("SELECT numpara FROM if_page_para WHERE numpage='$this->numpage' $fin_req ORDER BY ordre");
		//echo "SELECT numpara FROM if_page_para WHERE numpage='$this->numpage' $fin_req ORDER BY ordre<br/>";
		while ($row=mysql_fetch_row($result)) {
		   	$unPara=new Paragraphe();
			$unPara->numpara=$row[0];
			$unPara->numpage=$this->numpage;
			$unPara->infosPara();  
			$this->paras[]=$unPara;
		 }	//fin du while
	 } else if ($this->formation) {	// Liste des formations IFIP
	 	 $result=mysql_query("SELECT numpara FROM if_v_form $this->tri_date");
		 while ($row=mysql_fetch_row($result)) {
		   	$unPara=new Formation();
			$unPara->numpara=$row[0];  
			$unPara->infosFormation();  
			$this->paras[]=$unPara;
		 }	//fin du while
	 } else if ($this->doc) {	// Liste des docs IFIP
	 	 $result=mysql_query("SELECT numpara FROM if_v_doc $this->req_doc");
		 while ($row=mysql_fetch_row($result)) {
		   	$unPara=new Documentation();
			$unPara->numpara=$row[0];  
			if ($this->docvcourte)$unPara->infosDocVersionCourte(); //uniquement numpara + ann&eacute;e de stock&eacute;s (pour all&eacute;ger)
			else $unPara->infosDoc();  
			$this->paras[]=$unPara;
			//mise en commentaire HC sept. 2009 - on refait un tri sur le champ date
			//usort($this->paras, 'trierDocs');//tri sur le tableau d'ojets Documentation (sur anneeDoc cr&eacute;&eacute;e dans InfosDoc)
			
		 }	//fin du while     
		 if ($this->docvcourte) {
		 	$this->nbdocs=count($this->paras); 
			$this->paras=array_slice($this->paras, $this->borneinf, $this->bornesup); // troncage du tableau
			//print_r($this->paras);
		}
	 } else if ($this->breve) {	// Liste des br&egrave;ves internationales IFIP
	 	 $result=mysql_query("SELECT numpara FROM if_v_breve $this->req_breve");
		 while ($row=mysql_fetch_row($result)) {
		   	$unPara=new Breve();
			$unPara->numpara=$row[0];  
			$unPara->infosBreve();  
			$this->paras[]=$unPara;
		 }	//fin du while
	 } else if ($this->actu) {	// Liste des br&egrave;ves d'actualit&eacute;s IFIP
	 	 $result=mysql_query("SELECT numpara FROM if_v_actu $this->req_actu");
		 while ($row=mysql_fetch_row($result)) {
		   	$unPara=new Actualite();
			$unPara->numpara=$row[0];  
			$unPara->infosActu();  
			$this->paras[]=$unPara;
		 }	//fin du while
	 } else {// Liste de tous les paragraphes (pour choisir un paragraphe &agrave; associer lors de la cr&eacute;ation ou modification de la page sauf les paragraphes de type Formation et de type Doc
		  $result=mysql_query("SELECT numpara FROM if_paragraphe WHERE numpara NOT IN (SELECT numpara FROM if_v_form) AND NOT IN (SELECT numpara FROM if_v_doc)");
		 while ($row=mysql_fetch_row($result)) {
		   	$unPara=new Paragraphe();
			$unPara->numpara=$row[0];  
			$unPara->numpage=$this->numpage;
			$unPara->infosPara();  
			$this->paras[]=$unPara;
		 }	//fin du while
	 }
	 if ($this->docvcourte) return $this->nbdocs;
	 else return count($this->paras); 
   }
   
   function getIterator() {
   	  $iterator=new ListesIterator($this->paras);
	  return $iterator;
   }

}// fin de classe
?>
