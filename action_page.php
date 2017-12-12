<?php
require_once 'core/init.php';

/*
|----------------------------------------------------------------------- 
| Project registration/update
|----------------------------------------------------------------------- 
*/
$project = new Project();
$matObject = new Material();

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
		
		switch(Input::get('register'))
		{
			case 'register_project':
			$queryRun= $project->register();
			break;
			case 'update_project':
			$queryRun= $project->update();
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


/*
|=====================================================================
|  post method requests handling
|=====================================================================
*/
if(Input::exist('p_token'))
{
	switch(Input::get('p_token'))
	{
		case 'remind_later':
			$project->updateStatus(Input::get('p_token'),Input::get('projectId'),Input::get('field_name'));
			//Session::put(Input::get('p_token'), Input::get('projectId'));
		break;
		
		case 'satisfied':
			if($project->updateStatus(Input::get('p_token'),Input::get('project_id'),Input::get('field_name'))) {
				//delete sessions after approving bills
                Session::delete('SHOW_PROJECT_BILL'); 
                Session::delete('APPROVE_PROJECT_BILL'); 

				Redirect::to('dashboard.php');//take user to the dashboard
			} else {
				//trigger error message
				Redirect::to(503);
			}
		break;
		case 'notsatisfied':
			if($project->updateStatus(Input::get('p_token'),Input::get('projectId'),Input::get('field_name'))) {
				Redirect::to('dashboard.php');
			} else {
				//trigger error message
				Redirect::to(502);
			}
			
		break;
		case 'print':
			if($project->updateStatus(Input::get('p_token'),Input::get('project_id'),Input::get('field_name'))) {
				if(Input::get('field_name')=='status') {
					//store project id for printing
					Session::put('PROJECT_ID', Input::get('project_id'));
					
				} 

			} else {
				Redirect::to(503);//trigger error message
			}
	    break;

	    case 'print_project_session':
	    	Session::put('PRINT_PROJECT', TRUE);//set this token to control display on show_project page
	    break;

	    case 'print_bill_session':
	        if(Input::get('project_id') !=0) {
	        	Session::put('SHOW_PROJECT_BILL', TRUE);
	        	Session::put('PRINT_PROJECT_BILL', Input::get('project_id'));//set this token to control display on show_project page
	        }
	    	
	    break;
	    //for displaying bill details for approval only
	    case 'show_bill_session':
	        if(Input::get('project_id') !=0) {
	        	Session::put('SHOW_PROJECT_BILL', TRUE);
	        	Session::put('APPROVE_PROJECT_BILL', Input::get('project_id'));//set this token to control display on show_project page
	        }
	    	
	    break;

	    case 'clear_project_session':
	    	Session::delete('PRINT_PROJECT');//clear this token to control display on show_project page
	    break;

	    case 'submit_bill':
			if($matObject->prepareBill()) {
				Session::put('R_SUCCESS', 'bill');
				Redirect::to('project.php');
			} else {
				//trigger error message
				Redirect::to(503);
			}
	    break;

	    case 'receive':
			if($matObject->receive()) {
				Session::put('R_SUCCESS', 'received');
				Redirect::to('stock.php');
			} else {
				//trigger error message
				Redirect::to(503);
			}
		case 'dispatch':
			 if($matObject->saveDispatchedItems()) {
			 	Session::put('R_SUCCESS', 'dispatched');
			 	Redirect::to('stock.php');
			 }
	    break;
	    case 'check_material':
	    	echo $matObject->exist(Input::get('term'));
	    break;
	    case 'auto_add_material':
	    	 $matObject->add([Input::get('term'), 0, '']);
	    break;
	    case 'add_new_mat':
	    //die('hit');
	    	 if($matObject->add()) {
	    	 	Session::put('R_SUCCESS', 'new_mat_added');
	    	 	Redirect::to('stock.php');
	    	 }
	    break;
	    case 'allow_delete':
	    	echo $matObject->allowDelete(Input::get('material_id'));
	    	 
	    break;
	    case 'update_stock':
	    	if($matObject->saveChanges()){
	    		Session::put('R_SUCCESS', 'changes_saved');
	    		Redirect::to('stock.php');
	    	}
	    break;
	    case 'delete_mat':
	    	if($matObject->delete(Input::get('material_id'))) 
	    	{
	    		Session::put('R_SUCCESS', 'deleted');
	    	}
 
	    break;
		default:
		//code
		break;
	    	


	}

}


/*
|=====================================================================
|  get method requests handling
|=====================================================================
*/
if(Input::exist('p_token','get'))
{
	switch (Input::get('p_token'))
	 {
		case 'reminded':
		     $project->displayReminded();
			break;

		case 'get_material':
	         $data = [];
	    	 $material = $matObject->get(Input::get('term'));
	    	 $data['quantity_available'] = $material->quantity;
	    	 $data['unit'] = $material->unit;
	    	 echo json_encode($data);
	    	break;

	    case 'correct_project_reg':
		     $project->displayNonSatisfactoryProject(Input::get('item_id'));
			break;

		case 'correct_mat_bill':
		     $matObject->displayNonSatisfactoryMatBill(Input::get('item_id'));
			break;
		default:
			# code...
			break;
	}
}

if(Input::exist('load_mat_id', 'get'))
{
	$matObject->loadProjectMaterials(Input::get('load_mat_id'));
}

/*
|=====================================================================
| materials autocomplete 
|=====================================================================
*/
