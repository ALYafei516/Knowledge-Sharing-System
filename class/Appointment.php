<?php

//Appointment.php

class Appointment
{
	public $base_url = 'http://localhost/kss/';
	public $connect;
	public $query;
	public $statement;
	public $now;

	public function __construct()
	{
		$this->connect = new PDO("mysql:host=localhost;dbname=kss", "root", "");

		date_default_timezone_set('Asia/Kolkata');

		session_start();

		$this->now = date("Y-m-d H:i:s",  STRTOTIME(date('h:i:sa')));
	}

	function execute($data = null)
	{
		$this->statement = $this->connect->prepare($this->query);
		if($data)
		{
			$this->statement->execute($data);
		}
		else
		{
			$this->statement->execute();
		}		
	}

	function row_count()
	{
		return $this->statement->rowCount();
	}

	function statement_result()
	{
		return $this->statement->fetchAll();
	}

	function get_result()
	{
		return $this->connect->query($this->query, PDO::FETCH_ASSOC);
	}

	function is_login()
	{
		if(isset($_SESSION['admin_id']))
		{
			return true;
		}
		return false;
	}

	function is_master_user()
	{
		if(isset($_SESSION['user_type']))
		{
			if($_SESSION["user_type"] == 'Master')
			{
				return true;
			}
			return false;
		}
		return false;
	}

	function clean_input($string)
	{
	  	$string = trim($string);
	  	$string = stripslashes($string);
	  	$string = htmlspecialchars($string);
	  	return $string;
	}

	
	
	function get_total_today_complaints()
	{
		$this->query = "
		SELECT * FROM complaint_table
		WHERE complaint_date = CURDATE() 
		";
		$this->execute();
		return $this->row_count();
	}
	function get_total_today_reports()
	{
		$this->query = "
		SELECT * FROM repcom_table
		WHERE rep_date = CURDATE() 
		";
		$this->execute();
		return $this->row_count();
	}
		function get_total_yesterday_reports()
	{
		$this->query = "
		SELECT * FROM repcom_table 
		WHERE rep_date = CURDATE() - 1
		";
		$this->execute();
		return $this->row_count();
	}
		function get_total_seven_day_reports()
	{
		$this->query = "
		SELECT * FROM repcom_table  
		WHERE rep_date >= DATE(NOW()) - INTERVAL 7 DAY
		";
		$this->execute();
		return $this->row_count();
	}
	function check_inactive($id)
	{
		$this->query = "
		select * from expert_table where expert_status='Inactive' AND expert_id='$id'
		";
		$this->execute();
		return $this->row_count();
	}
	function get_total_thrty_day($id)
	{
		$this->query = "
		SELECT * FROM  post_table 
		WHERE expert_id='$id' AND expert_feedback='' AND accept_date <= DATE(NOW()) - INTERVAL 30 DAY
		";
		$this->execute();
		return $this->row_count();
	}
	function get_total_reports()
	{
		$this->query = "
		SELECT * FROM repcom_table   
		";
		$this->execute();
		return $this->row_count();
	}
	function get_total_today_res()
	{
		$this->query = "
		SELECT * FROM repcom_table
		WHERE 	rep_status = 'Resolved'
		";
		$this->execute();
		return $this->row_count();
	}
		function get_total_today_inv()
	{
		$this->query = "
		SELECT * FROM repcom_table
		WHERE 	rep_status = 'In Investigation'
		";
		$this->execute();
		return $this->row_count();
	}
		function get_total_today_hold()
	{
		$this->query = "
		SELECT * FROM repcom_table
		WHERE 	rep_status = 'On Hold'
		";
		$this->execute();
		return $this->row_count();
	}
	
	
	
	function get_total_today_posts()
	{
		$this->query = "
		SELECT * FROM post_table
		WHERE post_date = CURDATE() 
		";
		$this->execute();
		return $this->row_count();
	}
		function get_total_yesterday_posts()
	{
		$this->query = "
		SELECT * FROM post_table 
		WHERE post_date = CURDATE() - 1
		";
		$this->execute();
		return $this->row_count();
	}
		function get_total_seven_day_posts()
	{
		$this->query = "
		SELECT * FROM post_table 
		WHERE post_date >= DATE(NOW()) - INTERVAL 7 DAY
		";
		$this->execute();
		return $this->row_count();
	}
	function get_total_posts()
	{
		$this->query = "
		SELECT * FROM post_table  
		";
		$this->execute();
		return $this->row_count();
	}
	function get_total_pub()
	{
		$this->query = "
		SELECT * FROM publication_table  
		";
		$this->execute();
		return $this->row_count();
	}
	function get_total_experts()
	{
		$this->query = "
		SELECT * FROM expert_table 
		";
		$this->execute();
		return $this->row_count();
	}
	function get_total_inact()
	{
		$this->query = "
		SELECT * FROM expert_table
		WHERE 	expert_status = 'Inactive'
		";
		$this->execute();
		return $this->row_count();
	}
	function get_total_actex()
	{
		$this->query = "
		SELECT * FROM expert_table
		WHERE 	expert_status = 'Active'
		";
		$this->execute();
		return $this->row_count();
	}
	function get_total_coms()
	{
		$this->query = "
		SELECT * FROM coment_table 
		";
		$this->execute();
		return $this->row_count();
	}
		function get_total_sfc()
	{
		$a=4;
		$s=5;
		$this->query = "
		SELECT * FROM coment_table where post_rate='$s' || post_rate='$a'
		";
		$this->execute();
		return $this->row_count();
	}
	function get_total_usfc()
	{
		$a=1;
		$s=2;
		$d=3;
		$this->query = "
		SELECT * FROM coment_table where post_rate='$s' || post_rate='$a' || post_rate='$d'
		";
		$this->execute();
		return $this->row_count();
	}
	function get_total_fs()
	{
		$s=5;
		$this->query = "
		SELECT * FROM post_table where rating='$s' 
		";
		$this->execute();
		return $this->row_count();
	}
	function get_total_one()
	{
		$s=1;
		$this->query = "
		SELECT * FROM post_table where rating='$s' 
		";
		$this->execute();
		return $this->row_count();
	}
	function get_total_two()
	{
		$s=2;
		$this->query = "
		SELECT * FROM post_table where rating='$s' 
		";
		$this->execute();
		return $this->row_count();
	}
	
	function get_total_three()
	{
		$s=3;
		$this->query = "
		SELECT * FROM post_table where rating='$s' 
		";
		$this->execute();
		return $this->row_count();
	}
	function get_total_four()
	{
		$s=4;
		$this->query = "
		SELECT * FROM post_table where rating='$s' 
		";
		$this->execute();
		return $this->row_count();
	}
	function get_total_five()
	{
		$s=5;
		$this->query = "
		SELECT * FROM post_table where rating='$s' 
		";
		$this->execute();
		return $this->row_count();
	}
	function get_total_today_compl()
	{
		$this->query = "
		SELECT * FROM post_table
		WHERE 	post_status = 'Completed'
		";
		$this->execute();
		return $this->row_count();
	}
		function get_total_today_rev()
	{
		$this->query = "
		SELECT * FROM post_table
		WHERE 	post_status = 'Revised'
		";
		$this->execute();
		return $this->row_count();
	}
		function get_total_today_accep()
	{
		$this->query = "
		SELECT * FROM post_table
		WHERE 	post_status = 'Accepted'
		";
		$this->execute();
		return $this->row_count();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
function get_total_today_usf()
	{
		$this->query = "
		SELECT * FROM complaint_table
		WHERE complaint_type = 'Unsatisfied Expert’s Feedback'
		";
		$this->execute();
		return $this->row_count();
	}
	
	function get_total_today_wara()
	{
		$this->query = "
		SELECT * FROM complaint_table
		WHERE complaint_type = 'Wrongly Assigned Research Area'
		";
		$this->execute();
		return $this->row_count();
	}
	function get_total_today_other()
	{
		$this->query = "
		SELECT * FROM complaint_table
		WHERE complaint_type = 'Other Type'
		";
		$this->execute();
		return $this->row_count();
	}
	
	function get_total_yesterday_complaints()
	{
		$this->query = "
		SELECT * FROM complaint_table 
		WHERE complaint_date = CURDATE() - 1
		";
		$this->execute();
		return $this->row_count();
	}

	function get_total_seven_day_complaints()
	{
		$this->query = "
		SELECT * FROM complaint_table  
		WHERE complaint_date >= DATE(NOW()) - INTERVAL 7 DAY
		";
		$this->execute();
		return $this->row_count();
	}

	function get_total_appointment()
	{
		$this->query = "
		SELECT * FROM appointment_table 
		";
		$this->execute();
		return $this->row_count();
	}
		function get_total_complaints()
	{
		$this->query = "
		SELECT * FROM complaint_table 
		";
		$this->execute();
		return $this->row_count();
	}
	function get_total_expert()
	{
		$this->query = "
		SELECT * FROM expert_table 
		";
		$this->execute();
		return $this->row_count();
	}

function get_total_admin()
	{
		$this->query = "
		SELECT * FROM admin_table 
		";
		$this->execute();
		return $this->row_count();
	}
	function get_total_user()
	{
		$this->query = "
		SELECT * FROM user_table 
		";
		$this->execute();
		return $this->row_count();
	}
function get_total_stud()
	{	$st="Student";
		$this->query = "
		SELECT * FROM user_table where user_type='$st'";
		$this->execute();
		return $this->row_count();
	}
	function get_total_Lec()
	{	$st="Lecturer";
		$this->query = "
		SELECT * FROM user_table where user_type='$st'";
		$this->execute();
		return $this->row_count();
	}
	
function get_total_rev()
	{	$st="Revised";
		$this->query = "
		SELECT * FROM post_table where post_status='$st'";
		$this->execute();
		return $this->row_count();
	}
	function get_total_com()
	{	$st="Completed";
		$this->query = "
		SELECT * FROM post_table where post_status='$st'";
		$this->execute();
		return $this->row_count();
	}
		function get_total_Acc()
	{	$st="Accepted";
		$this->query = "
		SELECT * FROM post_table where post_status='$st'";
		$this->execute();
		return $this->row_count();
	}
	
	function Get_class_name($class_id)
	{
		$this->query = "
		SELECT class_name FROM class_srms 
		WHERE class_id = '$class_id'
		";
		$result = $this->get_result();
		foreach($result as $row)
		{
			return $row["class_name"];
		}
	}

	function Get_Class_subject($class_id)
	{
		$this->query = "
		SELECT subject_name FROM subject_srms 
		WHERE class_id = '$class_id' 
		AND subject_status = 'Enable'
		";
		$result = $this->get_result();
		$data = array();
		foreach($result as $row)
		{
			$data[] = $row["subject_name"];
		}
		return $data;
	}

	function Get_user_name($user_id)
	{
		$this->query = "
		SELECT * FROM user_srms 
		WHERE user_id = '".$user_id."'
		";
		$result = $this->get_result();
		foreach($result as $row)
		{
			if($row['user_type'] != 'Master')
			{
				return $row["user_name"];
			}
			else
			{
				return 'Master';
			}
		}
	}

	function Get_exam_name($exam_id)
	{
		$this->query = "
		SELECT exam_name FROM exam_srms 
		WHERE exam_id = '$exam_id'
		";
		$result = $this->get_result();
		foreach($result as $row)
		{
			return $row["exam_name"];
		}
	}

	
	function Get_total_classes()
	{
		$this->query = "
		SELECT COUNT(class_id) as Total 
		FROM class_srms 
		WHERE class_status = 'Enable'
		";
		$result = $this->get_result();
		foreach($result as $row)
		{
			return $row["Total"];
		}
	}

	function Get_total_subject()
	{
		$this->query = "
		SELECT COUNT(subject_id) as Total 
		FROM subject_srms 
		WHERE subject_status = 'Enable'
		";
		$result = $this->get_result();
		foreach($result as $row)
		{
			return $row["Total"];
		}
	}

	function Get_total_student()
	{
		$this->query = "
		SELECT COUNT(student_id) as Total 
		FROM student_srms 
		WHERE student_status = 'Enable'
		";
		$result = $this->get_result();
		foreach($result as $row)
		{
			return $row["Total"];
		}
	}

	function Get_total_exam()
	{
		$this->query = "
		SELECT COUNT(exam_id) as Total 
		FROM exam_srms 
		WHERE exam_status = 'Enable' 
		";
		$result = $this->get_result();
		foreach($result as $row)
		{
			return $row["Total"];
		}
	}

	function Get_total_result()
	{
		$this->query = "
		SELECT COUNT(result_id) as Total 
		FROM result_srms 
		";
		$result = $this->get_result();
		foreach($result as $row)
		{
			return $row["Total"];
		}
	}
	
	function get_total_inv()
	{	$st="In Investigate";
		$this->query = "
		SELECT * FROM repcom_table where rep_status='$st'";
		$this->execute();
		return $this->row_count();
	}
	function get_total_res()
	{	$st="Resolved";
		$this->query = "
		SELECT * FROM repcom_table where rep_status='$st'";
		$this->execute();
		return $this->row_count();
	}
	function get_total_hold()
	{	$st="On Hold";
		$this->query = "
		SELECT * FROM repcom_table where rep_status='$st'";
		$this->execute();
		return $this->row_count();
	}

}


?>