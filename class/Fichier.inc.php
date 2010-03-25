<?php  
/**
 * @date 19/11/2008
 * @class Fichier
 * @Cr&eacute;ation, modification, suppression d'un fichier
**/

class Fichier {
   	/**
   	 * num(id) du fichier
   	 * 
   	 */
    public $numfichier;
    /**
     * nom du fichier
     * 
     */
    public $nomFichier;
    /**
     * poids du fichier en octets
     * 
     */
	public $poidsFichier;
	/**
	 * Libell&eacute; du fichier
	 * 
	 */
	public $libFichier;
	/**
	 * Ordre du fichier 
	 * 
	 */
	public $ordreFichier;
	/**
	 * Paragraphe associ&eacute; au fichier
	 * 
	 */
	public $numparafichier;
	/**
	 * Nom temporaire
	 * 
	 */
	public $tmp_name;
	/**
	 * indique qu'on modifie la photo (pour donner valeur &agrave; $chem="../" depuis admin/modifier_fich.php)
	 * 
	 */
	public $modif;
	
	/**
	 * Fonction qui va cr&eacute;er le fichier
	 * @return le num(id) du fichier
	 */
	
	function creerFichier() {
	    if ($this->modif) $chem="../";
		
	    $liste=explode(".",$this->nomFichier);
	    if ($liste[4]) $ext=$liste[4]; else if ($liste[3]) $ext=$liste[3]; else if ($liste[2]) $ext=$liste[2]; else $ext=$liste[1]; 
	    $nom_fichier=$liste[0].".".$ext;
	    @move_uploaded_file($this->tmp_name, $chem."fichiers/".$nom_fichier);	
		
		mysql_query("INSERT INTO if_fichier (nom_fichier) VALUES ('$nom_fichier')");
		$this->numfichier=mysql_insert_id();
		
		return $this->numfichier; 
	}
	
	function modifierFichier() {
	
	}
	
	function supprimerFichier() {
	
	}
	
	/**
	 * Liste les infos du fichier
	 */
	function infosFichier() {
		
		
		if ($this->numparafichier) {
			$row=SelectMultiple("if_para_fichier","numparafichier",$this->numparafichier);
			$this->libFichier=$row["libelle"];
			$this->ordreFichier=$row["ordre"];
			$this->numfichier=$row["numfichier"];
			$row=SelectMultiple("if_fichier","numfichier",$this->numfichier);
			if (file_exists("fichiers/".$row["nom_fichier"])) {
				$this->nomFichier=$row["nom_fichier"];
				$poidsKo=filesize("fichiers/".$this->nomFichier)/1024;
				if ($poidsKo < 100) $this->poidsFichier=round($poidsKo)." Ko";
				else $this->poidsFichier=number_format($poidsKo/1024, 1,",","")." Mo";
			}
		} else {
			$row=SelectMultiple("if_fichier","numfichier",$this->numfichier);
			if (file_exists("fichiers/".$row["nom_fichier"])) {
				$this->nomFichier=$row["nom_fichier"];
				$poidsKo=filesize("fichiers/".$this->nomFichier)/1024;
				if ($poidsKo < 100) $this->poidsFichier=round($poidsKo)." Ko";
				else $this->poidsFichier=number_format($poidsKo/1024, 1,",","")." Mo";
			}
		}
	}
}

?>
