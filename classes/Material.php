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

	
}