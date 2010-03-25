<?php /* Date de cration: 18/11/2008 */ 
/**
Classe ListesIterator : class g&eacute;n&eacute;rique d'it&eacute;ration	des listes 
**/

class ListesIterator implements Iterator {
	  
	  private $array=array();
	  private $key;
	  private $current;
	  
	  function __construct($array) {
	  	 $this->array=$array;
	  }

	  function rewind() {
	  	reset($this->array);
		$this->next();
	  }
	  
	  function valid() {
	  	return $this->key !== NULL;
	  }
	  
	  function key() {
	  	return $this->key;
	  }
	  
	  function current() {
	  	return $this->current;
	  }
	  
	  function next() {
	  	 list($key, $current)=each($this->array);
		 $this->key=$key;
		 $this->current=$current;
	  }
}

?>