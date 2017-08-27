<?php

/**
*
*@author Agyapong William
*@package Wrapper classes
*@since 01/10/2016
* User class
*/

class User
{
	private $_db,
	        $_data,
	        $_sessionName,
	        $_cookieName,
	        $_loggedIN = false;
 	
 	public function __construct($user = null, $table='users') 
 	{
 		$this->_db = DBHandler::getInstance();

 		$this->_sessionName = Config::get('session/session_name');

 		if(!$user) {
 			//get current user
 			if(Session::exist($this->_sessionName)) {
 				$user = Session::get($this->_sessionName);

                if($this->find($user, $table)) {
                	$this->_loggedIN = true;
                } else {
                	//process logout
                }
 			}
 		} else {
               //get another user 
 			$this->find($user, $table);
 		}
 	}
  
	
	public function create($fields = array())
	{
		if($this->_db->insert('users', $fields)) 
		{
			throw new Exception('There was a problem creating user account.');
		}
	}


	public function find($user=null, $table)
	 {
		if($user) {
			//we can search by username because it is always going to be unique
			$field =  (is_numeric($user))? 'id': 'username';
			$data = $this->_db->get($table, array($field, '=', $user));
            
			if($data->count()) {
				$this->_data = $data->first();

				return true;
			}
		}
		return false;
	}


	public function login($username=null, $password=null, $table="users") 
	{
		$user = $this->find($username, $table);
	    
	    if($user) 
	    {  //echo $this->data()->password.' '. Hash::make($password); die();
	    	if($this->data()->password == Hash::make($password)) 
	    	{
	    		
	    		Session::put($this->_sessionName, $this->data()->id);

	    		return true;
	    	}
	    }

	    return false;
	}


	public function logout()
	{
		    
			Session::delete($this->_sessionName);
      
		     return true;
	}

    public function update($table, $fields= array(), $id=null) 
    {

    	if(!$id && $this->isLoggedIn()) {
    		$id = $this->data()->id;
    	}
 
    	if(!$this->_db->update($table, $fields, $id)) {

    		throw new Exception("There was a problem updating!");
    	}
    }


	public function exists() 
	{
		return (!empty($this->_data))? true: false;
	}

	public function data()
	{
		return $this->_data;
	}
   

	public function isLoggedIn() 
	{
		return $this->_loggedIN;
	}

   
   public function settleDebt()
	{   
		$debtorId = $_POST['cust-id'];
		$amount = $_POST['amount'];
		$debt   = $_POST['debt'];
		if(is_numeric($amount))
		{  
			if($amount == $debt) {

				if($this->_db->update2('sales', ['customer_id'=>$debtorId], ['customer_id'=>0])) {
	                  
	    	      if($this->_db->update2('customers', ['id'=>$debtorId], ['paid'=>$amount],'+')&&$this->_db->update2('customers', ['id'=>$debtorId], ['owing'=>$amount],'-')) {
	               
	               	   echo "<h2>Debt fully settled !</h2>";
	               	   return true;
	    	    } else {
	    	    	 return false;
	    	    }
	          }
		 } elseif($amount<$debt){
		 	   $bal = $debt - $amount;
		 	   if($this->_db->update2('customers', ['id'=>$debtorId], ['paid'=>$amount],'+')&&$this->_db->update2('customers', ['id'=>$debtorId], ['owing'=>$amount],'-')) {
	               
	               	   echo "<h2>GH&cent;". $bal." of debt still remaining !</h2>";
	                    return true;
	    	    } else {
	    	    	 return false;
	    	    }
		 	  
		 } else{

	 	   return false;
	    }          
	    
	  }
	}

public function getDebtors($name=null)
{  
	if($name) 
	{

	   return $this->_db->select("SELECT * FROM `customers` WHERE `name` LIKE '$name%' AND `owing`!= 0   ORDER BY `date` DESC")->results();

	} else {

	  return $this->_db->select("SELECT * FROM `customers` WHERE `owing`!= 0 ORDER BY `date` DESC")->results();
	}
}
   


   
}

?>