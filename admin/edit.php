<?php

include('../class/Appointment.php');

$object = new Appointment;


	
	if(isset($_POST["submit"]))
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
				UPDATE user_table  
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

				$object->execute();

				header("location:user.php");

		

}
else {
	echo "dhdkjdhk";
	
}

?>