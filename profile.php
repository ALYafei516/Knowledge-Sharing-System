<?php

//profile.php



include('class/Appointment.php');

$object = new Appointment;

$object->query = "
SELECT * FROM user_table 
WHERE user_id = '".$_SESSION["user_id"]."'
";

$result = $object->get_result();

include('header.php');

?>

<div class="container-fluid">
	<?php include('navbar.php'); ?>

	<div class="row justify-content-md-center">
		<div class="col col-md-6">
			<br />
			<?php
			if(isset($_GET['action']) && $_GET['action'] == 'edit')
			{
			?>
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-md-6">
							Edit Profile Details
						</div>
						<div class="col-md-6 text-right">
							<a href="profile.php" class="btn btn-secondary btn-sm">View</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="post" id="edit_profile_form">
						<div class="form-group">
							<label>User Email Address<span class="text-danger">*</span></label>
							<input type="text" name="user_email_address" id="user_email_address" class="form-control" required autofocus data-parsley-type="email" data-parsley-trigger="keyup" readonly />
						</div>
						<div class="form-group">
							<label>User Password<span class="text-danger">*</span></label>
							<input type="password" name="user_password" id="user_password" class="form-control" required  data-parsley-trigger="keyup" />
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>User First Name<span class="text-danger">*</span></label>
									<input type="text" name="user_first_name" id="user_first_name" class="form-control" required  data-parsley-trigger="keyup" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>User Last Name<span class="text-danger">*</span></label>
									<input type="text" name="user_last_name" id="user_last_name" class="form-control" required  data-parsley-trigger="keyup" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>User Date of Birth<span class="text-danger">*</span></label>
									<input type="text" name="user_date_of_birth" id="user_date_of_birth" class="form-control" required  data-parsley-trigger="keyup" readonly />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>User Gender<span class="text-danger">*</span></label>
									<select name="user_gender" id="user_gender" class="form-control">
										<option value="Male">Male</option>
										<option value="Female">Female</option>
										<option value="Other">Other</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>User Contact No.<span class="text-danger">*</span></label>
									<input type="text" name="user_phone_no" id="user_phone_no" class="form-control" required  data-parsley-trigger="keyup" />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>User Maritial Status<span class="text-danger">*</span></label>
									<select name="user_type" id="user_type" class="form-control">
										<option value="Student">Student</option>
										<option value="Lecturer">Lecturer</option>
										
									</select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>User Complete Address<span class="text-danger">*</span></label>
							<textarea name="user_address" id="user_address" class="form-control" required data-parsley-trigger="keyup"></textarea>
						</div>
						<div class="form-group text-center">
							<input type="hidden" name="action" value="edit_profile" />
							<input type="submit" name="edit_profile_button" id="edit_profile_button" class="btn btn-primary" value="Edit" />
						</div>
					</form>
				</div>
			</div>

			<br />
			<br />
			

			<?php
			}
			else
			{

				if(isset($_SESSION['success_message']))
				{
					echo $_SESSION['success_message'];
					unset($_SESSION['success_message']);
				}
			?>

			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-md-6">
							Profile Details
						</div>
						<div class="col-md-6 text-right">
							<a href="profile.php?action=edit" class="btn btn-secondary btn-sm">Edit</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					<table class="table table-striped">
						<?php
						foreach($result as $row)
						{
						?>
						<tr>
							<th class="text-right" width="40%">User Name</th>
							<td><?php echo $row["user_first_name"] . ' ' . $row["user_last_name"]; ?></td>
						</tr>
						<tr>
							<th class="text-right" width="40%">Email Address</th>
							<td><?php echo $row["user_email_address"]; ?></td>
						</tr>
						<tr>
							<th class="text-right" width="40%">Password</th>
							<td><?php echo $row["user_password"]; ?></td>
						</tr>
						<tr>
							<th class="text-right" width="40%">Address</th>
							<td><?php echo $row["user_address"]; ?></td>
						</tr>
						<tr>
							<th class="text-right" width="40%">Contact No.</th>
							<td><?php echo $row["user_phone_no"]; ?></td>
						</tr>
						<tr>
							<th class="text-right" width="40%">Date of Birth</th>
							<td><?php echo $row["user_date_of_birth"]; ?></td>
						</tr>
						<tr>
							<th class="text-right" width="40%">Gender</th>
							<td><?php echo $row["user_gender"]; ?></td>
						</tr>
						
						<tr>
							<th class="text-right" width="40%">User Type</th>
							<td><?php echo $row["user_type"]; ?></td>
						</tr>
						<?php
						}
						?>	
					</table>					
				</div>
			</div>
			<br />
			<br />
			<?php
			}
			?>
		</div>
	</div>
</div>

<?php

include('footer.php');


?>

<script>

$(document).ready(function(){

	$('#user_date_of_birth').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });

<?php
	foreach($result as $row)
	{

?>
$('#user_email_address').val("<?php echo $row['user_email_address']; ?>");
$('#user_password').val("<?php echo $row['user_password']; ?>");
$('#user_first_name').val("<?php echo $row['user_first_name']; ?>");
$('#user_last_name').val("<?php echo $row['user_last_name']; ?>");
$('#user_date_of_birth').val("<?php echo $row['user_date_of_birth']; ?>");
$('#user_gender').val("<?php echo $row['user_gender']; ?>");
$('#user_phone_no').val("<?php echo $row['user_phone_no']; ?>");
$('#user_type').val("<?php echo $row['user_type']; ?>");
$('#user_address').val("<?php echo $row['user_address']; ?>");

<?php

	}

?>

	$('#edit_profile_form').parsley();

	$('#edit_profile_form').on('submit', function(event){

		event.preventDefault();

		if($('#edit_profile_form').parsley().isValid())
		{
			$.ajax({
				url:"action.php",
				method:"POST",
				data:$(this).serialize(),
				beforeSend:function()
				{
					$('#edit_profile_button').attr('disabled', 'disabled');
					$('#edit_profile_button').val('wait...');
				},
				success:function(data)
				{
					window.location.href = "profile.php";
				}
			})
		}

	});

});

</script>