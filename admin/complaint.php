<?php

//user.php

include('../class/Appointment.php');

$object = new Appointment;

if(!$object->is_login())
{
    header("location:".$object->base_url."admin");
}



include('header.php');


 $adm=$object->get_total_today_usf();
 $exp=$object->get_total_today_wara();
 $lec=$object->get_total_today_other();

 
$dataPoints = array( 
	array("y" => $adm, "label" => "Unsatisfied Expert’s feedback" ),
	array("y" => $exp, "label" => "Wrongly Assigned Research Area" ),
	array("y" => $lec, "label" => "Other Type" ),
	

);
$pcom=$object->get_total_today_complaints();
$acc=$object->get_total_yesterday_complaints();
$rej=$object->get_total_seven_day_complaints();
$rej=$object->get_total_complaints();
 $dataPoints2 = array( 
	array("label"=>"Today Complaints", "y"=>$pcom),
	array("label"=>"Yesterday Complaints", "y"=>$acc),
	array("label"=>"Last Week Complaints", "y"=>$rej),
	array("label"=>"Last Month Complaints", "y"=>$rej),
	
);
?>
<head>
<script>
window.onload = function() {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: "Complaint Types Status"
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
		text: "Total Complaints"
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
                    <h1 class="h3 mb-4 text-gray-800">Complaints Calculations</h1>

                    <!-- Content Row -->
                    <div class="row row-cols-5">
                        
                        <div class="col mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Today Total Complaints</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_today_complaints(); ?></div>
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
                                                Yesterday Total Complaints</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_yesterday_complaints(); ?></div>
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
                                                Last 7 Days Total Complaints</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_seven_day_complaints(); ?></div>
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
                                                Total Complaints till date</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_complaints(); ?></div>
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
                                                Total Unsatisfied Expert’s Feedback Complaints</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_today_usf(); ?></div>
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
                                                Total Wrongly Assigned Research Area Complaints</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_today_wara(); ?></div>
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
                                                Total Other Type Complaints</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_today_other(); ?></div>
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
                 
                    <h1 class="h3 mb-4 text-gray-800" style="clear:both; padding-top:60px;">Complaint Management</h1>

                    <!-- DataTales Example -->
                    <span id="message"></span>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        	<div class="row">
                            	<div class="col">
                            		<h6 class="m-0 font-weight-bold text-danger">Complaint List</h6>
                            	</div>
                            	<div class="col" align="right">
                            	</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="complaint_table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Complaint Type</th>
                                            <th>Complaint Description</th>
                                            <th>User Name</th>
                                            <th>Complaint Date</th>
                                            <th>Complaint Status</th>
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
				<script>
				function abc(ele){
					hidden_st.value=ele.value;
					
				}
				
				
				</script>
<div id="expertModal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" id="expert_form" action="edit_complaint.php">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Add Complaint</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
        			<span id="form_message"></span>
		          	<div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Complaint Status<span class="text-danger">*</span></label>
                                <select name="complaint_status" id="complaint_status" class="form-control" required  data-parsley-trigger="keyup" onchange="abc(this)">
								<option value="se">--Select--</option>
								<option value="On Hold">On Hold</option>
								<option value="In Investigation">In Investigation</option>
								<option value="Resolved">Resolved</option>
								
								</select>
                            </div>
                            
		          		</div>
		          	</div>
                   
        		<div class="modal-footer">
				<input type="hidden" name="hidden_st" id="hidden_st" />
          			<input type="hidden" name="hidden_id" id="hidden_id" />
          			<input type="hidden" name="action" id="action" value="Add" />
          			<input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" />
          			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>
</div>
<div id="viewModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_title">View Complaint Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="complaint_details">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){

	var dataTable = $('#complaint_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"complaint_action.php",
			type:"POST",
			data:{action:'fetch'}
		},
		"columnDefs":[
			{
				"targets":[],
				"orderable":false,
			},
		],
	});

    $(document).on('click', '.view_button', function(){

        var complaint_id = $(this).data('id');

        $.ajax({

            url:"complaint_action.php",

            method:"POST",

            data:{complaint_id:complaint_id, action:'fetch_single'},

            dataType:'JSON',

            success:function(data)
            {
                var html = '<div class="table-responsive">';
                html += '<table class="table">';

                html += '<tr><th width="40%" class="text-right">Complaint Type</th><td width="60%">'+data.complaint_type+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Complaint Description</th><td width="60%">'+data.complaint_description+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">User Name</th><td width="60%">'+data.user_name+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Complaint Date</th><td width="60%">'+data.complaint_date+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Complaint status</th><td width="60%">'+data.complaint_status+'</td></tr>';
                html += '</table></div>';

                $('#viewModal').modal('show');

                $('#complaint_details').html(html);

            }

        })
    });

	$(document).on('click', '.delete_button', function(){

    	var id = $(this).data('id');

    	if(confirm("Are you sure you want to remove it?"))
    	{

      		$.ajax({

        		url:"complaint_action.php",

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
$(document).on('click', '.edit_button', function(){

		var complaint_id = $(this).data('id');

		$('#expert_form').parsley().reset();

		$('#form_message').html('');

		$.ajax({

	      	url:"complaint_action.php",

	      	method:"POST",

	      	data:{complaint_id:complaint_id, action:'fetch_single'},

	      	dataType:'JSON',

	      	success:function(data)
	      	{        
               	$('#modal_title').text('Edit Complaint');

	        	$('#action').val('Edit');

	        	$('#submit_button').val('Edit');

	        	$('#expertModal').modal('show');

	        	$('#hidden_id').val(complaint_id);

	      	}

	    })

	});


});
</script>