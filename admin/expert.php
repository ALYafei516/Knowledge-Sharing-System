<?php

//expert.php

include('../class/Appointment.php');

$object = new Appointment;

if(!$object->is_login())
{
    header("location:".$object->base_url."admin");
}

if($_SESSION['type'] != 'Admin')
{
    header("location:".$object->base_url."");
}

include('header.php');
 $o=$object->get_total_one();
$t=$object->get_total_two();
$th=$object->get_total_three();
$f=$object->get_total_four();
$fi=$object->get_total_five();
 
$dataPoints = array( 
	array("y" => $o, "label" => "1*" ),
	array("y" => $t, "label" => "2*" ),
	array("y" => $th, "label" => "3*" ),
	array("y" => $f, "label" => "4*" ),
array("y" => $fi, "label" => "5*" ),
);
$pcom=$object->get_total_com();
$acc=$object->get_total_Acc();
$rej=$object->get_total_rev();
 $dataPoints2 = array( 
	array("label"=>"Completed", "y"=>$pcom),
	array("label"=>"Accepted", "y"=>$acc),
	array("label"=>"Revised", "y"=>$rej),
	
);

                ?>
<head>
<script>
window.onload = function() {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: "Rating Report"
	},
	axisY: {
		title: ""
	},
	data: [{
		type: "column",
		yValueFormatString: "#,##0.## ",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 var chart1 = new CanvasJS.Chart("chartContainer2", {
	animationEnabled: true,
	title: {
		text: "Posts Status"
	},
	subtitles: [{
		text: "2023"
	}],
	data: [{
		type: "pie",
		yValueFormatString: "#,##0.00\"%\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
	}]
});
chart1.render();
}
</script>

</head>
 <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Experts Calculations</h1>

                    <!-- Content Row -->
                    <div class="row row-cols-5">
                        
                        <div class="col mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Experts</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_experts(); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
					
                        
                        <div class="col mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Active Experts</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_actex(); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						 <div class="col mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Total Inactive Experts</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_inact(); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="col mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Total Publications</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_pub(); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						
					</div>
					
					<div id="chartContainer" style="height: 370px; width: 47%; float:left;"></div>
						<div id="chartContainer2" style="height: 370px; width: 47%;float:right;"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Expert Management</h1>

                    <!-- DataTales Example -->
                    <span id="message"></span>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        	<div class="row">
                            	<div class="col">
                            		<h6 class="m-0 font-weight-bold text-danger">Expert List</h6>
                            	</div>
                            	<div class="col" align="right">
                            		<button type="button" name="add_expert" id="add_expert" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                            	</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="expert_table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>CV</th>
                                            <th>Expert Address</th>
                                            <th>Password</th>
                                            <th>Expert Name</th>
                                            <th>Expert Phone No.</th>
                                            <th>Expert Research Area</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                <?php
                include('footer.php');
                ?>

<div id="expertModal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" id="expert_form">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Add Expert</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
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
                                <label>Expert Address </label>
                                <input type="text" name="expert_address" id="expert_address" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <label>Expert Date of Birth </label>
                                <input type="text" name="expert_date_of_birth" id="expert_date_of_birth" readonly class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Expert Degree <span class="text-danger">*</span></label>
                                <input type="text" name="expert_degree" id="expert_degree" class="form-control" required data-parsley-trigger="keyup" />
                            </div>
                            <div class="col-md-6">
                                <label>Expert Speciality <span class="text-danger">*</span></label>
                                <input type="text" name="expert_expert_in" id="expert_expert_in" class="form-control" required  data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Expert CV <span class="text-danger">*</span></label>
                        <br />
                        <input type="file" name="expert_profile_image" id="expert_profile_image" />
                        <div id="uploaded_image"></div>
                        <input type="hidden" name="hidden_expert_profile_image" id="hidden_expert_profile_image" />
                    </div>
        		</div>
        		<div class="modal-footer">
          			<input type="hidden" name="hidden_id" id="hidden_id" />
          			<input type="hidden" name="action" id="action" value="Add" />
          			<input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" />
          			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>

<div id="viewModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_title">View Expert Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="expert_details">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){

	var dataTable = $('#expert_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"expert_action.php",
			type:"POST",
			data:{action:'fetch'}
		},
		"columnDefs":[
			{
				"targets":[2],
				"orderable":false,
			},
		],
	});

    $('#expert_date_of_birth').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });

	$('#add_expert').click(function(){
		
		$('#expert_form')[0].reset();

		$('#expert_form').parsley().reset();

    	$('#modal_title').text('Add expert');

    	$('#action').val('Add');

    	$('#submit_button').val('Add');

    	$('#expertModal').modal('show');

    	$('#form_message').html('');

	});

	$('#expert_form').parsley();

	$('#expert_form').on('submit', function(event){
		event.preventDefault();
		if($('#expert_form').parsley().isValid())
		{		
			$.ajax({
				url:"expert_action.php",
				method:"POST",
				data: new FormData(this),
				dataType:'json',
                contentType: false,
                cache: false,
                processData:false,
				beforeSend:function()
				{
					$('#submit_button').attr('disabled', 'disabled');
					$('#submit_button').val('wait...');
				},
				success:function(data)
				{
					$('#submit_button').attr('disabled', false);
					if(data.error != '')
					{
						$('#form_message').html(data.error);
						$('#submit_button').val('Add');
					}
					else
					{
						$('#expertModal').modal('hide');
						$('#message').html(data.success);
						dataTable.ajax.reload();

						setTimeout(function(){

				            $('#message').html('');

				        }, 5000);
					}
				}
			})
		}
	});

	$(document).on('click', '.edit_button', function(){

		var expert_id = $(this).data('id');

		$('#expert_form').parsley().reset();

		$('#form_message').html('');

		$.ajax({

	      	url:"expert_action.php",

	      	method:"POST",

	      	data:{expert_id:expert_id, action:'fetch_single'},

	      	dataType:'JSON',

	      	success:function(data)
	      	{

	        	$('#expert_email_address').val(data.expert_email_address);

                $('#expert_email_address').val(data.expert_email_address);
                $('#expert_password').val(data.expert_password);
                $('#expert_name').val(data.expert_name);
                $('#uploaded_image').html('<a href="'+data.expert_profile_image+'" class="img-fluid img-thumbnail" target="_blank">download</a>')
                $('#hidden_expert_profile_image').val(data.expert_profile_image);
                $('#expert_phone_no').val(data.expert_phone_no);
                $('#expert_address').val(data.expert_address);
                $('#expert_date_of_birth').val(data.expert_date_of_birth);
                $('#expert_degree').val(data.expert_degree);
                $('#expert_expert_in').val(data.expert_expert_in);

	        	$('#modal_title').text('Edit expert');

	        	$('#action').val('Edit');

	        	$('#submit_button').val('Edit');

	        	$('#expertModal').modal('show');

	        	$('#hidden_id').val(expert_id);

	      	}

	    })

	});

	$(document).on('click', '.status_button', function(){
		var id = $(this).data('id');
    	var status = $(this).data('status');
		var next_status = 'Active';
		if(status == 'Active')
		{
			next_status = 'Inactive';
		}
		if(confirm("Are you sure you want to "+next_status+" it?"))
    	{

      		$.ajax({

        		url:"expert_action.php",

        		method:"POST",

        		data:{id:id, action:'change_status', status:status, next_status:next_status},

        		success:function(data)
        		{

          			$('#message').html(data);

          			dataTable.ajax.reload();

          			setTimeout(function(){

            			$('#message').html('');

          			}, 5000);

        		}

      		})

    	}
	});

    $(document).on('click', '.view_button', function(){
        var expert_id = $(this).data('id');

        $.ajax({

            url:"expert_action.php",

            method:"POST",

            data:{expert_id:expert_id, action:'fetch_single'},

            dataType:'JSON',

            success:function(data)
            {
                var html = '<div class="table-responsive">';
                html += '<table class="table">';

                html += '<tr><td colspan="2" class="text-center"><a href="'+data.expert_profile_image+'" class="img-fluid img-thumbnail" target="_blank" >download</a></td></tr>';

                html += '<tr><th width="40%" class="text-right">expert Email Address</th><td width="60%">'+data.expert_email_address+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">expert Password</th><td width="60%">'+data.expert_password+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">expert Name</th><td width="60%">'+data.expert_name+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">expert Phone No.</th><td width="60%">'+data.expert_phone_no+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">expert Address</th><td width="60%">'+data.expert_address+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">expert Date of Birth</th><td width="60%">'+data.expert_date_of_birth+'</td></tr>';
                html += '<tr><th width="40%" class="text-right">expert Qualification</th><td width="60%">'+data.expert_degree+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">expert Speciality</th><td width="60%">'+data.expert_expert_in+'</td></tr>';

                html += '</table></div>';

                $('#viewModal').modal('show');

                $('#expert_details').html(html);

            }

        })
    });

	$(document).on('click', '.delete_button', function(){

    	var id = $(this).data('id');

    	if(confirm("Are you sure you want to remove it?"))
    	{

      		$.ajax({

        		url:"expert_action.php",

        		method:"POST",

        		data:{id:id, action:'delete'},

        		success:function(data)
        		{

          			$('#message').html(data);

          			dataTable.ajax.reload();

          			setTimeout(function(){

            			$('#message').html('');

          			}, 5000);

        		}

      		})

    	}

  	});



});
</script>