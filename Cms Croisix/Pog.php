<?php
/*
	This SQL query will create the table to store your object.

	CREATE TABLE `client` (
	`clientid` int(11) NOT NULL auto_increment,
	`raison` VARCHAR(255) NOT NULL,
	`nom` VARCHAR(255) NOT NULL,
	`prenom` VARCHAR(255) NOT NULL,
	`adr2` VARCHAR(255) NOT NULL,
	`adr1` VARCHAR(255) NOT NULL,
	`ville` VARCHAR(255) NOT NULL,
	`pays` VARCHAR(255) NOT NULL,
	`actif` VARCHAR(255) NOT NULL,
	`gsm` VARCHAR(255) NOT NULL, PRIMARY KEY  (`clientid`)) ENGINE=MyISAM;
*/

/**
* <b>Client</b> class with integrated CRUD methods.
* @author Php Object Generator
* @version POG 3.0e / PHP5.1 MYSQL
* @see http://www.phpobjectgenerator.com/plog/tutorials/45/pdo-mysql
* @copyright Free for personal & commercial use. (Offered under the BSD license)
* @link http://www.phpobjectgenerator.com/?language=php5.1&wrapper=pdo&pdoDriver=mysql&objectName=Client&attributeList=array+%28%0A++0+%3D%3E+%27raison%27%2C%0A++1+%3D%3E+%27nom%27%2C%0A++2+%3D%3E+%27prenom%27%2C%0A++3+%3D%3E+%27adr2%27%2C%0A++4+%3D%3E+%27adr1%27%2C%0A++5+%3D%3E+%27ville%27%2C%0A++6+%3D%3E+%27pays%27%2C%0A++7+%3D%3E+%27actif%27%2C%0A++8+%3D%3E+%27gsm%27%2C%0A%29&typeList=array%2B%2528%250A%2B%2B0%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B1%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B2%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B3%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B4%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B5%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B6%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B7%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2B%2B8%2B%253D%253E%2B%2527VARCHAR%2528255%2529%2527%252C%250A%2529
*/
include_once('class.pog_base.php');
class Client extends POG_Base
{
	public $clientId = '';

	/**
	 * @var VARCHAR(255)
	 */
	public $raison;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $nom;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $prenom;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $adr2;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $adr1;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $ville;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $pays;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $actif;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $gsm;
	
	public $pog_attribute_type = array(
		"clientId" => array('db_attributes' => array("NUMERIC", "INT")),
		"raison" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"nom" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"prenom" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"adr2" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"adr1" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"ville" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"pays" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"actif" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		"gsm" => array('db_attributes' => array("TEXT", "VARCHAR", "255")),
		);
	public $pog_query;
	
	
	/**
	* Getter for some private attributes
	* @return mixed $attribute
	*/
	public function __get($attribute)
	{
		if (isset($this->{"_".$attribute}))
		{
			return $this->{"_".$attribute};
		}
		else
		{
			return false;
		}
	}
	
	function Client($raison='', $nom='', $prenom='', $adr2='', $adr1='', $ville='', $pays='', $actif='', $gsm='')
	{
		$this->raison = $raison;
		$this->nom = $nom;
		$this->prenom = $prenom;
		$this->adr2 = $adr2;
		$this->adr1 = $adr1;
		$this->ville = $ville;
		$this->pays = $pays;
		$this->actif = $actif;
		$this->gsm = $gsm;
	}
	
	
	/**
	* Gets object from database
	* @param integer $clientId 
	* @return object $Client
	*/
	function Get($clientId)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `client` where `clientid`='".intval($clientId)."' LIMIT 1";
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->clientId = $row['clientid'];
			$this->raison = $this->Unescape($row['raison']);
			$this->nom = $this->Unescape($row['nom']);
			$this->prenom = $this->Unescape($row['prenom']);
			$this->adr2 = $this->Unescape($row['adr2']);
			$this->adr1 = $this->Unescape($row['adr1']);
			$this->ville = $this->Unescape($row['ville']);
			$this->pays = $this->Unescape($row['pays']);
			$this->actif = $this->Unescape($row['actif']);
			$this->gsm = $this->Unescape($row['gsm']);
		}
		return $this;
	}
	
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $clientList
	*/
	function GetList($fcv_array = array(), $sortBy='', $ascending=true, $limit='')
	{
		$connection = Database::Connect();
		$sqlLimit = ($limit != '' ? "LIMIT $limit" : '');
		$this->pog_query = "select * from `client` ";
		$clientList = Array();
		if (sizeof($fcv_array) > 0)
		{
			$this->pog_query .= " where ";
			for ($i=0, $c=sizeof($fcv_array); $i<$c; $i++)
			{
				if (sizeof($fcv_array[$i]) == 1)
				{
					$this->pog_query .= " ".$fcv_array[$i][0]." ";
					continue;
				}
				else
				{
					if ($i > 0 && sizeof($fcv_array[$i-1]) != 1)
					{
						$this->pog_query .= " AND ";
					}
					if (isset($this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes']) && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'NUMERIC' && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'SET')
					{
						if ($GLOBALS['configuration']['db_encoding'] == 1)
						{
							$value = POG_Base::IsColumn($fcv_array[$i][2]) ? "BASE64_DECODE(".$fcv_array[$i][2].")" : "'".$fcv_array[$i][2]."'";
							$this->pog_query .= "BASE64_DECODE(`".$fcv_array[$i][0]."`) ".$fcv_array[$i][1]." ".$value;
						}
						else
						{
							$value =  POG_Base::IsColumn($fcv_array[$i][2]) ? $fcv_array[$i][2] : "'".$this->Escape($fcv_array[$i][2])."'";
							$this->pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." ".$value;
						}
					}
					else
					{
						$value = POG_Base::IsColumn($fcv_array[$i][2]) ? $fcv_array[$i][2] : "'".$fcv_array[$i][2]."'";
						$this->pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." ".$value;
					}
				}
			}
		}
		if ($sortBy != '')
		{
			if (isset($this->pog_attribute_type[$sortBy]['db_attributes']) && $this->pog_attribute_type[$sortBy]['db_attributes'][0] != 'NUMERIC' && $this->pog_attribute_type[$sortBy]['db_attributes'][0] != 'SET')
			{
				if ($GLOBALS['configuration']['db_encoding'] == 1)
				{
					$sortBy = "BASE64_DECODE($sortBy) ";
				}
				else
				{
					$sortBy = "$sortBy ";
				}
			}
			else
			{
				$sortBy = "$sortBy ";
			}
		}
		else
		{
			$sortBy = "clientid";
		}
		$this->pog_query .= " order by ".$sortBy." ".($ascending ? "asc" : "desc")." $sqlLimit";
		$thisObjectName = get_class($this);
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$client = new $thisObjectName();
			$client->clientId = $row['clientid'];
			$client->raison = $this->Unescape($row['raison']);
			$client->nom = $this->Unescape($row['nom']);
			$client->prenom = $this->Unescape($row['prenom']);
			$client->adr2 = $this->Unescape($row['adr2']);
			$client->adr1 = $this->Unescape($row['adr1']);
			$client->ville = $this->Unescape($row['ville']);
			$client->pays = $this->Unescape($row['pays']);
			$client->actif = $this->Unescape($row['actif']);
			$client->gsm = $this->Unescape($row['gsm']);
			$clientList[] = $client;
		}
		return $clientList;
	}
	
	
	/**
	* Saves the object to the database
	* @return integer $clientId
	*/
	function Save()
	{
		$connection = Database::Connect();
		$this->pog_query = "select `clientid` from `client` where `clientid`='".$this->clientId."' LIMIT 1";
		$rows = Database::Query($this->pog_query, $connection);
		if ($rows > 0)
		{
			$this->pog_query = "update `client` set 
			`raison`='".$this->Escape($this->raison)."', 
			`nom`='".$this->Escape($this->nom)."', 
			`prenom`='".$this->Escape($this->prenom)."', 
			`adr2`='".$this->Escape($this->adr2)."', 
			`adr1`='".$this->Escape($this->adr1)."', 
			`ville`='".$this->Escape($this->ville)."', 
			`pays`='".$this->Escape($this->pays)."', 
			`actif`='".$this->Escape($this->actif)."', 
			`gsm`='".$this->Escape($this->gsm)."' where `clientid`='".$this->clientId."'";
		}
		else
		{
			$this->pog_query = "insert into `client` (`raison`, `nom`, `prenom`, `adr2`, `adr1`, `ville`, `pays`, `actif`, `gsm` ) values (
			'".$this->Escape($this->raison)."', 
			'".$this->Escape($this->nom)."', 
			'".$this->Escape($this->prenom)."', 
			'".$this->Escape($this->adr2)."', 
			'".$this->Escape($this->adr1)."', 
			'".$this->Escape($this->ville)."', 
			'".$this->Escape($this->pays)."', 
			'".$this->Escape($this->actif)."', 
			'".$this->Escape($this->gsm)."' )";
		}
		$insertId = Database::InsertOrUpdate($this->pog_query, $connection);
		if ($this->clientId == "")
		{
			$this->clientId = $insertId;
		}
		return $this->clientId;
	}
	
	
	/**
	* Clones the object and saves it to the database
	* @return integer $clientId
	*/
	function SaveNew()
	{
		$this->clientId = '';
		return $this->Save();
	}
	
	
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$connection = Database::Connect();
		$this->pog_query = "delete from `client` where `clientid`='".$this->clientId."'";
		return Database::NonQuery($this->pog_query, $connection);
	}
	
	
	/**
	* Deletes a list of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param bool $deep 
	* @return 
	*/
	function DeleteList($fcv_array)
	{
		if (sizeof($fcv_array) > 0)
		{
			$connection = Database::Connect();
			$pog_query = "delete from `client` where ";
			for ($i=0, $c=sizeof($fcv_array); $i<$c; $i++)
			{
				if (sizeof($fcv_array[$i]) == 1)
				{
					$pog_query .= " ".$fcv_array[$i][0]." ";
					continue;
				}
				else
				{
					if ($i > 0 && sizeof($fcv_array[$i-1]) !== 1)
					{
						$pog_query .= " AND ";
					}
					if (isset($this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes']) && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'NUMERIC' && $this->pog_attribute_type[$fcv_array[$i][0]]['db_attributes'][0] != 'SET')
					{
						$pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." '".$this->Escape($fcv_array[$i][2])."'";
					}
					else
					{
						$pog_query .= "`".$fcv_array[$i][0]."` ".$fcv_array[$i][1]." '".$fcv_array[$i][2]."'";
					}
				}
			}
			return Database::NonQuery($pog_query, $connection);
		}
	}
}
?>