<?php

//dashboard.php



include('class/Appointment.php');

$object = new Appointment;

include('header.php');
$a=0;
$msg="";
if(isset($_POST["submit"])){
			$comid=0;
			$txt= $_POST["description"];
			$uid= $_SESSION["user_id"];
			$da=date('Y-m-d');
			$pid=0;
			$object->query = "
			
		INSERT INTO repcom_table VALUES('','$comid','$txt','$uid','$da','On Hold')";
		
		
		$object->execute();
		$msg="Report Submited";
		$a=1;
		}



?>

<div class="container-fluid">
	<?php
	include('navbar.php');
	?>
	<br />
	<div class="card">
		<div class="card-header"><h4>Add Post</h4></div>
			<div class="card-body">
				<div class="table-responsive">
		      	<form name="fa" method="POST" action="">
				<?php if($a==1){?><h6 style="color: yellow;
    background: green;
    height: 35px;
    text-align: center;
    padding: 4px;
				border: solid;"><?php echo $msg;?></h6><?php }?><br>
				<label><b>Post Description   </b></label>
				<input type="text" name="title" placeholder=" write title of post" required style="
    height: 200px;
    width: 100%;
    border-color: skyblue;
    border: solid 2px skyblue;
"><br>
				<label><b>Post Description</b></label><br>
				<input type="text" name="description" placeholder=" write description of post in detail" required style="
    height: 150px;
    width: 100%;
    border-color: skyblue;
    border: solid 2px skyblue;
"><br><br>
				<input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Report" />
          			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					
			    </div>
			</div>
		</div>
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