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
	$des=$_POST['des'];
	
	$sa="Accepted";
	
	$object->query = "
	UPDATE post_table SET post_status='$sa', post_description='$des' WHERE post_id='$id'";
	$object->execute();
	header("location:postview.php?id=$id");
}
?>