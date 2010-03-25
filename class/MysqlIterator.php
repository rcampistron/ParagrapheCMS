<?php
class MysqlIterator implements IIterator {
    private $_collection;
    private $_elementCourant;
    private $_ligneCourante;
    // Constructeur de la classe prenant une ressource sql
    public function __construct($ressource){
        if(!is_ressource($ressource)){
            throw new Exception("Ce n'est pas une ressource");
        }
        $this->_collection = $ressource;
    }
    // Définition de la méthode key
    public function key(){
        return $this->_ligneCourante;
    }
    public function valid(){
        // Retourne vrai si il reste des éléments dans la collection
        return  ($this->_ligneCourante < mysql_num_rows($this->_collection));
    }
    // On passe à l'élément suivant en récupérant les informations de la ligne
    public function next(){
        $this->_ligneCourant++;
        $this->_elementCourant = mysql_fetch_array($this->_collection);
    }
    // On retourne au début de la collection
    public function rewind(){
        $this->_ligneCourante = 1;
        return mysql_data_seek($this->_collection, 0);
    }
    // Retourne l'élément courant
    public function current(){
         return $this->_elementCourant;
    }
}
?>