<?php /* Date de cration:  */ 
/**
 * @class ListePhotos ListePhotos
 * @date 19/11/2008
 * 
**/



class ListePhotos  implements IteratorAggregate {

   public $photos = array();
   public $numpara;
   
   function afficherListePhotos() {
   	 //requete sql
	 if ($this->numpara) {
	 	 $result=mysql_query("SELECT numphoto,legende,numparaphoto FROM if_para_photo WHERE numpara='$this->numpara' ORDER BY ordre");
		 while ($row=mysql_fetch_row($result)) {
		   	$unePhoto=new Photo();
			$unePhoto->numphoto=$row[0];
			$unePhoto->legendePhoto=$row[1];
			$unePhoto->numparaphoto=$row[2];
			$unePhoto->infosPhoto();  
			$this->photos[]=$unePhoto;
		 }
	 } else {
		 $result=mysql_query("SELECT numphoto FROM if_photo ORDER BY nom_photo");
		 while ($row=mysql_fetch_row($result)) {
		   	$unePhoto=new Photo();
			$unePhoto->numphoto=$row[0];
			$unePhoto->infosPhoto();  
			$this->photos[]=$unePhoto;
		 }
	 }
	 if (count($this->photos)>=1) return true;
   }
   
   function getIterator() {
   	  $iterator=new ListesIterator($this->photos);
	  return $iterator;
   }

}
?>
