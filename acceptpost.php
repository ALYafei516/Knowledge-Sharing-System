<?php

//dashboard.php



include('class/Appointment.php');
$id=0;
$object = new Appointment;
if(!isset($_GET['id']))
{
	header('location:dashboard.php');
}
else{
	$id=$_GET['id'];
	$uid=$_SESSION['user_id'];
	$sa="Accepted";
	$da=date('Y-m-d');
	$object->query = "
	UPDATE post_table SET post_status='$sa',expert_id ='$uid',accept_date='$da' WHERE post_id='$id'";
	$object->execute();
	header("location:postview.php?id=$id");
}
?>