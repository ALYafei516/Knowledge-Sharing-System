<?php

//dashboard.php



include('class/Appointment.php');
$id=0;
$object = new Appointment;
if(!isset($_POST['subfb']))
{
	header('location:dashboard.php');
}
else{
	$id=$_POST['pid'];
	$fb=$_POST['fb'];
	//$sa="Completed";
	
	$object->query = "
	UPDATE post_table SET expert_feedback='$fb' WHERE post_id='$id'";
	$object->execute();
	header("location:postview.php?id=$id");
}
?>