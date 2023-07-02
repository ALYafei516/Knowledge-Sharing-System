                <?php

                include('../class/Appointment.php');

				$object = new Appointment;

				if(!$object->is_login())
				{
				    header("location:".$object->base_url."");
				}

              

                include('header.php');

 $inv=$object->get_total_inv();
 $res=$object->get_total_res();
 $hold=$object->get_total_hold();

 
$dataPoints = array( 
	array("y" => $inv, "label" => "In Investigate" ),
	array("y" => $res, "label" => "Resolved" ),
	array("y" => $hold, "label" => "On Hold" ),
	

);
$pcom=$object->get_total_com();
$acc=$object->get_total_Acc();
$rej=$object->get_total_rev();
 $dataPoints2 = array( 
	array("label"=>"In Investigate", "y"=>$inv),
	array("label"=>"Resolved", "y"=>$res),
	array("label"=>"On Hold", "y"=>$hold),
	
);

                ?>
<head>
<script>
window.onload = function() {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: "Reports Status"
	},
	axisY: {
		title: ""
	},
	data: [{
		type: "column",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 var chart1 = new CanvasJS.Chart("chartContainer2", {
	animationEnabled: true,
	title: {
		text: "Reports Status"
	},
	subtitles: [{
		text: "2023"
	}],
	data: [{
		type: "pie",
		yValueFormatString: "#,##0.0\"%\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
	}]
});
chart1.render();
}
</script>

</head>
                  
                     <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Report Calculations</h1>

                    <!-- Content Row -->
                    <div class="row row-cols-5">
                        
                        <div class="col mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Today Total Reports</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_today_reports(); ?></div>
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
                                                Yesterday Total Reports</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_yesterday_reports(); ?></div>
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
                                                Last 7 Days Total Reports</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_seven_day_reports(); ?></div>
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
                                                Total Reports till date</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_reports(); ?></div>
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
                                                Total Resolved Reports</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_today_res(); ?></div>
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
                                                Total In Investigation’ Reports</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_today_inv(); ?></div>
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
                                                Total On Hold Reports</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_today_hold(); ?></div>
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
                                                Total Registered Expert</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_expert(); ?></div>
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
                                                Total Registered User</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_user(); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div style="clear:both"></div>
						 <div class="col mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Total Posts</div>
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
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total valueable  5* rating Posts</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_fs(); ?></div>
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
                                                Total Comments</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_coms(); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						 <div class="col mb-4">
                            <div class="card border-left-success  shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Satisfy User Comments</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_sfc(); ?></div>
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
                                                Total Unsatisfy User Comments</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $object->get_total_usfc(); ?></div>
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
					
                    <h1 class="h3 mb-4 text-gray-800" style="clear:both; padding-top:60px;">Report Management</h1>

                    <!-- DataTales Example -->
                    <span id="message"></span>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        	<div class="row">
                            	<div class="col">
                            		<h6 class="m-0 font-weight-bold text-danger">Report List</h6>
                            	</div>
                            	<div class="col" align="right">
                            		
                            	</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="report_table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Report ID</th>
                                            <th>Reported By</th>
                                            <th>Report Description</th>
                                            <th>Reported On</th>
                                            <th>Status<input type="hidden" name="state" id="state"></th>
                                            <th>Opeation</th>
                                           
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
  function ch(ele) {
    var id = ele.id;
state.value=ele.value;
   
  }
</script>	
               <script>
$(document).ready(function(){

	var dataTable = $('#report_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"report_action.php",
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

	$(document).on('click', '.edit_button', function(){

    	var id = $(this).data('id');
		var state = $('#state').val();
		
    	if(confirm("Are you sure you want to change status it?"))
    	{

      		$.ajax({

        		url:"report_action.php",

        		method:"POST",

        		data:{id:id,state:state, action:'delete'},

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