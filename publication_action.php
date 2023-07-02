<?php

//publication_action.php

include('class/Appointment.php');

$object = new Appointment;
$user_id=$_SESSION['user_id'];
if(isset($_POST["action"]))
{
	if($_POST["action"] == 'fetch')
	{
		$order_column = array('publication_id', 'publication_title');

		$output = array();

		$main_query = "
		SELECT * FROM publication_table WHERE expert_id= '$user_id' ";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'OR publication_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR publication_title LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR publication_description LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR publication_date LIKE "%'.$_POST["search"]["value"].'%" ';
			
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY publication_id DESC ';
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

		$data = array();

		foreach($result as $row)
		{
			$sub_array = array();
			$sub_array[] = $row["publication_id"];;
			$sub_array[] = $row["publication_title"];
			$sub_array[] = $row["publication_description"];
			$sub_array[] = $row["publication_date"];
			
			
			$sub_array[] = '
			<div align="center">
			<button type="button" name="view_button" class="btn btn-info btn-circle btn-sm view_button" data-id="'.$row["publication_id"].'"><i class="fas fa-eye"></i></button>
			<button type="button" name="edit_button" class="btn btn-warning btn-circle btn-sm edit_button" data-id="'.$row["publication_id"].'"><i class="fas fa-edit"></i></button>
			<button type="button" name="delete_button" class="btn btn-danger btn-circle btn-sm delete_button" data-id="'.$row["publication_id"].'"><i class="fas fa-times"></i></button>
			</div>
			';
			$data[] = $sub_array;
		}

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

				$id='';
				$title=$_POST["publication_title"];
				$des=$_POST["publication_description"];
				$dat=$_POST["publication_date"];
			$eid=$user_id;

				$object->query = "
				INSERT INTO publication_table 
				VALUES ('','$title','$des','$dat','$eid')
				";

				$object->execute();

				$success = '<div class="alert alert-success">publication Added</div>';
			
		

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}

	if($_POST["action"] == 'fetch_single')
	{
		$object->query = "
		SELECT * FROM publication_table 
		WHERE publication_id = '".$_POST["publication_id"]."'
		";

		$result = $object->get_result();

		$data = array();

		foreach($result as $row)
		{
			$data['publication_title'] = $row['publication_title'];
			$data['publication_description'] = $row['publication_description'];
			$data['publication_date'] = $row['publication_date'];
			
			
		}

		echo json_encode($data);
	}

	if($_POST["action"] == 'Edit')
	{
		$error = '';

		$success = '';

		$title=$_POST["publication_title"];
				$des=$_POST["publication_description"];
				$dat=$_POST["publication_date"];

				$object->query = "
				UPDATE publication_table  
				SET publication_title ='$title' , 
				publication_description ='$des', 
				publication_date = '$dat' 
				WHERE publication_id = '".$_POST['hidden_id']."'
				";

				$object->execute();

				$success = '<div class="alert alert-success">publication Data Updated</div>';
						
		

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}

	if($_POST["action"] == 'change_status')
	{
		$data = array(
			':publication_status'		=>	$_POST['next_status']
		);

		$object->query = "
		UPDATE publication_table 
		SET publication_status = :publication_status 
		WHERE publication_id = '".$_POST["id"]."'
		";

		$object->execute($data);

		echo '<div class="alert alert-success">Class Status change to '.$_POST['next_status'].'</div>';
	}

	if($_POST["action"] == 'delete')
	{
		$object->query = "
		DELETE FROM publication_table 
		WHERE publication_id = '".$_POST["id"]."'
		";

		$object->execute();

		echo '<div class="alert alert-success">publication Data Deleted</div>';
	}
}

?>