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

}