<?php
defined('BASEPATH') or exit('No direct script access allowed');

class New_Events1 extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$row = $this->session->userdata('user');

		if (empty($row['computer_code'])) {
			redirect(base_url('Login'));
		}
		$this->load->model('AdministratorM');
		$this->load->model('CounsellingM');
		$this->load->model('Mod_Common');
		$this->load->model('New_EventM');
	}
	/* For Class Coordinator Only*/
	public function index()
	{
		redirect(base_url('New_Events/sub_events'));
	}


	public function add_mst_question()
	{
		// echo "<pre>";
		// print_r($_POST);
		// echo '<br>';				
		// print_r($_FILES);
		// echo '<br>';				
		// die();
		if (!empty($_POST)) {
			if (empty($_FILES['attach_pdf'])) {
				$this->session->set_flashdata('no_question_mst', 'Please upload question paper for Event !! ');
				redirect(base_url('New_Events/sub_events'));
			} else {

				if ($_POST['event_name'] == "MST1") {
					$question_no = array();
					$question_no[0] = 1;
					$question_no[1] = 2;

					$max_marks_array = array();
					$max_marks_array[0] = 5;
					$max_marks_array[1] = 5;

					$co = array();
					$co[0] = "CO1";
					$co[1] = "CO2";

					$question = array();
					$question[0] = "";
					$question[1] = "";
				} else if ($_POST['event_name'] == "MST2") {
					$question_no = array();
					$question_no[0] = 1;
					$question_no[1] = 2;
					$question_no[2] = 3;

					$max_marks_array = array();
					$max_marks_array[0] = 5;
					$max_marks_array[1] = 5;
					$max_marks_array[2] = 5;

					$co = array();
					$co[0] = "CO3";
					$co[1] = "CO4";
					$co[2] = "CO5";

					$question = array();
					$question[0] = "";
					$question[1] = "";
					$question[2] = "";
				}

				$row = $this->session->userdata('user');
				$computer_code = $row['computer_code'];
				$date = $_POST['date'];
				$event_name = $_POST['event_name'];
				$section = $_POST['section'];
				$data = array(
					'event_category' => $_POST['event_type'],
					'event_name' => $_POST['event_name'],
					'section' => $_POST['section'],
					'subject' => $_POST['subject'],
					'academic_session' => $row['academic_id'],
					'faculty_computer_code' => $computer_code,
					'date_of_creation' => $_POST['date']
				);

				$max_marks = 0;
				for ($i = 0; $i < sizeof($max_marks_array); $i++) {

					$max_marks = $max_marks + $max_marks_array[$i];

				}

				if ($max_marks > 20) {

					$this->session->set_flashdata('error_mst_marks', 'MST Marks should not exceed 20 !!  MST is not created !!!  Please create again !!!');
					redirect(base_url('New_Events/sub_events'));
				} else {

					$event_info_id = $this->Mod_Common->insertData('event_info', $data);

					$i = 0;
					foreach ($question_no as $a) {
						$data1 = array(
							'event_info' => $event_info_id,
							'question_no' => $question_no[$i],
							'question' => $question[$i],
							'co' => $co[$i],
							'max_marks' => $max_marks_array[$i]
						);
						$check_1 = $this->Mod_Common->insertData('event_data', $data1);

						$i++;
					}

					$name = $date . "-" . $event_info_id . "-" . $event_name . "-" . $section . "-" . $computer_code . ".pdf";
					$file_tmp = $_FILES['attach_pdf']['tmp_name'];
					$doc_path = $name;
					$location = pathinfo(pathinfo(__DIR__, PATHINFO_DIRNAME), PATHINFO_DIRNAME);
					$location = $location . "/uploads/Event_Documents";
					$file_location = $location . "/" . $name;
					if (!is_dir('uploads/Event_Documents')) {
						mkdir("uploads/Event_Documents", 0777, true);
					}
					$Event_Status = $this->New_EventM->GetEventStatus($event_info_id);
					if (move_uploaded_file($file_tmp, $file_location)) {
						chmod($file_location, 0777);
						if (empty($Event_Status)) {
							$this->New_EventM->InsertEventDetails($event_info_id, $doc_path);
						} elseif (!empty($Event_Status)) {
							$this->New_EventM->UpdateEventDetails($event_info_id, $doc_path);
						}
					} else {
						$this->session->set_flashdata('not_upload', 'Something went wrong, Try again !!!');
					}

					if (!empty($_POST['submission_date'])) {
						$data2 = array('event_info' => $event_info_id, 'submission_date' => $_POST['submission_date']);
						$this->Mod_Common->insertData('event_ha_submission_date', $data2);

						if (($_SESSION['user']['department_id'] == 11)) {
							redirect(base_url('New_Assignment_Notification/Nstudent/') . $_POST['section'] . "/" . $_POST['subject'] . "/" . $_POST['event_name'] . "/" . $row['academic_id'] . "/" . $_POST['submission_date']);
						}
					}

				}

				if (1) {

					$this->session->set_flashdata('success_mst', 'Event Created Successfully');

					redirect(base_url('New_Events/sub_events'));
				}
			}
		} else {
			$this->session->set_flashdata('error_mst', 'Something Went wrong Plaese Try again !!');
			redirect(base_url('New_Events/sub_events'));
		}
	}

	public function add_home_assignment_question()
	{
		$row = $this->session->userdata('user');
		$current_session_id=$row['current_session_id'];
		$faculty_computer_code = $row['computer_code'];
		$home_dept = $row['department_id'];
		$data = $this->New_EventM->get_year_current($current_session_id,$home_dept);
		$specialization = 0;
		$semester = $row['semester_array'][$data[0]['year'] - 1];
		$marks=$this->New_EventM->get_marks($_POST['subject'],$current_session_id,$semester);
		// echo "<pre>";
		// print_r($marks);
		// echo "<br>";
		// print_r($_FILES);
		// die();
		
		if (!empty($_POST)) {
			if (empty($_FILES['attach_pdf'])) {
				$this->session->set_flashdata('no_question_mst', 'Please upload question paper for Event!! ');
				redirect(base_url('New_Events/sub_events'));
			} else {
				$max_marks = 0;
				if ($_POST['event_name'] == "H1") {
					$question_no = 1;
					$max_marks = $marks['assignment']/5;
					$co = "CO1";
					$question = "";
				} else if ($_POST['event_name'] == "H2") {
					$question_no = 1;
					$max_marks = $marks['assignment']/5;
					$co = "CO2";
					$question = "";
				} else if ($_POST['event_name'] == "H3") {
					$question_no = 1;
					$max_marks = $marks['assignment']/5;
					$co = "CO3";
					$question = "";
				} else if ($_POST['event_name'] == "H4") {
					$question_no = 1;
					$max_marks = $marks['assignment']/5;
					$co = "CO4";
					$question = "";
				} else if ($_POST['event_name'] == "H5") {
					$question_no = 1;
					$max_marks = $marks['assignment']/5;
					$co = "CO5";
					$question = "";
				}

				$row = $this->session->userdata('user');
				$computer_code = $row['computer_code'];
				$date = $_POST['date'];
				$event_name = $_POST['event_name'];
				$section = $_POST['section'];
				$data = array(
					'event_category' => $_POST['event_type'],
					'event_name' => $_POST['event_name'],
					'section' => $_POST['section'],
					'subject' => $_POST['subject'],
					'academic_session' => $row['academic_id'],
					'faculty_computer_code' => $computer_code,
					'date_of_creation' => $_POST['date']
				);

				if ($max_marks > $marks['assignment']) {

					$this->session->set_flashdata('error_ha_marks', 'Home Assignment Marks should not exceed 10 !! Home Assignment is not created !! Please create again !!!');
					redirect(base_url('New_Events/sub_events'));
				} else {

					$event_info_id = $this->Mod_Common->insertData('event_info', $data);
					$data1 = array(
						'event_info' => $event_info_id,
						'question_no' => $question_no,
						'question' => $question,
						'co' => $co,
						'max_marks' => $max_marks
					);
					$check_1 = $this->Mod_Common->insertData('event_data', $data1);

					$name = $date . "-" . $event_info_id . "-" . $event_name . "-" . $section . "-" . $computer_code . ".pdf";
					$file_tmp = $_FILES['attach_pdf']['tmp_name'];
					$doc_path = $name;
					$location = pathinfo(pathinfo(__DIR__, PATHINFO_DIRNAME), PATHINFO_DIRNAME);
					$location = $location . "/uploads/Event_Documents";
					$file_location = $location . "/" . $name;
					if (!is_dir('uploads/Event_Documents')) {
						mkdir("uploads/Event_Documents", 0777, true);
					}
					$Event_Status = $this->New_EventM->GetEventStatus($event_info_id);
					if (move_uploaded_file($file_tmp, $file_location)) {
						chmod($file_location, 0777);
						if (empty($Event_Status)) {
							$this->New_EventM->InsertEventDetails($event_info_id, $doc_path);
						} elseif (!empty($Event_Status)) {
							$this->New_EventM->UpdateEventDetails($event_info_id, $doc_path);
						}
					} else {
						$this->session->set_flashdata('not_upload', 'Something went wrong, Try again !!!');
					}

					if (!empty($_POST['submission_date'])) {
						$data2 = array('event_info' => $event_info_id, 'submission_date' => $_POST['submission_date']);
						$this->Mod_Common->insertData('event_ha_submission_date', $data2);

						if (($_SESSION['user']['department_id'] == 11)) {
							redirect(base_url('New_Assignment_Notification/Nstudent/') . $_POST['section'] . "/" . $_POST['subject'] . "/" . $_POST['event_name'] . "/" . $row['academic_id'] . "/" . $_POST['submission_date']);
						}
					}

				}

				if ($check_1) {

					$this->session->set_flashdata('success_mst', 'Event Created Successfully');

					redirect(base_url('New_Events/sub_events'));
				}
			}
		} else {
			$this->session->set_flashdata('error_mst', 'Something Went wrong Plaese Try again !!');
			redirect(base_url('New_Events/sub_events'));
		}
	}



	// ************************************** Add end sem event ***************************************************************

	public function add_endsem()
	{

		if (!empty($_POST)) {
			// if(empty($_POST['question_no']))
			// {
			//  $this->session->set_flashdata('no_question_mst', 'Please Enter Questions for Test!! ');
			//  redirect(base_url('New_Events/sub_events'));
			// }  
			// else

			$row = $this->session->userdata('user');
			$computer_code = $row['computer_code'];
			$data = array(
				'event_category' => $_POST['event_type'],
				'event_name' => $_POST['event_name'],
				'section' => $_POST['section'],
				'subject' => $_POST['subject'],
				'academic_session' => $row['academic_id'],
				'faculty_computer_code' => $computer_code,
				'date_of_creation' => $_POST['date']
			);

			// print_r($_POST);die();             
			$event_info_id = $this->Mod_Common->insertData('event_info', $data);
			$lock_endsem = $this->New_EventM->insert_lock_endsem($data['faculty_computer_code'], $row['department_id'], $data['academic_session'], $data['section'], $data['event_category']);

			$data1 = array(
				'event_info' => $event_info_id,
				'question_no' => " ",
				'question' => " ",
				'co' => " ",
				'max_marks' => " "
			);
			$check_1 = $this->Mod_Common->insertData('event_data', $data1);



			if (1) {

				$this->session->set_flashdata('success_mst', 'Event Created Successfully');

				redirect(base_url('New_Events/sub_events'));
			}

		} else {
			$this->session->set_flashdata('error_mst', 'Something Went wrong Plaese Try again !!');
			redirect(base_url('New_Events/sub_events'));
		}

	}


	// *****************************************************************************************************************************************



	public function delete_event($event_info_id)
	{
		$event_info = base64_decode($event_info_id);

		$this->load->model('New_AssignmentM');
		$event_category_check = $this->New_AssignmentM->GET_Category($event_info);

		if ($event_category_check[0]['event_category'] == 6 || $event_category_check[0]['event_category'] == 7 || $event_category_check[0]['event_category'] == 8) {
			$flag = 1;
		} else {
			$flag = 0;
		}

		$row = $this->Mod_Common->selectData($fields = '*', 'event_data', $condition = array('event_info' => $event_info), $limit = '', $start = '');

		$i = 1;
		if (!empty($row)) {
			foreach ($row as $r)
				$arr[$i] = $r->event_data_id;
			$c1 = $this->Mod_Common->deleteData('event_marks', $condition = array('event_data' => $arr[$i]));
			$i++;
		}

		$c2 = $this->Mod_Common->deleteData('event_data', $condition = array('event_info' => $event_info));
		$c3 = $this->Mod_Common->deleteData('event_info', $condition = array('event_info_id' => $event_info));
		if ($event_category_check[0]['event_category'] == 8) {
			$c4 = $this->Mod_Common->deleteData('event_practical_group_date', $condition = array('event_info' => $event_info));
		}
		if ($c1 && $c2 && $c3) {

			$this->load->model('New_AssignmentM');

			if ($flag == 1) {
				// ************* New Code for deleting event documents  *******************

				$file_name = $this->New_AssignmentM->GET_Events_files($event_info);
				$filename = $file_name[0]['document_name'];
				$path = base_url('/uploads/Event_Documents/' . $filename);
				// chmod($path, 0644);
				unlink($path);
				$this->New_AssignmentM->Delete_event_file($event_info);

				// ************************************************************************************
// ************* Previous Code for deleting home assignment documents  *******************
				//   	if (!(empty($row))) {

				//   	foreach ($row as $ans) {

				//   		if (!(empty($ans->event_data_id))) {

				//   		//echo $ans->event_data_id; echo "<br>";
				//   		$delete_files=$this->New_AssignmentM->GET_Ext_files($ans->event_data_id);
				//   		//print_r($delete_files);echo "<br>";

				//   		foreach ($delete_files as $val) {

				//   			//echo $val['path'];echo "<br>";

				//   			if (!(empty($val['path']))) {

				//   				unlink($val['path']);
				//   			}
				//   			if (!(empty($val['img_path']))) {

				//   				unlink($val['img_path']);
				//   			}

				//   		}

				//   			$this->New_AssignmentM->Delect_assign_file($ans->event_data_id);

				//   	 }	

				//   	}
				//   }
				// ************************************************************************
			}
			$this->session->set_flashdata('event_deleted', 'Event Deleted');
			return redirect(base_url('New_Events/sub_events'));

		}
	}
	public function print_event($event_info_id)
	{
		$event_info = base64_decode($event_info_id);
		$row = $this->session->userdata('user');
		$academic_session = $row['academic_id'];

		$data['student_marks'] = $this->New_EventM->print_data($event_info, $academic_session);
		$data['sheet_details'] = $this->New_EventM->sheet_details($event_info);

		$specialization = $data['sheet_details'][0]->specialization;
		if ($specialization != 0) {
			$specialization_name = $this->New_EventM->get_specialization_name($specialization);
			$data['specialization'] = $specialization_name[0]['name'];
		}
		$data['semester_details'] = $this->New_EventM->semester_details($data['student_marks'][0]->batch_id);
		$event_category = $data['student_marks'][0]->event_category;

		if ($event_category == 9 || $event_category == 10 || $event_category == 11) {
			$data['student_endsem'] = array();
			$i = 0;
			foreach ($data['student_marks'] as $stu) {
				$computer_code = $stu->computer_code;
				$enrollment_no = $stu->enrollment_no;
				$batch_id = $stu->batch_id;
				$event_info_id = $stu->event_info_id;
				$academic_session = $stu->academic_session;
				$college_subject_code = $stu->subject;
				$student_name = $stu->student_name;

				$data['student_endsem'][$i] = $this->New_EventM->get_endsem_details($computer_code, $enrollment_no, $batch_id, $event_info_id, $college_subject_code, $academic_session);
				$data['student_endsem'][$i]['student_name'] = $student_name;
				$data['student_endsem'][$i]['enrollment_no'] = $enrollment_no;
				$i++;
			}

			// echo "<pre>";
			// print_r($data['student_marks']);
			// exit();

			if ($data['student_endsem'][0][0]['subject_type'] == 'T') {
				if ($specialization == 0) {
					$this->load->view('new_events/new_event_endsem_theory_print', $data);
				} else {
					$this->load->view('new_events/new_event_endsem_theory_print_mtech', $data);
				}

			} else if ($data['student_endsem'][0][0]['subject_type'] == 'P') {
				if ($specialization == 0) {
					$this->load->view('new_events/new_event_endsem_practical_print', $data);
				} else {
					$this->load->view('new_events/new_event_endsem_practical_print_mtech', $data);
				}
			} else if ($data['student_endsem'][0][0]['subject_type'] == 'E') {
				if ($specialization == 0) {
					$this->load->view('new_events/new_event_endsem_extra_print', $data);
				} else {
					$this->load->view('new_events/new_event_endsem_extra_print_mtech', $data);
				}
			} else if ($data['student_endsem'][0][0]['subject_type'] == 'MC') {
				if ($specialization == 0) {
					$this->load->view('new_events/new_event_endsem_mc_print', $data);
				} else {
					$this->load->view('new_events/new_event_endsem_mc_print_mtech', $data);
				}
			}



		} else {
			// echo "<pre>";
			// print_r($data);
			// die();
			$data['question'] = $this->Mod_Common->selectData($fields = '*', 'event_data', $condition = array('event_info' => $event_info), $limit = '', $start = '');
			if ($specialization == 0) {
				$this->load->view('new_events/new_event_print', $data);
			} else {
				$this->load->view('new_events/new_event_print_mtech', $data);
			}

		}
	}

	public function event_questions_practical($event_info_id)
	{
		$event_info = base64_decode($event_info_id);
		$row = $this->session->userdata('user');
		$session = $row['academic_id'];
		$data['event_questions'] = $this->Mod_Common->selectData($fields = '*', 'event_data', $condition = array('event_info' => $event_info), $limit = '', $start = '');
		$sub = $this->Mod_Common->selectData($fields = 'subject', 'event_info', $condition = array('event_info_id' => $event_info), $limit = '', $start = '');
		if (!empty($sub))
			foreach ($sub as $s) {
				$subject = $s->subject;
			}
		$data['co_number'] = $this->New_EventM->get_co($subject, $session);
		// echo "<pre>";
		// print_r($data);
		// exit();
		$this->load->view('new_template/faculty_common');
		$this->load->view('new_events/new_upload_questions_practical', $data);
		$this->load->view('new_template/new_footer');
	}

	public function event_questions($event_info_id)
	{
		$event_info = base64_decode($event_info_id);
		$row = $this->session->userdata('user');
		$session = $row['academic_id'];
		$data['question_paper'] = $this->New_EventM->getEventDocumentName($event_info);

		$sub = $this->Mod_Common->selectData($fields = 'subject', 'event_info', $condition = array('event_info_id' => $event_info), $limit = '', $start = '');
		if (!empty($sub))
			foreach ($sub as $s) {
				$subject = $s->subject;
			}

		$data['event_info_id'] = $event_info_id;

		$this->load->view('new_template/faculty_common');
		$this->load->view('new_events/new_upload_questions', $data);
		$this->load->view('new_template/new_footer');
	}

	public function upload_question()
	{
		$row = $this->session->userdata('user');
		$computer_code = $row['computer_code'];
		if (!empty($_POST) && !empty($_FILES)) {
			$event_info_id = base64_decode($_POST['event_info_id']);
			$question_paper = $this->New_EventM->getEventDocumentName($event_info_id);
			$name = $question_paper[0]['document_name'];
			$file_tmp = $_FILES['event_document']['tmp_name'];
			$doc_path = $name;
			$location = pathinfo(pathinfo(__DIR__, PATHINFO_DIRNAME), PATHINFO_DIRNAME);
			$location = $location . "/uploads/Event_Documents";
			$file_location = $location . "/" . $name;
			if (!is_dir('uploads/Event_Documents')) {
				mkdir("uploads/Event_Documents", 0777, true);
			}
			$path = base_url('/uploads/Event_Documents/' . $name);
			unlink($path);
			if (move_uploaded_file($file_tmp, $file_location)) {
				$this->session->set_flashdata('upload', 'Event Document Uploaded Successfully');
			} else {
				$this->session->set_flashdata('not_upload', 'Something went wrong, Try again !!!');
			}
			redirect(base_url('New_events1/event_questions/') . $_POST['event_info_id']);
		} else {
			redirect(base_url('New_Events/sub_events'));
		}


		// ************ Previous Code ************************
		//echo $_POST['question_document'];
		// $name = $_FILES['question_document']['name'];
		// $path_info = pathinfo($name);
		// if($path_info['extension']=="pdf" || $path_info['extension']=="jpg" || $path_info['extension']=="jpeg" || $path_info['extension']=="png")
		// {
		// $tmp_name =  $_FILES['question_document']['tmp_name'];
		// $location = pathinfo(pathinfo(__DIR__,PATHINFO_DIRNAME),PATHINFO_DIRNAME);
		// $location = $location."/uploads/events";
		// $date = date("YmdHis");
		// $img_name = $date.".".$path_info['extension'];
		// $new_name = $location."/".$img_name;

		// $document = array('event_info_id'=>$event_info_id, 'document_name'=>$img_name);
		// $this->Mod_Common->insertData('event_question_uploads', $document);
		// if (move_uploaded_file($tmp_name, $new_name))
		// {
		//   $this->session->set_flashdata('event_quest_uploaded', 'Event Question Uploaded Successfully ');
		// }

		// else
		// {			  
		// 	$this->session->set_flashdata('event_quest_not_uploaded', 'Event Question not Uploaded.Please upload again');
		// }

		// }
		// redirect(base_url('New_Events/sub_events'));
	}

	public function delete_question($event_info_id)
	{
		$event_info = base64_decode($event_info_id);
		$data['event_questions'] = $this->Mod_Common->selectData($fields = '*', 'event_question_uploads', $condition = array('event_info_id' => $event_info), $limit = '', $start = '');
		$this->load->view('new_template/faculty_common');
		$this->load->view('new_events/new_delete_questions', $data);
		$this->load->view('new_template/new_footer');
	}

	public function view_question($event_info_id)
	{
		$event_info = base64_decode($event_info_id);
		$data['event_questions'] = $this->Mod_Common->selectData($fields = '*', 'event_question_uploads', $condition = array('event_info_id' => $event_info), $limit = '', $start = '');
		$this->load->view('new_template/faculty_common');
		$this->load->view('new_events/new_view_questions', $data);
		$this->load->view('new_template/new_footer');
	}

	public function delete_question_pic($pic)
	{
		$event_pic = base64_decode($pic);
		$location = pathinfo(pathinfo(__DIR__, PATHINFO_DIRNAME), PATHINFO_DIRNAME);
		$location = dirname(__FILE__, 3) . "/uploads/events";
		$c2 = unlink($location . "/" . $event_pic);
		if (!($c2)) {
			$this->session->set_flashdata('event_pic_not_deleted', 'Event Question Image not Deleted.Please delete again');
		} else {
			$c1 = $this->Mod_Common->deleteData('event_question_uploads', $condition = array('document_name' => $event_pic));
			if ($c1)
				$this->session->set_flashdata('event_pic_deleted', 'Event Question Image Deleted');
		}
		redirect(base_url('New_Events/sub_events'));
	}
	public function edit_event_question($event_data_id)
	{
		$event_data = base64_decode($event_data_id);
		$row = $this->session->userdata('user');
		$session = $row['academic_id'];

		$data['event_details'] = $this->Mod_Common->selectData($fields = '*', 'event_data', $condition = array('event_data_id' => $event_data), $limit = '', $start = '');

		$subject = $this->New_EventM->get_subject_co($event_data);
		if (!empty($subject))
			foreach ($subject as $s) {
				$sub = $s->subject;
			}
		$data['co_number'] = $this->New_EventM->get_co($sub, $session);

		$this->load->view('new_template/faculty_common');
		$this->load->view('new_events/new_edit_event_questions', $data);
		$this->load->view('new_template/new_footer');
	}

	public function event_question_updated()
	{
		$c = $this->Mod_Common->updateData('event_data', $condition = array('event_data_id' => $_POST['event_data_id']), $data = array('co' => $_POST['co'], 'question_no' => $_POST['question_no'], 'question' => $_POST['question'], 'max_marks' => $_POST['max_marks']));

		if ($c) {
			$this->session->set_flashdata('event_quest_updated', 'Event Question Updated');
		} else {
			$this->session->set_flashdata('event_quest_not_updated', 'Event Question Not Updated. Please try again');
		}
		redirect(base_url('New_Events/sub_events'));

	}


}