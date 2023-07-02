<?php 
echo $comid=$_GET["cid"];
include('class/Appointment.php');

$object = new Appointment;
$object->query = "
		SELECT * FROM coment_table where com_id=$comid ";

		$object->execute();

$pid="";
		$result = $object->get_result();
foreach($result as $row)
		{
			echo"<br>";
			$txt= $row["com_comment"];
			$uid= $row["user_id"];
			$da=date('Y-m-d');
			$pid=$row["post_id"];
			$object->query = "
			
		INSERT INTO repcom_table VALUES('','$comid','$txt','$uid','$da','On Hold')";
		
		
		$object->execute();
		
		}
		header("location:postview.php?id=$pid");
?>