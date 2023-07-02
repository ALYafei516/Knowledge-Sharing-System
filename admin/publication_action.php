<?php

//publication_action.php

include('../class/Appointment.php');

$object = new Appointment;

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'fetch')
	{
		$order_column = array('publication_name', 'publication_status');

		$output = array();

		$main_query = "
		SELECT * FROM publication_table ";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'WHERE publication_email_address LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR publication_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR publication_phone_no LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR publication_date_of_birth LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR publication_degree LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR publication_publication_in LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR publication_status LIKE "%'.$_POST["search"]["value"].'%" ';
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

		$data = array(
			':publication_email_address'	=>	$_POST["publication_email_address"]
		);

		$object->query = "
		SELECT * FROM publication_table 
		WHERE publication_email_address = :publication_email_address
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">Email Address Already Exists</div>';
		}
		else
		{
			$publication_profile_image = $_POST["hidden_publication_profile_image"];

			if($_FILES['publication_profile_image']['name'] != '')
			{
				$allowed_file_format = array("docx","doc", "pdf");

	    		$file_extension = pathinfo($_FILES["publication_profile_image"]["name"], PATHINFO_EXTENSION);

	    		if(!in_array($file_extension, $allowed_file_format))
			    {
			        $error = "<div class='alert alert-danger'>Upload valiid file. doc, docx, pdf</div>";
			    }
			    else if (($_FILES["publication_profile_image"]["size"] > 2000000))
			    {
			       $error = "<div class='alert alert-danger'>File size exceeds 2MB</div>";
			    }
			    else
			    {
			    	$new_name = rand() . '.' . $file_extension;

					$destination = '../images/' . $new_name;

					move_uploaded_file($_FILES['publication_profile_image']['tmp_name'], $destination);

					$publication_profile_image = 'images/' . $new_name;;
			    }
			}


			if($error == '')
			{
				$data = array(
					':publication_email_address'			=>	$object->clean_input($_POST["publication_email_address"]),
					':publication_password'				=>	$_POST["publication_password"],
					':publication_name'					=>	$object->clean_input($_POST["publication_name"]),
					':publication_profile_image'			=>	$publication_profile_image,
					':publication_phone_no'				=>	$object->clean_input($_POST["publication_phone_no"]),
					':publication_address'				=>	$object->clean_input($_POST["publication_address"]),
					':publication_date_of_birth'			=>	$object->clean_input($_POST["publication_date_of_birth"]),
					':publication_degree'				=>	$object->clean_input($_POST["publication_degree"]),
					':publication_publication_in'				=>	$object->clean_input($_POST["publication_publication_in"]),
					':publication_status'				=>	'Active',
					':publication_added_on'				=>	$object->now
				);

				$object->query = "
				INSERT INTO publication_table 
				(publication_email_address, publication_password, publication_name, publication_profile_image, publication_phone_no, publication_address, publication_date_of_birth, publication_degree, publication_publication_in, publication_status, publication_added_on) 
				VALUES (:publication_email_address, :publication_password, :publication_name, :publication_profile_image, :publication_phone_no, :publication_address, :publication_date_of_birth, :publication_degree, :publication_publication_in, :publication_status, :publication_added_on)
				";

				$object->execute($data);

				$success = '<div class="alert alert-success">publication Added</div>';
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
		SELECT * FROM publication_table 
		WHERE publication_id = '".$_POST["publication_id"]."'
		";

		$result = $object->get_result();

		$data = array();

		foreach($result as $row)
		{
			$data['publication_email_address'] = $row['publication_email_address'];
			$data['publication_password'] = $row['publication_password'];
			$data['publication_name'] = $row['publication_name'];
			$data['publication_profile_image'] ='../'.$row['publication_profile_image'];
			$data['publication_phone_no'] = $row['publication_phone_no'];
			$data['publication_address'] = $row['publication_address'];
			$data['publication_date_of_birth'] = $row['publication_date_of_birth'];
			$data['publication_degree'] = $row['publication_degree'];
			$data['publication_publication_in'] = $row['publication_publication_in'];
		}

		echo json_encode($data);
	}

	if($_POST["action"] == 'Edit')
	{
		$error = '';

		$success = '';

		$data = array(
			':publication_email_address'	=>	$_POST["publication_email_address"],
			':publication_id'			=>	$_POST['hidden_id']
		);

		$object->query = "
		SELECT * FROM publication_table 
		WHERE publication_email_address = :publication_email_address 
		AND publication_id != :publication_id
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">Email Address Already Exists</div>';
		}
		else
		{
			$publication_profile_image = $_POST["hidden_publication_profile_image"];

			if($_FILES['publication_profile_image']['name'] != '')
			{
				$allowed_file_format = array("docx","doc", "pdf");

	    		$file_extension = pathinfo($_FILES["publication_profile_image"]["name"], PATHINFO_EXTENSION);

	    		if(!in_array($file_extension, $allowed_file_format))
			    {
			        $error = "<div class='alert alert-danger'>Upload valiid file. doc, docx, pdf</div>";
			    }
			    else if (($_FILES["publication_profile_image"]["size"] > 2000000))
			    {
			       $error = "<div class='alert alert-danger'>File size exceeds 2MB</div>";
			    }
			    else
			    {
			    	$new_name = rand() . '.' . $file_extension;

					$destination = '../images/' . $new_name;

					move_uploaded_file($_FILES['publication_profile_image']['tmp_name'], $destination);

					$publication_profile_image = 'images/' . $new_name;;
			    }
			}

			if($error == '')
			{
				$data = array(
					':publication_email_address'			=>	$object->clean_input($_POST["publication_email_address"]),
					':publication_password'				=>	$_POST["publication_password"],
					':publication_name'					=>	$object->clean_input($_POST["publication_name"]),
					':publication_profile_image'			=>	$publication_profile_image,
					':publication_phone_no'				=>	$object->clean_input($_POST["publication_phone_no"]),
					':publication_address'				=>	$object->clean_input($_POST["publication_address"]),
					':publication_date_of_birth'			=>	$object->clean_input($_POST["publication_date_of_birth"]),
					':publication_degree'				=>	$object->clean_input($_POST["publication_degree"]),
					':publication_publication_in'				=>	$object->clean_input($_POST["publication_publication_in"])
				);

				$object->query = "
				UPDATE publication_table  
				SET publication_email_address = :publication_email_address, 
				publication_password = :publication_password, 
				publication_name = :publication_name, 
				publication_profile_image = :publication_profile_image, 
				publication_phone_no = :publication_phone_no, 
				publication_address = :publication_address, 
				publication_date_of_birth = :publication_date_of_birth, 
				publication_degree = :publication_degree,  
				publication_publication_in = :publication_publication_in 
				WHERE publication_id = '".$_POST['hidden_id']."'
				";

				$object->execute($data);

				$success = '<div class="alert alert-success">publication Data Updated</div>';
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