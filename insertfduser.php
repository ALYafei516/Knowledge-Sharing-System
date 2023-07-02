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
	$ufb=$_POST['ufb'];
	$rat=$_POST['rate'];
	//$sa="Completed";
	
	$object->query = "
	UPDATE post_table SET user_feedback='$ufb', rating='$rat' WHERE post_id='$id'";
	$object->execute();
	header("location:postview.php?id=$id");
}
?>