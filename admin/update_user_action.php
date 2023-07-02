<?php

include('../class/Appointment.php');

$object = new Appointment;

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'fetch_single')
	{
		$object->query = "
		SELECT * FROM user_table 
		WHERE user_id = '".$_POST["user_id"]."'
		";

		$result = $object->get_result();

		$data = array();

		foreach($result as $row)
		{
			$data['user_email_address'] = $row['user_email_address'];
			$data['user_password'] = $row['user_password'];
			$data['user_first_name'] = $row['user_first_name'];
			$data['user_last_name'] = $row['user_last_name'];
			$data['user_date_of_birth'] = $row['user_date_of_birth'];
			$data['user_gender'] = $row['user_gender'];
			$data['user_address'] = $row['user_address'];
			$data['user_phone_no'] = $row['user_phone_no'];
			$data['user_type'] = $row['user_type'];
			if($row['email_verify'] == 'Yes')
			{
				$data['email_verify'] = '<span class="badge badge-success">Yes</span>';
			}
			else
			{
				$data['email_verify'] = '<span class="badge badge-danger">No</span>';
			}
		}

		echo json_encode($data);
	}
	if($_POST["action"] == 'Edit')
	{
		$error = 'eeeeee';

		$success = 'sssss';

		
				
					$user_email_address =$_POST["user_email_address"];
					$user_password	=$_POST["user_password"];
					$user_name=$_POST["user_name"];
					$user_phone_no				=$_POST["user_phone_no"];
					$user_address				    =$_POST["user_address"];
					$user_date_of_birth			=$_POST["user_date_of_birth"];
					$user_gender=$_POST["user_gender"];
					$user_type=$_POST["user_type"];
				$id=$_POST['hidden_id'];

				$object->query = "
				UPDATE user_tabl  
				SET user_email_address = '$user_email_address', 
				user_password = '$user_password', 
				user_first_name = '$user_name', 
				user_phone_no = '$user_phone_no', 
				user_address = '$user_address', 
				user_date_of_birth = '$user_date_of_birth', 
				user_gender = '$user_gender',  
				user_type = '$user_type'
				WHERE user_id = '$id'	
				";

				$object->execute($data);

				$success = '<script>alert("testuidhi");</script><div style="clear:both" class="alert alert-success">User Data Updated</div>';
						
		

		

		echo json_encode($success);

}
}
?>