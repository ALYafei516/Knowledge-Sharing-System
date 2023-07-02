<?php

//index.php

include('class/Appointment.php');

$object = new Appointment;

if(isset($_SESSION['user_id']))
{
	header('location:dashboard.php');
}
$d=date('Y-m-d');
//echo $d;
$object->query = "
		SELECT * FROM post_table ";

		$object->execute();


		$result = $object->get_result();

		
include('header.php');

?>

		      	<div class="card">
		      		<form method="post" action="result.php">
			      		<div class="card-header text-danger"><h3><b>Post List</b></h3></div>
			      		<div class="card">
		<div class="card-header"><h4>Post </h4></div>
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
    </div>
		<?php }?>
			    </div>
			</div>
		</div>
	</div>
		      			</div>
		      		</form>
		      	</div>
		    

<?php

include('footer.php');

?>

<script>

$(document).ready(function(){
	$(document).on('click', '.get_appointment', function(){
		var action = 'check_login';
		var expert_schedule_id = $(this).data('id');
		$.ajax({
			url:"action.php",
			method:"POST",
			data:{action:action, expert_schedule_id:expert_schedule_id},
			success:function(data)
			{
				window.location.href=data;
			}
		})
	});
});

</script>