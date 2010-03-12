<?php 
/**
 * @class Photo Photo.inc.php 
 * @date 19/11/2008
 * Cr&eacute;ation, modification, suppression, redimensionnement d'une image ou photo
 * 
 * 
**/
class Photo {
   	/**
   	 * num(id) de la photo 
   	 * 
   	 */
    public $numphoto;
    /**
     * nom de la photo
     * 
     */
    public $nomPhoto;
    /**
     * 
     * 
     */
	public $tmp_name;
	/**
	 * l&eacute;gende de la photo
	 * 
	 */
	public $legendePhoto;
	/**
	 * Ordre dans lequel la photo apparaît
	 * 
	 */
	public $ordrePhoto;
	/**
	 * 
	 * 
	 */
	public $logo; 
	/**
	 * taille de la photo : 185px ou 385px
	 * 
	 */
	public $taille;
	/**
	 * Cl&eacute; liant un paragraphe &agrave; une photo
	 * 
	 */
	public $numparaphoto; 
	/**
	 * @brief indique qu'on modifie la photo 
	 * @details pour donner une valeur Ã  $chem="../" depuis admin/modifier_fich.php ou admin/pop_sup.php)
	 * 
	 */
	public $modif;
	/**
	 * extension du fichier photo
	 * 
	 */
	public $ext;
	/**
	 * Gestion de la photo, upload de la photo et insertion dans la base 
	 * @return renvoie le num(id) de la photo
	 */
	function creerPhoto() {
	   // Gestion de la photo
   	  	//$tmp_fich=$this->nomPhoto; 
		if ($this->modif) $chem="../";
		$liste=explode(".",$this->nomPhoto);
	    if ($liste[4]) $ext=$liste[4]; else if ($liste[3]) $ext=$liste[3]; else if ($liste[2]) $ext=$liste[2]; else $ext=$liste[1]; 
	    $nom_photo=$liste[0].".".$ext;	 
		if ($this->taille) { //on a une taille de spcifie
			if ($ext=="jpg") {	   
				@move_uploaded_file($this->tmp_name, $chem."photos/".$nom_photo);	
				$log=$nom_photo;
				@copy($chem."photos/".$nom_photo, $chem."photos/o".$nom_photo);	
				if ($this->taille) $this->redimPhoto($chem."photos/",$log,$this->taille);	
				@unlink($chem."photos/o".$nom_photo);	
		    } else {
				@move_uploaded_file($this->tmp_name, $chem."photos/".$nom_photo);	
		    }
	    } else {
			@move_uploaded_file($this->tmp_name, $chem."photos/".$nom_photo);	
		}
		mysql_query("INSERT INTO if_photo (nom_photo) VALUES ('$nom_photo')");
		$this->numphoto=mysql_insert_id();
		/** if ($ext=="jpg") { //Mise en commentaire sv le 11/07/08
				move_uploaded_file($tmp_fich, $chem."photos/".$fichier_photo);	
				$log=$fichier_photo;	 
				copy($chem."photos/".$fichier_photo, $chem."photos/o".$fichier_photo);
				redim($chem."photos/",$log,190);	
				unlink($chem."photos/o".$fichier_photo);
		   }**/
		
		/**if ($action=="mod") {// on supprime l'ancien fichier
			$fich_photo=SelectSimple("fichier_photo","su_produits","numprod",$numprod);	
			if ($fich_photo && file_exists($chem."photos/".$fich_photo)) unlink($chem."photos/".$fich_photo); 
		} **/ 
		
		return $this->numphoto; 
	}
	
	function modifierPhoto() {
		
	}
	/**
	 * Supprime la photo de la bdd et du serveur
	 */
	function supprimerPhoto() {
		$this->infosPhoto();
		if ($this->modif) $chem="../";
		if (file_exists($chem."photos/".$this->nomPhoto)) @unlink($chem."photos/".$this->nomPhoto);
		mysql_query("DELETE FROM if_photo WHERE numphoto='$this->numphoto'");	
	}
	/**
	 * redimensionne la photo 
	 * 
	 * @param $chemin r&eacute;pertoire de la photo 
	 * @param $photo la photo que l'on souhaite redimensionner
	 * @param $taille la taille d&eacute;sir&eacute; 
	 */
	function redimPhoto($chemin,$photo,$taille) {
		//redimensionnement photo petit format
		$size=getimagesize($chemin."o".$photo);
		if (($size[0]>$taille) || ($size[1]>$taille)) {
		
			if ($size[0]>$size[1]) {// largeur suprieure  la hauteur				
				$wg=$taille;
				$hg=number_format($size[1]/($size[0]/$taille),0,",","");									
			} else {// hauteur suprieure  la largeur				
				$hg=$taille;
				$wg=number_format($size[0]/($size[1]/$taille),0,",","");				
			}	
						
		} else {			
			$wg=$size[0];
			$hg=$size[1];			
		}
	
		$src_img = imagecreatefromjpeg($chemin."o".$photo); 
		$dst_img = imagecreatetruecolor($wg,$hg); 
		imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $wg, $hg, $size[0], $size[1]);
		Imagejpeg($dst_img, $chemin.$photo,100);
	}
	/**
	 * Compte le nombre de photos li&eacute;es &agrave; un paragraphe
	 * @return renvoie le nombre de photos
	 */
	function countPhotos() {
		 return SelectCount("numparaphoto","if_para_photo","numphoto",$this->numphoto);
	}
	/**
	 * R&eacute;cup&egrave;re les infos de la photo afin de les afficher
	 */
	function infosPhoto() {
		if ($this->numparaphoto) {
			$row=SelectMultiple("if_para_photo","numparaphoto",$this->numparaphoto);
			$this->legendePhoto=$row["legende"];
			$this->ordrePhoto=$row["ordre"];
			$this->numphoto=$row["numphoto"];
			$row=SelectMultiple("if_photo","numphoto",$this->numphoto);
			$this->nomPhoto=$row["nom_photo"];
			$liste=explode(".",$this->nomPhoto);
	    	if ($liste[4]) $this->ext=$liste[4]; else if ($liste[3]) $this->ext=$liste[3]; else if ($liste[2]) $this->ext=$liste[2]; else $this->ext=$liste[1]; 
		
		} else {
			$row=SelectMultiple("if_photo","numphoto",$this->numphoto);
			$this->nomPhoto=$row["nom_photo"];
			$liste=explode(".",$this->nomPhoto);
	    	if ($liste[4]) $this->ext=$liste[4]; else if ($liste[3]) $this->ext=$liste[3]; else if ($liste[2]) $this->ext=$liste[2]; else $this->ext=$liste[1]; 
		}
		//$this->legende=$row["legende"];
	}
}

?>
