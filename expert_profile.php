<?php

include('class/Appointment.php');

$object = new Appointment;

$user_type=$_SESSION['user_type'];
$user_id=$_SESSION['user_id'];


if($user_type=="expert"){
	if($object->check_inactive($user_id)>0){
	header('location:alert.php');
}
}
$object->query = "
    SELECT * FROM expert_table
    WHERE expert_id = '".$_SESSION["user_id"]."'
    ";

$result = $object->get_result();

include('header.php');
include('navbar.php');

?>

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Profile</h1>

                    <!-- DataTales Example -->
                    
                    <form method="post" id="profile_form" enctype="multipart/form-data">
                        <div class="row"><div class="col-md-10"><span id="message"></span><div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <div class="row">
                                    <div class="col">
                                        <h6 class="m-0 font-weight-bold text-danger">Profile</h6>
                                    </div>
                                    <div clas="col" align="right">
                                        <input type="hidden" name="action" value="expert_profile" />
                                        <input type="hidden" name="hidden_id" id="hidden_id" />
                                        <button type="submit" name="edit_button" id="edit_button" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</button>
                                        &nbsp;&nbsp;
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <!--<div class="row">
                                    <div class="col-md-6">!-->
                                        <span id="form_message"></span>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Expert Email Address <span class="text-danger">*</span></label>
                                                    <input type="text" name="expert_email_address" id="expert_email_address" class="form-control" required data-parsley-type="email" data-parsley-trigger="keyup" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Expert Password <span class="text-danger">*</span></label>
                                                    <input type="password" name="expert_password" id="expert_password" class="form-control" required  data-parsley-trigger="keyup" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Expert Name <span class="text-danger">*</span></label>
                                                    <input type="text" name="expert_name" id="expert_name" class="form-control" required data-parsley-trigger="keyup" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Expert Phone No. <span class="text-danger">*</span></label>
                                                    <input type="text" name="expert_phone_no" id="expert_phone_no" class="form-control" required  data-parsley-trigger="keyup" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>expert Address </label>
                                                    <input type="text" name="expert_address" id="expert_address" class="form-control" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label>expert Date of Birth </label>
                                                    <input type="text" name="expert_date_of_birth" id="expert_date_of_birth" readonly class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>expert Degree <span class="text-danger">*</span></label>
                                                    <input type="text" name="expert_degree" id="expert_degree" class="form-control" required data-parsley-trigger="keyup" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label>expert Speciality <span class="text-danger">*</span></label>
                                                    <input type="text" name="expert_expert_in" id="expert_expert_in" class="form-control" required  data-parsley-trigger="keyup" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>expert CV<span class="text-danger">*</span></label>
                                            <br />
                                            <input type="file" name="expert_profile_image" id="expert_profile_image" />
                                            <div id="uploaded_image"></div>
                                            <input type="hidden" name="hidden_expert_profile_image" id="hidden_expert_profile_image" />
                                        </div>
                                    <!--</div>
                                </div>!-->
                            </div>
                        </div></div></div>
                    </form>
                <?php
                include('footer.php');
                ?>

<script>
$(document).ready(function(){

    $('#expert_date_of_birth').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });

    <?php
    foreach($result as $row)
    {
    ?>
    $('#hidden_id').val("<?php echo $row['expert_id']; ?>");
    $('#expert_email_address').val("<?php echo $row['expert_email_address']; ?>");
    $('#expert_password').val("<?php echo $row['expert_password']; ?>");
    $('#expert_name').val("<?php echo $row['expert_name']; ?>");
    $('#expert_phone_no').val("<?php echo $row['expert_phone_no']; ?>");
    $('#expert_address').val("<?php echo $row['expert_address']; ?>");
    $('#expert_date_of_birth').val("<?php echo $row['expert_date_of_birth']; ?>");
    $('#expert_degree').val("<?php echo $row['expert_degree']; ?>");
    $('#expert_expert_in').val("<?php echo $row['expert_expert_in']; ?>");
    
    $('#uploaded_image').html('<a href="<?php echo $row["expert_profile_image"]; ?>" class="img-thumbnail" target="_blank">download</a><input type="hidden" name="hidden_expert_profile_image" value="<?php echo $row["expert_profile_image"]; ?>" />');

    $('#hidden_expert_profile_image').val("<?php echo $row['expert_profile_image']; ?>");
    <?php
    }
    ?>

    $('#expert_profile_image').change(function(){
        var extension = $('#expert_profile_image').val().split('.').pop().toLowerCase();
        if(extension != '')
        {
            if(jQuery.inArray(extension, ['docx','pdf']) == -1)
            {
                alert("Invalid Image File");
                $('#expert_profile_image').val('');
                return false;
            }
        }
    });

    $('#profile_form').parsley();

	$('#profile_form').on('submit', function(event){
		event.preventDefault();
		if($('#profile_form').parsley().isValid())
		{		
			$.ajax({
				url:"profile_action.php",
				method:"POST",
				data:new FormData(this),
                dataType:'json',
                contentType:false,
                processData:false,
				beforeSend:function()
				{
					$('#edit_button').attr('disabled', 'disabled');
					$('#edit_button').html('wait...');
				},
				success:function(data)
				{
					$('#edit_button').attr('disabled', false);
                    $('#edit_button').html('<i class="fas fa-edit"></i> Edit');

                    $('#expert_email_address').val(data.expert_email_address);
                    $('#expert_password').val(data.expert_password);
                    $('#expert_name').val(data.expert_name);
                    $('#expert_phone_no').val(data.expert_phone_no);
                    $('#expert_address').text(data.expert_address);
                    $('#expert_date_of_birth').text(data.expert_date_of_birth);
                    $('#expert_degree').text(data.expert_degree);
                    $('#expert_expert_in').text(data.expert_expert_in);
                    if(data.expert_profile_image != '')
                    {
                        $('#uploaded_image').html('<a href="'+data.expert_profile_image+'" class="img-thumbnail" target="_blank">download</a>');

                        $('#user_profile_image').attr('src', data.expert_profile_image);
                    }

                    $('#hidden_expert_profile_image').val(data.expert_profile_image);
						
                    $('#message').html(data.success);

					setTimeout(function(){

				        $('#message').html('');

				    }, 5000);
				}
			})
		}
	});

});
</script>