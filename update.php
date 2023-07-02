<?php

//dashboard.php


include('class/Appointment.php');
$id=0;
$object = new Appointment;
echo $_GET['id'];
if(!isset($_GET['id']))
{
	header('location:dashboard.php');
}
else{
	 $id=$_GET['id'];
	
	$sa="Revised";
	
	$object->query = "
	UPDATE post_table SET post_status='$sa' WHERE post_id='$id'";
	$object->execute();
	header("location:postview.php?id=$id");
}
?>