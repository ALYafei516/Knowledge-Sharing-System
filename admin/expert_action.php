<?php

//expert_action.php

include('../class/Appointment.php');

$object = new Appointment;

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'fetch')
	{
		$order_column = array('expert_name', 'expert_status');

		$output = array();

		$main_query = "
		SELECT * FROM expert_table ";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'WHERE expert_email_address LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR expert_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR expert_phone_no LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR expert_date_of_birth LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR expert_degree LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR expert_expert_in LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR expert_status LIKE "%'.$_POST["search"]["value"].'%" ';
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY expert_id DESC ';
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
			$sub_array[] = '<a href="../'.$row["expert_profile_image"].'" class="img-thumbnail" target="_blank">download</a>';
			$sub_array[] = $row["expert_email_address"];
			$sub_array[] = $row["expert_password"];
			$sub_array[] = $row["expert_name"];
			$sub_array[] = $row["expert_phone_no"];
			$sub_array[] = $row["expert_expert_in"];
			$status = '';
			if($row["expert_status"] == 'Active')
			{
				$status = '<button type="button" name="status_button" class="btn btn-primary btn-sm status_button" data-id="'.$row["expert_id"].'" data-status="'.$row["expert_status"].'">Active</button>';
			}
			else
			{
				$status = '<button type="button" name="status_button" class="btn btn-danger btn-sm status_button" data-id="'.$row["expert_id"].'" data-status="'.$row["expert_status"].'">Inactive</button>';
			}
			$sub_array[] = $status;
			$sub_array[] = '
			<div align="center">
			<button type="button" name="view_button" class="btn btn-info btn-circle btn-sm view_button" data-id="'.$row["expert_id"].'"><i class="fas fa-eye"></i></button>
			<button type="button" name="edit_button" class="btn btn-warning btn-circle btn-sm edit_button" data-id="'.$row["expert_id"].'"><i class="fas fa-edit"></i></button>
			<button type="button" name="delete_button" class="btn btn-danger btn-circle btn-sm delete_button" data-id="'.$row["expert_id"].'"><i class="fas fa-times"></i></button>
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

		$data = array(
			':expert_email_address'	=>	$_POST["expert_email_address"]
		);

		$object->query = "
		SELECT * FROM expert_table 
		WHERE expert_email_address = :expert_email_address
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">Email Address Already Exists</div>';
		}
		else
		{
			$expert_profile_image = $_POST["hidden_expert_profile_image"];

			if($_FILES['expert_profile_image']['name'] != '')
			{
				$allowed_file_format = array("docx","doc", "pdf");

	    		$file_extension = pathinfo($_FILES["expert_profile_image"]["name"], PATHINFO_EXTENSION);

	    		if(!in_array($file_extension, $allowed_file_format))
			    {
			        $error = "<div class='alert alert-danger'>Upload valiid file. doc, docx, pdf</div>";
			    }
			    else if (($_FILES["expert_profile_image"]["size"] > 2000000))
			    {
			       $error = "<div class='alert alert-danger'>File size exceeds 2MB</div>";
			    }
			    else
			    {
			    	$new_name = rand() . '.' . $file_extension;

					$destination = '../images/' . $new_name;

					move_uploaded_file($_FILES['expert_profile_image']['tmp_name'], $destination);

					$expert_profile_image = 'images/' . $new_name;;
			    }
			}


			if($error == '')
			{
				$data = array(
					':expert_email_address'			=>	$object->clean_input($_POST["expert_email_address"]),
					':expert_password'				=>	$_POST["expert_password"],
					':expert_name'					=>	$object->clean_input($_POST["expert_name"]),
					':expert_profile_image'			=>	$expert_profile_image,
					':expert_phone_no'				=>	$object->clean_input($_POST["expert_phone_no"]),
					':expert_address'				=>	$object->clean_input($_POST["expert_address"]),
					':expert_date_of_birth'			=>	$object->clean_input($_POST["expert_date_of_birth"]),
					':expert_degree'				=>	$object->clean_input($_POST["expert_degree"]),
					':expert_expert_in'				=>	$object->clean_input($_POST["expert_expert_in"]),
					':expert_status'				=>	'Active',
					':expert_added_on'				=>	$object->now
				);

				$object->query = "
				INSERT INTO expert_table 
				(expert_email_address, expert_password, expert_name, expert_profile_image, expert_phone_no, expert_address, expert_date_of_birth, expert_degree, expert_expert_in, expert_status, expert_added_on) 
				VALUES (:expert_email_address, :expert_password, :expert_name, :expert_profile_image, :expert_phone_no, :expert_address, :expert_date_of_birth, :expert_degree, :expert_expert_in, :expert_status, :expert_added_on)
				";

				$object->execute($data);

				$success = '<div class="alert alert-success">Expert Added</div>';
			}
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
		SELECT * FROM expert_table 
		WHERE expert_id = '".$_POST["expert_id"]."'
		";

		$result = $object->get_result();

		$data = array();

		foreach($result as $row)
		{
			$data['expert_email_address'] = $row['expert_email_address'];
			$data['expert_password'] = $row['expert_password'];
			$data['expert_name'] = $row['expert_name'];
			$data['expert_profile_image'] ='../'.$row['expert_profile_image'];
			$data['expert_phone_no'] = $row['expert_phone_no'];
			$data['expert_address'] = $row['expert_address'];
			$data['expert_date_of_birth'] = $row['expert_date_of_birth'];
			$data['expert_degree'] = $row['expert_degree'];
			$data['expert_expert_in'] = $row['expert_expert_in'];
		}

		echo json_encode($data);
	}

	if($_POST["action"] == 'Edit')
	{
		$error = '';

		$success = '';

		$data = array(
			':expert_email_address'	=>	$_POST["expert_email_address"],
			':expert_id'			=>	$_POST['hidden_id']
		);

		$object->query = "
		SELECT * FROM expert_table 
		WHERE expert_email_address = :expert_email_address 
		AND expert_id != :expert_id
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">Email Address Already Exists</div>';
		}
		else
		{
			$expert_profile_image = $_POST["hidden_expert_profile_image"];

			if($_FILES['expert_profile_image']['name'] != '')
			{
				$allowed_file_format = array("docx","doc", "pdf");

	    		$file_extension = pathinfo($_FILES["expert_profile_image"]["name"], PATHINFO_EXTENSION);

	    		if(!in_array($file_extension, $allowed_file_format))
			    {
			        $error = "<div class='alert alert-danger'>Upload valiid file. doc, docx, pdf</div>";
			    }
			    else if (($_FILES["expert_profile_image"]["size"] > 2000000))
			    {
			       $error = "<div class='alert alert-danger'>File size exceeds 2MB</div>";
			    }
			    else
			    {
			    	$new_name = rand() . '.' . $file_extension;

					$destination = '../images/' . $new_name;

					move_uploaded_file($_FILES['expert_profile_image']['tmp_name'], $destination);

					$expert_profile_image = 'images/' . $new_name;;
			    }
			}

			if($error == '')
			{
				$data = array(
					':expert_email_address'			=>	$object->clean_input($_POST["expert_email_address"]),
					':expert_password'				=>	$_POST["expert_password"],
					':expert_name'					=>	$object->clean_input($_POST["expert_name"]),
					':expert_profile_image'			=>	$expert_profile_image,
					':expert_phone_no'				=>	$object->clean_input($_POST["expert_phone_no"]),
					':expert_address'				=>	$object->clean_input($_POST["expert_address"]),
					':expert_date_of_birth'			=>	$object->clean_input($_POST["expert_date_of_birth"]),
					':expert_degree'				=>	$object->clean_input($_POST["expert_degree"]),
					':expert_expert_in'				=>	$object->clean_input($_POST["expert_expert_in"])
				);

				$object->query = "
				UPDATE expert_table  
				SET expert_email_address = :expert_email_address, 
				expert_password = :expert_password, 
				expert_name = :expert_name, 
				expert_profile_image = :expert_profile_image, 
				expert_phone_no = :expert_phone_no, 
				expert_address = :expert_address, 
				expert_date_of_birth = :expert_date_of_birth, 
				expert_degree = :expert_degree,  
				expert_expert_in = :expert_expert_in 
				WHERE expert_id = '".$_POST['hidden_id']."'
				";

				$object->execute($data);

				$success = '<div class="alert alert-success">expert Data Updated</div>';
			}			
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
		WHERE expert_id = '".$_POST["id"]."'
		";

		$object->execute($data);

		echo '<div class="alert alert-success">Class Status change to '.$_POST['next_status'].'</div>';
	}

	if($_POST["action"] == 'delete')
	{
		$object->query = "
		DELETE FROM expert_table 
		WHERE expert_id = '".$_POST["id"]."'
		";

		$object->execute();

		echo '<div class="alert alert-success">expert Data Deleted</div>';
	}
}

?>