<?php

//action.php

include('class/Appointment.php');

$object = new Appointment;

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'check_login')
	{
		if(isset($_SESSION['user_id']))
		{
			echo 'dashboard.php';
		}
		else
		{
			echo 'login.php';
		}
	}

	if($_POST['action'] == 'user_register')
	{
		$error = '';

		$success = '';

		$data = array(
			':user_email_address'	=>	$_POST["user_email_address"]
		);

		$object->query = "
		SELECT * FROM user_table 
		WHERE user_email_address = :user_email_address
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">Email Address Already Exists</div>';
		}
		else
		{
			$user_verification_code = md5(uniqid());
			$data = array(
				':user_email_address'		=>	$object->clean_input($_POST["user_email_address"]),
				':user_password'				=>	$_POST["user_password"],
				':user_first_name'			=>	$object->clean_input($_POST["user_first_name"]),
				':user_last_name'			=>	$object->clean_input($_POST["user_last_name"]),
				':user_date_of_birth'		=>	$object->clean_input($_POST["user_date_of_birth"]),
				':user_gender'				=>	$object->clean_input($_POST["user_gender"]),
				':user_address'				=>	$object->clean_input($_POST["user_address"]),
				':user_phone_no'				=>	$object->clean_input($_POST["user_phone_no"]),
				':user_type'		=>	$object->clean_input($_POST["user_type"]),
				':user_added_on'				=>	$object->now,
				':user_verification_code'	=>	$user_verification_code,
				':email_verify'					=>	'Yes'
			);

			$object->query = "
			INSERT INTO user_table 
			(user_email_address, user_password, user_first_name, user_last_name, user_date_of_birth, user_gender, user_address, user_phone_no, user_type, user_added_on, user_verification_code, email_verify) 
			VALUES (:user_email_address, :user_password, :user_first_name, :user_last_name, :user_date_of_birth, :user_gender, :user_address, :user_phone_no, :user_type, :user_added_on, :user_verification_code, :email_verify)
			";

			$object->execute($data);
/*
			require 'class/class.phpmailer.php';
			$mail = new PHPMailer;
			$mail->IsSMTP();
			$mail->Host = 'smtpout.secureserver.net';
			$mail->Port = '80';
			$mail->SMTPAuth = true;
			$mail->Username = 'xxxxx';
			$mail->Password = 'xxxxx';
			$mail->SMTPSecure = '';
			$mail->From = 'tutorial@webslesson.info';
			$mail->FromName = 'Webslesson';
			$mail->AddAddress($_POST["user_email_address"]);
			$mail->WordWrap = 50;
			$mail->IsHTML(true);
			$mail->Subject = 'Verification code for Verify Your Email Address';

			$message_body = '
			<p>For verify your email address, Please click on this <a href="'.$object->base_url.'verify.php?code='.$user_verification_code.'"><b>link</b></a>.</p>
			<p>Sincerely,</p>
			<p>Webslesson.info</p>
			';
			$mail->Body = $message_body;

			if($mail->Send())
			{
				
			}
			else
			{
				$error = '<div class="alert alert-danger">' . $mail->ErrorInfo . '</div>';
			}
		} */
		$success = '<div class="alert alert-success">Register Successfully</div>';
		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);
		echo json_encode($output);
	}
}
	if($_POST['action'] == 'user_login')
	{
		$error = '';

		$data = array(
			':user_email_address'	=>	$_POST["user_email_address"]
		);

		$object->query = "
		SELECT * FROM user_table 
		WHERE user_email_address = :user_email_address
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{

			$result = $object->statement_result();

			foreach($result as $row)
			{
				if($row["email_verify"] == 'Yes')
				{
					if($row["user_password"] == $_POST["user_password"])
					{
						$_SESSION['user_id'] = $row['user_id'];
						$_SESSION['user_name'] = $row['user_first_name'] . ' ' . $row['user_last_name'];
						$_SESSION['user_type']="user";
					}
					else
					{
						$error = '<div class="alert alert-danger">Wrong Password</div>';
					}
				}
				else
				{
					$error = '<div class="alert alert-danger">Please first verify your email address</div>';
				}
			}
		}
		else
		{
			$object->query = "
		SELECT * FROM expert_table 
		WHERE expert_email_address = :user_email_address
		";

		$object->execute($data);
			if($object->row_count() > 0)
		{

			$result = $object->statement_result();

			foreach($result as $row)
			{
				if($row["expert_password"] == $_POST["user_password"])
					{
						$_SESSION['user_id'] = $row['expert_id'];
						$_SESSION['user_name'] = $row['expert_name'];
						$_SESSION['user_type']="expert";
					}
					else
					{
						$error = '<div class="alert alert-danger">Wrong Password</div>';
					}
				
				
			}
		}
			else{
			$error = '<div class="alert alert-danger">Wrong Email Address</div>';}
		}

		$output = array(
			'error'		=>	$error
		);

		echo json_encode($output);

	}

	if($_POST['action'] == 'fetch_schedule')
	{
		$output = array();

		$order_column = array('expert_table.expert_name', 'expert_table.doctor_degree', 'doctor_table.doctor_expert_in', 'doctor_schedule_table.doctor_schedule_date', 'doctor_schedule_table.doctor_schedule_day', 'doctor_schedule_table.doctor_schedule_start_time');
		
		$main_query = "
		SELECT * FROM doctor_schedule_table 
		INNER JOIN doctor_table 
		ON doctor_table.doctor_id = doctor_schedule_table.doctor_id 
		";

		$search_query = '
		WHERE doctor_schedule_table.doctor_schedule_date >= "'.date('Y-m-d').'" 
		AND doctor_schedule_table.doctor_schedule_status = "Active" 
		AND doctor_table.doctor_status = "Active" 
		';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'AND ( doctor_table.doctor_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR doctor_table.doctor_degree LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR doctor_table.doctor_expert_in LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR doctor_schedule_table.doctor_schedule_date LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR doctor_schedule_table.doctor_schedule_day LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR doctor_schedule_table.doctor_schedule_start_time LIKE "%'.$_POST["search"]["value"].'%") ';
		}
		
		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY doctor_schedule_table.doctor_schedule_date ASC ';
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

		$object->query = $main_query . $search_query;

		$object->execute();

		$total_rows = $object->row_count();

		$data = array();

		foreach($result as $row)
		{
			$sub_array = array();

			$sub_array[] = $row["doctor_name"];

			$sub_array[] = $row["doctor_degree"];

			$sub_array[] = $row["doctor_expert_in"];

			$sub_array[] = $row["doctor_schedule_date"];

			$sub_array[] = $row["doctor_schedule_day"];

			$sub_array[] = $row["doctor_schedule_start_time"];

			$sub_array[] = '
			<div align="center">
			<button type="button" name="get_appointment" class="btn btn-primary btn-sm get_appointment" data-doctor_id="'.$row["doctor_id"].'" data-doctor_schedule_id="'.$row["doctor_schedule_id"].'">Get Appointment</button>
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

	if($_POST['action'] == 'edit_profile')
	{
		$data = array(
			':user_password'			=>	$_POST["user_password"],
			':user_first_name'		=>	$_POST["user_first_name"],
			':user_last_name'		=>	$_POST["user_last_name"],
			':user_date_of_birth'	=>	$_POST["user_date_of_birth"],
			':user_gender'			=>	$_POST["user_gender"],
			':user_address'			=>	$_POST["user_address"],
			':user_phone_no'			=>	$_POST["user_phone_no"],
			':user_type'	=>	$_POST["user_type"]
		);

		$object->query = "
		UPDATE user_table  
		SET user_password = :user_password, 
		user_first_name = :user_first_name, 
		user_last_name = :user_last_name, 
		user_date_of_birth = :user_date_of_birth, 
		user_gender = :user_gender, 
		user_address = :user_address, 
		user_phone_no = :user_phone_no, 
		user_type = :user_type 
		WHERE user_id = '".$_SESSION['user_id']."'
		";

		$object->execute($data);

		$_SESSION['success_message'] = '<div class="alert alert-success">Profile Data Updated</div>';

		echo 'done';
	}

	if($_POST['action'] == 'make_appointment')
	{
		$object->query = "
		SELECT * FROM user_table 
		WHERE user_id = '".$_SESSION["user_id"]."'
		";

		$user_data = $object->get_result();

		$object->query = "
		SELECT * FROM doctor_schedule_table 
		INNER JOIN expert_table 
		ON expert_table.expert_id = doctor_schedule_table.doctor_id 
		WHERE doctor_schedule_table.doctor_schedule_id = '".$_POST["doctor_schedule_id"]."'
		";

		$doctor_schedule_data = $object->get_result();

		$html = '
		<h4 class="text-center">user Details</h4>
		<table class="table">
		';

		foreach($user_data as $user_row)
		{
			$html .= '
			<tr>
				<th width="40%" class="text-right">user Name</th>
				<td>'.$user_row["user_first_name"].' '.$user_row["user_last_name"].'</td>
			</tr>
			<tr>
				<th width="40%" class="text-right">Contact No.</th>
				<td>'.$user_row["user_phone_no"].'</td>
			</tr>
			<tr>
				<th width="40%" class="text-right">Address</th>
				<td>'.$user_row["user_address"].'</td>
			</tr>
			';
		}

		$html .= '
		</table>
		<hr />
		<h4 class="text-center">Appointment Details</h4>
		<table class="table">
		';
		foreach($doctor_schedule_data as $doctor_schedule_row)
		{
			$html .= '
			<tr>
				<th width="40%" class="text-right">expert Name</th>
				<td>'.$doctor_schedule_row["expert_name"].'</td>
			</tr>
			<tr>
				<th width="40%" class="text-right">Appointment Date</th>
				<td>'.$doctor_schedule_row["doctor_schedule_date"].'</td>
			</tr>
			<tr>
				<th width="40%" class="text-right">Appointment Day</th>
				<td>'.$doctor_schedule_row["doctor_schedule_day"].'</td>
			</tr>
			<tr>
				<th width="40%" class="text-right">Available Time</th>
				<td>'.$doctor_schedule_row["doctor_schedule_start_time"].' - '.$doctor_schedule_row["doctor_schedule_end_time"].'</td>
			</tr>
			';
		}

		$html .= '
		</table>';
		echo $html;
	}

	if($_POST['action'] == 'book_appointment')
	{
		$error = '';
		$data = array(
			':user_id'			=>	$_SESSION['user_id'],
			':doctor_schedule_id'	=>	$_POST['hidden_doctor_schedule_id']
		);

		$object->query = "
		SELECT * FROM appointment_table 
		WHERE user_id = :user_id 
		AND doctor_schedule_id = :doctor_schedule_id
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">You have already applied for appointment for this day, try for other day.</div>';
		}
		else
		{
			$object->query = "
			SELECT * FROM doctor_schedule_table 
			WHERE doctor_schedule_id = '".$_POST['hidden_doctor_schedule_id']."'
			";

			$schedule_data = $object->get_result();

			$object->query = "
			SELECT COUNT(appointment_id) AS total FROM appointment_table 
			WHERE doctor_schedule_id = '".$_POST['hidden_doctor_schedule_id']."' 
			";

			$appointment_data = $object->get_result();

			$total_doctor_available_minute = 0;
			$average_consulting_time = 0;
			$total_appointment = 0;

			foreach($schedule_data as $schedule_row)
			{
				$end_time = strtotime($schedule_row["doctor_schedule_end_time"] . ':00');

				$start_time = strtotime($schedule_row["doctor_schedule_start_time"] . ':00');

				$total_doctor_available_minute = ($end_time - $start_time) / 60;

				$average_consulting_time = $schedule_row["average_consulting_time"];
			}

			foreach($appointment_data as $appointment_row)
			{
				$total_appointment = $appointment_row["total"];
			}

			$total_appointment_minute_use = $total_appointment * $average_consulting_time;

			$appointment_time = date("H:i", strtotime('+'.$total_appointment_minute_use.' minutes', $start_time));

			$status = '';

			$appointment_number = $object->Generate_appointment_no();

			if(strtotime($end_time) > strtotime($appointment_time . ':00'))
			{
				$status = 'Booked';
			}
			else
			{
				$status = 'Waiting';
			}
			
			$data = array(
				':expert_id'				=>	$_POST['hidden_expert_id'],
				':user_id'				=>	$_SESSION['user_id'],
				':doctor_schedule_id'		=>	$_POST['hidden_doctor_schedule_id'],
				':appointment_number'		=>	$appointment_number,
				':reason_for_appointment'	=>	$_POST['reason_for_appointment'],
				':appointment_time'			=>	$appointment_time,
				':status'					=>	'Booked'
			);

			$object->query = "
			INSERT INTO appointment_table 
			(doctor_id, user_id, doctor_schedule_id, appointment_number, reason_for_appointment, appointment_time, status) 
			VALUES (:doctor_id, :user_id, :doctor_schedule_id, :appointment_number, :reason_for_appointment, :appointment_time, :status)
			";

			$object->execute($data);

			$_SESSION['appointment_message'] = '<div class="alert alert-success">Your Appointment has been <b>'.$status.'</b> with Appointment No. <b>'.$appointment_number.'</b></div>';
		}
		echo json_encode(['error' => $error]);
		
	}

	if($_POST['action'] == 'fetch_appointment')
	{
		$output = array();

		$order_column = array('appointment_table.appointment_number','doctor_table.doctor_name', 'doctor_schedule_table.doctor_schedule_date', 'appointment_table.appointment_time', 'doctor_schedule_table.doctor_schedule_day', 'appointment_table.status');
		
		$main_query = "
		SELECT * FROM appointment_table  
		INNER JOIN expert_table 
		ON expert_table.expert_id = appointment_table.doctor_id 
		INNER JOIN doctor_schedule_table 
		ON doctor_schedule_table.doctor_schedule_id = appointment_table.doctor_schedule_id 
		
		";

		$search_query = '
		WHERE appointment_table.user_id = "'.$_SESSION["user_id"].'" 
		';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'AND ( appointment_table.appointment_number LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR expert_table.expert_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR doctor_schedule_table.doctor_schedule_date LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR appointment_table.appointment_time LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR doctor_schedule_table.doctor_schedule_day LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR appointment_table.status LIKE "%'.$_POST["search"]["value"].'%") ';
		}
		
		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY appointment_table.appointment_id ASC ';
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

		$object->query = $main_query . $search_query;

		$object->execute();

		$total_rows = $object->row_count();

		$data = array();

		foreach($result as $row)
		{
			$sub_array = array();

			$sub_array[] = $row["appointment_number"];

			$sub_array[] = $row["expert_name"];

			$sub_array[] = $row["doctor_schedule_date"];			

			$sub_array[] = $row["appointment_time"];

			$sub_array[] = $row["doctor_schedule_day"];

			$status = '';

			if($row["status"] == 'Booked')
			{
				$status = '<span class="badge badge-warning">' . $row["status"] . '</span>';
			}

			if($row["status"] == 'In Process')
			{
				$status = '<span class="badge badge-primary">' . $row["status"] . '</span>';
			}

			if($row["status"] == 'Completed')
			{
				$status = '<span class="badge badge-success">' . $row["status"] . '</span>';
			}

			if($row["status"] == 'Cancel')
			{
				$status = '<span class="badge badge-danger">' . $row["status"] . '</span>';
			}

			$sub_array[] = $status;

			$sub_array[] = '<a href="download.php?id='.$row["appointment_id"].'" class="btn btn-danger btn-sm" target="_blank"><i class="fas fa-file-pdf"></i> PDF</a>';

			$sub_array[] = '<button type="button" name="cancel_appointment" class="btn btn-danger btn-sm cancel_appointment" data-id="'.$row["appointment_id"].'"><i class="fas fa-times"></i></button>';

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

	if($_POST['action'] == 'cancel_appointment')
	{
		$data = array(
			':status'			=>	'Cancel',
			':appointment_id'	=>	$_POST['appointment_id']
		);
		$object->query = "
		UPDATE appointment_table 
		SET status = :status 
		WHERE appointment_id = :appointment_id
		";
		$object->execute($data);
		echo '<div class="alert alert-success">Your Appointment has been Cancel</div>';
	}
}



?>