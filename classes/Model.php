<?php
/**
* A base class for project and material classes
* @author Agyapong William
* @since       
*/
class Model
{
	/**
	*set global variable for database interactions
	*@var string
	*/

    protected $table = 'projects';
    protected $table2 = 'materials';
    protected $table3 = 'project_material';
    protected $table4 = 'material_flow';
	protected $_db;


	public function __construct() {
		$this->_db = DBHandler::getInstance();
	}

	/**
	* fetch materials relating to a project
	* @param project id | int
	* @return array
	*/
	public function getProjectMaterials($projectId)
	{  
		$sql = "SELECT * FROM {$this->table2} INNER JOIN {$this->table3} ON {$this->table2}.id = {$this->table3}.material_id WHERE {$this->table3}.project_id= {$projectId} ORDER BY {$this->table2}.name ASC";
		return $this->_db->select($sql)->results();
	}


	/**
	*fetch all projects with bill of required materials not prepared
	*@param void
	*@return projects | array
	*/
	public function getUnbilled()
	{
		return $this->_db->select("SELECT * FROM {$this->table} WHERE `status`=1 AND `bill_status` = 'none' ORDER BY `name` ASC")->results();
	}
    

	/**
	*fetch all projects with approved bill of materials
	*@param void
	*@return projects | array
	*/
	public function getbilled()
	{
		return $this->_db->select("SELECT * FROM {$this->table} WHERE `status`=1 AND `bill_status` != 'none' ORDER BY `name` ASC")->results();
	}

	/**
	*fetch all projects with approved bill of materials
	*@param void
	*@return projects | array
	*/
	public function getActiveProjects()
	{
		//think about more appropriate method name
		return $this->_db->select("SELECT * FROM {$this->table} WHERE `status`=1 AND `bill_status`=1 ORDER BY `name` ASC")->results();
	}


}