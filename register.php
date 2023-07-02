<?php

//login.php

include('header.php');

?>

<div class="container">
	<div class="row justify-content-md-center">
		<div class="col col-md-6">
			<span id="message"></span>
			<div class="card">
				<div class="card-header">Register</div>
				<div class="card-body">
					<form method="post" id="user_register_form">
						<div class="form-group">
							<label>User Email Address<span class="text-danger">*</span></label>
							<input type="text" name="user_email_address" id="user_email_address" class="form-control" required autofocus data-parsley-type="email" data-parsley-trigger="keyup" />
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
									<label>User Type<span class="text-danger">*</span></label>
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
							<input type="hidden" name="action" value="user_register" />
							<input type="submit" name="user_register_button" id="user_register_button" class="btn btn-primary" value="Register" />
						</div>

						<div class="form-group text-center">
							<p><a href="login.php">Login</a></p>
						</div>
					</form>
				</div>
			</div>
			<br />
			<br />
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

	$('#user_register_form').parsley();

	$('#user_register_form').on('submit', function(event){

		event.preventDefault();

		if($('#user_register_form').parsley().isValid())
		{
			$.ajax({
				url:"action.php",
				method:"POST",
				data:$(this).serialize(),
				dataType:'json',
				beforeSend:function(){
					$('#user_register_button').attr('disabled', 'disabled');
				},
				success:function(data)
				{
					$('#user_register_button').attr('disabled', false);
					$('#user_register_form')[0].reset();
					if(data.error !== '')
					{
						$('#message').html(data.error);
					}
					if(data.success != '')
					{
						$('#message').html(data.success);
					}
				}
			});
		}

	});

});

</script>