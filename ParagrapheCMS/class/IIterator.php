<?php
interface IIterator{
    public function key(); // Retourne la clef de l'élément courant
    public function valid(); // Vérifie si la collection est terminée
    public function current(); // Retourne l'élément courant
    public function next(); // Avance le curseur au prochain élément
    public function rewind(); // Le curseur retourne au 1er élément de la collection
}
?>