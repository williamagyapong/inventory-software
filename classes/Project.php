<?php 

class Project extends Model
{


    /**
    *fetch all projects or a particular project
    *@param id | int
    *@return projects | array
    */
	public function get($id="*")
	{
		if($id=="*"){
			//select all products
	      return $this->_db->select("SELECT * FROM {$this->table} ORDER BY `date_begun` DESC")->results();
		}
		else{
			//select a particular product
			return $this->_db->select("SELECT * FROM {$this->table} WHERE `id`='$id'")->first();
		}
	}

    /**
    * insert project project 
    * @param void
    * @return boolean
    */

    public function register()
    {
    	$projectManager = json_encode(array('name'=>ucwords(Input::get('name_of_project_manager')), 'phone'=>Input::get('project_manager_phone')));
		$storesAdmin = json_encode(array('name'=>ucwords(Input::get('name_of_stores_admin')), 'phone'=>Input::get('stores_admin_phone')));

    	if($this->_db->insert($this->table, [
                                  'name'=>ucfirst(Input::get('name')),
                                  'location'=>ucfirst(Input::get('location')),
                                  'description'=>ucfirst(Input::get('description')),
                                  'company_in_charge'=>ucfirst(Input::get('company')),
                                  'date_begun'=>Input::get('commencement_date'),
                                  'date_completion'=>Input::get('completion_date'),
                                  'project_manager'=>$projectManager,
                                  'stores_admin'=>$storesAdmin
			])) {
    		return true;//success
    	}
    	return false;//failure
    }


    /**
    * change project project
    * @param void
    * @return boolean
    */

    public function update()
    {
    	$projectManager = json_encode(array('name'=>ucwords(Input::get('name_of_project_manager')), 'phone'=>Input::get('project_manager_phone')));
		$storesAdmin = json_encode(array('name'=>ucwords(Input::get('name_of_stores_admin')), 'phone'=>Input::get('stores_admin_phone')));

		if($this->_db->update($this->table, [
                                  'name'=>ucfirst(Input::get('name')),
                                  'location'=>ucfirst(Input::get('location')),
                                  'description'=>ucfirst(Input::get('description')),
                                  'company_in_charge'=>ucfirst(Input::get('company')),
                                  'date_begun'=>Input::get('commencement_date'),
                                  'date_completion'=>Input::get('completion_date'),
                                  'project_manager'=>$projectManager,
                                  'stores_admin'=>$storesAdmin,
                                  'status'=>0
			],Input::get('project_id'))) {
			return true; // success
		}
		return false; // failure
    }


    /**
	*fetch all projects approved by manager
	*@param void
	*@return projects | array
	*/
	public function getApproved()
	{
		return $this->_db->get($this->table, array('status', '=', 1))->results();
	}


	/**
	*fetch all projects tagged non satisfactory by manager
	*@param void
	*@return projects | array
	*/
	public function getNotSatisfied()
	{
		return $this->_db->get($this->table, array('status', '=', 3))->results();
	}


	/**
	*fetch all projects with bill of required materials not prepared
	*@param void
	*@return projects | array
	*/
	public function getInProgress()
	{
		$currentDate = date('Y-m-d');
		//$currentDate = '2017-09-02';
		return $this->_db->select("SELECT $ FROM {$this->table} WHERE `status`=1 AND `date_begun`<='{$currentDate}'ORDER BY `name` ASC LIMIT 5")->results();
	}

	

	/**
    * determine project ratings
    * @param void
    * @return array|int
    */
    public function getRatings()
    {
    	$total = count($this->get());
    	$approved = count($this->getApproved());
    	$notSatisfied = count($this->getNotSatisfied());
    	$nonApproved = $total - ($approved + $notSatisfied);

    	//convert to percentages
    	$approved = round(($approved/$total)*100, 2);
    	$notSatisfied = round(($notSatisfied/$total)*100, 2);
    	$nonApproved = round(($nonApproved/$total)*100, 2);

    	return array($total, $approved, $notSatisfied, $nonApproved);
    	
    }


	/**
	*indicate the status of each project on display
	*@param administrator/user | string
	*@return string
	*/
	public function displayStatus($admin, $id = null)
	{
	   if($id)
	   {
	   		$project = $this->get($id);
	   		switch ($project->status) {
	   			case '0':
	   				return '<span class="w3-text-orange">Awaiting Approval</span>';
	   				break;
	   			case '1':
	   				return '<span class="w3-text-blue">Approved</span>';
	   				break;
	   			case '2':
	   			    if($admin=='storekeeper') {
	   			    	return '<span class="w3-text-orange">Awaiting Approval</span>';
	   			    } else {
	   			    	return '<span class="w3-text-red">On Reminder</span>';
	   			    }
	   				
	   				break;
	   			case '3':
	   				return '<span class="w3-text-red w3-bold">Not Satisfied</span>';
	   				break;
	   			default:
	   				# code...
	   				break;
	   		}
	   }
	}


	public function displayBillStatus($admin, $id = null)
	{
	   if($id)
	   {
	   		$project = $this->get($id);
	   		switch ($project->bill_status) {
	   			case '0':
	   				return '<span class="w3-text-orange">Awaiting Approval</span>';
	   				break;
	   			case '1':
	   				return '<span class="w3-text-blue">Approved</span>';
	   				break;
	   			case '2':
	   			    if($admin=='storekeeper') {
	   			    	return '<span class="w3-text-orange">Awaiting Approval</span>';
	   			    } else {
	   			    	return '<span class="w3-text-red">On Reminder</span>';
	   			    }
	   				
	   				break;
	   			case '3':
	   				return '<span class="w3-text-red w3-bold">Not Satisfied</span>';
	   				break;
	   			default:
	   				return '<span class="w3-text-black w3-bold">Not billed</span>';
	   				break;
	   		}
	   }
	}



	/**
	*change the status of projects per initiated requests
	*@param directive | string, project id | int
	*@return boolean
	*/
	public function updateStatus($token, $id, $field='status')
	{
		
		switch($token)
		{
			case 'remind_later':
				$this->_db->update($this->table, [$field=>2], $id);
				break;
			case 'satisfied':
				if($this->_db->update($this->table, [$field=>1, 'd_notes'=>''], $id)) {
					return true;
				}
				break;
			case 'print':
				if($this->_db->update($this->table, [$field=>1, 'd_notes'=>''], $id)) {
					return true;
				}
				break;
			case 'notsatisfied':
			   if($this->_db->update($this->table, [
			   	                  $field=>3,
			   	                  'd_notes'=>Input::get('notes')
			   	                  ], $id)) {
			   		return true;
			   }
			   break;
			case 'bill_saved':
			   if($this->_db->update($this->table, ['bill_status'=>0], $id)) {
			   		return true;
			   }
			   break;
			default:
			//code goes here
			break;
		}
		
	}


	/**
	*display projects put on reminder for viewing
	*@param void
	*@return html elements
	*/
	public function displayReminded()
	{
		$projects = $this->_db->get($this->table, ['status', '=', 2])->results();
		echo "
	        <div id=\"remindedmodal\" style=\"position:absolute;margin-left:30px;margin-top:50px\">
			    <div class=\"w3-modal-content w3-card w3-border w3-round\" style=\"margin-top: 30px;\">

			      <div class=\"w3-center\"><br>
			        <span onclick=\"hideElement('remindedmodal')\" class=\"fa fa-times w3-button w3-xlarge w3-hover-red w3-display-topright\" title=\"Close\"></span>";
			    echo (count($projects)==1)?"<span class=\"w3-text-red w3-large bold\">Reminded Project for Approval</span>":" <h3 class=\"w3-text-red w3-large bold\">Reminded Projects for Approval</h3>";
			    echo "
			      </div>

			       <div class=\"w3-responsive\">
			        <table class=\"talbe w3-table w3-striped w3-border w3-bordered\">
			          <tr>
			           <th>ID</th>
			           <th>Project Name</th>
			           <th>Action</th>
			          </tr>";
			$count = 0;
			foreach($projects as $project) {
				$sql = "SELECT * FROM {$this->table} WHERE status = 2 AND id={$project->id}";
				$thisProject = $this->_db->select($sql)->first();
				$count++;
				echo "<tr>
				       <td>".$count."</td>
				       <td>".$project->name."</td>
				       <td><button class=\"my-button\" onclick=\"openTab('div".$project->id."') \"><i class=\"fa fa-folder-open-o w3-text-orange\"></i> View</button></td> 
				      </tr>
				      
	                     <div id=\"div$project->id\" class=\"tabs\" style=\"display:none;margin-bottom:20px;\">
	                     <div class=\"w3-container w3-light-grey\">
	                      <div class\"w3-section \" id=\"section\">
	                          <div class=\"w3-half\">
	                            <span class=\"w3-bold\">Name of Project</span>
	                            <div class=\"w3-border w3-margin-bottom w3-blue-grey w3-padding\" id=\"box\">".$thisProject->name." </div>
	                          </div>
	                          <div class=\"w3-half\">
	                            <span class=\"w3-bold\">Company In Charge</span>
	                            <div class=\"w3-border w3-margin-bottom w3-blue-grey w3-padding\" id=\"box\">".$thisProject->company_in_charge." </div>
	                          </div>
	                          <div class=\"w3-half\">
	                            <span class=\"w3-bold\">Location Of Project</span>
	                            <div class=\"w3-border w3-margin-bottom w3-blue-grey w3-padding\" id=\"box\">".$thisProject->location." </div>
	                          </div>
	                          <div class=\"w3-half\">
	                            <span class=\"w3-bold\">Description Of Project</span>
	                            <div class=\"w3-border w3-margin-bottom w3-blue-grey w3-padding\" id=\"box\">".$thisProject->description." </div>
	                          </div>
	                          <div class=\"w3-half\">
	                            <span class=\"w3-bold\">Commencement Date</span>
	                            <div class=\"w3-border w3-margin-bottom w3-blue-grey w3-padding\" id=\"box\">".$thisProject->date_begun." </div>
	                          </div>
	                          <div class=\"w3-half\">
	                            <span class=\"w3-bold\">Completion Date</span>
	                            <div class=\"w3-border w3-margin-bottom w3-blue-grey w3-padding\" id=\"box\">".$thisProject->date_completion." </div>
	                          </div>
	                          
		                      <fieldset class=\"w3-light-grey\">
		                        <legend class=\"w3-text-red\">Project Manager</legend>
		                        <div class=\"w3-half\">
	                            <span class=\"w3-bold\">Name</span>
	                            <div class=\"w3-border w3-margin-bottom w3-blue-grey w3-padding\" id=\"box\">".json_decode($thisProject->project_manager)->name." </div>
	                          </div>
	                          <div class=\"w3-half\">
	                            <span class=\"w3-bold\">Phone</span>
	                            <div class=\"w3-border w3-margin-bottom w3-blue-grey w3-padding\" id=\"box\">".json_decode($thisProject->project_manager)->phone." </div>
	                          </div>
		                      </fieldset>
		                      <fieldset class=\"w3-light-grey\">
		                        <legend class=\"w3-text-red\">Stores Administrator</legend>
		                        <div class=\"w3-half\">
	                            <span class=\"w3-bold\">Name</span>
	                            <div class=\"w3-border w3-margin-bottom w3-blue-grey w3-padding\" id=\"box\">".json_decode($thisProject->stores_admin)->name." </div>
	                          </div>
	                          <div class=\"w3-half\">
	                            <span class=\"w3-bold\">Phone</span>
	                            <div class=\"w3-border w3-margin-bottom w3-blue-grey w3-padding\" id=\"box\">".json_decode($thisProject->stores_admin)->phone." </div>
	                          </div>
		                      </fieldset>
		                      <fieldset class=\"w3-container w3-border-top w3-padding-16 w3-light-grey\">
	                       <div class=\"w3-right\">
	                        <button class=\"w3-button\" type=\"submit\" name=\"satisfied\" onclick=\"updateProject('".$project->id."', 'satisfied');document.getElementById('div".$project->id."').style.display='none'\"><b>Satisfied</b></button>
	                        <button class=\"w3-button\" type=\"submit\" name=\"notsatisfied\" onclick=\"showElement('notsatisfied-modal', '".$project->id."');document.getElementById('div".$project->id."').style.display='none'\"><b>Not Satisfied</b></button>
	                        </div>
	                       </fieldset>
		                  </div>
		                 </div>";
			}
		      echo   "</table>
		            </div>
		           </div>
		          </div>
		         ";
	}



	/**
	*display projects marked as non-satisfactory for editing
	*@param void
	*@return html elements
	*/

	public function displayNonSatisfactoryProject($projectId)
	{
		$project = $this->get($projectId);
		$projectManager = json_decode($project->project_manager);
		$storesAdmin =  json_decode($project->stores_admin);
		//print_array($storesAdmin);
		
			echo "
                <form class=\"w3-container\" action=\"action_page.php\" method=\"post\">
                  <input type=\"hidden\" name=\"project_id\" value=\" $project->id\">
                  <div class=\"w3-section\">
                   <fieldset class=\"w3-light-grey\">
                    <div class=\"w3-half\">
                      <label><b>Name of Project</b></label>
                      <input class=\"w3-input w3-border w3-margin-bottom w3-blue-grey\" type=\"text\" name=\"name\" value=\"$project->name\" required=\"required\">
                    </div>
                    <div class=\"w3-half\">
                      <label><b>Company In Charge of Project</b></label>
                      <input class=\"w3-input w3-border w3-margin-bottom w3-blue-grey\" type=\"text\" name=\"company\" value=\"$project->company_in_charge\" required=\"required\">
                    </div>
                    <div class=\"w3-half\">
                      <label><b>Location of Project</b></label>
                      <input class=\"w3-input w3-border w3-margin-bottom w3-blue-grey\" type=\"text\" name=\"location\" value=\"$project->location\" required=\"required\">  
                    </div>
                    <div class=\"w3-half\">
                      <label><b>Description of Project</b></label>
                      <input class=\"w3-input w3-border w3-margin-bottom w3-blue-grey\" type=\"text\"  name=\"description\" value=\"$project->description\" required=\"required\">
                    </div>
                    <div class=\"w3-half\">
                      <label><b>Date of Commencement</b></label>
                      <input class=\"w3-input w3-border w3-margin-bottom w3-blue-grey\" type=\"date\" name=\"commencement_date\" value=\"$project->date_begun\" required=\"required\"> 
                    </div>
                    <div class=\"w3-half\">
                      <label><b>Expected Date of Completion</b></label>
                      <input class=\"w3-input w3-border w3-margin-bottom w3-blue-grey\" type=\"date\" name=\"completion_date\" value=\"$project->date_completion\" required=\"required\">
                    </div>
                    </fieldset>
                    <fieldset class=\"w3-light-grey\">
                      <legend class=\"w3-text-red\"><b>Project Manager</b></legend>
                      <div class=\"w3-half\">
                        <label><b>Name</b></label>
                        <input class=\"w3-input w3-border w3-margin-bottom w3-blue-grey\" type=\"text\" name=\"name_of_project_manager\" value=\"$projectManager->name\" required=\"required\">
                      </div>
                      <div class=\"w3-half\">
                        <label><b>Phone</b></label>
                        <input class=\"w3-input w3-border w3-margin-bottom w3-blue-grey\" type=\"text\" name=\"project_manager_phone\" value=\"$projectManager->phone\" required=\"required\">
                      </div>
                    </fieldset>
                    <fieldset class=\"w3-light-grey\">
                      <legend class=\"w3-text-red\"><b>Stores Administrator</b></legend>
                      <div class=\"w3-half\">
                        <label><b>Name</b></label>
                        <input class=\"w3-input w3-border w3-margin-bottom w3-blue-grey\" type=\"text\" name=\"name_of_stores_admin\" value=\"$storesAdmin->name\" required=\"required\">
                      </div>
                      <div class=\"w3-half\">
                        <label><b>Phone</b></label>
                        <input class=\"w3-input w3-border w3-margin-bottom w3-blue-grey\" type=\"text\" name=\"stores_admin_phone\" value=\"$storesAdmin->phone\" required=\"required\">
                      </div>
                    </fieldset>
                    <div class=\"w3-container w3-border-top w3-padding-16 w3-light-grey\">
                      <div class=\"w3-right\">
                        <button class=\"w3-button\" type=\"submit\" name=\"register\" value=\"update_project\"><b>Submit For Approval</b></button>
                      </div>
                   </div>
                  </div>
                </form>
     ";
		

	}




	

	


}