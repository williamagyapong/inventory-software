<?php
require_once 'core/init.php';
//print_array($_SESSION);
/*
|----------------------------------------------------------------------- 
| Project registration
|----------------------------------------------------------------------- 
*/
if(Input::exist('register'))
{
	$validate = new Validator();
	$validation = $validate->check( array(
		          'name'=>array('required'=>true),
		          'location'=>array('required'=>true),
		          'company'=>array('required'=>true),
		          'description'=>array('required'=>true),
		          'commencement_date'=>array('required'=>true),
		          'completion_date'=>array('required'=>true),
		          'name_of_project_manager'=>array('required'=>true),
		          'project_manager_phone'=>array('required'=>true),
		          'name_of_stores_admin'=>array('required'=>true),
		          'stores_admin_phone'=>array('required'=>true)
		 )                            
		);
	if($validation->passed())
	{
		$projectManager = json_encode(array('name'=>Input::get('name_of_project_manager'), 'phone'=>Input::get('project_manager_phone')));
		$storesAdmin = json_encode(array('name'=>Input::get('name_of_stores_admin'), 'phone'=>Input::get('stores_admin_phone')));
		$inserted=DBHandler::getInstance()->insert('projects', [
                                  'name'=>Input::get('name'),
                                  'location'=>Input::get('location'),
                                  'description'=>Input::get('description'),
                                  'company_in_charge'=>Input::get('company'),
                                  'date_begun'=>Input::get('commencement_date'),
                                  'date_completion'=>Input::get('completion_date'),
                                  'project_manager'=>$projectManager,
                                  'stores_admin'=>$storesAdmin
			]);
		if($inserted)
		{   

			Session::put('R_SUCCESS', TRUE);
			Redirect::to('project.php');
		}
	}else{
		print_array($_SESSION);
		Session::put('R_ERRORS', $validation->errors());
	}
}