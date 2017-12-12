<?php

class Material extends Model
{

	/**
	* fetch all materials / a particular material
	* @param token | varied
	* @return array
	*/
	
	public function get($token=null)
	{   
	
		if($token)
		{
			$field =  (is_numeric($token))? 'id': 'name';
			if($this->exist($token))
			{
			  return $this->_db->get($this->table2, [$field, '=', $token])->first();
			}
			return false;

		} else {
			return $this->_db->select("SELECT * FROM {$this->table2} ORDER BY `name` ASC")->results();
		}
	}
/**
	

	/**
	*check for availability of material
	*@param token | string/int
	*@return boolean
	*/

	public function exist($token)
	{   
		$field =  (is_numeric($token))? 'id': 'name';
		if(!empty($this->_db->get($this->table2, [$field, '=', $token])->results())) {
			return true;
		}
		return false;
	}


	/**
	* add material to stock
	* @param void
	* @return boolean
	*/
	public function add($details=array())
	{
		//implement auto add
		if(!empty($details))
		{
			if(!$this->exist($details[0]))
			{
				if($this->_db->insert($this->table2, [
													'name'=>$details[0],
													'quantity'=>$details[1],
													'unit'=>$details[2],
													'date_added'=>date('Y-m-d')
					                              ])) {
					return true;
				}
				return false;
			}
		}
		//add new materials manually
		elseif(empty($details)) 
		{
			for($i=0; $i<5; $i++)
			{
				if(Input::get('checked_'.$i) == 'checked')
				{
		
				  $this->_db->insert($this->table2, [
				  									'name'=>Input::get('name_'.$i),
				  									'quantity'=>Input::get('quantity_'.$i),
				  									'unit'=>Input::get('unit_'.$i),
				  									'date_added'=>date('Y-m-d')
						                           ]);

				}
			}
			return true;
		}

	}

    
    
	/**
	* update material details 
	* @param void
	* @return boolean
	*/
	public function saveChanges()
	{
		if($this->_db->update($this->table2, [
											'name'=>Input::get('name'),
											'quantity'=>Input::get('quantity'),
											'unit'=>Input::get('unit')
											], Input::get('mat_id')))
		{
			return true;
		}
		return false;
	}


	/**
	* grant material deletion
	* @param material id | int
	* @return boolean
	*/
 	public function allowDelete($id)
 	{
 		if(empty($this->_db->get($this->table3, ['material_id','=',$id])->results()))
 		{
 			return true;//allow
 		}
 		return false; //deny
 	}


 	/**
	* delete material record
	* @param material id | int
	* @return boolean
	*/
 	public function delete($id)
 	{
 		if($this->_db->delete($this->table2, ['id','=',$id]))
 		 {
 		 	return true;//deleted
 		 }
 		 return false;//failed to delete
 	}

	/**
	*receive materials for store
	*@param void
	*@return boolean
	*/
	public function receive() 
	{
		$materials = [];
		$totalRows = 2;
		//$projectId = Input::get('project_id');
		$affectedRows = 0;
		for($i = 0; $i<30; $i++)
		{
			$name = Input::get('name_'.$i);
			$quantity = Input::get('quantity_received_'.$i);
			$date = Input::get('date_received_'.$i);
			$material = $this->get($name);
			if($name!=''&&$quantity!=''&&$date!='')
			{
				$insert = $this->_db->insert($this->table4, [
									    'material_id'=>$material->id,
									    'quantity_received'=>$quantity,
										'flow_date'=>$date
									]);
			    //update quantity of material
				$update = $this->_db->update($this->table2, [
											'quantity'=>($material->quantity+$quantity)
					                ], $material->id);
			if($insert && $update) {
				$affectedRows++;
			}
			}
		}

		if($affectedRows==$totalRows) {
			return true;
			
		}
		return false;
	}


	/**
	*prepare bill of required materials
	*@param void
	*@return boolean
	*/
	public function prepareBill() 
	{
		$materials = [];
		$totalRows = Input::get('total_rows');
		$projectId = Input::get('project_id');
		$rowsInserted = 0;
		for($i = 0; $i<$totalRows; $i++)
		{

			/*$materialId = $this->get(Input('name_'.$i))->$id;
			$row = $this->_db->select("SELECT * FROM {$this->table3} WHERE project_id={$projectId} AND material_id={$materialId}");
			if(empty($row))
			{

			}*/
			$query = $this->_db->insert($this->table3, [
									    'project_id'=>$projectId,
									    'quantity_needed'=>Input::get('quantity_'.$i),
										'material_id'=>$this->get(Input::get('name_'.$i))->id,
										'date_prepared'=>date('Y-m-d')
									]);
			if($query) {
				$rowsInserted +=1;
			}
		}

		if($rowsInserted==$totalRows) {//update the projects table
			if($this->_db->update($this->table, ['bill_status'=>0], $projectId)) {
				return true;
			}
			
		}
		return false;
	}


	/**
	* store details of materials issued to site
	* @param void
	* @return boolean
	*/
	public function saveDispatchedItems()
	{
		$receivingOfficer = json_encode(array('name'=>ucfirst(Input::get('receive_officer_name')), 'position'=>ucfirst(Input::get('receive_officer_pos'))));
		$totalRows = Input::get('total_mat');//stored at loading time

		for($i = 1; $i<= $totalRows; $i++)
		{
			$checked = Input::get('checked_'.$i);

			if($checked=='ticked')
			{
				$this->_db->insert($this->table4, [
										 'material_id'=>Input::get('mat_id_'.$i),
										 'project_id'=>Input::get('project_id'),
										 'quantity_sent'=>Input::get('quantity_sent_'.$i),
										 'receiving_officer'=>$receivingOfficer,
										 'receiving_dept'=>Input::get('receiving_dept'),
										 'purpose'=>Input::get('purpose'),
										 'flow_date'=>date('Y-m-d')
					                    ]);
			}
		}

		return true;
	}


	/**
	*fetch all projects approved by manager
	*@param void
	*@return projects | array
	*/
	public function getApproved()
	{
		return $this->_db->get($this->table, array('bill_status', '=', 1))->results();
	}


	/**
	*fetch all projects tagged non satisfactory by manager
	*@param void
	*@return projects | array
	*/
	public function getNotSatisfied()
	{
		return $this->_db->get($this->table, array('bill_status', '=', 3))->results();
	}


	/**
    * determine materials bills ratings
    * @param void
    * @return array|int
    */
    public function getBillsRatings()
    {
    	$totalBills = count($this->getBilled());
    	$approvedBills = count($this->getApproved());
    	$notSatisfiedBills = count($this->getNotSatisfied());
    	$nonApprovedBills = $totalBills - ($approvedBills + $notSatisfiedBills);

    	//convert to percentages
    	$approvedBills = round(($approvedBills/$totalBills)*100, 2);
    	$notSatisfiedBills = round(($notSatisfiedBills/$totalBills)*100, 2);
    	$nonApprovedBills = round(($nonApprovedBills/$totalBills)*100, 2);

    	return array($totalBills, $approvedBills, $notSatisfiedBills, $nonApprovedBills);
    	
    }

	
	/**
	* load project materials via ajax request
	* @param project id | int
	* @return materials | html
	*/
	public function loadProjectMaterials($projectId)
	{
		$materials = $this->getProjectMaterials($projectId);
		//print_array($materials);
		if(!empty($materials)) 
		{	$numMat = 0;
			$totalMat = count($materials);
			foreach($materials as $material)
			{
				$numMat++;
				echo "<tr>";
				     echo "<td><input type=\"checkbox\" name=\"checked_$numMat\" value=\"ticked\" class=\"w3-check\"></td>";
				     echo "<td><input type=\"text\" name=\"name_$numMat\" value=\"$material->name\" style=\"padding-left:10px\" readonly></td>";
				     echo "<input type=\"hidden\" name=\"mat_id_$numMat\" value=\"$material->material_id\">";
				     echo "<td><input type=\"text\" name=\"quantity_sent_$numMat\" class=\"table-input\"></td>";
				echo "</tr>";
			}
			echo "<input type=\"hidden\" name=\"total_mat\" value=\"$totalMat\" />";
			echo "<tr>";
			 echo "<td colspan=4><span id=\"check2\" onclick=\"checkAll('check2','dispatch_form')\" class=\"w3-button my-button w3-text-orange\"><b>Select All</b></span></td>";
			echo "</tr>";
		}
	}



	/**
	*display projects marked as non-satisfactory for editing
	*@param void
	*@return html elements
	*/

	public function displayNonSatisfactoryMatBill($projectId)
	{
		$project = $this->_db->get($this->table, array('id', '=', $projectId))->first();
		$materials = $this->getProjectMaterials($projectId);
		$datePrepared = $materials[0]->date_prepared;
		$numMaterials = count($materials);
		//print_array($materials);

		echo "
		  <div class =\"w3-container\">
		  	<div class=\"w3-center\"><br>
             <span class=\"w3-text-red w3-large\">Required Materials Bill</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             <span class=\"w3-display-middleright\"> Prepared on: $datePrepared &nbsp;&nbsp;&nbsp;</span>
            </div>
		  </div>
          <fieldset>
            <legend class=\"w3-text-red\"><b>Name of Project</b></legend>
            <div class=\"w3-input w3-border w3-margin-bottom w3-light-grey\">
              <b>$project->name;</b>
            </div>
           </fieldset>
          <form id=\"mr_form\" class=\"w3-container w3-margin-bottom\" action=\"action_page.php\" method=\"post\" onsubmit=\"return validateForm()\">
            <div class=\"w3-container w3-border-top w3-padding-16 w3-light-grey\">
              <input type=\"hidden\" name=\"total_rows\">
              <div class=\"w3-responsive\">
                <table class=\"w3-table\">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Name of Material Needed For The Project</th>
                      <th>Quantity Needed</th>
                      <th>Quantity Already Available And Usable</th>
                      <th>Quantity to Purchase</th>
                    </tr>
                  </thead>
                  <tbody>";
                  for($x=0; $x<$numMaterials;$x++)
                  {
                  	$quantityToPurch = (($materials[$x]->quantity_needed>$materials[$x]->quantity))?($materials[$x]->quantity_needed-$materials[$x]->quantity):0;
                  	echo "
                  	<input type=\"hidden\" name=\"COUNTER\">
                    <tr id=\"field_row_$x\">
                      <td><input type=\"checkbox\" name=\"checked_$x\" disabled></td>
                      <td><input class=\"material table-input\" type=\"text\" name=\"name_$x\" value=\"".$materials[$x]->name."\" onblur=\"checkRow()\"></td>
                      <td><input type=\"text\" name=\"quantity_$x\" value=\"".$materials[$x]->quantity_needed."\" class=\"table-input numberonly\" onblur=\"checkRow();autoFill()\"></td>
                      <td><input type=\"text\" name=\"quantity_available_usable_$x\" value=\"".$materials[$x]->quantity."\" class=\"table-input\" onblur=\"checkRow()\" readonly></td>
                      <td><input type=\"text\" name=\"quantity_to_purchase_$x\" value=\"".$quantityToPurch."\" class=\"table-input\" onblur=\"checkRow()\" readonly></td>
                    </tr>";
                  }

                  //provide fields if additional ones are needed
                 echo "</tbody><tbody id=\"more_material_fields\" style=\"display:none;\">";
                  for($x=$numMaterials; $x<($numMaterials+5); $x++)
                  {
                  	echo "
	                  	<input type=\"hidden\" name=\"COUNTER\">
	                    <tr id=\"field_row_$x\">
	                      <td><input type=\"checkbox\" name=\"checked_$x\" disabled></td>
	                      <td><input class=\"material table-input\" type=\"text\" name=\"name_$x\" onblur=\"checkRow()\"></td>
	                      <td><input type=\"text\" name=\"quantity_$x\" class=\"table-input numberonly\" onblur=\"checkRow();autoFill()\"></td>
	                      <td><input type=\"text\" name=\"quantity_available_usable_$x\" class=\"table-input\" onblur=\"checkRow()\" readonly></td>
	                      <td><input type=\"text\" name=\"quantity_to_purchase_$x\" class=\"table-input\" onblur=\"checkRow()\" readonly></td>
	                    </tr>";
	                  

                  }
                echo "</tbody>";

                echo " 
                  
                </table>
              </div>
              <div class=\"w3-container w3-border-top w3-padding-16 w3-light-grey\">
                <div id=\"edit_btn_area\">
                  <span id=\"nsmb_edit_btn\" onclick=\"$('#more_material_fields').toggle(function(){if($('#nsmb_edit_btn').html()=='More Rows'){}});\" id=\"mat_edit_rows_btn\" class=\"w3-button w3-text-red my-button\"><b>More Rows</b></span>
                </div>
                <div class=\"w3-right\">
                  <span id=\"alert\" class=\"w3-text-red w3-padding\"></span>
                  <button class=\"w3-button\" type=\"submit\" name=\"p_token\" value=\"submit_bill\"><b>Submit For Approval</b></button>
                </div>
              </div>
            </div>
          </form>

		     ";
		    //nsmb = nonsatisfactory material bill
	}

	
}