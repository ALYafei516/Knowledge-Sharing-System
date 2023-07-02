<?php

//publication.php

include('class/Appointment.php');

$object = new Appointment;



include('header.php');

?>
<div class="container-fluid">
	<?php
	include('navbar.php');
	?>
                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Publication Management</h1>

                    <!-- DataTales Example -->
                    <span id="message"></span>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        	<div class="row">
                            	<div class="col">
                            		<h6 class="m-0 font-weight-bold text-danger">Publication List</h6>
                            	</div>
                            	<div class="col" align="right">
                            		<button type="button" name="add_publication" id="add_publication" class="btn btn-success btn-circle btn-sm"><i class="fas fa-plus"></i></button>
                            	</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="publication_table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Publication Title</th>
                                            <th>Publication Description</th>
                                            <th>Publication Date</th>
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

<div id="publicationModal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" id="publication_form">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Add publication</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
        			<span id="form_message"></span>
		          	<div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>publication title <span class="text-danger">*</span></label>
                                <input type="text" name="publication_title" id="publication_title" class="form-control" required  data-parsley-trigger="keyup" />
                            </div>
                            <div class="col-md-6">
                                <label>publication Description <span class="text-danger">*</span></label>
                                <input type="text" name="publication_description" id="publication_description" class="form-control" required  data-parsley-trigger="keyup" />
                            </div>
		          		</div>
		          	</div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>publication Date <span class="text-danger">*</span></label>
								<input type="date" name="publication_date" id="publication_date" class="form-control" />
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
</div>
<div id="viewModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_title">View publication Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="publication_details">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</div>
<script>
$(document).ready(function(){

	var dataTable = $('#publication_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"publication_action.php",
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

    $('#publication_date_of_birth').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });

	$('#add_publication').click(function(){
		
		$('#publication_form')[0].reset();

		$('#publication_form').parsley().reset();

    	$('#modal_title').text('Add publication');

    	$('#action').val('Add');

    	$('#submit_button').val('Add');

    	$('#publicationModal').modal('show');

    	$('#form_message').html('');

	});

	$('#publication_form').parsley();

	$('#publication_form').on('submit', function(event){
		event.preventDefault();
		if($('#publication_form').parsley().isValid())
		{		
			$.ajax({
				url:"publication_action.php",
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
						$('#publicationModal').modal('hide');
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

		var publication_id = $(this).data('id');

		$('#publication_form').parsley().reset();

		$('#form_message').html('');

		$.ajax({

	      	url:"publication_action.php",

	      	method:"POST",

	      	data:{publication_id:publication_id, action:'fetch_single'},

	      	dataType:'JSON',

	      	success:function(data)
	      	{

	        	$('#publication_title').val(data.publication_title);

                $('#publication_description').val(data.publication_description);
                $('#publication_date').val(data.publication_date);
                

	        	$('#modal_title').text('Edit publication');

	        	$('#action').val('Edit');

	        	$('#submit_button').val('Edit');

	        	$('#publicationModal').modal('show');

	        	$('#hidden_id').val(publication_id);

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

        		url:"publication_action.php",

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
        var publication_id = $(this).data('id');

        $.ajax({

            url:"publication_action.php",

            method:"POST",

            data:{publication_id:publication_id, action:'fetch_single'},

            dataType:'JSON',

            success:function(data)
            {
                var html = '<div class="table-responsive">';
                html += '<table class="table">';

               html += '<tr><th width="40%" class="text-right">Publication Title</th><td width="60%">'+data.publication_title+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Publication Description</th><td width="60%">'+data.publication_description+'</td></tr>';
				 html += '<tr><th width="40%" class="text-right">Publication Date</th><td width="60%">'+data.publication_date+'</td></tr>';
                html += '</table></div>';

                $('#viewModal').modal('show');

                $('#publication_details').html(html);

            }

        })
    });

	$(document).on('click', '.delete_button', function(){

    	var id = $(this).data('id');

    	if(confirm("Are you sure you want to remove it?"))
    	{

      		$.ajax({

        		url:"publication_action.php",

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