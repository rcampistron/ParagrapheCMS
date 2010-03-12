<?php 
/**
 * @date 19/11/2008
 * @class ListeVideos ListeVideos.php
 *  liste toutes les vid&eacute;os.
**/

class ListeVideos implements IteratorAggregate {
 /**
 * un tableau contenant toutes les infos de la vid&eacute;o
 * 
 */
   public $videos = array();
   /**
    * Num&eacute;ro de paragraphe
    * 
    */
   public $numpara;
   /**
    * R&eacute;cup&egrave;re les diff&eacute;rentes propri&eacute;t&eacute;s afin de les afficher
    * @return true si le tableau n'est pas vide
    */
   function afficherListeVideos() {
   	 //requete sql
	  if ($this->numpara) {
	 	 $result=mysql_query("SELECT numvideo,legende,numparavideo,ordre FROM if_para_video WHERE numpara='$this->numpara' ORDER BY ordre");
		 while ($row=mysql_fetch_row($result)) {
		   	$uneVideo=new Video();
			$uneVideo->numvideo=$row[0];
			$uneVideo->legendeVideo=$row[1];
			$uneVideo->numparavideo=$row[2];
			$uneVideo->numparavideo=$row[2];
			$uneVideo->infosVideo();  
			$this->videos[]=$uneVideo;
		 }
	 } else {
		 $result=mysql_query("SELECT numvideo FROM if_video ORDER BY nom_video");
		 while ($row=mysql_fetch_row($result)) {
		   	$uneVideo=new Video();
			$uneVideo->numvideo=$row[0];
			$uneVideo->infosVideo();  
			$this->videos[]=$uneVideo;
		 }
	  }
	 if (count($this->videos)>=1) return true;
   }
   
   function getIterator() {
   	  $iterator=new ListesIterator($this->videos);
	  return $iterator;
   }

}
?>
