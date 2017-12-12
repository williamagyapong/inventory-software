<?php
class Notification
{   

    private static function getDB()
    {
    	return DBHandler::getInstance();
    }



	public function getNonApproved() 
	{    
		$db = self::getDB();

		$result = $db->get('projects', array('status','=',0))->results();
		$num = count($result);
		if($num==0)
		{
			return  '';
		}
	}


	public static function getProjectReminders()
	{
		$db = self::getDB();
		$count = count($db->get('projects', array('status','=',2))->results());

		switch($count)
		{
			case 0:
			return false;
			break;

			case 1:
			return "One project requires your attention";

			default:
			return $count. " projects require your attention";
		}
		
	}


	/**
	*@param
	*@var 
    */
    public static function getStorekeeperMsg()
    {
    	$sql = "SELECT * FROM projects WHERE status = 3 OR bill_status = 3";
    	return self::getDB()->select($sql)->results();
    }


	public static function counter()
	{
		
	}
	
}


//echo Notification::getProjectReminders();die();