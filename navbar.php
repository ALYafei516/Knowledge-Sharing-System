	<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  		<!-- Brand -->
  		<a class="navbar-brand" href="dashboard.php"><?php echo $_SESSION['user_name']; ?></a>

  		<!-- Links -->
	  	<ul class="navbar-nav">
		<?php $user_type=$_SESSION['user_type'];
$user_id=$_SESSION['user_id'];
if($user_type=="user"){ ?>
	    	<li class="nav-item">
	      		<a class="nav-link" href="profile.php">Profile</a>
</li> 

<?php } else {?>
<li class="nav-item">
	      		<a class="nav-link" href="expert_profile.php">Profile</a>
</li> 

<?php }?>
	    	<li class="nav-item">
	      		<a class="nav-link" href="mypost.php">My Posts</a>
	    	</li>
			<?php 
if($user_type=="expert"){ ?>
				<li class="nav-item">
	      		<a class="nav-link" href="publication.php">Publications</a>
	    	</li>
<?php } 
if($user_type=="user"){ ?>
				<li class="nav-item">
	      		<a class="nav-link" href="addpost.php">Add Post</a>
	    	</li>
	    	<li class="nav-item">
	      		<a class="nav-link" href="report.php">Bug Report</a>
	    	</li>
			<li class="nav-item">
	      		<a class="nav-link" href="Complaint.php">Complaint</a>
	    	</li>
<?php }?>
	    	<li class="nav-item">
	      		<a class="nav-link" href="logout.php">Logout</a>
	    	</li>
	  	</ul>
	</nav>