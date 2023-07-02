<?php

//dashboard.php



include('class/Appointment.php');

$object = new Appointment;

include('header.php');
$user_type=$_SESSION['user_type'];
$user_id=$_SESSION['user_id'];
echo $object->get_total_thrty_day($user_id);
if($user_type=="expert"){
	$user_id=0;
$object->query = "
		SELECT * FROM post_table where expert_id='$user_id' ";	
}
else{
$object->query = "
		SELECT * FROM post_table ";
}
		$object->execute();


		$result = $object->get_result();


?>

<div class="container-fluid">
	<?php
	include('navbar.php');
	?>
	<br />
	<div class="card">
	<img src="images/alert.png" height="200px" width="400px" style="margin-left:300px">
	<h1 style="margin-left:100px"> Account block due to not communicate with user Contact with admin</h1>
	</div>

</div>

<?php

include('footer.php');

?>




<script>

$(document).ready(function(){

	var dataTable = $('#appointment_list_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"action.php",
			type:"POST",
			data:{action:'fetch_schedule'}
		},
		"columnDefs":[
			{
                "targets":[6],				
				"orderable":false,
			},
		],
	});

	$(document).on('click', '.get_appointment', function(){

		var doctor_schedule_id = $(this).data('doctor_schedule_id');
		var doctor_id = $(this).data('doctor_id');

		$.ajax({
			url:"action.php",
			method:"POST",
			data:{action:'make_appointment', doctor_schedule_id:doctor_schedule_id},
			success:function(data)
			{
				$('#appointmentModal').modal('show');
				$('#hidden_doctor_id').val(doctor_id);
				$('#hidden_doctor_schedule_id').val(doctor_schedule_id);
				$('#appointment_detail').html(data);
			}
		});

	});

	$('#appointment_form').parsley();

	$('#appointment_form').on('submit', function(event){

		event.preventDefault();

		if($('#appointment_form').parsley().isValid())
		{

			$.ajax({
				url:"action.php",
				method:"POST",
				data:$(this).serialize(),
				dataType:"json",
				beforeSend:function(){
					$('#submit_button').attr('disabled', 'disabled');
					$('#submit_button').val('wait...');
				},
				success:function(data)
				{
					$('#submit_button').attr('disabled', false);
					$('#submit_button').val('Book');
					if(data.error != '')
					{
						$('#form_message').html(data.error);
					}
					else
					{	
						window.location.href="appointment.php";
					}
				}
			})

		}

	})

});

</script>