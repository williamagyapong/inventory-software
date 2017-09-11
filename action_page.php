<?php
require_once 'core/init.php';
//print_array($_SESSION);
/*
|----------------------------------------------------------------------- 
| Project registration
|----------------------------------------------------------------------- 
*/
$project = new Project();
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
		switch(Input::get('register'))
		{
			case 'register_project':
			$queryRun=DBHandler::getInstance()->insert('projects', [
                                  'name'=>Input::get('name'),
                                  'location'=>Input::get('location'),
                                  'description'=>Input::get('description'),
                                  'company_in_charge'=>Input::get('company'),
                                  'date_begun'=>Input::get('commencement_date'),
                                  'date_completion'=>Input::get('completion_date'),
                                  'project_manager'=>$projectManager,
                                  'stores_admin'=>$storesAdmin
			]);
			break;
			case 'update_project':
			$queryRun=DBHandler::getInstance()->update('projects', [
                                  'name'=>Input::get('name'),
                                  'location'=>Input::get('location'),
                                  'description'=>Input::get('description'),
                                  'company_in_charge'=>Input::get('company'),
                                  'date_begun'=>Input::get('commencement_date'),
                                  'date_completion'=>Input::get('completion_date'),
                                  'project_manager'=>$projectManager,
                                  'stores_admin'=>$storesAdmin,
                                  'status'=>0
			],Input::get('project_id'));
			break;
			default:
			 #code to execute
			break;

		}
		if($queryRun)
		{   

			Session::put('R_SUCCESS', 'project');
			Redirect::to('project.php');
		}
		else{
			Session::put('R_ERRORS', $validation->errors());
			Redirect::to(502);
		}
	}else{
		 Session::put('R_ERRORS', $validation->errors());
		 Redirect::to(502);
	}
}

// update project status 
if(Input::exist('p_token'))
{
	switch(Input::get('p_token'))
	{
		case 'remind_later':
			$project->updateStatus(Input::get('p_token'),Input::get('projectId'));
			Session::put(Input::get('p_token'), Input::get('projectId'));
		break;
		
		case 'satisfied':
			if($project->updateStatus(Input::get('p_token'),Input::get('projectId'))) {
				Redirect::to('dashboard.php');
			} else {
				//trigger error message
				Redirect::to(502);
			}
		break;
		case 'notsatisfied':
			if($project->updateStatus(Input::get('p_token'),Input::get('projectId'))) {
				Redirect::to('dashboard.php');
			} else {
				//trigger error message
				Redirect::to(502);
			}
			
		break;
		case 'print':
			if($project->updateStatus(Input::get('p_token'),Input::get('projectId'))) {
				Session::put('PROJECT_ID', Input::get('projectId'));
				Redirect::to('print.php');
			} else {
				//trigger error message
				Redirect::to(502);
			}
	    break;
	    case 'print_session':
	    	Session::put('PRINTING', TRUE);//set this token to control display on show_project page
	    break;
	    case 'submit_bill':
			if($project->createMaterialsBill()) {
				Session::put('R_SUCCESS', 'bill');
				Redirect::to('project.php');
			} else {
				//trigger error message
				Redirect::to(502);
			}
	    break;
		default:
		//code
		break;


	}

}
//load projects details
if(Input::exist('p_token','get'))
{
	switch (Input::get('p_token'))
	 {
		case 'reminded':
		     $project->displayReminded();
			break;
		
		default:
			# code...
			break;
	}
}
