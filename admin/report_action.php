<?php

//doctor_action.php

include('../class/Appointment.php');

$object = new Appointment;

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'fetch')
	{
		$order_column = array('com_id', 'com_text', 'user_id', 'rep_date');
		$output = array();

		$main_query = "
		SELECT * FROM repcom_table ";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'WHERE com_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR com_text LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR user_id LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR rep_date LIKE "%'.$_POST["search"]["value"].'%" ';
			
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY rep_id DESC ';
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
			$sub_array[] = $row["rep_id"];
			$sub_array[] = $row["user_id"];
			$sub_array[] = $row["com_text"];
			$sub_array[] = $row["rep_date"];
			$status = '
			<select name="state" id="sel'.$row["rep_id"].'" onchange="ch(this)">
			<option value="no">Select Status</option>
			<option value="In Investigate">In Investigate</option>
			<option value="Resolved">Resolved</option>
			<option value="On Hold">On Hold</option>
			</select>
			';
			
			$sub_array[] = $status;
			$sub_array[] = '
			<div align="center">
		
			<button type="button" name="edit_button" class="btn btn-warning btn-circle btn-sm edit_button" data-id="'.$row["rep_id"].'"><i class="fas fa-edit"></i></button>
			
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

	/*if($_POST["action"] == 'Add')
	{
		$error = '';

		$success = '';

		$data = array(
			':doctor_email_address'	=>	$_POST["doctor_email_address"]
		);

		$object->query = "
		SELECT * FROM doctor_table 
		WHERE doctor_email_address = :doctor_email_address
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">Email Address Already Exists</div>';
		}
		else
		{
			$doctor_profile_image = '';
			if($_FILES['doctor_profile_image']['name'] != '')
			{
				$allowed_file_format = array("jpg", "png");

	    		$file_extension = pathinfo($_FILES["doctor_profile_image"]["name"], PATHINFO_EXTENSION);

	    		if(!in_array($file_extension, $allowed_file_format))
			    {
			        $error = "<div class='alert alert-danger'>Upload valiid file. jpg, png</div>";
			    }
			    else if (($_FILES["doctor_profile_image"]["size"] > 2000000))
			    {
			       $error = "<div class='alert alert-danger'>File size exceeds 2MB</div>";
			    }
			    else
			    {
			    	$new_name = rand() . '.' . $file_extension;

					$destination = '../images/' . $new_name;

					move_uploaded_file($_FILES['doctor_profile_image']['tmp_name'], $destination);

					$doctor_profile_image = $destination;
			    }
			}
			else
			{
				$character = $_POST["doctor_name"][0];
				$path = "../images/". time() . ".png";
				$image = imagecreate(200, 200);
				$red = rand(0, 255);
				$green = rand(0, 255);
				$blue = rand(0, 255);
			    imagecolorallocate($image, 230, 230, 230);  
			    $textcolor = imagecolorallocate($image, $red, $green, $blue);
			    imagettftext($image, 100, 0, 55, 150, $textcolor, '../font/arial.ttf', $character);
			    imagepng($image, $path);
			    imagedestroy($image);
			    $doctor_profile_image = $path;
			}

			if($error == '')
			{
				$data = array(
					':doctor_email_address'			=>	$object->clean_input($_POST["doctor_email_address"]),
					':doctor_password'				=>	$_POST["doctor_password"],
					':doctor_name'					=>	$object->clean_input($_POST["doctor_name"]),
					':doctor_profile_image'			=>	$doctor_profile_image,
					':doctor_phone_no'				=>	$object->clean_input($_POST["doctor_phone_no"]),
					':doctor_address'				=>	$object->clean_input($_POST["doctor_address"]),
					':doctor_date_of_birth'			=>	$object->clean_input($_POST["doctor_date_of_birth"]),
					':doctor_degree'				=>	$object->clean_input($_POST["doctor_degree"]),
					':doctor_expert_in'				=>	$object->clean_input($_POST["doctor_expert_in"]),
					':doctor_status'				=>	'Active',
					':doctor_added_on'				=>	$object->now
				);

				$object->query = "
				INSERT INTO doctor_table 
				(doctor_email_address, doctor_password, doctor_name, doctor_profile_image, doctor_phone_no, doctor_address, doctor_date_of_birth, doctor_degree, doctor_expert_in, doctor_status, doctor_added_on) 
				VALUES (:doctor_email_address, :doctor_password, :doctor_name, :doctor_profile_image, :doctor_phone_no, :doctor_address, :doctor_date_of_birth, :doctor_degree, :doctor_expert_in, :doctor_status, :doctor_added_on)
				";

				$object->execute($data);

				$success = '<div class="alert alert-success">Doctor Added</div>';
			}
		}

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}*/

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
			
			
			$data['complaint_type'] = $row["complaint_type"];
			$data["complaint_description"] = $row["complaint_description"];
			$data["user_name"] = $row["user_name"];
			$data["complaint_date"] = $row["complaint_date"];
			
			if($row['complaint_status'] == 'Resolved')
			{
				$data['complaint_status'] = '<span class="badge badge-success">Resolved</span>';
			}
			else if($row['complaint_status'] == 'In Investigation')
			{
				$data['complaint_status'] = '<span class="badge badge-warning">In Investigation</span>';
			}
			else
			{
				$data['complaint_status'] = '<span class="badge badge-danger">On Hold</span>';
			}
		}

		echo json_encode($data);
	}

	/*if($_POST["action"] == 'Edit')
	{
		$error = '';

		$success = '';

		$data = array(
			':doctor_email_address'	=>	$_POST["doctor_email_address"],
			':doctor_id'			=>	$_POST['hidden_id']
		);

		$object->query = "
		SELECT * FROM doctor_table 
		WHERE doctor_email_address = :doctor_email_address 
		AND doctor_id != :doctor_id
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">Email Address Already Exists</div>';
		}
		else
		{
			$doctor_profile_image = $_POST["hidden_doctor_profile_image"];

			if($_FILES['doctor_profile_image']['name'] != '')
			{
				$allowed_file_format = array("jpg", "png");

	    		$file_extension = pathinfo($_FILES["doctor_profile_image"]["name"], PATHINFO_EXTENSION);

	    		if(!in_array($file_extension, $allowed_file_format))
			    {
			        $error = "<div class='alert alert-danger'>Upload valiid file. jpg, png</div>";
			    }
			    else if (($_FILES["doctor_profile_image"]["size"] > 2000000))
			    {
			       $error = "<div class='alert alert-danger'>File size exceeds 2MB</div>";
			    }
			    else
			    {
			    	$new_name = rand() . '.' . $file_extension;

					$destination = '../images/' . $new_name;

					move_uploaded_file($_FILES['doctor_profile_image']['tmp_name'], $destination);

					$doctor_profile_image = $destination;
			    }
			}

			if($error == '')
			{
				$data = array(
					':doctor_email_address'			=>	$object->clean_input($_POST["doctor_email_address"]),
					':doctor_password'				=>	$_POST["doctor_password"],
					':doctor_name'					=>	$object->clean_input($_POST["doctor_name"]),
					':doctor_profile_image'			=>	$doctor_profile_image,
					':doctor_phone_no'				=>	$object->clean_input($_POST["doctor_phone_no"]),
					':doctor_address'				=>	$object->clean_input($_POST["doctor_address"]),
					':doctor_date_of_birth'			=>	$object->clean_input($_POST["doctor_date_of_birth"]),
					':doctor_degree'				=>	$object->clean_input($_POST["doctor_degree"]),
					':doctor_expert_in'				=>	$object->clean_input($_POST["doctor_expert_in"])
				);

				$object->query = "
				UPDATE doctor_table  
				SET doctor_email_address = :doctor_email_address, 
				doctor_password = :doctor_password, 
				doctor_name = :doctor_name, 
				doctor_profile_image = :doctor_profile_image, 
				doctor_phone_no = :doctor_phone_no, 
				doctor_address = :doctor_address, 
				doctor_date_of_birth = :doctor_date_of_birth, 
				doctor_degree = :doctor_degree,  
				doctor_expert_in = :doctor_expert_in 
				WHERE doctor_id = '".$_POST['hidden_id']."'
				";

				$object->execute($data);

				$success = '<div class="alert alert-success">Doctor Data Updated</div>';
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
			':doctor_status'		=>	$_POST['next_status']
		);

		$object->query = "
		UPDATE doctor_table 
		SET doctor_status = :doctor_status 
		WHERE doctor_id = '".$_POST["id"]."'
		";

		$object->execute($data);

		echo '<div class="alert alert-success">Class Status change to '.$_POST['next_status'].'</div>';
	}
*/
	if($_POST["action"] == 'delete')
	{
		$object->query = "
		UPDATE repcom_table SET rep_status='".$_POST["state"]."'
		WHERE rep_id  = '".$_POST["id"]."'
		";

		$object->execute();

		echo '<div class="alert alert-success">Data Updated</div>';
	}
}

?>