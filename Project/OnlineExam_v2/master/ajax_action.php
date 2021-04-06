<?php

//ajax_action.php

include('Examination.php');

require_once('../class/class.phpmailer.php');
date_default_timezone_set("Hongkong");
$exam = new Examination;

$current_datetime = date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')));
	
if(isset($_POST['page']))
{
	if($_POST['page'] == 'register')
	{
		if($_POST['action'] == 'check_email')
		{
			$exam->query = "
			SELECT * FROM admin_table 
			WHERE admin_email_address = '".trim($_POST["email"])."'
			";

			$total_row = $exam->total_row();

			if($total_row == 0)
			{
				$output = array(
					'success'	=>	true
				);

				echo json_encode($output);
			}
		}

		if($_POST['action'] == 'register')
		{
			$admin_verification_code = md5(rand());

			$receiver_email = $_POST['admin_email_address'];

			$exam->data = array(
				':admin_email_address'		=>	$receiver_email,
				':admin_password'			=>	password_hash($_POST['admin_password'], PASSWORD_DEFAULT),
				':admin_verfication_code'	=>	$admin_verification_code,
				':admin_type'				=>	'sub_master', 
				':admin_created_on'			=>	$current_datetime
			);

			$exam->query = "
			INSERT INTO admin_table 
			(admin_email_address, admin_password, admin_verfication_code, admin_type, admin_created_on) 
			VALUES 
			(:admin_email_address, :admin_password, :admin_verfication_code, :admin_type, :admin_created_on)
			";

			$exam->execute_query();

			$subject = 'Online Examination Registration Verification';

			$body = '
			<p>Thank you for registering.</p>
			<p>This is a verification eMail, please click the link to verify your eMail address by clicking this <a href="'.$exam->home_page.'verify_email.php?type=master&code='.$admin_verification_code.'" target="_blank"><b>link</b></a>.</p>
			<p>In case if you have any difficulty please eMail us.</p>
			<p>Thank you,</p>
			<p>Online Examination System</p>
			';

			$exam->send_email($receiver_email, $subject, $body);

			$output = array(
				'success'	=>	true
			);

			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'login')
	{
		if($_POST['action'] == 'login')
		{
			$exam->data = array(
				':admin_login_id'	=>	$_POST['admin_login_id']
			);

			$exam->query = "
			SELECT * FROM admin_table 
			WHERE admin_login_id = :admin_login_id
			";

			$total_row = $exam->total_row();

			if($total_row > 0)
			{
				$result = $exam->query_result();

				foreach($result as $row)
				{
					if(password_verify($_POST['admin_password'], $row['admin_password']))
					{
						$_SESSION['admin_id'] = $row['admin_id'];
						$output = array(
							'success'	=>	true
						);
					}
					else
					{
						$output = array(
							'error'	=>	'Wrong Password'
						);
					}
				}
			}
			else
			{
				$output = array(
					'error'		=>	'Wrong Login ID'
				);
			}
			echo json_encode($output);
		}

	}

	if($_POST['page'] == 'exam')
	{
		if($_POST['action'] == 'fetch')
		{
			$output = array();

			$exam->query = "
			SELECT * FROM online_exam_table 
			WHERE admin_id = '".$_SESSION["admin_id"]."' 
			AND (
			";

			if(isset($_POST['search']['value']))
			{
				$exam->query .= 'online_exam_title LIKE "%'.$_POST["search"]["value"].'%" ';

				$exam->query .= 'OR online_exam_datetime LIKE "%'.$_POST["search"]["value"].'%" ';

				$exam->query .= 'OR online_exam_duration LIKE "%'.$_POST["search"]["value"].'%" ';

				$exam->query .= 'OR total_question LIKE "%'.$_POST["search"]["value"].'%" ';

				$exam->query .= 'OR marks_per_right_answer LIKE "%'.$_POST["search"]["value"].'%" ';

				$exam->query .= 'OR marks_per_wrong_answer LIKE "%'.$_POST["search"]["value"].'%" ';

				$exam->query .= 'OR online_exam_status LIKE "%'.$_POST["search"]["value"].'%" ';
			}

			$exam->query .= ')';

			if(isset($_POST['order']))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY online_exam_id DESC ';
			}

			$extra_query = '';

			if($_POST['length'] != -1)
			{
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();

			$exam->query .= $extra_query;

			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM online_exam_table 
			WHERE admin_id = '".$_SESSION["admin_id"]."'
			";

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();
				$sub_array[] = html_entity_decode($row['online_exam_title']);

				$sub_array[] = $row['online_exam_datetime'];

				$sub_array[] = $row['online_exam_duration'] . ' Minute';

				$sub_array[] = $row['total_question'] . ' Question';

				$sub_array[] = $row['marks_per_right_answer'] . ' Mark';


				$sub_array[] = '-' . $row['marks_per_wrong_answer'] . ' Mark';

				$status = '';
				$edit_button = '';
				$delete_button = '';
				$question_button = '';
				$result_button = '';
				$enroll_button = '';

				if($row['online_exam_status'] == 'Pending')
				{
					$status = '<span class="badge badge-warning">Pending</span>';
				}

				if($row['online_exam_status'] == 'Created')
				{
					$status = '<span class="badge badge-success">Created</span>';
				}

				if($row['online_exam_status'] == 'Started')
				{
					$status = '<span class="badge badge-primary">Started</span>';
				}

				if($row['online_exam_status'] == 'Completed')
				{
					$status = '<span class="badge badge-dark">Completed</span>';
				}

				if($exam->Is_exam_is_not_started($row["online_exam_id"]))
				{
					$edit_button = '
					<button type="button" name="edit" class="btn btn-primary btn-sm edit" id="'.$row['online_exam_id'].'">Edit</button>
					';

					$delete_button = '<button type="button" name="delete" class="btn btn-danger btn-sm delete" id="'.$row['online_exam_id'].'">Delete</button>';

				}
				else
				{
					$result_button = '<a href="exam_result.php?code='.$row["online_exam_code"].'" class="btn btn-dark btn-sm">Result</a>';
					$enroll_button = '<a href="exam_enroll.php?code='.$row["online_exam_code"].'" class="btn btn-dark btn-sm">Enroll</a>';
				}

				if($exam->Is_allowed_add_question($row['online_exam_id']))
				{
					$question_button = '
					<button type="button" name="add_question" class="btn btn-info btn-sm add_question" id="'.$row['online_exam_id'].'">Add Question</button>
					';
				}
				else
				{
					$question_button = '
					<a href="question.php?code='.$row['online_exam_code'].'" class="btn btn-warning btn-sm">View Question</a>
					';
					//$status = '<span class="badge badge-success">Created</span>';
				}

				$sub_array[] = $status;

				$sub_array[] = $enroll_button;

				$sub_array[] = $question_button;

				$sub_array[] = $result_button;

				$sub_array[] = $edit_button . ' ' . $delete_button;

				$data[] = $sub_array;
			}

			$output = array(
				"draw"				=>	intval($_POST["draw"]),
				"recordsTotal"		=>	$total_rows,
				"recordsFiltered"	=>	$filtered_rows,
				"data"				=>	$data
			);

			echo json_encode($output);

		}

		if($_POST['action'] == 'Add')
		{
			$exam->data = array(
				':admin_id'				=>	$_SESSION['admin_id'],
				':online_exam_title'	=>	$exam->clean_data($_POST['online_exam_title']),
				':online_exam_datetime'	=>	$_POST['online_exam_datetime'] . ':00',
				':online_exam_duration'	=>	$_POST['online_exam_duration'],
				':total_question'		=>	$_POST['total_question'],
				':marks_per_right_answer'=>	$_POST['marks_per_right_answer'],
				':marks_per_wrong_answer'=>	$_POST['marks_per_wrong_answer'],
				':online_exam_created_on'=>	$current_datetime,
				':online_exam_status'	=>	'Pending',
				':online_exam_code'		=>	md5(rand())
			);

			$exam->query = "
			INSERT INTO online_exam_table 
			(admin_id, online_exam_title, online_exam_datetime, online_exam_duration, total_question, marks_per_right_answer, marks_per_wrong_answer, online_exam_created_on, online_exam_status, online_exam_code) 
			VALUES (:admin_id, :online_exam_title, :online_exam_datetime, :online_exam_duration, :total_question, :marks_per_right_answer, :marks_per_wrong_answer, :online_exam_created_on, :online_exam_status, :online_exam_code)
			";

			$exam->execute_query();

			$output = array(
				'success'	=>	'New Exam Details Added'
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'edit_fetch')
		{
			$exam->query = "
			SELECT * FROM online_exam_table 
			WHERE online_exam_id = '".$_POST["exam_id"]."'
			";

			$result = $exam->query_result();

			foreach($result as $row)
			{
				$output['online_exam_title'] = $row['online_exam_title'];

				$output['online_exam_datetime'] = $row['online_exam_datetime'];

				$output['online_exam_duration'] = $row['online_exam_duration'];

				$output['total_question'] = $row['total_question'];

				$output['marks_per_right_answer'] = $row['marks_per_right_answer'];

				$output['marks_per_wrong_answer'] = $row['marks_per_wrong_answer'];
			}

			echo json_encode($output);
		}

		if($_POST['action'] == 'Edit')
		{
			$exam->data = array(
				':online_exam_title'	=>	$_POST['online_exam_title'],
				':online_exam_datetime'	=>	$_POST['online_exam_datetime'] . ':00',
				':online_exam_duration'	=>	$_POST['online_exam_duration'],
				':total_question'		=>	$_POST['total_question'],
				':marks_per_right_answer'=>	$_POST['marks_per_right_answer'],
				':marks_per_wrong_answer'=>	$_POST['marks_per_wrong_answer'],
				':online_exam_id'		=>	$_POST['online_exam_id']
			);

			$exam->query = "
			UPDATE online_exam_table 
			SET online_exam_title = :online_exam_title, online_exam_datetime = :online_exam_datetime, online_exam_duration = :online_exam_duration, total_question = :total_question, marks_per_right_answer = :marks_per_right_answer, marks_per_wrong_answer = :marks_per_wrong_answer  
			WHERE online_exam_id = :online_exam_id
			";

			$exam->execute_query($exam->data);

			$output = array(
				'success'	=>	'Exam Details has been changed'
			);

			echo json_encode($output);
		}
		if($_POST['action'] == 'delete')
		{
			$exam->data = array(
				':online_exam_id'	=>	$_POST['exam_id']
			);

			$exam->query = "
			DELETE FROM online_exam_table 
			WHERE online_exam_id = :online_exam_id
			";

			$exam->execute_query();

			$output = array(
				'success'	=>	'Exam Details has been removed'
			);

			echo json_encode($output);
		}
	}
	


	if($_POST['page'] == 'question')
	{
		if($_POST['action'] == 'Add')
		{
			$exam->data = array(
				':online_exam_id'		=>	$_POST['online_exam_id'],
				':question_title'		=>	$exam->clean_data($_POST['question_title']),
				':question_type'		=>	$_POST['question_type'],
				':answer_option'		=>	$_POST['answer_option']

			);

			$exam->query = "
			INSERT INTO question_table 
			(online_exam_id, question_title, question_type, answer_option) 
			VALUES (:online_exam_id, :question_title, :question_type, :answer_option)
			";

			$question_id = $exam->execute_question_with_last_id($exam->data);

			for($count = 1; $count <= 4; $count++)
			{
				$exam->data = array(
					':question_id'		=>	$question_id,
					':option_number'	=>	$count,
					':option_title'		=>	$exam->clean_data($_POST['option_title_' . $count])
				);

				$exam->query = "
				INSERT INTO option_table 
				(question_id, option_number, option_title) 
				VALUES (:question_id, :option_number, :option_title)
				";

				$exam->execute_query($exam->data);
			}

			$output = array(
				'success'		=>	'Question Added'
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'fetch')
		{
			$output = array();
			$exam_id = '';
			if(isset($_POST['code']))
			{
				$exam_id = $exam->Get_exam_id($_POST['code']);
			}
			$exam->query = "
			SELECT * FROM question_table 
			WHERE online_exam_id = '".$exam_id."' 
			AND (
			";

			if(isset($_POST['search']['value']))
			{
				$exam->query .= 'question_title LIKE "%'.$_POST["search"]["value"].'%" ';
			}

			$exam->query .= ')';

			if(isset($_POST["order"]))
			{
				$exam->query .= '
				ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' 
				';
			}
			else
			{
				$exam->query .= 'ORDER BY question_id ASC ';
			}

			$extra_query = '';

			if($_POST['length'] != -1)
			{
				$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();

			$exam->query .= $extra_query;

			$result = $exam->query_result();
			
			
			$exam->query = "
			SELECT COUNT(user_exam_question_answer.user_id) AS count
			FROM question_table INNER JOIN user_exam_question_answer
			ON question_table.question_id=user_exam_question_answer.question_id
			WHERE question_table.online_exam_id = '".$exam_id."'
			GROUP BY question_table.question_id
			";
			
			$result = $exam->query_result();
			$n = 0;
			$count = array("0"=>"0", "1"=>"0", "2"=>"0", "3"=>"0", "4"=>"0", "5"=>"0","6"=>"0", "7"=>"0", "8"=>"0", "9"=>"0", "10"=>"0", "11"=>"0", "12"=>"0", "13"=>"0", "14"=>"0", "15"=>"0","16"=>"0", "17"=>"0", "18"=>"0", "19"=>"0", "20"=>"0", "21"=>"0", "22"=>"0", "23"=>"0", "24"=>"0", "25"=>"0","26"=>"0", "27"=>"0", "28"=>"0", "29"=>"0", "30"=>"0");
			foreach ($result as $row)
			{	
				$sub_array = array();
				
				$sub_array[$n] = $row['count'];
				
			$count[$n] = $sub_array[$n];
				$n++;
			}
			
			$exam->query = "
			SELECT COUNT(user_exam_question_answer.user_id) AS count
			FROM question_table INNER JOIN user_exam_question_answer
			ON question_table.question_id=user_exam_question_answer.question_id
			WHERE question_table.online_exam_id = '".$exam_id."' AND question_table.answer_option = user_exam_question_answer.user_answer_option
			GROUP BY question_table.question_id
			";
			
			$result = $exam->query_result();
			$n = 0;
			$stat_count = array("0"=>"0", "1"=>"0", "2"=>"0", "3"=>"0", "4"=>"0", "5"=>"0","6"=>"0", "7"=>"0", "8"=>"0", "9"=>"0", "10"=>"0", "11"=>"0", "12"=>"0", "13"=>"0", "14"=>"0", "15"=>"0","16"=>"0", "17"=>"0", "18"=>"0", "19"=>"0", "20"=>"0", "21"=>"0", "22"=>"0", "23"=>"0", "24"=>"0", "25"=>"0","26"=>"0", "27"=>"0", "28"=>"0", "29"=>"0", "30"=>"0");

			foreach ($result as $row)
			{	
				$sub_array = array();
				
				$sub_array[$n] = $row['count'];
				
			$stat_count[$n] = $sub_array[$n];
				$n++;
			}
			

			
			$exam->query = "
			SELECT * , AVG(user_exam_question_answer.marks) AS Average FROM question_table INNER JOIN user_exam_question_answer
			ON question_table.question_id=user_exam_question_answer.question_id
			WHERE question_table.online_exam_id = '".$exam_id."'
			GROUP BY question_table.question_id
			";
			
			$result = $exam->query_result();
						
			$total_rows = $exam->total_row();

			$data = array();
			$n = 0;
			foreach($result as $row)
			{
				$sub_array = array();

				$sub_array[] = $row['question_title'];
				
				$sub_array[] = $row['question_type'];

				$sub_array[] = 'Option ' . $row['answer_option'];
				
				$sub_array[] = number_format($stat_count[$n]/$count[$n]*100, 4, '.', '')."%";
				
				$sub_array[] = number_format($row['Average'], 4, '.', '');
				$edit_button = '';
				$delete_button = '';

				if($exam->Is_exam_is_not_started($exam_id))
				{
					$edit_button = '<button type="button" name="edit" class="btn btn-primary btn-sm edit" id="'.$row['question_id'].'">Edit</button>';

					$delete_button = '<button type="button" name="delete" class="btn btn-danger btn-sm delete" id="'.$row['question_id'].'">Delete</button>';
				}

				$sub_array[] = $edit_button . ' ' . $delete_button;

				$data[] = $sub_array;
				
				$n++;
			}

			$output = array(
				"draw"		=>	intval($_POST["draw"]),
				"recordsTotal"	=>	$total_rows,
				"recordsFiltered"	=>	$filtered_rows,
				"data"		=>	$data
			);

			echo json_encode($output);
		}

		if($_POST['action'] == 'edit_fetch')
		{
			$exam->query = "
			SELECT * FROM question_table 
			WHERE question_id = '".$_POST["question_id"]."'
			";

			$result = $exam->query_result();

			foreach($result as $row)
			{
				$output['question_title'] = html_entity_decode($row['question_title']);

				$output['answer_option'] = $row['answer_option'];

				for($count = 1; $count <= 4; $count++)
				{
					$exam->query = "
					SELECT option_title FROM option_table 
					WHERE question_id = '".$_POST["question_id"]."' 
					AND option_number = '".$count."'
					";

					$sub_result = $exam->query_result();

					foreach($sub_result as $sub_row)
					{
						$output["option_title_" . $count] = html_entity_decode($sub_row["option_title"]);
					}
				}
			}

			echo json_encode($output);
		}

		if($_POST['action'] == 'Edit')
		{
			$exam->data = array(
				':question_title'		=>	$_POST['question_title'],
				':answer_option'		=>	$_POST['answer_option'],
				':question_id'			=>	$_POST['question_id']
			);

			$exam->query = "
			UPDATE question_table 
			SET question_title = :question_title, answer_option = :answer_option 
			WHERE question_id = :question_id
			";

			$exam->execute_query();

			for($count = 1; $count <= 4; $count++)
			{
				$exam->data = array(
					':question_id'		=>	$_POST['question_id'],
					':option_number'	=>	$count,
					':option_title'		=>	$_POST['option_title_' . $count]
				);

				$exam->query = "
				UPDATE option_table 
				SET option_title = :option_title 
				WHERE question_id = :question_id 
				AND option_number = :option_number
				";
				$exam->execute_query();
			}

			$output = array(
				'success'	=>	'Question Edit'
			);

			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'user')
	{
		if($_POST['action'] == 'fetch')
		{
			$output = array();

			$exam->query = "
			SELECT * FROM user_table 
			WHERE ";

			if(isset($_POST["search"]["value"]))
			{
			 	$exam->query .= 'user_email_address LIKE "%'.$_POST["search"]["value"].'%" ';
			 	$exam->query .= 'OR user_name LIKE "%'.$_POST["search"]["value"].'%" ';
			 	$exam->query .= 'OR user_gender LIKE "%'.$_POST["search"]["value"].'%" ';
			 	$exam->query .= 'OR user_mobile_no LIKE "%'.$_POST["search"]["value"].'%" ';
			}
			
			if(isset($_POST["order"]))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY user_id DESC ';
			}

			$extra_query = '';

			if($_POST["length"] != -1)
			{
			 	$extra_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filterd_rows = $exam->total_row();

			$exam->query .= $extra_query;

			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM user_table";

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();
				$sub_array[] = '<img src="../upload/'.$row["user_image"].'" class="img-thumbnail" width="75" />';
				if($row["user_role"] == 'Teacher')
				{
					$user_role_icon = '<label class="badge badge-danger">Teacher</label>';
				}
				else
				{
					$user_role_icon = '<label class="badge badge-success">Student</label>';	
				}
				$sub_array[] = $user_role_icon;
				$sub_array[] = $row["user_login_id"];
				$sub_array[] = $row["user_name"];
				$sub_array[] = $row["user_email_address"];
				$sub_array[] = $row["user_gender"];
				$sub_array[] = $row["user_birthday"];
				$sub_array[] = $row["user_course_no"];
				$view_button = '';
				$edit_button = '';
				$delete_button = '';
				$view_button = '<button type="button" name="view_detail" class="btn btn-primary btn-sm details" id="'.$row["user_id"].'">View Details</button>';

				$edit_button = '
					<button type="button" name="edit" class="btn btn-success btn-sm edit" id="'.$row['user_id'].'">Edit</button>
					';

				$delete_button = '<button type="button" name="delete" class="btn btn-danger btn-sm delete" id="'.$row['user_id'].'">Delete</button>';
				$sub_array[] = $view_button . ' ' . $edit_button . ' ' . $delete_button;
				$data[] = $sub_array;
			}

			$output = array(
			 	"draw"    			=> 	intval($_POST["draw"]),
			 	"recordsTotal"  	=>  $total_rows,
			 	"recordsFiltered" 	=> 	$filterd_rows,
			 	"data"    			=> 	$data
			);
			echo json_encode($output);	
		}
		if($_POST['action'] == 'fetch_data')
		{
			$exam->query = "
			SELECT * FROM user_table 
			WHERE user_id = '".$_POST["user_id"]."'
			";
			$result = $exam->query_result();
			$output = '';
			foreach($result as $row)
			{
				$is_email_verified = '';
				if($row["user_role"] == 'Teacher')
				{
					$user_role_icon = '<label class="badge badge-danger">Teacher</label>';
				}
				else
				{
					$user_role_icon = '<label class="badge badge-success">Student</label>';	
				}

				$output .= '
				<div class="row">
					<div class="col-md-12">
						<div align="center">
							<img src="../upload/'.$row["user_image"].'" class="img-thumbnail" width="200" />
						</div>
						<br />
						<table class="table table-bordered">
							<tr>
								<th>Role</th>
								<td>'.$user_role_icon.'</td>
							</tr>
							<tr>
								<th>Nick Name</th>
								<td>'.$row["user_name"].'</td>
							</tr>
							<tr>
								<th>Gender</th>
								<td>'.$row["user_gender"].'</td>
							</tr>
							<tr>
								<th>Birthday</th>
								<td>'.$row["user_birthday"].'</td>
							</tr>
							<tr>
								<th>Course No.</th>
								<td>'.$row["user_course_no"].'</td>
							</tr>
							<tr>
								<th>Email Address</th>
								<td>'.$row["user_email_address"].'</td>
							</tr>
						</table>
					</div>
				</div>
				';
			}	
			echo $output;			
		}
		
		if($_POST['action'] == 'check_email')
		{
			$exam->query = "
			SELECT * FROM user_table 
			WHERE user_email_address = '".trim($_POST["email"])."'
			";

			$total_row = $exam->total_row();

			if($total_row == 0)
			{
				$output = array(
					'success'		=>	true
				);
				echo json_encode($output);
			}
		}
		
		if($_POST['action'] == 'check_loginid')
		{
			$exam->query = "
			SELECT * FROM user_table 
			WHERE user_login_id = '".trim($_POST["loginid"])."'
			";

			$total_row = $exam->total_row();

			if($total_row == 0)
			{
				$output = array(
					'success'		=>	true
				);
				echo json_encode($output);
			}
		}
		
		if($_POST['action'] == 'register')
		{
			$user_verfication_code = md5(rand());

			$receiver_email = $_POST['user_email_address'];


			
			if(isset($_POST['user_gender']) && isset($_POST['user_birthday'])){
			
			$exam->data = array(
				':user_role'	=>	$_POST['user_role'],
				':user_login_id'	=>	$_POST['user_login_id'],
				':user_password'		=>	password_hash($_POST['user_password'], PASSWORD_DEFAULT),
				':user_verfication_code'=>	$user_verfication_code,
				':user_name'			=>	$_POST['user_name'],
				':user_email_address'	=>	$receiver_email,

				':user_gender'			=>	$_POST['user_gender'],
				':user_birthday'		=>	$_POST['user_birthday'],
				':user_created_on'		=>	$current_datetime
			);

			$exam->query = "
			INSERT INTO user_table 
			(user_role, user_login_id, user_password, user_verfication_code, user_name, user_email_address, user_gender, user_birthday, user_created_on)
			VALUES 
			(:user_role, :user_login_id, :user_password, :user_verfication_code, :user_name, :user_email_address, :user_gender, :user_birthday, :user_created_on)
			";
			}else{
			
			$exam->data = array(
				':user_role'	=>	$_POST['user_role'],
				':user_login_id'	=>	$_POST['user_login_id'],
				':user_password'		=>	password_hash($_POST['user_password'], PASSWORD_DEFAULT),
				':user_verfication_code'=>	$user_verfication_code,
				':user_name'			=>	$_POST['user_name'],
				':user_email_address'	=>	$receiver_email,
				':user_course_no'		=>	$_POST['user_course_no'],
				':user_created_on'		=>	$current_datetime
			);

			$exam->query = "
			INSERT INTO user_table 
			(user_role, user_login_id, user_password, user_verfication_code, user_name, user_email_address, user_course_no, user_created_on)
			VALUES 
			(:user_role, :user_login_id, :user_password, :user_verfication_code, :user_name, :user_email_address, :user_course_no, :user_created_on)
			";	
			}
			
			$exam->execute_query();
			
			// If Teacher, Insert to both DB
			
			if(isset($_POST['user_course_no'])){
			{
			
			$exam->data = array(
				':admin_login_id'	=>	$_POST['user_login_id'],
				':admin_password'		=>	password_hash($_POST['user_password'], PASSWORD_DEFAULT),
				':admin_verfication_code'=>	$user_verfication_code,
				':admin_email_address'	=>	$receiver_email,
				':admin_created_on'		=>	$current_datetime
			);
			
			$exam->query = "
			INSERT INTO admin_table 
			(admin_login_id, admin_password, admin_verfication_code, admin_email_address, admin_created_on)
			VALUES 
			(:admin_login_id, :admin_password, :admin_verfication_code, :admin_email_address, :admin_created_on)
			";	
			}
			
			$exam->execute_query();
			}

			$output = array(
				'success'		=>	true
			);

			echo json_encode($output);
		}
	
	
		if($_POST['action'] == 'edit_fetch')
		{
			$exam->query = "
			SELECT * FROM user_table 
			WHERE user_id = '".$_POST["user_id"]."'
			";

			$result = $exam->query_result();

			foreach($result as $row)
			{
				$output['user_role'] = $row['user_role'];

				$output['user_login_id'] = $row['user_login_id'];

				$output['user_password'] = '';

				$output['user_name'] = $row['user_name'];

				$output['user_email_address'] = $row['user_email_address'];

				$output['user_gender'] = $row['user_gender'];
				
				if($row['user_role'] == 'Student'){
				
				$output['user_gender'] = $row['user_gender'];
				
				$output['user_birthday'] = $row['user_birthday'];
				
				}else if ($row['user_role'] == 'Teacher'){
					
				$output['user_course_no'] = $row['user_course_no'];
				
				}
			}

			echo json_encode($output);
		}

		if($_POST['action'] == 'Edit')
		{
			if ($_POST['user_role'] == 'Student'){
			$exam->data = array(
				':user_role'	=>	$_POST['user_role'],
				':user_login_id'	=>	$_POST['user_login_id'],
				':user_password'	=>	$_POST['user_password'],
				':user_name'		=>	$_POST['user_name'],
				':user_email_address'=>	$_POST['user_email_address'],
				':user_gender'=>	$_POST['user_gender'],
				':user_birthday'		=>	$_POST['user_birthday'],
				':user_id'		=>	$_POST['user_id']
			);

			$exam->query = "
			UPDATE user_table 
			SET user_role = :user_role, user_login_id = :user_login_id, user_password = :user_password, user_name = :user_name, user_email_address = :user_email_address, user_gender = :user_gender, user_birthday = :user_birthday 
			WHERE user_id = :user_id
			";

			$exam->execute_query($exam->data);

			$output = array(
				'success'	=>	'User Details has been changed'
			);

			echo json_encode($output);
			}
		}
		
		if($_POST['action'] == 'delete')
		{
			$exam->data = array(
				':user_id'	=>	$_POST['user_id']
			);

			$exam->query = "
			DELETE FROM user_table 
			WHERE user_id = :user_id
			";

			$exam->execute_query();

			$output = array(
				'success'	=>	'User Details has been removed'
			);

			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'exam_enroll')
	{
		if($_POST['action'] == 'fetch')
		{
			$output = array();

			$exam_id = $exam->Get_exam_id($_POST['code']);

			$exam->query = "
			SELECT * FROM user_exam_enroll_table 
			INNER JOIN user_table 
			ON user_table.user_id = user_exam_enroll_table.user_id  
			WHERE user_exam_enroll_table.exam_id = '".$exam_id."' 
			AND (
			";

			if(isset($_POST['search']['value']))
			{
				$exam->query .= '
				user_table.user_name LIKE "%'.$_POST["search"]["value"].'%" 
				';
				$exam->query .= 'OR user_table.user_gender LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR user_table.user_mobile_no LIKE "%'.$_POST["search"]["value"].'%" ';
				$exam->query .= 'OR user_table.user_email_verified LIKE "%'.$_POST["search"]["value"].'%" ';
			}
			$exam->query .= ') ';

			if(isset($_POST['order']))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY user_exam_enroll_table.user_exam_enroll_id ASC ';
			}

			$extra_query = '';

			if($_POST['length'] != -1)
			{
				$extra_query = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();

			$exam->query .= $extra_query;

			$result = $exam->query_result();

			$exam->query = "
			SELECT * FROM user_exam_enroll_table 
			INNER JOIN user_table 
			ON user_table.user_id = user_exam_enroll_table.user_id  
			WHERE user_exam_enroll_table.exam_id = '".$exam_id."'
			";

			$total_rows = $exam->total_row();

			$data = array();

			foreach($result as $row)
			{
				$sub_array = array();
				$sub_array[] = "<img src='../upload/".$row["user_image"]."' class='img-thumbnail' width='75' />";
				if($row["user_role"] == 'Teacher')
				{
					$user_role_icon = '<label class="badge badge-danger">Teacher</label>';
				}
				else
				{
					$user_role_icon = '<label class="badge badge-success">Student</label>';	
				}
				$sub_array[] = $user_role_icon;
				$sub_array[] = $row["user_name"];
				$sub_array[] = $row["user_gender"];
				
				$sub_array[] = $row["submit_exam_datetime"];
				$result = '';

				if($exam->Get_exam_status($exam_id) == 'Completed')
				{
					$result = '<a href="user_exam_result.php?code='.$_POST['code'].'&id='.$row['user_id'].'" class="btn btn-info btn-sm" target="_blank">Result</a>';
				}
				$sub_array[] = $result;

				$data[] = $sub_array;
			}

			$output = array(
				"draw"				=>	intval($_POST["draw"]),
				"recordsTotal"		=>	$total_rows,
				"recordsFiltered"	=>	$filtered_rows,
				"data"				=>	$data
			);

			echo json_encode($output);
		}
	}

	if($_POST['page'] == 'exam_result')
	{
		if($_POST['action'] == 'fetch')
		{
			$output = array();
			$exam_id = $exam->Get_exam_id($_POST["code"]);
			$exam->query = "
			SELECT user_table.user_id, user_table.user_image, user_table.user_name, sum(user_exam_question_answer.marks) as total_mark  
			FROM user_exam_question_answer  
			INNER JOIN user_table 
			ON user_table.user_id = user_exam_question_answer.user_id 
			WHERE user_exam_question_answer.exam_id = '$exam_id' 
			AND (
			";

			if(isset($_POST["search"]["value"]))
			{
				$exam->query .= 'user_table.user_name LIKE "%'.$_POST["search"]["value"].'%" ';
			}

			$exam->query .= '
			) 
			GROUP BY user_exam_question_answer.user_id 
			';

			if(isset($_POST["order"]))
			{
				$exam->query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
			}
			else
			{
				$exam->query .= 'ORDER BY total_mark DESC ';
			}

			$extra_query = '';

			if($_POST["length"] != -1)
			{
				$extra_query = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
			}

			$filtered_rows = $exam->total_row();

			$exam->query .= $extra_query;

			$result = $exam->query_result();

			$exam->query = "
			SELECT 	user_table.user_image, user_table.user_name, sum(user_exam_question_answer.marks) as total_mark  
			FROM user_exam_question_answer  
			INNER JOIN user_table 
			ON user_table.user_id = user_exam_question_answer.user_id 
			WHERE user_exam_question_answer.exam_id = '$exam_id' 
			GROUP BY user_exam_question_answer.user_id 
			ORDER BY total_mark DESC
			";

			$total_rows = $exam->total_row();

			$data = array();
			$total = 0;
			$count = 0;
			$test = 0;
			$max = -999;
			$min = 999;
			$result_median = array();
			$median = 0;
			foreach($result as $row)
			{
				$sub_array = array();
				$sub_array[] = '<img src="../upload/'.$row["user_image"].'" class="img-thumbnail" width="75" />';
				$sub_array[] = $row["user_name"];
				$sub_array[] = $exam->Get_user_exam_status($exam_id, $row["user_id"]);
				$sub_array[] = $row["total_mark"];
				$data[] = $sub_array;
				$total += $row["total_mark"];
				$count ++;
				$test = $row["total_mark"];
				if ($test >= $max){
				$max = $test;
				}
				if ($test <= $min){
				$min = $test;
				}
				$result_median[] = $row["total_mark"];
				
			}
				if ($count%2 == 0){
					$median = $result_median[$count/2-0.5] + $result_median[$count/2+0.5];
					$median = $median /2;
				}else {
					$median = $result_median[$count/2];
				}
				$sub_array = array();
				$sub_array[] = "Maximum";
				$sub_array[] = "Minimum";
				$sub_array[] = "Median";
				$sub_array[] = "Average";
				$data[] = $sub_array;
				
				$sub_array = array();
				$sub_array[] = $max;
				$sub_array[] = $min;
				$sub_array[] = number_format($median, 4, '.', '');
				$sub_array[] = number_format($total / $count, 4, '.', '');
				$data[] = $sub_array;
			$output = array(
				"draw"				=>	intval($_POST["draw"]),
				"recordsTotal"		=>	$total_rows,
				"recordsFiltered"	=>	$filtered_rows,
				"data"				=>	$data,
				"total"				=>	$total,
				"count"				=>	$count
			);

			echo json_encode($output);
		}
		

		
	}
}

?>