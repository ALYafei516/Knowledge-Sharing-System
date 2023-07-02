<?php

//expert.php

include('class/Appointment.php');

$object = new Appointment;




include('header.php');

?>
<div class="container-fluid">
	<?php
	include('navbar.php');
	?>
                    <!-- Page Heading -->
                    

                    <!-- DataTales Example -->
                    <span id="message"></span>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        	<div class="row">
                            	<div class="col">
                            		<h6 class="m-0 font-weight-bold text-danger">Complaint List</h6>
                            	</div>
                            	<div class="col" align="right">
                            		<button type="button" name="add_complaint" id="add_complaint" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                            	</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="complaint_table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
										<th>Sr. No</th>
                                            <th>Complaint type</th>
                                            <th>Complaint Description</th>
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

<div id="expertModal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" id="expert_form">
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
                                <label>Complaint Type<span class="text-danger">*</span></label>
                                <select name="complaint_type" id="complaint_type" class="form-control" required  data-parsley-trigger="keyup">
								<option value="Unsatisfied Expert’s Feedback">Unsatisfied Expert’s Feedback</option>
								<option value="Wrongly Assigned Research Area">Wrongly Assigned Research Area</option>
								<option value="Other Type">Other Type</option>
								
								</select>
                            </div>
                            <div class="col-md-6">
                                <label>Complaint Description <span class="text-danger">*</span></label>
                                <input type="text" name="complaint_description" id="complaint_description" class="form-control" required  data-parsley-trigger="keyup" />
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

    $('#expert_date_of_birth').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });

	$('#add_complaint').click(function(){
		
		$('#expert_form')[0].reset();

		$('#expert_form').parsley().reset();

    	$('#modal_title').text('Add Complaint');

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
				url:"complaint_action.php",
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

	        	

                $('#complaint_type').val(data.complaint_type);
                $('#complaint_description').val(data.complaint_description);
                
              

	        	$('#modal_title').text('Edit Complaint');

	        	$('#action').val('Edit');

	        	$('#submit_button').val('Edit');

	        	$('#expertModal').modal('show');

	        	$('#hidden_id').val(complaint_id);

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

        		url:"complaint_action.php",

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

                html += '<tr><th width="40%" class="text-right"> Complaint Date</th><td width="60%">'+data.complaint_date+'</td></tr>';

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



});
</script>