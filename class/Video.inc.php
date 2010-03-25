<?php 
/**
 * @date 19/11/2008
 * @class Video Video.inc.php
 * Cr&eacute;ation, modification, suppression d'une vid&eacute;o
**/

class Video {
   	/**
   	 * num(id) de la vid&eacute;o 
   	 * 
   	 */
	public $numvideo;
	/**
	 * nom de la vid&eacute;o
	 * 
	 */
    public $nomVideo;  
    /**
     * nom temporaire 
     * 
     */
	public $tmp_name;
	/**
	 * l&eacute;gende de la vid&eacute;o 
	 * 
	 */
	public $legendeVideo;
	/**
	 * Ordre d'affichage de la vid&eacute;o 
	 * 
	 */
	public $ordreVideo;
	/**
	 * Propri&eacute;t&eacute; liant le paragraphe a la vid&eacute;o 
	 * 
	 */
	public $numparavideo;
	/**
	 * indique qu'on modifie la photo (pour donner valeur &agrave; $chem="../"  depuis admin/modifier_fich.php)
	 * 
	 */
	public $modif;
	/**
	 * Se charge de cr&eacute;er la vid&eacute;o et ins&egrave;re ses diff&eacute;rentes valeurs dans la base et sur le serveur
	 * @return renvoie le num(id) de la vid&eacute;o
	 */
	
	function creerVideo() {
   	  	if ($this->modif) $chem="../";
		$liste=explode(".",$this->nomVideo);
	    if ($liste[4]) $ext=$liste[4]; else if ($liste[3]) $ext=$liste[3]; else if ($liste[2]) $ext=$liste[2]; else $ext=$liste[1]; 
	    $nom_video=$liste[0].".".$ext;
	    move_uploaded_file($this->tmp_name, $chem."videos/".$nom_video);	
		
		mysql_query("INSERT INTO if_video (nom_video) VALUES ('$nom_video')");
		$this->numvideo=mysql_insert_id();
		
		return $this->numvideo; 
	}
	
	function modifierVideo() {
	
	}
	
	function supprimerVideo() {
	
	}
	/**
	 * R&eacute;cup&egrave;re les diff&eacute;rentes infos concernant, afin de pouvoir les afficher
	 */
	function infosVideo() {
		if ($this->numparavideo) {
			$row=SelectMultiple("if_para_video","numparavideo",$this->numparavideo);
			$this->legendeVideo=$row["legende"];
			$this->ordreVideo=$row["ordre"];
			$this->numvideo=$row["numvideo"];
			$row=SelectMultiple("if_video","numvideo",$this->numvideo);
			$this->nomVideo=$row["nom_video"];
		} else {
			$row=SelectMultiple("if_video","numvideo",$this->numvideo);
			$this->nomVideo=$row["nom_video"];
		}
	}
}

?>
