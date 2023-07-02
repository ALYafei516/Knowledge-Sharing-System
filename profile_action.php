<?php

include('class/Appointment.php');

$object = new Appointment;

if($_POST["action"] == 'expert_profile')
{
	sleep(2);

	$error = '';

	$success = '';

	$expert_profile_image = '';

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
			$allowed_file_format = array("jpg", "png");

	    	$file_extension = pathinfo($_FILES["expert_profile_image"]["name"], PATHINFO_EXTENSION);

	    	if(!in_array($file_extension, $allowed_file_format))
		    {
		        $error = "<div class='alert alert-danger'>Upload valiid file. jpg, png</div>";
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

				$expert_profile_image = $destination;
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
		'error'					=>	$error,
		'success'				=>	$success,
		'expert_email_address'	=>	$_POST["expert_email_address"],
		'expert_password'		=>	$_POST["expert_password"],
		'expert_name'			=>	$_POST["expert_name"],
		'expert_profile_image'	=>	$expert_profile_image,
		'expert_phone_no'		=>	$_POST["expert_phone_no"],
		'expert_address'		=>	$_POST["expert_address"],
		'expert_date_of_birth'	=>	$_POST["expert_date_of_birth"],
		'expert_degree'			=>	$_POST["expert_degree"],
		'expert_expert_in'		=>	$_POST["expert_expert_in"],
	);

	echo json_encode($output);
}

if($_POST["action"] == 'admin_profile')
{
	sleep(2);

	$error = '';

	$success = '';

	$hospital_logo = $_POST['hidden_hospital_logo'];

	if($_FILES['hospital_logo']['name'] != '')
	{
		$allowed_file_format = array("jpg", "png");

	    $file_extension = pathinfo($_FILES["hospital_logo"]["name"], PATHINFO_EXTENSION);

	    if(!in_array($file_extension, $allowed_file_format))
		{
		    $error = "<div class='alert alert-danger'>Upload valiid file. jpg, png</div>";
		}
		else if (($_FILES["hospital_logo"]["size"] > 2000000))
		{
		   $error = "<div class='alert alert-danger'>File size exceeds 2MB</div>";
	    }
		else
		{
		    $new_name = rand() . '.' . $file_extension;

			$destination = '../images/' . $new_name;

			move_uploaded_file($_FILES['hospital_logo']['tmp_name'], $destination);

			$hospital_logo = $destination;
		}
	}

	if($error == '')
	{
		$data = array(
			':admin_email_address'			=>	$object->clean_input($_POST["admin_email_address"]),
			':admin_password'				=>	$_POST["admin_password"],
			':admin_name'					=>	$object->clean_input($_POST["admin_name"]),
			':hospital_name'				=>	$object->clean_input($_POST["hospital_name"]),
			':hospital_address'				=>	$object->clean_input($_POST["hospital_address"]),
			':hospital_contact_no'			=>	$object->clean_input($_POST["hospital_contact_no"]),
			':hospital_logo'				=>	$hospital_logo
		);

		$object->query = "
		UPDATE admin_table  
		SET admin_email_address = :admin_email_address, 
		admin_password = :admin_password, 
		admin_name = :admin_name, 
		hospital_name = :hospital_name, 
		hospital_address = :hospital_address, 
		hospital_contact_no = :hospital_contact_no, 
		hospital_logo = :hospital_logo 
		WHERE admin_id = '".$_SESSION["admin_id"]."'
		";
		$object->execute($data);

		$success = '<div class="alert alert-success">Admin Data Updated</div>';

		$output = array(
			'error'					=>	$error,
			'success'				=>	$success,
			'admin_email_address'	=>	$_POST["admin_email_address"],
			'admin_password'		=>	$_POST["admin_password"],
			'admin_name'			=>	$_POST["admin_name"], 
			'hospital_name'			=>	$_POST["hospital_name"],
			'hospital_address'		=>	$_POST["hospital_address"],
			'hospital_contact_no'	=>	$_POST["hospital_contact_no"],
			'hospital_logo'			=>	$hospital_logo
		);

		echo json_encode($output);
	}
	else
	{
		$output = array(
			'error'					=>	$error,
			'success'				=>	$success
		);
		echo json_encode($output);
	}
}

?>