<?php 
/** 
 * @date 22/12/2008
 * @file classes.php
 * @brief Inclut toutes les classes nécessaires
 */
if (!$chem) $chem="";
require_once ($chem."class/ListeUtilisateurs.inc.php");
require_once ($chem."class/Utilisateur.inc.php");
require_once ($chem."class/ListeMenus.inc.php");	
require_once ($chem."class/Menu.inc.php");
require_once ($chem."class/Page.inc.php");	 
require_once ($chem."class/ListePages.inc.php");
require_once($chem."class/ListesIterator.inc.php");  
require_once ($chem."class/ListePhotos.inc.php");	
require_once($chem."class/Photo.inc.php");	
require_once ($chem."class/ListeVideos.inc.php");	
require_once($chem."class/Video.inc.php");
require_once ($chem."class/ListeFichiers.inc.php");	
require_once($chem."class/Fichier.inc.php");  
require_once ($chem."class/ListeParagraphes.inc.php");	
require_once($chem."class/Paragraphe.inc.php");
require_once ($chem."class/ListeLiens.inc.php");	
require_once($chem."class/Lien.inc.php");
require_once ($chem."class/ListeContacts.inc.php");	
require_once($chem."class/Contact.inc.php");
require_once($chem."class/Formation.inc.php");
require_once($chem."class/Documentation.inc.php");
require_once($chem."class/ListeClients.inc.php");
require_once($chem."class/Client.inc.php");
require_once($chem."class/Commande.inc.php");
require_once($chem."class/Panier.inc.php");
require_once($chem."class/ListeCommandes.inc.php");
require_once($chem."class/Breve.inc.php");
require_once($chem."class/Actualite.inc.php");
require_once($chem."class/Article.inc.php");
require_once($chem."class/ListeArticles.inc.php");
?>