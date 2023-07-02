<?php

//user.php

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
 $adm=$object->get_total_admin();
 $exp=$object->get_total_expert();
 $lec=$object->get_total_Lec();
 $st=$object->get_total_stud();
 
$dataPoints = array( 
	array("y" => $adm, "label" => "Admins" ),
	array("y" => $exp, "label" => "Experts" ),
	array("y" => $lec, "label" => "Lecturers" ),
	array("y" => $st, "label" => "Students" ),

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
		text: "Total Number of Users"
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
                    <h1 class="h3 mb-4 text-gray-800">User Post Calculations</h1>

                    <!-- Content Row -->
                    <div class="row row-cols-5">
                        
                        <div class="col mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Today Total Posts</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_today_posts(); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col mb-4">
                            <div class="card border-left-secondary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                                Yesterday Total Posts</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_yesterday_posts(); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Last 7 Days Total Posts</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_seven_day_posts(); ?></div>
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
                                                Total Posts till date</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_posts(); ?></div>
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
                                                Total Accepted Posts</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_today_accep(); ?></div>
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
                                                Total Revised Posts</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_today_rev(); ?></div>
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
                                                Total Completed Posts</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_today_compl(); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<div id="chartContainer" style="height: 370px; width: 45%; float:left;"></div>
						<div id="chartContainer2" style="height: 370px; width: 45%;float:right;"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800" style="clear:both">User Management</h1>

                    <!-- DataTales Example -->
                    <span id="message"></span>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        	<div class="row">
                            	<div class="col">
                            		<h6 class="m-0 font-weight-bold text-danger">User List</h6>
                            	</div>
                            	<div class="col" align="right">
                            	</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="user_table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email Address</th>
                                            <th>Contact No.</th>
                                            <th>User Gender</th>
											<th>User Type</th>
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
<div id="userModal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" id="user_form" action="edit.php">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Add user</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
        			<span id="form_message"></span>
		          	<div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>User Email Address <span class="text-danger">*</span></label>
                                <input type="text" name="user_email_address" id="user_email_address" class="form-control" required data-parsley-type="email" data-parsley-trigger="keyup" />
                            </div>
                            <div class="col-md-6">
                                <label>User Password <span class="text-danger">*</span></label>
                                <input type="password" name="user_password" id="user_password" class="form-control" required  data-parsley-trigger="keyup" />
                            </div>
		          		</div>
		          	</div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>User Name <span class="text-danger">*</span></label>
                                <input type="text" name="user_name" id="user_name" class="form-control" required data-parsley-trigger="keyup" />
                            </div>
                            <div class="col-md-6">
                                <label>User Phone No. <span class="text-danger">*</span></label>
                                <input type="text" name="user_phone_no" id="user_phone_no" class="form-control" required  data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>User Address </label>
                                <input type="text" name="user_address" id="user_address" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <label>User Date of Birth </label>
                                <input type="text" name="user_date_of_birth" id="user_date_of_birth" readonly class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>User Gender <span class="text-danger">*</span></label>
                                <input type="text" name="user_gender" id="user_gender" class="form-control" required data-parsley-trigger="keyup" />
                            </div>
                            <div class="col-md-6">
                                <label>User Type <span class="text-danger">*</span></label>
                                <input type="text" name="user_type" id="user_type" class="form-control" required  data-parsley-trigger="keyup" />
                            </div>
                        </div>
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
                <h4 class="modal-title" id="modal_title">View User Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="user_details">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){

	var dataTable = $('#user_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"user_action.php",
			type:"POST",
			data:{action:'fetch'}
		},
		"columnDefs":[
			{
				"targets":[5],
				"orderable":false,
			},
		],
	});

    $(document).on('click', '.view_button', function(){

        var user_id = $(this).data('id');

        $.ajax({

            url:"user_action.php",

            method:"POST",

            data:{user_id:user_id, action:'fetch_single'},

            dataType:'JSON',

            success:function(data)
            {
                var html = '<div class="table-responsive">';
                html += '<table class="table">';

                html += '<tr><th width="40%" class="text-right">Email Address</th><td width="60%">'+data.user_email_address+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Password</th><td width="60%">'+data.user_password+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">user Name</th><td width="60%">'+data.user_first_name+' '+data.user_last_name+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Contact No.</th><td width="60%">'+data.user_phone_no+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Address</th><td width="60%">'+data.user_address+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Date of Birth</th><td width="60%">'+data.user_date_of_birth+'</td></tr>';
                html += '<tr><th width="40%" class="text-right">Gender</th><td width="60%">'+data.user_gender+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">User Type</th><td width="60%">'+data.user_type+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Email Verification Status</th><td width="60%">'+data.email_verify+'</td></tr>';

                html += '</table></div>';

                $('#viewModal').modal('show');

                $('#user_details').html(html);

            }

        })
    });
$(document).on('click', '.edit_button', function(){

		var user_id = $(this).data('id');

		$('#user_form').parsley().reset();

		$('#form_message').html('');

		$.ajax({

	      	url:"update_user_action.php",

	      	method:"POST",

	      	data:{user_id:user_id, action:'fetch_single'},

	      	dataType:'JSON',

	      	success:function(data)
	      	{

	        	

                $('#user_email_address').val(data.user_email_address);
                $('#user_password').val(data.user_password);
                $('#user_name').val(data.user_first_name);
               
                $('#user_phone_no').val(data.user_phone_no);
                $('#user_address').val(data.user_address);
                $('#user_date_of_birth').val(data.user_date_of_birth);
                $('#user_gender').val(data.user_gender);
                $('#user_type').val(data.user_type);

	        	$('#modal_title').text('Edit user');

	        	$('#action').val('Edit');

	        	$('#submit_button').val('Edit');

	        	$('#userModal').modal('show');

	        	$('#hidden_id').val(user_id);

	      	}

	    })

	});
	$(document).on('click', '.delete_button', function(){

    	var id = $(this).data('id');

    	if(confirm("Are you sure you want to remove it?"))
    	{

      		$.ajax({

        		url:"user_action.php",

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