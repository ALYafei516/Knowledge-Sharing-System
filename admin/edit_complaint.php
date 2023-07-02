<?php

include('../class/Appointment.php');

$object = new Appointment;


	
	if(isset($_POST["submit"]))
	{
		$error = 'eeeeee';

		$success = 'sssss';


				$object->query = "
				UPDATE complaint_table  
				SET complaint_status = '".$_POST["hidden_st"]."'
				WHERE complaint_id = '".$_POST['hidden_id']."'
				";

				$object->execute();

				$success = '<div class="alert alert-success">Complaint Data Updated</div>';
						
		


	header("location:complaint.php");

		

}
else {
	echo "dhdkjdhk";
	
}

?>