<?php

//dashboard.php



include('class/Appointment.php');
$id=0;
$object = new Appointment;
if(!isset($_GET['id']))
{
	header('location:dashboard.php');
}
else{
	$id=$_GET['id'];
}
include('header.php');
if(isset($_POST['sub']) ){
	$rate=$_POST['rating'];
	$com=$_POST['comm'];
	$user=$_SESSION['user_name'];
	$uid=$_SESSION['user_id'];
	$da=date('Y-m-d');
	$object->query = "
		INSERT INTO coment_table VALUES('','$com','$id','$uid','$user','$rate','$da') ";
			$object->execute();
}
$object->query = "
		SELECT * FROM post_table where post_id=$id ";

		$object->execute();


		$result = $object->get_result();


?>
<head>
<style>
body{
	background-color: #fff;
}
.container{
	background-color: #eef2f5;
	width: 400px;
}
.addtxt{
	padding-top: 10px;
	padding-bottom: 10px;
	text-align: center;
	font-size: 13px;
	width: 350px;
	background-color: #e5e8ed;
	font-weight: 500;
}
.form-control: focus{
	color: #000;
}
.second{
	width: 350px;
	background-color: white;
	border-radius: 4px;
	box-shadow: 10px 10px 5px #aaaaaa;
}
.text1{
	font-size: 13px;
    font-weight: 500;
    color: #56575b;
}
.text2{
	font-size: 13px;
    font-weight: 500;
    margin-left: 6px;
    color: #56575b;
}
.text3{
	font-size: 13px;
    font-weight: 500;
    margin-right: 4px;
    color: #828386;
}
.text3o{
	color: #00a5f4;

}
.text4{
	font-size: 13px;
    font-weight: 500;
    color: #828386;
}
.text4i{
	color: #00a5f4;
}
.text4o{
	color: white;
}
.thumbup{
	font-size: 13px;
    font-weight: 500;
    margin-right: 5px;
}
.thumbupo{
	color: #17a2b8;
}



.comment-box{
    
    padding:5px;
}



.comment-area textarea{
   resize: none; 
        border: 1px solid #ad9f9f;
}


.form-control:focus {
    color: #495057;
    background-color: #fff;
    border-color: #ffffff;
    outline: 0;
    box-shadow: 0 0 0 1px rgb(255, 0, 0) !important;
}

.send {
    color: #fff;
    background-color: #ff0000;
    border-color: #ff0000;
}

.send:hover {
    color: #fff;
    background-color: #f50202;
    border-color: #f50202;
}


.rating {
 display: flex;
        margin-top: -10px;
    flex-direction: row-reverse;
    margin-left: -4px;
        float: left;
}

.rating>input {
    display: none
}

.rating>label {
        position: relative;
    width: 19px;
    font-size: 25px;
    color: #ff0000;
    cursor: pointer;
}

.rating>label::before {
    content: "\2605";
    position: absolute;
    opacity: 0
}

.rating>label:hover:before,
.rating>label:hover~label:before {
    opacity: 1 !important
}

.rating>input:checked~label:before {
    opacity: 1
}

.rating:hover>input:checked~label:before {
    opacity: 0.4
}
</style></head>
<div class="container-fluid">
	<?php
	include('navbar.php');
	?>
	<br />
	<div class="card">
		<div class="card-header"><h4>Post List</h4></div>
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
	  <?php if($row["post_status"] == 'Revised' AND $user_type=="user" ) {?>
	  
	  <div style=" padding-left: 16px;">
	  <form method="POST" action="description.php" name="fed"><table><tr><td> New Description : <input type="text" name="des"><input type="hidden" name="pid" value="<?php echo $row["post_id"]; ?>"></td>
	  <td><input type="submit" name="subfb" value="Submit"></td>
	</tr></table></form></div><br>
	  
	  
	  <?php }?>
	  <?php if($row["expert_feedback"] != '') {?>
	  <div style="background: firebrick;
    color: white;
    padding-left: 16px;"> <h6><b> Feed Back of Expert :   &emsp;</b><?php echo $row["expert_feedback"];?></h6></div>
	<?php if($row["user_feedback"] == '' AND $user_type=="user" ) {?><br>
	<div style=" padding-left: 16px;">
	  <form method="POST" action="insertfduser.php" name="fed"><table><tr><td> User feedback :</td><td> <input type="text" name="ufb"><input type="hidden" name="pid" value="<?php echo $row["post_id"]; ?>"></td>
	 <td>Rating</td>
	 <td><select name="rate">
	 <option value="0">0</option>
	 <option value="1">1</option>
	 <option value="2">2</option>
	 <option value="3">3</option>
	 <option value="4">4</option>
	 <option value="5">5</option>
	 </select></td> <td><input type="submit" name="subfb" value="User Feedback"></td>
	</tr></table></form></div><br><?php } else { if($user_type=="expert" AND $row["user_feedback"]==''){?>  <div style="
    padding-left: 16px;"> <h6> Waiting for User Feedback  </h6></div><?php } else{
		?>
		 <div style="
    padding-left: 16px;"> <h6><b> Feed Back of User :   &emsp;</b><?php echo $row["user_feedback"];?> <b> Rating:     &emsp;</b><?php echo $row["rating"];?> </h6></div>
	<?php } if($user_type=="expert" AND $row["user_feedback"]!=''){ if($row["post_status"]!="Completed"){?> <a href="completepost.php?id=<?php echo $row["post_id"]; ?>" style="display:block"><button style="
    background: brown;
    margin: 10px 60px;
    width: 165px;
    color: wheat;
    border-color: white;
	">Completed Post</button></a> <?php }?>
	
	<?php }}?>
	  <?php } else { if($user_type=="expert"){ if($row["post_status"]=="On Hold"){?> <a href="acceptpost.php?id=<?php echo $row["post_id"]; ?>" style="display:block"><button style="
    background: brown;
    margin: 10px 60px;
    width: 165px;
    color: wheat;
    border-color: white;
">Accept Post</button></a> <?php } else { if($row["post_status"]!="Revised"){?><div style=" padding-left: 16px;">
	  <form method="POST" action="insertfd.php" name="fed"><table><tr><td> Expert feedback : <input type="text" required name="fb"><input type="hidden" name="pid" value="<?php echo $row["post_id"]; ?>"></td>
	  <td><input type="submit" name="subfb" value="Expert Feedback"></form></td>
	 <td> <a href="update.php?id=<?php echo $row["post_id"]; ?>"style="
    background: brown;
    margin: 10px 10px;
	padding:4px 10px;
    width: 110px;
    color: wheat;
   display:block;">Revised Post</a> </td></tr></table></div><br><?php }}}}?>
	  
	  
	  <?php if($row["post_status"] == 'Completed')
			{?>
				<span class="badge badge-success">Completed</span>
				<?php
			}
		 if($row["post_status"] == 'Accepted')
			{?>
				<span class="badge badge-warning">Accepted</span>
			<?php }
			 if($row["post_status"] == 'Revised')
			{?>
				<span class="badge badge-danger">Revised</span>
<?php			}?>
    </div>
		<?php }?>
		
		
		
		
		<?php
		$object->query = "
		SELECT * FROM coment_table where post_id=$id ORDER BY com_id DESC";

		$object->execute();


		$result = $object->get_result();
		?>
		<div class="container justify-content-center mt-5 border-left border-right" style="float:left">
    <div class="d-flex justify-content-center pt-3 pb-2"> <h5>User Comments . . .</h5></div>
    <?php foreach($result as $row)
		{?>
			
	<div class="d-flex justify-content-center py-2">
        <div class="second py-2 px-2"> <span class="text1"><?php echo $row["com_comment"]; ?></span>
            <div class="d-flex justify-content-between py-1 pt-2">
                 <div><span class="text2">Name:</span><span class="text2"><?php echo $row["user_name"]; ?></span> <span class="text2"><?php echo $row["post_rate"]; ?>☆</span><a href="reportCom.php?cid=<?php echo $row["com_id"]; ?>" <span class="text2" style="color:red;"> Report </span></a></div>
                <div><span class="text3">Date:</span><span class="thumbup"><i class="fa fa-thumbs-o-up"></i></span><span class="text4"><?php echo $row["com_date"]; ?></span></div>
            </div>
        </div>
    </div>
		<?php }?>
        </div>
		<?php if($user_type=="user"){?>
		<div class="card" style="position: relative;
		float:right;
    display: flex;
    flex-direction: column;
    min-width: 0;
    padding: 20px;
    width: 450px;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border-radius: 6px;
    -moz-box-shadow: 0px 0px 5px 0px rgba(212, 182, 212, 1)">
               
              <div class="row">
                  
                  <div class="col-2">
                      
                      
                      <img src="https://i.imgur.com/xELPaag.jpg" width="70" class="rounded-circle mt-2">
                  
                  
                  </div>
                  
                  <div class="col-10">
                      
                      <div class="comment-box ml-2">
                           <form name="fa" method="POST" action="">
                          <h4>Add a comment</h4>
                         
                          <div class="rating"> 
                              <input type="radio" name="rating" value="5" id="5"><label for="5">☆</label>
                              <input type="radio" name="rating" value="4" id="4"><label for="4">☆</label> 
                              <input type="radio" name="rating" value="3" id="3"><label for="3">☆</label>
                              <input type="radio" name="rating" value="2" id="2"><label for="2">☆</label>
                              <input type="radio" name="rating" value="1" id="1"><label for="1">☆</label>
                          </div>
                          
                          <div class="comment-area">
                              
                              <textarea class="form-control" name="comm" placeholder="what is your view?" rows="4"></textarea>
                          
                          </div>
                          
                          <div class="comment-btns mt-2">
                              
                              <div class="row">
                                  
                                  <div class="col-6">
                                      
                                      <div class="pull-left">
                                      
                                      <button class="btn btn-success btn-sm">Cancel</button>      
                                          
                                      </div>
                                  
                                  </div>
                                  
                                  <div class="col-6">
                                      
                                      <div class="pull-right">
                                      
                                      <input type="submit" value="Send" name="sub" >   
                                          
                                      </div>
                                  
                                  </div>
                              
                              </div>
                          
                          </div>
                      
                      
                      </div>
                  
                  </div>
              
              
              </div>
    
          </div>
		<?php }?>
		
    </div>
</div>


</div>

<?php

include('footer.php');

?>
