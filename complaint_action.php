<?php

//expert_action.php

include('class/Appointment.php');

$object = new Appointment;

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'fetch')
	{
		$order_column = array('complaint_id','complaint_type', 'complaint_description','complaint_date','complaint_status');

		$output = array();

		$main_query = "
		SELECT * FROM complaint_table ";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'WHERE complaint_type LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR complaint_description LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR complaint_date LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR complaint_status LIKE "%'.$_POST["search"]["value"].'%" ';
			
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY complaint_id DESC ';
		}

		$limit_query = '';

		if($_POST["length"] != -1)
		{
			$limit_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$object->query = $main_query . $search_query . $order_query;

		$object->execute();

		$filtered_rows = $object->row_count();

		$object->query .= $limit_query;

		$result = $object->get_result();

		$object->query = $main_query;

		$object->execute();

		$total_rows = $object->row_count();
$sr=0;
		$data = array();

		foreach($result as $row)
		{
			$sub_array = array();
			$sub_array[] = $sr;
			$sub_array[] = $row["complaint_type"];
			$sub_array[] = $row["complaint_description"];
			$sub_array[] = $row["complaint_date"];
			$sub_array[] = $row["complaint_status"];
			
			$sub_array[] = '
			<div align="center">
			<button type="button" name="view_button" class="btn btn-info btn-circle btn-sm view_button" data-id="'.$row["complaint_id"].'"><i class="fas fa-eye"></i></button>
			<button type="button" name="edit_button" class="btn btn-warning btn-circle btn-sm edit_button" data-id="'.$row["complaint_id"].'"><i class="fas fa-edit"></i></button>
			<button type="button" name="delete_button" class="btn btn-danger btn-circle btn-sm delete_button" data-id="'.$row["complaint_id"].'"><i class="fas fa-times"></i></button>
			</div>
			';
			$data[] = $sub_array;
		$sr++;}

		$output = array(
			"draw"    			=> 	intval($_POST["draw"]),
			"recordsTotal"  	=>  $total_rows,
			"recordsFiltered" 	=> 	$filtered_rows,
			"data"    			=> 	$data
		);
			
		echo json_encode($output);
	
	}

	if($_POST["action"] == 'Add')
	{
		$error = '';

		$success = '';

		

			if($error == '')
			{ 
		$s="On Hold";
		$d=date("Y-m-d");
		$t=date("h:i:sa");
				$data = array(
					':complaint_type'				=> 	$_POST["complaint_type"],
					':complaint_description'		=>	$_POST["complaint_description"],
					':user_id'						=> 	$_SESSION['user_id'],
					':user_name'					=>	$_SESSION['user_name'],
					':complaint_status'				=>	$s,
					':complaint_date'				=>	$d,
					':complaint_time'				=>	$t
					
				);

				$object->query = "
				INSERT INTO complaint_table
				VALUES ('',:complaint_type, :complaint_description,:complaint_status, :user_id, :user_name,:complaint_date, :complaint_time)
				";

				$object->execute($data);

				$success = '<div class="alert alert-success">Expert Added</div>';
			}
		

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}

	if($_POST["action"] == 'fetch_single')
	{
		$object->query = "
		SELECT * FROM complaint_table
		WHERE complaint_id = '".$_POST["complaint_id"]."'
		";

		$result = $object->get_result();

		$data = array();

		foreach($result as $row)
		{
			$data['complaint_type'] = $row['complaint_type'];
			$data['complaint_description'] = $row['complaint_description'];
			$data['complaint_date'] = $row['complaint_date'];
			$data['complaint_status'] = $row['complaint_status'];
			
		}

		echo json_encode($data);
	}

	if($_POST["action"] == 'Edit')
	{
		$error = '';

		$success = '';

		

			if($error == '')
			{
				$data = array(
					
					':complaint_type'				=>	$_POST["complaint_type"],
					':complaint_description'				=>	$_POST["complaint_description"]
				
				);

				$object->query = "
				UPDATE complaint_table  
				SET complaint_type = :complaint_type, 
				complaint_description = :complaint_description 
				WHERE complaint_id = '".$_POST['hidden_id']."'
				";

				$object->execute($data);

				$success = '<div class="alert alert-success">Complaint Data Updated</div>';
			}			
		

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}

	if($_POST["action"] == 'change_status')
	{
		$data = array(
			':expert_status'		=>	$_POST['next_status']
		);

		$object->query = "
		UPDATE expert_table 
		SET expert_status = :expert_status 
		WHERE complaint_id = '".$_POST["id"]."'
		";

		$object->execute($data);

		echo '<div class="alert alert-success">Class Status change to '.$_POST['next_status'].'</div>';
	}

	if($_POST["action"] == 'delete')
	{
		$object->query = "
		DELETE FROM complaint_table   
		WHERE complaint_id = '".$_POST["id"]."'
		";

		$object->execute();

		echo '<div class="alert alert-success">Complaint Data Deleted</div>';
	}
}

?>