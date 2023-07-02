<?php

//dashboard.php



include('class/Appointment.php');

$object = new Appointment;

include('header.php');
$user_type=$_SESSION['user_type'];
$user_id=$_SESSION['user_id'];
if($object->check_inactive($user_id)>0){
	header('location:alert.php');
}
$a=$object->get_total_thrty_day($user_id);
if($a>0){
	$st="On Hold";

	$object->query = "
		update post_table SET expert_id='0',post_status = '$st'
		WHERE expert_id='$user_id' AND expert_feedback='' AND accept_date <= DATE(NOW()) - INTERVAL 30 DAY
		";
		$object->execute();
		$object->query = "
		update expert_table SET expert_status='Inactive' 
		WHERE expert_id='$user_id'
		";
		$object->execute();
		header('location:alert.php');
}
if($user_type=="expert"){
	$user_id=0;
$object->query = "
		SELECT * FROM post_table where expert_id='$user_id' ORDER BY post_id DESC";	
}
else{
$object->query = "
		SELECT * FROM post_table ORDER BY post_id DESC ";
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
		<div class="card-header"><h4>Post List <?php echo $_SESSION['user_type'];?></h4></div>
			<div class="card-body">
				<div class="table-responsive">
		      		<?php foreach($result as $row)
		{?>
			
			
			
			
			
			
		
 <div class="card" style="margin-bottom: 20px;">
      <h3 class="card-header text-danger"><?php echo $row["post_title"]; ?></h3>
      <p style="background: firebrick;
    color: white;
    padding-left: 16px;"><?php echo $row["user_name"]; ?>, Date : <?php echo $row["post_date"]; ?></p>
   
      <p style=" padding-left: 16px;"><?php echo $row["post_description"]; ?></p>
	  <a href="postview.php?id=<?php echo $row["post_id"]; ?>" style="display:block"><button style="
    background: brown;
    margin: 10px 60px;
    width: 165px;
    color: wheat;
    border-color: white;
">View Details </button></a>
<?php if($user_type=="expert"){?>
 <a href="acceptpost.php?id=<?php echo $row["post_id"]; ?>" style="display:block"><button style="
    background: brown;
    margin: 10px 60px;
    width: 165px;
    color: wheat;
    border-color: white;
">Accept Post</button></a> <?php }?>
 <?php if($row["post_status"] == 'Completed')
			{?>
				<span class="badge badge-success">Completed</span>
				<?php
			}
		 if($row["post_status"] == 'Accepted')
			{?>
				<span class="badge badge-warning">Accepted</span>
			<?php }
			 if($row["post_status"] == 'Revised')
			{?>
				<span class="badge badge-danger">Revised</span>
<?php			}?>
    
		
		
		   

   </div>
		<?php }?>
		
			    </div>
			</div>
		</div>
	</div>

</div>

<?php

include('footer.php');

?>

<div id="appointmentModal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" id="appointment_form">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Make Appointment</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
        			<span id="form_message"></span>
                    <div id="appointment_detail"></div>
                    <div class="form-group">
                    	<label><b>Reasone for Appointment</b></label>
                    	<textarea name="reason_for_appointment" id="reason_for_appointment" class="form-control" required rows="5"></textarea>
                    </div>
        		</div>
        		<div class="modal-footer">
          			<input type="hidden" name="hidden_doctor_id" id="hidden_doctor_id" />
          			<input type="hidden" name="hidden_doctor_schedule_id" id="hidden_doctor_schedule_id" />
          			<input type="hidden" name="action" id="action" value="book_appointment" />
          			<input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Book" />
          			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>


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