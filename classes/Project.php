<?php 

class Project extends Model
{
    private $table = 'projects';

	public function get($id="*")
	{
		if($id=="*"){
			//select all products
	      return $this->_db->select("SELECT * FROM {$this->table} ORDER BY `name` ASC")->results();
		}
		else{
			//select a particular product
			return $this->_db->select("SELECT * FROM {$this->table} WHERE `id`='$id'")->first();
		}
	}



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


	public function updateStatus($token, $id)
	{
		
		switch($token)
		{
			case 'remind_later':
				$this->_db->update($this->table, ['status'=>2], $id);
				break;
			case 'satisfied':
				if($this->_db->update($this->table, ['status'=>1, 'd_notes'=>''], $id)) {
					return true;
				}
				break;
			case 'print':
				if($this->_db->update($this->table, ['status'=>1], $id)) {
					return true;
				}
				break;
			case 'notsatisfied':
			   if($this->_db->update($this->table, [
			   	                  'status'=>3,
			   	                  'd_notes'=>Input::get('notes')
			   	                  ], $id)) {
			   		return true;
			   }
			   break;
			default:
			//code goes here
			break;
		}
		
		
	}


	public function displayReminded()
	{
		$projects = $this->_db->get($this->table, ['status', '=', 2])->results();
		echo "
	        <div id=\"remindedmodal\">
			    <div class=\"w3-modal-content w3-card w3-border w3-round\" style=\"max-width:690px;margin-top: 30px;\">

			      <div class=\"w3-center\"><br>
			        <span onclick=\"hideElement('remindedmodal')\" class=\"w3-button w3-xxlarge w3-hover-red w3-display-topright\" title=\"Close\">&times;</span>
			        <h3 class=\"w3-text-red\">Reminded Projects for Approval</h3>
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
				       <td><button onclick=\"openTab('div".$project->id."') \">View</button></td> 
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
	                        <button class=\"w3-button  w3-indigo w3-section w3-padding\" type=\"submit\" name=\"satisfied\" onclick=\"updateProject('".$project->id."', 'satisfied');document.getElementById('div".$project->id."').style.display='none'\"><b>Satisfied</b></button>
	                        <button class=\"w3-button  w3-indigo w3-section w3-padding\" type=\"submit\" name=\"notsatisfied\" onclick=\"showElement('notsatisfied-modal', '".$project->id."');document.getElementById('div".$project->id."').style.display='none'\"><b>Not Satisfied</b></button>
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



	public function createMaterialsBill() 
	{
		$materials = [];
		$totalRows = Input::get('total_rows');
		for($i = 0; $i<$totalRows; $i++)
		{
			$materials[Input::get('name_'.$i)] = array(
												Input::get('quantity_'.$i),
												Input::get('quantity_available_usable_'.$i),
												Input::get('quantity_to_purchase_'.$i)
												);
		}
		$query = $this->_db->insert('project_materials', [
									'project_id'=>Input::get('project_id'),
									'materials'=>json_encode($materials)
								]);
		if($query) {
			return true;
		}
		return false;
	}




}