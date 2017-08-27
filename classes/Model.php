<?php
class Model
{
	protected $_db;

	public function __construct() {
		$this->_db = DB::getInstance();
	}
}