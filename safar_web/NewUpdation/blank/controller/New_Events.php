<?php
defined('BASEPATH') or exit('No direct script access allowed');

class New_Events extends CI_Controller
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
	public function fill_marks_combined_ha($section, $subject, $event_id)
	{
		$academic_session = $_SESSION['user']['academic_id'];
		$data['student_list'] = $this->New_EventM->student_list_sheet($section, $academic_session);
		$data['event_info'] = $this->Mod_Common->selectData($fields = '*', 'event_info', $condition = array('section' => $section, 'subject' => $subject, 'event_category' => 7), $limit = '', $start = '');
		$data['section_check'] = array($section);
		$this->load->view('new_template/faculty_common');
		$this->load->view('new_events/new_fill_marks_combined_ha', $data);
		$this->load->view('new_template/new_footer');

	}
	public function edit_event($event_info_id, $section_name)
	{
		$event_info_id = base64_decode($event_info_id);
		$section_name = base64_decode($section_name);

		$row = $this->Mod_Common->selectData($fields = '*', 'event_info', $condition = array('event_info_id' => $event_info_id), $limit = '', $start = '');
		foreach ($row as $r) {
			$event_category = $r->event_category;
			$event_name = $r->event_name;
			$date_of_creation = $r->date_of_creation;
		}

		if ($event_category == 1 || $event_category == 2 || $event_category == 3 || $event_category == 4 || $event_category == 5 || $event_category == 6 || $event_category == 7 || $event_category == 8)
			$this->edit_event_name($event_info_id, $section_name, $event_name, $date_of_creation, $event_category);

	}

	public function edit_event_name($event_info_id, $section_name, $event_name, $date_of_creation, $event_category)
	{
		$data['section_name'] = $section_name;
		$data['event_name'] = $event_name;
		$data['date_of_creation'] = $date_of_creation;
		$data['event_info_id'] = $event_info_id;
		$data['event_category'] = $event_category;
		$this->load->view('new_template/faculty_common');
		$this->load->view('new_events/new_edit_event_name', $data);
		$this->load->view('new_template/new_footer');
	}

	public function save_edited_name()
	{
		if (!empty($_POST)) {
			$data = array('event_name' => $_POST['event_name'], 'date_of_creation' => $_POST['date']);
			$condition = array('event_info_id' => $_POST['event_info']);
			$a = $this->Mod_Common->updateData('event_info', $condition, $data);
			if ($a) {
				$this->session->set_flashdata('success', 'Event Updated Successfully');
				redirect(base_url('New_Events/sub_events'));
			} else {
				$this->session->set_flashdata('fail', 'Event Not Updated. Please try again');
				redirect(base_url('New_Events/sub_events'));
			}

		}
	}


	public function sub_events()
	{

		$row = $this->session->userdata('user');

		if ($row['permanent_sub'] == 1) {
			$computer_code = $row['computer_code'];
			$academic_session = $row['academic_id'];
			$department = $row['department_id'];

			$data['batch_names'] = $this->New_EventM->find_batch_sub($computer_code, $academic_session);

			$i = 0;
			foreach ($data['batch_names'] as $b) {
				$batch_id = $b['batch_id'];
				$check = $this->New_EventM->get_faculty_lock_status_endsem($batch_id, $computer_code, $academic_session, $department);

				if (!empty($check)) {
					$data['batch_names'][$i]['endsem_lock'] = $check[0]['lock_marks'];
				} else {
					$data['batch_names'][$i]['endsem_lock'] = 0;
				}
				$i++;
			}

			$data['type'] = "subject_coordinator";

			//   $status = $this->New_EventM->get_all_modules();
			//   $data['endsem'] = $status[0]['active'];
			//   $data['sessional'] = $status[1]['active'];

			$i = 0;
			foreach ($data['batch_names'] as $b) {
				$status = $this->New_EventM->get_all_modules($b['course'], $b['semester']);
				// echo"<pre>";print_r($status);die();
				// $j=$status[$i]['department'];
				$j = 0;
				foreach ($status as $s) {
					if ($data['batch_names'][$i]['department'] == $s['department']) {
						$data['batch_names'][$i]['department'] = $s;
					}
					$j++;
				}
				$i++;
			}
			//  echo "<pre>";
			//  print_r($data);
			//  die();
			$this->load->view('new_template/faculty_common');
			$this->load->view('new_events/new_create_event', $data);
			$this->load->view('new_template/new_footer');
		} else {
			redirect(base_url('FacultyCommon'));
		}
	}

	public function get_subject_type()
	{
		if (isset($_GET['id'])) {

			$endsem = $_GET['endsem'];
			$sessional = $_GET['sessional'];
			//   echo"<pre>";print_r($_GET);die();
			//   $subject_id = urldecode($_GET['id']);
			$batch_id = urldecode($_GET['id']);
			//    echo $subject_id;
			//    die();
			//   $subject = $this->Mod_Common->selectData($fields='*', 'subject_new' , $condition=array('clg_sub_code'=>$subject_id), $limit='',$start='');
			$subject = $this->Mod_Common->selectData($fields = '*', 'subject_batch', $condition = array('batch_id' => $batch_id), $limit = '', $start = '');
			// $subject = $this->New_EventsM->getEvents($batch_id,$endsem,$sessional);
			// print_r($subject); 
			if ($subject) {

				foreach ($subject as $f)
				//$year = $this->New_EventM->get_year($f->semester);
				{
					if ($f->type == "T" || $f->type == "P") {
						//   $event = $this->Mod_Common->selectData($fields='*', 'event_category' , $condition=array('lecture'=>$f->type,'active'=>1), $limit='',$start='');
						$event = $this->New_EventM->getEventCategory($f->type, $f->batch_id, $f->semester);
						// echo"<pre>";print_r($event);die();
						$event_type = "";
						foreach ($event as $e) {
							if ($e['endsem_module'] == 1 && $e['lecture'] == "T" && $e['event_category_id'] == 9) {
								$event_type = " (Theory)";
								echo '<option value="' . $e['event_category_id'] . '">' . $e['event_category_name'] . $event_type;
								'</option>';
							} else if ($e['endsem_module'] == 1 && $e['lecture'] == "P" && $e['event_category_id'] == 10) {
								$event_type = " (Practical)";
								echo '<option value="' . $e['event_category_id'] . '">' . $e['event_category_name'] . $event_type;
								'</option>';
							} else if ($e['endsem_module'] == 1 && $e['lecture'] == "P" && $e['event_category_id'] == 11) {
								$event_type = " (MC)";
								echo '<option value="' . $e['event_category_id'] . '">' . $e['event_category_name'] . $event_type;
								'</option>';
							} else if ($e['sessional_module'] == 1 && $e['lecture'] == "T" && $e['event_category_id'] == 6) {
								$event_type = " (Theory)";
								echo '<option value="' . $e['event_category_id'] . '">' . $e['event_category_name'] . $event_type;
								'</option>';
							} else if ($e['sessional_module'] == 1 && $e['lecture'] == "T" && $e['event_category_id'] == 7) {
								$event_type = " (Theory)";
								echo '<option value="' . $e['event_category_id'] . '">' . $e['event_category_name'] . $event_type;
								'</option>';
							} else if ($e['sessional_module'] == 1 && $e['lecture'] == "P" && $e['event_category_id'] == 8) {
								$event_type = " (Practical)";
								echo '<option value="' . $e['event_category_id'] . '">' . $e['event_category_name'] . $event_type;
								'</option>';
							}
						}

					} else if ($f->type == "B") {
						//   $event = $this->Mod_Common->selectData($fields='*', 'event_category' , $condition=array(), $limit='',$start='');
						//    $event_type="";
						$event = $this->New_EventM->selectEvent();
						//    echo "<pre>";
						//    print_r($event);
						//    die();
						foreach ($event as $e) {
							if ($e['lecture'] == "T")
								$event_type = " (Theory)";
							else if ($e['lecture'] == "P")
								$event_type = " (Practical)";
							echo '<option value="' . $e['event_category_id'] . '">' . $e['event_category_name'] . $event_type;
							'</option>';
						}
					} else if ($f->type == "E") {
						$event = $this->Mod_Common->selectData($fields = '*', 'event_category', $condition = array('lecture' => 'P', 'active' => 1), $limit = '', $start = '');
						$event_type = "";
						foreach ($event as $e) {
							if ($e->lecture == "T")
								$event_type = " (Theory)";
							else if ($e->lecture == "P")
								$event_type = " (Practical)";
							echo '<option value="' . $e->event_category_id . '">' . $e->event_category_name . $event_type;
							'</option>';
						}
					} else if ($f->type == "MCT" || $f->type == "MCP") {
						$event = $this->Mod_Common->selectData($fields = '*', 'event_category', $condition = array('lecture' => 'MC', 'active' => 1), $limit = '', $start = '');

						$event_type = "";
						foreach ($event as $e) {
							if ($e->lecture == "MC")
								$event_type = " (Mandatory Course)";
							echo '<option value="' . $e->event_category_id . '">' . $e->event_category_name . $event_type;
							'</option>';
						}
					}


				}

			}
		} else {
			$this->session->set_flashdata('error', 'Some Error Occured. Please Try Again!! ');
			redirect(base_url('New_Events/sub_events'));
		}
	}
	//**************************************************
	//      section in this code reffers to batch id
	//		batch  refers batch name
	//*************************************************
	public function event_handler()
	{

		$section_id = $_POST['section_name'];
		$arr = explode('->', $section_id);
		$section = $arr[0];
		$subject = $arr[1];
		$batch = $arr[2];
		$event = $_POST['event'];
		// print_r(expression)
		// if($event==1)
		// 	$this->Nba_other($section,$subject,$event);
		// else if($event==2 || $event==3)
		// 	$this->university_result($section,$subject,$event);

		// else if($event==4 || $event==5)
		// 	$this->teacher_assessment($section,$subject,$event,$batch);

		if ($event == 6)
			$this->test($section, $subject, $event, $batch);
		else if ($event == 7)
			$this->home_assignment($section, $subject, $event, $batch);
		else if ($event == 8)
			$this->practical_experiment($section, $subject, $event);
		else if ($event == 9)
			$this->end_sem_theory($section, $subject, $event, $batch);
		else if ($event == 10)
			$this->end_sem_practical($section, $subject, $event, $batch);
		else if ($event == 11)
			$this->end_sem_mc($section, $subject, $event, $batch);

	}
	//  public function Nba_other($section,$subject,$event)
	// {

	// 	  $data['section'] =  $section;
	//        $data['subject'] = $subject;
	//        $data['event'] =  $event;
	//        $row = $this->session->userdata('user'); 
	//       $computer_code = $row['computer_code'];
	//  $academic_session = $row['academic_id'];
	//  $data['section_names'] = $this->New_EventM->find_section_name($computer_code, $academic_session, $section, $subject);

	// 	  $this->load->view('new_template/faculty_common');
	//  $this->load->view('new_events/new_nba_event', $data);
	//  $this->load->view('new_template/new_footer');
	// }

	//  public function university_result($section,$subject,$event)
	// {
	// 	  $data['section'] =  $section;
	//        $data['subject'] = $subject;
	//        $data['event'] =  $event;
	//        // print_r($data);die();
	//        $row = $this->session->userdata('user'); 
	//        $computer_code = $row['computer_code'];
	//  $academic_session = $row['academic_id'];
	//  $data['section_names'] = $this->New_EventM->find_section_name($computer_code, $academic_session, $section, $subject);
	//         // print_r($data);die();
	// 	  $this->load->view('new_template/faculty_common');
	//  $this->load->view('new_events/new_university_result', $data);
	//  $this->load->view('new_template/new_footer');
	// }


	public function test($section, $subject, $event, $batch)
	{
		$data['section'] = $section;
		$data['subject'] = $subject;
		$data['event'] = $event;
		$data['batch'] = $batch;
		$row = $this->session->userdata('user');
		$computer_code = $row['computer_code'];
		$academic_session = $row['academic_id'];
		$data['co_number'] = $this->New_EventM->get_co($subject, $academic_session);
		$data['sub_events'] = $this->New_EventM->fetch_detail_mst($academic_session, $computer_code, $section);
		// echo "<pre>";
		// print_r($data['sub_events']);
		// die();
		$data['mst1'] = 0;
		$data['mst2'] = 0;
		foreach ($data['sub_events'] as $sub) {
			if ($sub['event_name'] == 'MST1') {
				$data['mst1'] = 1;
			} else if ($sub['event_name'] == 'MST2') {
				$data['mst2'] = 1;
			}

		}
		$this->load->view('new_template/faculty_common');
		$this->load->view('new_events/new_test', $data);
		$this->load->view('new_template/new_footer');
	}

	public function end_sem_theory($section, $subject, $event, $batch)
	{
		$data['section'] = $section;
		$data['subject'] = $subject;
		$data['event'] = $event;

		$data['batch'] = $batch;
		$row = $this->session->userdata('user');
		$computer_code = $row['computer_code'];
		$academic_session = $row['academic_id'];
		$data['co_number'] = $this->New_EventM->get_co($subject, $academic_session);
		$data['sub_events'] = $this->New_EventM->fetch_detail_end_sem_theory($academic_session, $computer_code, $section);

		$check = $this->New_EventM->checkEndSem($event, $section, $subject, $computer_code, $academic_session);
		if (!empty($check)) {
			$this->session->set_flashdata('success', 'Event Already Created');
			redirect(base_url('New_Events/sub_events'));
		} else {
			$this->load->view('new_template/faculty_common');
			$this->load->view('new_events/new_endsem_theory', $data);
			$this->load->view('new_template/new_footer');
		}

	}

	public function end_sem_practical($section, $subject, $event, $batch)
	{
		$data['section'] = $section;
		$data['subject'] = $subject;
		$data['event'] = $event;
		//   echo $event;
		//   die();
		$data['batch'] = $batch;
		$row = $this->session->userdata('user');
		$computer_code = $row['computer_code'];
		$academic_session = $row['academic_id'];
		$data['co_number'] = $this->New_EventM->get_co($subject, $academic_session);
		$data['sub_events'] = $this->New_EventM->fetch_detail_end_sem_practical($academic_session, $computer_code, $section);

		$check = $this->New_EventM->checkEndSem($event, $section, $subject, $computer_code, $academic_session);
		if (!empty($check)) {
			$this->session->set_flashdata('success', 'Event Already Created');
			redirect(base_url('New_Events/sub_events'));
		} else {
			$this->load->view('new_template/faculty_common');
			$this->load->view('new_events/new_endsem_practical', $data);
			$this->load->view('new_template/new_footer');
		}

	}

	public function end_sem_mc($section, $subject, $event, $batch)
	{
		$data['section'] = $section;
		$data['subject'] = $subject;
		$data['event'] = $event;
		$data['batch'] = $batch;
		$row = $this->session->userdata('user');
		$computer_code = $row['computer_code'];
		$academic_session = $row['academic_id'];
		//   $data['co_number'] = $this->New_EventM->get_co($subject,$academic_session);
		$data['sub_events'] = $this->New_EventM->fetch_detail_end_sem_mc($academic_session, $computer_code, $section);
		// print_r($data['sub_events']);
		// die();
		$check = $this->New_EventM->checkEndSem($event, $section, $subject, $computer_code, $academic_session);
		if (!empty($check)) {
			$this->session->set_flashdata('success', 'Event Already Created');
			redirect(base_url('New_Events/sub_events'));
		} else {
			$this->load->view('new_template/faculty_common');
			$this->load->view('new_events/new_endsem_mc', $data);
			$this->load->view('new_template/new_footer');
		}
	}
	// public function teacher_assessment($section,$subject,$event,$batch)
	// {
	// 	  $data['section'] =  $section;
	//        $data['subject'] = $subject;
	//        $data['event'] =  $event; 
	//        $data['batch'] =  $batch; 
	//        $row = $this->session->userdata('user'); 
	//       $computer_code = $row['computer_code'];
	//  $academic_session = $row['academic_id'];
	//  $data['section_names'] = $this->New_EventM->find_section_name($computer_code, $academic_session, $section, $subject);

	//        $this->load->view('new_template/faculty_common');
	//  $this->load->view('new_events/new_teacher_assessment', $data);
	//  $this->load->view('new_template/new_footer');
	// }
	public function create_practical_experiment()
	{

		$row = $this->session->userdata('user');
		$computer_code = $row['computer_code'];

		$event_category = $_POST['event_type'];
		$section = $_POST['section'];
		$subject = $_POST['subject'];
		$date = $_POST['date'];
		$academic_session = $row['academic_id'];


		if (empty($_FILES['attach_pdf'])) {
			$this->session->set_flashdata('no_question_mst', 'Please upload question paper for Event !! ');
			redirect(base_url('New_Events/sub_events'));
		} else {

			$data = array(
				'event_category' => $event_category,
				'event_name' => 'Practical',
				'section' => $section,
				'subject' => $subject,
				'academic_session' => $academic_session,
				'faculty_computer_code' => $computer_code,
				'date_of_creation' => $date
			);

			$event_info_id = $this->Mod_Common->insertData('event_info', $data);

			$max_marks = $this->New_EventM->getMaxMarks($subject, $academic_session, $section);
			$marks = $max_marks / 5;
			$question_no = array();
			$max_marks_array = array();
			$co = array();
			$question = array();

			for ($i = 1; $i <= 5; $i++) {
				$question_no[$i] = $i;

				$max_marks_array[$i] = $marks;

				$co[$i] = "CO" . $i;

				$question[$i] = "";
			}

			$i = 1;
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


			$name = $date . "-" . $event_info_id . "-P-" . $section . "-" . $computer_code . ".pdf";
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


			$practical = array();
			for ($i = 1; $i <= 15; $i++) {
				$temp = "";
				for ($j = 1; $j <= 5; $j++) {
					$p = 'P' . $i;
					$co = 'CO' . $j;
					$key = $p . '-' . $co;
					if (isset($_POST[$key])) {
						if ($temp != "") {
							$temp = $temp . ',' . $co;
						} else {
							$temp = $co;
						}
						$practical[$i]['co'] = $temp;
						$practical[$i]['event_name'] = $p;
						$practical[$i]['group_a_date'] = $_POST['P' . $i . '-date_group_a'];
						$practical[$i]['group_b_date'] = $_POST['P' . $i . '-date_group_b'];
					}
				}
			}


			foreach ($practical as $pr) {
				$event_name = $pr['event_name'];
				$co = $pr['co'];
				$group_a_date = $pr['group_a_date'];
				$group_b_date = $pr['group_b_date'];


				$data2 = array(
					'event_info' => $event_info_id,
					'event_name' => $event_name,
					'co' => $co,
					'group_a_date' => $group_a_date,
					'group_b_date' => $group_b_date
				);
				$check_2 = $this->Mod_Common->insertData('event_practical_group_date', $data2);
			}

			$this->session->set_flashdata('success', 'Event Created Successfully');
			redirect(base_url('New_Events/sub_events'));
		}

	}






	public function event_created()
	{
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

		$event_info_id = $this->Mod_Common->insertData('event_info', $data);
		// print_r($event_info_id);die();
		if ($_POST['event_type'] == 9 || $_POST['event_type'] == 10) {
			$data1 = array(
				'event_info' => $event_info_id,
				'question' => " ",
				'co' => " ",
				'max_marks' => " "
			);
			$check_1 = $this->Mod_Common->insertData('event_data', $data1);
		} else {
			$data1 = array(
				'event_info' => $event_info_id,
				'question' => $_POST['question'],
				'co' => $_POST['co'],
				'max_marks' => $_POST['max_marks']
			);
			$check_1 = $this->Mod_Common->insertData('event_data', $data1);
			if ($_POST['event_type'] == 8) {
				$data2 = array(
					'event_info' => $event_info_id,
					'group_a_date' => $_POST['date_group_a'],
					'group_b_date' => $_POST['date_group_b']
				);
				$check_2 = $this->Mod_Common->insertData('event_practical_group_date', $data2);
			}
		}
		if ($_POST['event_type'] == 8 && ($check_1 != 0) && ($check_2 != 0) && ($event_info_id != 0)) {
			$this->session->set_flashdata('success', 'Event Created Successfully');
			redirect(base_url('New_Events/sub_events'));
		}
		if ($_POST['event_type'] != 8 && ($check_1 != 0) && ($event_info_id != 0)) {
			$this->session->set_flashdata('success', 'Event Created Successfully');
			redirect(base_url('New_Events/sub_events'));
		} else {
			$this->session->set_flashdata('fail', 'Event Not Created. Please try again');
			redirect(base_url('New_Events/sub_events'));
		}
	}
	//**************************************************
	//      section in this code reffers to batch id
	//		batch  refers batch name
	//*************************************************
	public function home_assignment($section, $subject, $event, $batch)
	{

		$data['section'] = $section;
		$data['subject'] = $subject;
		$data['event'] = $event;
		$data['batch'] = $batch;
		$row = $this->session->userdata('user');
		$computer_code = $row['computer_code'];
		$academic_session = $row['academic_id'];
		$data['co_number'] = $this->New_EventM->get_co($subject, $academic_session);

		$data['section_names'] = $this->New_EventM->find_section_name($computer_code, $academic_session, $section, $subject);
		//   echo "<pre>";
		//   print_r($data['section_names']);
		//   die();
		$data['sub_events'] = $this->New_EventM->fetch_detail_ha($academic_session, $computer_code, $section);


		$data['h1'] = 0;
		$data['h2'] = 0;
		$data['h3'] = 0;
		$data['h4'] = 0;
		$data['h5'] = 0;


		foreach ($data['sub_events'] as $sub) {

			if ($sub['event_name'] == 'H1') {
				$data['h1'] = 1;
			} else if ($sub['event_name'] == 'H2') {
				$data['h2'] = 1;
			} else if ($sub['event_name'] == 'H3') {
				$data['h3'] = 1;
			} else if ($sub['event_name'] == 'H4') {
				$data['h4'] = 1;
			} else if ($sub['event_name'] == 'H5') {
				$data['h5'] = 1;
			}

		}

		//   echo"<pre>";
		//   echo $data['h1']." ".$data['h2']." ".$data['h3']." ".$data['h4']." ".$data['h5'];
		//   die();


		$this->load->view('new_template/faculty_common');
		$this->load->view('new_events/new_home_assignment', $data);
		$this->load->view('new_template/new_footer');
	}
	public function event_actions()
	{
		$row = $this->session->userdata('user');
		
		$computer_code = $row['computer_code'];
		$academic_session = $row['current_session_id'];
		$department = $row['department_id'];
		$section_id = $_POST['section_name'];
		$a = explode('->', $section_id);
		$batch_id = $a[0];
		$clg_sub_code = $a[1];
		$batch = $a[2];
		$subject_name =$a[7];
		$tools = $_POST['tools'];
		$event = $_POST['event'];
		$type = $_POST['type'];

		//***************************************************Lock sessional data***************************************************  


		$data['lock_status_mst'] = $this->New_EventM->get_faculty_lock_status_mst($batch_id, $computer_code, $academic_session, $department);
		$data['lock_status_ha'] = $this->New_EventM->get_faculty_lock_status_home_assignment($batch_id, $computer_code, $academic_session, $department);
		$data['lock_status_practical'] = $this->New_EventM->get_faculty_lock_status_practical($batch_id, $computer_code, $academic_session, $department);

		$endsem_lock_status = $this->New_EventM->get_faculty_lock_status_endsem($batch_id, $computer_code, $academic_session, $department);

		$endsem_scheme = $this->New_EventM->get_endsem_scheme($batch_id, $academic_session);

		//*************************************************************************************************************************  

		if ($tools == "all-events" && $event == "view") {

			$this->event_list($section_id, $type, $data['lock_status_mst'], $data['lock_status_ha'], $data['lock_status_practical'], $endsem_lock_status, $endsem_scheme);

		}
		if ($tools == "rgpv-backup" && $event == "view") {
			redirect(base_url('New_EventSheets/rgpv_backup_list/' . $batch_id . '/' . $clg_sub_code . '/' . $batch));
		}
		if ($tools == "rgpv-backup-practical" && $event == "view") {
			redirect(base_url('New_EventSheets/rgpv_backup_list_practical/' . $batch_id . '/' . $clg_sub_code . '/' . $batch));
		}
		if ($tools == "rgpv-main" && $event == "view") {
			redirect(base_url('New_EventSheets/rgpv_main_list/' . $batch_id . '/' . $clg_sub_code . '/' . $batch));
		}
		if ($tools == "rgpv-backup-endsem-theory" && $event == "view") {
			redirect(base_url('New_EventSheets/rgpv_endsem_theory/' . $batch_id . '/' . $clg_sub_code . '/' . $batch));
		}
		if ($tools == "rgpv-backup-endsem-practical" && $event == "view") {
			redirect(base_url('New_EventSheets/rgpv_endsem_practical/' . $batch_id . '/' . $clg_sub_code . '/' . $batch));
		}
		if ($tools == "record" && $event == "view") {
			redirect(base_url('New_EventSheets/sessional_practical_sheet_blank/' . $batch_id . '/' . $clg_sub_code . '/' . $batch .'/'. $subject_name));
		}


	}
	//**************************************************
	//      section in this code reffers to batch id
	//		batch  refers batch name
	//**************************************************
	public function event_list($section_id, $type, $mst_status, $ha_status, $practical_status, $endsem_lock_status, $endsem_scheme)
	{
		$arr = explode('->', $section_id);
		$section = $arr[0];
		$subject = $arr[1];
		$batch = $arr[2];

		if (empty($mst_status)) {
			$data['mst_lock_status'] = 0;
		} else {
			$data['mst_lock_status'] = $mst_status[0]['lock_status'];
		}

		if (empty($ha_status)) {
			$data['ha_lock_status'] = 0;
		} else {
			$data['ha_lock_status'] = $ha_status[0]['lock_status'];
		}

		if (empty($practical_status)) {
			$data['practical_lock_status'] = 0;
		} else {
			$data['practical_lock_status'] = $practical_status[0]['lock_status'];
		}

		if (empty($endsem_lock_status)) {
			$data['endsem_lock_marks'] = 0;
			$data['endsem_lock_grade'] = 0;
			$data['endsem_lock_grade_range'] = 0;
		} else {
			$data['endsem_lock_marks'] = $endsem_lock_status[0]['lock_marks'];
			$data['endsem_lock_grade'] = $endsem_lock_status[0]['lock_grade'];
			$data['endsem_lock_grade_range'] = $endsem_lock_status[0]['lock_grade_range'];
		}

		if (empty($endsem_scheme)) {
			$data['status'] = 0;
		} else {
			$data['status'] = $endsem_scheme[0]['end_sem'];
		}

		$Subject_type = $this->New_EventM->get_sub_type($subject, $section);
		$data['subject_type'] = $Subject_type[0]['type'];

		$data['section_events'] = $this->New_EventM->view_event($section, $subject);
		$row = $this->session->userdata('user');
		$cur_ses = $row['current_session_id'];
		$session_status = $this->Mod_Common->selectData($fields = '*', 'academic_session', $condition = array('academic_session_id' => $cur_ses), $limit = '', $start = '');
		$data['status_of_change'] = $session_status[0]->active;
		$data['status_of_change'] = 1;
		$computer_code = $row['computer_code'];
		$academic_session = $row['academic_id'];


		if ($type == "subject_coordinator") {
			$section_names = $this->New_EventM->find_section_name_subject($computer_code, $academic_session, $section, $subject);
			$subject_name = $this->Mod_Common->selectData($fields = '*', 'subject_batch', $condition = array('clg_sub_code' => $subject, 'batch_id' => $section), $limit = '', $start = '');

			if (!empty($section_names))
				foreach ($section_names as $s) {
					$na1 = $s->dept_code . " - " . $s->batch . ' - ' . $s->semester;
				} else
				$na1 = "";
			if (!empty($subject_name))
				foreach ($subject_name as $s) {
					$na2 = ' - ' . $s->subject_name . '[' . $data['subject_type'] . ']';
				} else
				$na2 = "";
			$na = $na1 . $na2;
		}

		$data['na'] = base64_encode($na);
		$data['endsem_created'] = 0;

		if ($data['subject_type'] == 'T') {
			$check = $this->New_EventM->checkEndSem(9, $section, $subject, $computer_code, $academic_session);
			if (!empty($check)) {
				$data['endsem_created'] = 1;
			}
		} else if ($data['subject_type'] == 'P') {
			$check = $this->New_EventM->checkEndSem(10, $section, $subject, $computer_code, $academic_session);
			if (!empty($check)) {
				$data['endsem_created'] = 1;
			}
		} else {
			$check = $this->New_EventM->checkEndSem(11, $section, $subject, $computer_code, $academic_session);
			if (!empty($check)) {
				$data['endsem_created'] = 1;
			}
		}

		$data['mst_created'] = 0;

		if ($data['subject_type'] == 'T') {
			$check = $this->New_EventM->checkmst(6, $section, $subject, $computer_code, $academic_session);
			if (!empty($check)) {
				$data['mst_created'] = 1;
			}

		}

		$data['homeassignment_created'] = 0;

		if ($data['subject_type'] == 'T') {
			$check = $this->New_EventM->checkhomeassignment(7, $section, $subject, $computer_code, $academic_session);
			if (!empty($check)) {
				$data['homeassignment_created'] = 1;
			}

		}

		$data['practical_created'] = 0;

		if ($data['subject_type'] == 'P') {
			$check = $this->New_EventM->checkPractical($computer_code, $section, $subject, $academic_session);
			if (!empty($check)) {
				$data['practical_created'] = 1;
			}

		}

		$this->load->view('new_template/faculty_common');
		$this->load->view('new_events/new_event_view_list', $data);
		$this->load->view('new_template/new_footer');
	}
	public function fill_marks_combined_mst($section, $subject, $event_id)
	{
		// echo $event_id;
		// die();
		$academic_session = $_SESSION['user']['academic_id'];
		$data['student_list'] = $this->New_EventM->student_list_sheet($section, $academic_session);
		// echo "<pre>";print_r($data);die();
		$data['event_info'] = $this->New_EventM->event_details($section, $subject, 6);
		// echo "<pre>";
		// print_r($data['event_info']);
		// die();
		$this->load->view('new_template/faculty_common');
		$this->load->view('new_events/new_fill_marks_combined_mst', $data);
		$this->load->view('new_template/new_footer');

	}

	public function feed_univ_marks_ha($marks, $computer_code, $event_data_id)
	{

		if ($marks >= 0)
			$attend = 1;
		else if ($marks == -1) {
			$attend = 0;
			$marks = 0;
		}
		$row = $this->Mod_Common->selectData($fields = '*', 'event_marks', $condition = array('student_computer_code' => $computer_code, 'event_data' => $event_data_id), $limit = '', $start = '');


		if (empty($row)) {
			if (($_SESSION['user']['department_id'] != 11)) {
				$this->Mod_Common->insertData('event_marks', $data = array('student_computer_code' => $computer_code, 'event_data' => $event_data_id, 'marks' => $marks, 'attend' => $attend));
			}
		}

		if (!empty($row)) {

			$this->Mod_Common->updateData('event_marks', $condition = array('student_computer_code' => $computer_code, 'event_data' => $event_data_id), $data = array('marks' => $marks, 'attend' => $attend));



		}

	}
	public function feed_univ_marks($marks, $computer_code, $event_data_id)
	{
		if ($marks >= 0)
			$attend = 1;
		else if ($marks == -1) {
			$attend = 0;
			$marks = 0;
		}
		$row = $this->Mod_Common->selectData($fields = '*', 'event_marks', $condition = array('student_computer_code' => $computer_code, 'event_data' => $event_data_id), $limit = '', $start = '');



		if (empty($row)) {
			$this->Mod_Common->insertData('event_marks', $data = array('student_computer_code' => $computer_code, 'event_data' => $event_data_id, 'marks' => $marks, 'attend' => $attend));
		}

		if (!empty($row)) {

			$this->Mod_Common->updateData('event_marks', $condition = array('student_computer_code' => $computer_code, 'event_data' => $event_data_id), $data = array('marks' => $marks, 'attend' => $attend));
		}
	}
	public function fill_marks($id, $section_name)
	{

		$event_info_id = base64_decode($id);

		$row = $this->Mod_Common->selectData($fields = '*', 'event_info', $condition = array('event_info_id' => $event_info_id), $limit = '', $start = '');
		// print_r($event_info_id);die();
		foreach ($row as $r) {
			$event_category = $r->event_category;
		}

		if ($event_category == 1)
			$this->Nba_other_fill_marks($event_info_id);
		else if ($event_category == 2 || $event_category == 3)
			$this->university_result_fill_marks($event_info_id, $section_name);
		else if ($event_category == 4 || $event_category == 5)
			$this->teacher_assessment_fill_marks($event_info_id, $section_name);
		else if ($event_category == 6)
			$this->test_fill_marks($event_info_id, $section_name);
		else if ($event_category == 7)
			$this->home_assignment_fill_marks($event_info_id, $section_name);
		else if ($event_category == 8)
			$this->practical_experiment_fill_marks($event_info_id, $section_name);


	}
	public function practical_experiment_fill_marks($event_info_id, $section_name)
	{

		$data['student_list'] = $this->New_EventM->view_student_list($event_info_id);
		$data['event_data_id'] = $this->Mod_Common->selectData($fields = '*', 'event_data', $condition = array('event_info' => $event_info_id), $limit = '', $start = '');
		$data['section_name'] = $section_name;
		$this->load->view('new_template/faculty_common');
		$this->load->view('new_events/new_fill_marks_list_univ', $data);
		$this->load->view('new_template/new_footer');

	}
	public function university_result_fill_marks($event_info_id, $section_name)
	{

		$data['student_list'] = $this->New_EventM->view_student_list($event_info_id);
		// print_r($event_info_id);die();

		$data['event_data_id'] = $this->Mod_Common->selectData($fields = '*', 'event_data', $condition = array('event_info' => $event_info_id), $limit = '', $start = '');
		$data['section_name'] = $section_name;
		$this->load->view('new_template/faculty_common');
		$this->load->view('new_events/new_fill_marks_list_univ', $data);
		$this->load->view('new_template/new_footer');


	}
	public function teacher_assessment_fill_marks($event_info_id, $section_name)
	{

		$data['student_list'] = $this->New_EventM->view_student_list($event_info_id);
		// print_r($data);die();
		$data['event_data_id'] = $this->Mod_Common->selectData($fields = '*', 'event_data', $condition = array('event_info' => $event_info_id), $limit = '', $start = '');
		$data['section_name'] = $section_name;
		$this->load->view('new_template/faculty_common');
		$this->load->view('new_events/new_fill_marks_list_teacher_assessment', $data);
		$this->load->view('new_template/new_footer');


	}
	public function test_fill_marks($event_info_id, $section_name)
	{
		$data['event_data_id'] = $this->New_EventM->mst_data($event_info_id);
		//  echo "<pre>";
		// print_r($data['event_data_id']);
		// exit();
		$data['question_count'] = $this->Mod_Common->count($fields = '*', "event_data", $condition = array('event_info' => $event_info_id));

		$data['event_data_question_id'] = $this->Mod_Common->selectData($fields = '*', "event_data", $condition = array('event_info' => $event_info_id));
		$data['event_name'] = $this->Mod_Common->selectData($fields = 'event_name', "event_info", $condition = array('event_info_id' => $event_info_id));

		// print_r($data['event_name']);
		// die();
		// var_dump($data['event_data_question_id']);
		// die();
		//   echo "<prsdata['event_data_question_id']);
		//   echo '</br>';
		//   die();
		if (!empty($data['event_data_question_id'])) {
			$i = 1;

			foreach ($data['event_data_question_id'] as $k) {

				$co[$i] = $k->co;
				$i++;
			}
		}
		//print_r($co);

		//   for($j=1;$j<=$i-1;$j++)
		//   {
		//   	$co_name = $this->Mod_Common->selectData($fields='*' , "co" , $condition=array('co_id'=>$co[$j]));
		//   	if(!empty($co_name))
		//   		foreach ($co_name as $c) {
		//   			$c_name[$j] = $c->co_name;
		//   		}
		//   }
		$data['c_name'] = $co;
		//print_r($data['$c_name']);

		// echo "<pre>";
		// print_r($data);
		// exit();
		$data['student_list'] = $this->New_EventM->view_student_list_mst($event_info_id);

		$data['student_count'] = $this->New_EventM->section_student_count($event_info_id);
		//    echo "hello";
		// die();
		$data['section_name'] = $section_name;
		//    echo "<pre>";
		// print_r($data['student_list']);
		// die();
		$this->load->view('new_template/faculty_common');
		$this->load->view('new_events/new_fill_marks_list_test', $data);
		$this->load->view('new_template/new_footer');
	}

	public function home_assignment_fill_marks($event_info_id, $section_name)
	{
		$data['event_data_id'] = $this->New_EventM->mst_data($event_info_id);
		$data['section_check'] = array($data['event_data_id'][0]->section);
		$data['question_count'] = $this->Mod_Common->count($fields = '*', "event_data", $condition = array('event_info' => $event_info_id));
		$data['event_data_question_id'] = $this->Mod_Common->selectData($fields = '*', "event_data", $condition = array('event_info' => $event_info_id));
		$data['student_list'] = $this->New_EventM->view_student_list_mst($event_info_id);
		$data['student_count'] = $this->New_EventM->section_student_count($event_info_id);
		$data['section_name'] = $section_name;
		$this->load->view('new_template/faculty_common');
		$this->load->view('new_events/new_fill_marks_list_ha', $data);
		$this->load->view('new_template/new_footer');
	}

	public function practical_experiment($section, $subject, $event)
	{
		$data['section'] = $section;
		$data['subject'] = $subject;
		$data['event'] = $event;
		$row = $this->session->userdata('user');
		$computer_code = $row['computer_code'];
		$academic_session = $row['academic_id'];
		$data['co_number'] = $this->New_EventM->get_co($subject, $academic_session);

		$data['section_names'] = $this->New_EventM->find_section_name($computer_code, $academic_session, $section, $subject);
		$data['practical_details'] = $this->New_EventM->checkPractical($computer_code, $section, $subject, $academic_session);

		if (!empty($data['practical_details'])) {
			// $i=0;
			// foreach($data['practical_details'] as $c){
			// 	$practical_date = $this->New_EventM->getPracticalDate($c['event_info_id']);
			// 	$data['practical_details'][$i]['group_a_date'] = $practical_date[0]['group_a_date'];
			// 	$data['practical_details'][$i]['group_b_date'] = $practical_date[0]['group_b_date'];
			// 	$data['practical_details'][$i]['co'] = $practical_date[0]['co'];

			// 	$i++;
			// }

			$this->session->set_flashdata('success', 'Event Already Created');
			redirect(base_url('New_Events/sub_events'));
		} else {
			$this->load->view('new_template/faculty_common');
			$this->load->view('new_events/new_practical_experiment', $data);
			$this->load->view('new_template/new_footer');
		}
		// print_r( $data['section_names']);die();

	}

	// ******************************************* End Sem Marks Feed ************************************************************************

	public function fill_marks_combined_endsem_theory($section, $subject, $event_id)
	{
		$IP = $this->input->ip_address();
		$academic_session = $_SESSION['user']['academic_id'];
		$data['student_list'] = $this->New_EventM->student_list_sheet_array($section, $academic_session);



		$data['event_info'] = $this->Mod_Common->selectData($fields = '*', 'event_info', $condition = array('section' => $section, 'subject' => $subject, 'event_category' => 9), $limit = '', $start = '');
		$data['event_info_id'] = $data['event_info'][0]->event_info_id;
		// print_r($event_info_id);die();



		$data['subject_detail'] = $this->New_EventM->GetSubjectDetails($section, $subject, $academic_session);
		// echo "<pre>";
//  	  print_r($data['subject_detail']);die();
		$Type = 'T';
		$UniversitySubjectCode = $data['subject_detail'][0]['university_sub_code'];
		$CollegeSubjectCode = $data['subject_detail'][0]['clg_sub_code'];
		$Department = $data['subject_detail'][0]['department'];
		//   print_r($Department);
		//   die();


		$data['SubjectMaxMarks'] = $this->New_EventM->GetSubjectMaxMarks($UniversitySubjectCode, $CollegeSubjectCode, $Type, $Department, $section);

		$i = 0;
		foreach ($data['student_list'] as $v) {

			$temp = $this->New_EventM->GetStudentData($v['computer_code'], $v['enrollment_no'], $UniversitySubjectCode, $CollegeSubjectCode, $section, $academic_session, $Type, $data['event_info_id']);
			// print_r($temp);die();

			if (!empty($temp)) {

				$data['student_list'][$i]['co1'] = $temp[0]['co1'];
				$data['student_list'][$i]['co2'] = $temp[0]['co2'];
				$data['student_list'][$i]['co3'] = $temp[0]['co3'];
				$data['student_list'][$i]['co4'] = $temp[0]['co4'];
				$data['student_list'][$i]['co5'] = $temp[0]['co5'];
				if ($temp[0]['total_marks'] == '-1') {
					$data['student_list'][$i]['TotalMarks'] = 0;
				} else {
					$data['student_list'][$i]['TotalMarks'] = $temp[0]['total_marks'];
				}



			} else {
				$data['student_list'][$i]['co1'] = '';
				$data['student_list'][$i]['co2'] = '';
				$data['student_list'][$i]['co3'] = '';
				$data['student_list'][$i]['co4'] = '';
				$data['student_list'][$i]['co5'] = '';

				$data['student_list'][$i]['TotalMarks'] = '';

			}
			// echo "<pre>";
			// print_r($v);
			$i++;
		}

		// die();
		// echo "<pre>";
// 	  print_r($data['student_list']);die();

		$this->load->view('new_template/faculty_common');
		$this->load->view('new_events/new_fill_marks_combined_endsem_theory', $data);
		$this->load->view('new_template/new_footer');

	}

	public function fill_marks_combined_endsem_practical($section, $subject, $event_id)
	{

		$IP = $this->input->ip_address();
		$academic_session = $_SESSION['user']['academic_id'];
		$data['student_list'] = $this->New_EventM->student_list_sheet_array($section, $academic_session);



		$data['event_info'] = $this->Mod_Common->selectData($fields = '*', 'event_info', $condition = array('section' => $section, 'subject' => $subject, 'event_category' => 10), $limit = '', $start = '');
		$data['event_info_id'] = $data['event_info'][0]->event_info_id;
		// print_r($data['event_info_id']);die();



		$data['subject_detail'] = $this->New_EventM->GetSubjectDetails($section, $subject, $academic_session);
		// echo "<pre>";
		// print_r($data['subject_detail']);die();
		$UniversitySubjectCode = $data['subject_detail'][0]['university_sub_code'];
		$CollegeSubjectCode = $data['subject_detail'][0]['clg_sub_code'];
		$Department = $data['subject_detail'][0]['department'];
		$Type = $data['subject_detail'][0]['type'];

		if ($Type == 'P' || $Type == 'B') {
			$Type = 'P';
		} else if ($Type == 'E') {
			$Type = 'E';
		}

		$data['SubjectMaxMarks'] = $this->New_EventM->GetSubjectMaxMarks($UniversitySubjectCode, $CollegeSubjectCode, $Type, $Department, $section);

		if ($Type == 'P') {

			$i = 0;
			foreach ($data['student_list'] as $v) {

				$temp = $this->New_EventM->GetStudentData($v['computer_code'], $v['enrollment_no'], $UniversitySubjectCode, $CollegeSubjectCode, $section, $academic_session, $Type, $data['event_info_id']);
				// print_r($temp);die();

				if (!empty($temp)) {

					$data['student_list'][$i]['co1'] = $temp[0]['co1'];
					$data['student_list'][$i]['co2'] = $temp[0]['co2'];
					$data['student_list'][$i]['co3'] = $temp[0]['co3'];
					$data['student_list'][$i]['co4'] = $temp[0]['co4'];
					$data['student_list'][$i]['co5'] = $temp[0]['co5'];

					if ($temp[0]['total_marks'] == '-1') {
						$data['student_list'][$i]['TotalMarks'] = 0;
					} else {
						$data['student_list'][$i]['TotalMarks'] = $temp[0]['total_marks'];
					}


				} else {
					$data['student_list'][$i]['co1'] = '';
					$data['student_list'][$i]['co2'] = '';
					$data['student_list'][$i]['co3'] = '';
					$data['student_list'][$i]['co4'] = '';
					$data['student_list'][$i]['co5'] = '';

					$data['student_list'][$i]['TotalMarks'] = '';

				}


				// echo "<pre>";
				// print_r($v);
				$i++;
			}

		} else if ($Type == 'E') {

			$i = 0;
			foreach ($data['student_list'] as $v) {

				$temp = $this->New_EventM->GetStudentData($v['computer_code'], $v['enrollment_no'], $UniversitySubjectCode, $CollegeSubjectCode, $section, $academic_session, $Type, $data['event_info_id']);
				// print_r($temp);die();

				if (!empty($temp)) {

					$data['student_list'][$i]['EMarks'] = $temp[0]['total_marks'];
					// $data['student_list'][$i]['ECredit'] = $temp[0]['earn_credit'];

				} else {

					$data['student_list'][$i]['EMarks'] = '';
					// $data['student_list'][$i]['ECredit'] = '';
				}


				// echo "<pre>";
				// print_r($v);
				$i++;
			}

		}

		// die();
		// echo "<pre>";
// 	  print_r($data['student_list']);die();

		if ($Type == 'P') {

			$this->load->view('new_template/faculty_common');
			$this->load->view('new_events/new_fill_marks_combined_endsem_practical', $data);
			$this->load->view('new_template/new_footer');

		} else if ($Type == 'E') {

			$this->load->view('new_template/faculty_common');
			$this->load->view('new_events/new_fill_marks_combined_endsem_extra', $data);
			$this->load->view('new_template/new_footer');

		}


	}

	// **************************************************************************************************************************************

	// **************************************************** End Sem Feed Grade *****************************************************************


	public function fill_grade_combined_endsem_theory($section, $subject, $event_id)
	{

		$IP = $this->input->ip_address();

		$faculty_computer_code = $_SESSION['user']['computer_code'];

		$data['event_info'] = $this->Mod_Common->selectData($fields = '*', 'event_info', $condition = array('section' => $section, 'subject' => $subject, 'event_category' => 9), $limit = '', $start = '');
		$data['event_info_id'] = $data['event_info'][0]->event_info_id;

		$academic_session = $_SESSION['user']['academic_id'];

		$data['subject_detail'] = $this->New_EventM->GetSubjectDetails($section, $subject, $academic_session);

		$academic_session = $_SESSION['user']['academic_id'];

		$data['StudentList'] = $this->New_EventM->student_list_sheet_array($section, $academic_session);

		$Type = 'T';
		$Subject = $data['subject_detail'][0]['subject_name'];
		$UniversitySubjectCode = $data['subject_detail'][0]['university_sub_code'];
		$CollegeSubjectCode = $data['subject_detail'][0]['clg_sub_code'];
		$Department = $data['subject_detail'][0]['department'];
		$BatchId = $section;

		$data['extra'] = array('Subject' => $Subject, 'Type' => $Type, 'UniversitySubjectCode' => $UniversitySubjectCode, 'CollegeSubjectCode' => $CollegeSubjectCode, 'Department' => $Department, 'BatchId' => $BatchId);

		$data['SubjectMaxMarks'] = $this->New_EventM->GetSubjectMaxMarks($UniversitySubjectCode, $CollegeSubjectCode, $Type, $Department, $BatchId);

		$data['SubjectMaxMarks'][0]['total_marks'] = $data['SubjectMaxMarks'][0]['end_sem'] + $data['SubjectMaxMarks'][0]['mst'] + $data['SubjectMaxMarks'][0]['assignment'];

		$data['student_mst_marks'] = array();
		$i = 0;
		foreach ($data['StudentList'] as $v) {

			$temp = $this->New_EventM->GetStudentData($v['computer_code'], $v['enrollment_no'], $UniversitySubjectCode, $CollegeSubjectCode, $BatchId, $academic_session, $Type, $data['event_info_id']);

			$checkgrace = $this->New_EventM->CheckGrace($v['computer_code'], $v['enrollment_no'], $BatchId, $academic_session, $data['event_info_id']);

			$data['StudentList'][$i]['Grace'] = 0;
			if (!empty($checkgrace)) {
				$data['StudentList'][$i]['Grace'] = 1;
			}

			//********************************************************************************************************************************************

			$mst_marks = $this->New_EventM->fetch_eventmarks(6, $v['computer_code'], $academic_session, $faculty_computer_code, $BatchId);

			$mst1 = 0;
			$mst2 = 0;
			foreach ($mst_marks as $m) {
				if ($m['event_name'] == 'MST1') {
					$mst1 += $m['marks'];
				} else if ($m['event_name'] == 'MST2') {
					$mst2 += $m['marks'];
				}
			}

			$mst = 0;
			$mst = $mst1 + $mst2;


			$ha1 = 0;
			$ha2 = 0;
			$ha3 = 0;
			$ha4 = 0;
			$ha5 = 0;

			$ha_marks = $this->New_EventM->fetch_eventmarks(7, $v['computer_code'], $academic_session, $faculty_computer_code, $BatchId);

			foreach ($ha_marks as $h) {
				if ($h['event_name'] == 'H1') {
					$ha1 += $h['marks'];
				} else if ($h['event_name'] == 'H2') {
					$ha2 += $h['marks'];
				} else if ($h['event_name'] == 'H3') {
					$ha3 += $h['marks'];
				} else if ($h['event_name'] == 'H4') {
					$ha4 += $h['marks'];
				} else if ($h['event_name'] == 'H5') {
					$ha5 += $h['marks'];
				}

			}



			$ha = 0;
			$ha = $ha1 + $ha2 + $ha3 + $ha4 + $ha5;


			//********************************************************************************************************************************************

			if (!empty($temp[0])) {

				$data['StudentList'][$i]['Tendsem'] = $temp[0]['total_marks'];
				$data['StudentList'][$i]['Tmst'] = $mst;
				$data['StudentList'][$i]['Tquiz'] = $ha;
				if ($temp[0]['total_marks'] == '-1') {
					$data['StudentList'][$i]['TotalTMarks'] = $ha + $mst;
				} else {
					$data['StudentList'][$i]['TotalTMarks'] = $temp[0]['total_marks'] + $ha + $mst;
				}

				$data['StudentList'][$i]['TGrade'] = $temp[0]['grade'];


				// $data['StudentList'][$i]['TCredit'] = $temp[0]['earn_credit'];

			} else {

				$data['StudentList'][$i]['Tendsem'] = '';
				$data['StudentList'][$i]['Tmst'] = '';
				$data['StudentList'][$i]['Tquiz'] = '';
				$data['StudentList'][$i]['TotalTMarks'] = '';
				$data['StudentList'][$i]['TGrade'] = '';


				// $data['StudentList'][$i]['TCredit'] = '';
			}


			$i++;
		}

		// die();
		// echo "<pre>";
		// print_r($data);
		// die();

		$this->load->view('new_template/faculty_common');
		$this->load->view('new_events/new_fill_grade_endsem_theory', $data);
		$this->load->view('new_template/new_footer');

	}



	public function fill_grade_combined_endsem_practical($section, $subject, $event_id)
	{

		$IP = $this->input->ip_address();

		$faculty_computer_code = $_SESSION['user']['computer_code'];

		$data['event_info'] = $this->Mod_Common->selectData($fields = '*', 'event_info', $condition = array('section' => $section, 'subject' => $subject, 'event_category' => 10), $limit = '', $start = '');
		$data['event_info_id'] = $data['event_info'][0]->event_info_id;

		$academic_session = $_SESSION['user']['academic_id'];

		$data['subject_detail'] = $this->New_EventM->GetSubjectDetails($section, $subject, $academic_session);

		$academic_session = $_SESSION['user']['academic_id'];

		$data['StudentList'] = $this->New_EventM->student_list_sheet_array($section, $academic_session);

		$Type = $data['subject_detail'][0]['type'];

		if ($Type == 'P' || $Type == 'B') {
			$Type = 'P';
		} else if ($Type == 'E') {
			$Type = 'E';
		}

		$Subject = $data['subject_detail'][0]['subject_name'];
		$UniversitySubjectCode = $data['subject_detail'][0]['university_sub_code'];
		$CollegeSubjectCode = $data['subject_detail'][0]['clg_sub_code'];
		$Department = $data['subject_detail'][0]['department'];
		$BatchId = $section;

		$data['extra'] = array('Subject' => $Subject, 'Type' => $Type, 'UniversitySubjectCode' => $UniversitySubjectCode, 'CollegeSubjectCode' => $CollegeSubjectCode, 'Department' => $Department, 'BatchId' => $BatchId);

		$data['SubjectMaxMarks'] = $this->New_EventM->GetSubjectMaxMarks($UniversitySubjectCode, $CollegeSubjectCode, $Type, $Department, $BatchId);

		$data['SubjectMaxMarks'][0]['total_marks'] = $data['SubjectMaxMarks'][0]['end_sem'] + $data['SubjectMaxMarks'][0]['labwork_sessional'];

		$data['student_mst_marks'] = array();


		if ($Type == 'P') {

			$i = 0;
			foreach ($data['StudentList'] as $v) {

				$temp = $this->New_EventM->GetStudentData($v['computer_code'], $v['enrollment_no'], $UniversitySubjectCode, $CollegeSubjectCode, $BatchId, $academic_session, $Type, $data['event_info_id']);

				//********************************************************************************************************************************************

				$labwork = $this->New_EventM->fetch_eventmarks(8, $v['computer_code'], $academic_session, $faculty_computer_code, $BatchId);

				if (!empty($labwork)) {

					$total_labwork = 0;
					foreach ($labwork as $lab) {
						$total_labwork += $lab['marks'];
					}
					//   $avg = $total_labwork/count($labwork);

					//   $lab_marks = round($avg * 4);
					$lab_marks = $total_labwork;

				} else {

					$lab_marks = '';
				}

				//********************************************************************************************************************************************
				if ($data['SubjectMaxMarks'][0]['end_sem'] == 0) {
					if (!empty($labwork)) {
						$data['StudentList'][$i]['Pendsem'] = '';
						$data['StudentList'][$i]['Plabsessional'] = $lab_marks;
						$data['StudentList'][$i]['TotalPMarks'] = $lab_marks;
						if (!empty($temp[0])) {
							$data['StudentList'][$i]['PGrade'] = $temp[0]['grade'];
						} else {
							$data['StudentList'][$i]['PGrade'] = '';
						}
					} else {
						$data['StudentList'][$i]['Pendsem'] = '';
						$data['StudentList'][$i]['Plabsessional'] = '';
						$data['StudentList'][$i]['TotalPMarks'] = '';
						$data['StudentList'][$i]['PGrade'] = '';
					}
				} else {
					if (!empty($temp[0])) {

						$data['StudentList'][$i]['Pendsem'] = $temp[0]['total_marks'];
						$data['StudentList'][$i]['Plabsessional'] = $lab_marks;

						if ($temp[0]['total_marks'] == '-1') {
							$data['StudentList'][$i]['TotalPMarks'] = $lab_marks;
						} else {
							$data['StudentList'][$i]['TotalPMarks'] = $temp[0]['total_marks'] + $lab_marks;
						}

						$data['StudentList'][$i]['PGrade'] = $temp[0]['grade'];


						// $data['StudentList'][$i]['TCredit'] = $temp[0]['earn_credit'];

					} else {

						$data['StudentList'][$i]['Pendsem'] = '';
						$data['StudentList'][$i]['Plabsessional'] = '';
						$data['StudentList'][$i]['TotalPMarks'] = '';
						$data['StudentList'][$i]['PGrade'] = '';


						// $data['StudentList'][$i]['TCredit'] = '';
					}
				}



				$i++;
			}

		} else if ($Type == 'E') {

			$i = 0;
			foreach ($data['StudentList'] as $v) {


				$temp = $this->New_EventM->GetStudentData($v['computer_code'], $v['enrollment_no'], $UniversitySubjectCode, $CollegeSubjectCode, $BatchId, $academic_session, $Type, $data['event_info_id']);




				//********************************************************************************************************************************************

				$labwork = $this->New_EventM->fetch_eventmarks(8, $v['computer_code'], $academic_session, $faculty_computer_code, $BatchId);

				if (!empty($labwork)) {

					$total_labwork = 0;
					foreach ($labwork as $lab) {
						$total_labwork += $lab['marks'];
					}
					$avg = $total_labwork / count($labwork);

					$lab_marks = round($avg) * 4;

				} else {

					$lab_marks = '';
				}

				//********************************************************************************************************************************************

				if (!empty($temp)) {

					$data['StudentList'][$i]['Eendsem'] = $temp[0]['total_marks'];
					$data['StudentList'][$i]['Elabsessional'] = $lab_marks;

					if ($temp[0]['total_marks'] == '-1') {
						$data['StudentList'][$i]['TotalEMarks'] = $lab_marks;
					} else {
						$data['StudentList'][$i]['TotalEMarks'] = $temp[0]['total_marks'] + $lab_marks;
					}

					$data['StudentList'][$i]['EGrade'] = $temp[0]['grade'];


					// $data['StudentList'][$i]['TCredit'] = $temp[0]['earn_credit'];

				} elseif ($data['SubjectMaxMarks'][0]['end_sem'] == 0) {

					$data['StudentList'][$i]['Eendsem'] = '';
					$data['StudentList'][$i]['Elabsessional'] = $lab_marks;
					$data['StudentList'][$i]['TotalEMarks'] = $lab_marks;
					$data['StudentList'][$i]['EGrade'] = $temp[0]['grade'];
				} else {

					$data['StudentList'][$i]['Eendsem'] = '';
					$data['StudentList'][$i]['Elabsessional'] = '';
					$data['StudentList'][$i]['TotalEMarks'] = '';
					$data['StudentList'][$i]['EGrade'] = '';


					// $data['StudentList'][$i]['TCredit'] = '';
				}


				$i++;
			}
		}


		if ($Type == 'P') {

			$this->load->view('new_template/faculty_common');
			$this->load->view('new_events/new_fill_grade_endsem_practical', $data);
			$this->load->view('new_template/new_footer');

		} else if ($Type == 'E') {

			$this->load->view('new_template/faculty_common');
			$this->load->view('new_events/new_fill_grade_endsem_extra', $data);
			$this->load->view('new_template/new_footer');

		}

	}
	public function fill_grade_combined_endsem_mc($section, $subject)
	{

		$IP = $this->input->ip_address();

		$faculty_computer_code = $_SESSION['user']['computer_code'];

		$data['event_info'] = $this->Mod_Common->selectData($fields = '*', 'event_info', $condition = array('section' => $section, 'subject' => $subject, 'event_category' => 11), $limit = '', $start = '');
		$data['event_info_id'] = $data['event_info'][0]->event_info_id;

		$academic_session = $_SESSION['user']['academic_id'];

		$data['subject_detail'] = $this->New_EventM->GetSubjectDetails($section, $subject, $academic_session);

		$academic_session = $_SESSION['user']['academic_id'];

		$data['StudentList'] = $this->New_EventM->student_list_sheet_array($section, $academic_session);

		if ($data['subject_detail'][0]['type'] == 'MCT' || $data['subject_detail'][0]['type'] == 'MCP') {
			$Type = 'MC';
		} else {
			$Type = $data['subject_detail'][0]['type'];
		}
		// echo $Type;
		// die();

		$Subject = $data['subject_detail'][0]['subject_name'];
		$UniversitySubjectCode = $data['subject_detail'][0]['university_sub_code'];
		$CollegeSubjectCode = $data['subject_detail'][0]['clg_sub_code'];
		$Department = $data['subject_detail'][0]['department'];
		$BatchId = $section;

		$data['extra'] = array('Subject' => $Subject, 'Type' => $Type, 'UniversitySubjectCode' => $UniversitySubjectCode, 'CollegeSubjectCode' => $CollegeSubjectCode, 'Department' => $Department, 'BatchId' => $BatchId);

		// $data['SubjectMaxMarks'] = $this->New_EventM->GetSubjectMaxMarks($UniversitySubjectCode, $CollegeSubjectCode, $Type, $Department);

		// $data['SubjectMaxMarks'][0]['total_marks'] = $data['SubjectMaxMarks'][0]['end_sem'] + $data['SubjectMaxMarks'][0]['labwork_sessional'];








		$i = 0;
		foreach ($data['StudentList'] as $v) {


			$temp = $this->New_EventM->GetStudentData($v['computer_code'], $v['enrollment_no'], $UniversitySubjectCode, $CollegeSubjectCode, $BatchId, $academic_session, $Type, $data['event_info_id']);




			//********************************************************************************************************************************************

			//********************************************************************************************************************************************

			if (!empty($temp)) {



				$data['StudentList'][$i]['MCGrade'] = $temp[0]['grade'];


				// $data['StudentList'][$i]['TCredit'] = $temp[0]['earn_credit'];

			} else {


				$data['StudentList'][$i]['MCGrade'] = '';


				// $data['StudentList'][$i]['TCredit'] = '';
			}


			$i++;
		}





		$this->load->view('new_template/faculty_common');
		$this->load->view('new_events/new_fill_grade_endsem_mc', $data);
		$this->load->view('new_template/new_footer');



	}

	//***************************************************************************************************************************************

	//********************************************** End Sem Credit Feedn ********************************************************************

	public function fill_credit_combined_endsem_theory($section, $subject, $event_id)
	{
		// echo "hello";
		// die();
		$IP = $this->input->ip_address();
		$academic_session = $_SESSION['user']['academic_id'];
		$data['StudentList'] = $this->New_EventM->student_list_sheet_array($section, $academic_session);

		$data['event_info'] = $this->Mod_Common->selectData($fields = '*', 'event_info', $condition = array('section' => $section, 'subject' => $subject, 'event_category' => 9), $limit = '', $start = '');

		$data['event_info_id'] = $data['event_info'][0]->event_info_id;



		$Type = 'T';

		$data['subject_detail'] = $this->New_EventM->GetSubjectDetails($section, $subject, $academic_session);

		$Subject = $data['subject_detail'][0]['subject_name'];
		$UniversitySubjectCode = $data['subject_detail'][0]['university_sub_code'];
		$CollegeSubjectCode = $data['subject_detail'][0]['clg_sub_code'];
		$Department = $data['subject_detail'][0]['department'];
		$BatchId = $section;


		$data['extra'] = array('Subject' => $Subject, 'Type' => $Type, 'UniversitySubjectCode' => $UniversitySubjectCode, 'CollegeSubjectCode' => $CollegeSubjectCode, 'Department' => $Department, 'BatchId' => $BatchId);

		$data['StudentCredit'] = $this->New_EventM->GetSubjectCredit($UniversitySubjectCode, $CollegeSubjectCode, $Department, $academic_session, $Type, $BatchId);

		$data['SubjectMaxMarks'] = $this->New_EventM->GetSubjectMaxMarks($UniversitySubjectCode, $CollegeSubjectCode, $Type, $Department, $BatchId);

		$i = 0;
		foreach ($data['StudentList'] as $v) {

			$temp = $this->New_EventM->GetStudentData($v['computer_code'], $v['enrollment_no'], $UniversitySubjectCode, $CollegeSubjectCode, $BatchId, $academic_session, $Type, $data['event_info_id']);


			if (!empty($temp[0]['earn_credit'])) {

				// $data['StudentList'][$i]['TMarks'] = $temp[0]['marks'];
				$data['StudentList'][$i]['TCredit'] = $temp[0]['earn_credit'];

			} else {

				// $data['StudentList'][$i]['TMarks'] = '';
				$data['StudentList'][$i]['TCredit'] = '';
			}



			$i++;
		}

		$this->load->view('new_template/faculty_common');
		$this->load->view('new_events/new_fill_credit_endsem_theory', $data);
		$this->load->view('new_template/new_footer');

	}


	public function fill_credit_combined_endsem_practical($section, $subject, $event_id)
	{
		// echo "hello";
		// die();
		$IP = $this->input->ip_address();
		$academic_session = $_SESSION['user']['academic_id'];
		$data['StudentList'] = $this->New_EventM->student_list_sheet_array($section, $academic_session);

		$data['event_info'] = $this->Mod_Common->selectData($fields = '*', 'event_info', $condition = array('section' => $section, 'subject' => $subject, 'event_category' => 10), $limit = '', $start = '');

		$data['event_info_id'] = $data['event_info'][0]->event_info_id;



		$data['subject_detail'] = $this->New_EventM->GetSubjectDetails($section, $subject, $academic_session);

		$Subject = $data['subject_detail'][0]['subject_name'];
		$UniversitySubjectCode = $data['subject_detail'][0]['university_sub_code'];
		$CollegeSubjectCode = $data['subject_detail'][0]['clg_sub_code'];
		$Department = $data['subject_detail'][0]['department'];
		$BatchId = $section;
		$Type = $data['subject_detail'][0]['type'];

		if ($Type == 'P' || $Type == 'B') {
			$Type = 'P';
		} else if ($Type == 'E') {
			$Type = 'E';
		}

		$data['extra'] = array('Subject' => $Subject, 'Type' => $Type, 'UniversitySubjectCode' => $UniversitySubjectCode, 'CollegeSubjectCode' => $CollegeSubjectCode, 'Department' => $Department, 'BatchId' => $BatchId);

		$data['StudentCredit'] = $this->New_EventM->GetSubjectCredit($UniversitySubjectCode, $CollegeSubjectCode, $Department, $academic_session, $Type, $BatchId);

		$data['SubjectMaxMarks'] = $this->New_EventM->GetSubjectMaxMarks($UniversitySubjectCode, $CollegeSubjectCode, $Type, $Department, $BatchId);

		$i = 0;
		foreach ($data['StudentList'] as $v) {

			$temp = $this->New_EventM->GetStudentData($v['computer_code'], $v['enrollment_no'], $UniversitySubjectCode, $CollegeSubjectCode, $BatchId, $academic_session, $Type, $data['event_info_id']);

			if ($Type == 'P') {

				if (!empty($temp[0]['earn_credit'])) {

					// $data['StudentList'][$i]['TMarks'] = $temp[0]['marks'];
					$data['StudentList'][$i]['PCredit'] = $temp[0]['earn_credit'];

				} else {

					// $data['StudentList'][$i]['TMarks'] = '';
					$data['StudentList'][$i]['PCredit'] = '';
				}
			} else if ($Type == 'E') {

				if (!empty($temp[0]['earn_credit'])) {

					// $data['StudentList'][$i]['TMarks'] = $temp[0]['marks'];
					$data['StudentList'][$i]['ECredit'] = $temp[0]['earn_credit'];

				} else {

					// $data['StudentList'][$i]['TMarks'] = '';
					$data['StudentList'][$i]['ECredit'] = '';
				}

			}




			$i++;
		}


		if ($Type == 'P') {

			$this->load->view('new_template/faculty_common');
			$this->load->view('new_events/new_fill_credit_endsem_practical', $data);
			$this->load->view('new_template/new_footer');

		} else if ($Type == 'E') {

			$this->load->view('new_template/faculty_common');
			$this->load->view('new_events/new_fill_credit_endsem_extra', $data);
			$this->load->view('new_template/new_footer');

		}


	}


	//*************************************************************************************************************************************

	//**************************************************** Submit End Sem Result **********************************************************

	public function SubmitEndsemResult()
	{

		// print_r($_GET);
		// die();

		$value = $_POST['value'];
		$co = $_POST['co'];
		$Computer_code = $_POST['Computer_code'];
		$Enrollment = $_POST['Enrollment'];
		$UniversitySubjectCode = $_POST['UniversitySubjectCode'];
		$CollegeSubjectCode = $_POST['CollegeSubjectCode'];
		$Department = $_POST['Department'];
		$BatchId = $_POST['BatchId'];
		$type = $_POST['type'];
		$event_info_id = $_POST['event_info_id'];

		$academic_session = $_SESSION['user']['academic_id'];
		$faculty_computer_code = $_SESSION['user']['computer_code'];

		if ($type == 'TCredit' || $type == 'TMarks' || $type == 'TGrade') {

			$Subject_type = 'T';
		}
		if ($type == 'PCredit' || $type == 'PMarks' || $type == 'PGrade') {

			$Subject_type = 'P';
		}
		if ($type == 'ECredit' || $type == 'EMarks' || $type == 'EGrade') {

			$Subject_type = 'E';
		}
		if ($type == 'MCGrade') {

			$Subject_type = 'MC';

		}



		$check = $this->New_EventM->Check($Computer_code, $Enrollment, $UniversitySubjectCode, $CollegeSubjectCode, $Department, $BatchId, $Subject_type, $academic_session);

		// print_r($check);die();

		$data['StudentCredit'] = $this->New_EventM->GetSubjectCredit($UniversitySubjectCode, $CollegeSubjectCode, $Department, $academic_session, $Subject_type, $BatchId);
		// print_r($data['StudentCredit']);die();

		if (!empty($data['StudentCredit'])) {

			$credit = $data['StudentCredit'][0]['credit'];
		} else {

			$credit = 0;
		}


		if (($type != 'TCredit' && $type != 'PCredit' && $type != 'ECredit') && empty($check[0])) {


			if (!empty($data['StudentCredit'])) {

				$credit = $data['StudentCredit'][0]['credit'];
			} else {

				$credit = 0;
			}


		}

		$UpdateCredit = 0;

		if (($type != 'TCredit' && $type != 'PCredit' && $type != 'ECredit') && ($value == -1)) {

			$credit = 0;
			$UpdateCredit = 1;
		} elseif (($type != 'TCredit' && $type != 'PCredit' && $type != 'ECredit') && ($value != -1)) {

			if ((!empty($check[0])) && ($check[0]['earn_credit'] == 0) && ($check[0]['marks'] == -1)) {

				$credit = $data['StudentCredit'][0]['credit'];
				$UpdateCredit = 1;
			}
		}

		$IP = $this->input->ip_address();

		if ($type == 'TGrade' || $type == 'PGrade' || $type == 'EGrade' || $type == 'MCGrade') {
			$checkgrade = $this->New_EventM->CheckGrade($Computer_code, $Enrollment, $UniversitySubjectCode, $CollegeSubjectCode, $Department, $BatchId, $Subject_type, $academic_session, $event_info_id);


			if (empty($checkgrade[0])) {
				if ($value == 'F' || $value == 'F*') {
					$this->New_EventM->InsertSubjectGrade($Computer_code, $Enrollment, $UniversitySubjectCode, $CollegeSubjectCode, $Department, $BatchId, $Subject_type, $academic_session, $event_info_id, 0, $value, $IP);
				} else {
					$this->New_EventM->InsertSubjectGrade($Computer_code, $Enrollment, $UniversitySubjectCode, $CollegeSubjectCode, $Department, $BatchId, $Subject_type, $academic_session, $event_info_id, $credit, $value, $IP);
				}

			} else {
				if ($value == 'F' || $value == 'F*') {
					$this->New_EventM->UpdateSubjectGrade($Computer_code, $Enrollment, $UniversitySubjectCode, $CollegeSubjectCode, $Department, $BatchId, $Subject_type, $academic_session, $event_info_id, 0, $value, $IP);
				} else {
					$this->New_EventM->UpdateSubjectGrade($Computer_code, $Enrollment, $UniversitySubjectCode, $CollegeSubjectCode, $Department, $BatchId, $Subject_type, $academic_session, $event_info_id, $credit, $value, $IP);
				}
			}
		}

		if (empty($check[0])) {

			if ($type == 'TCredit' || $type == 'PCredit' || $type == 'ECredit') {

				// $this->New_EventM->InsertSubjectCredit($Computer_code, $Enrollment, $UniversitySubjectCode, $CollegeSubjectCode, $Department, $BatchId, $Subject_type, $academic_session, $value, $IP);
				// return 1;

			} elseif ($type == 'TMarks' || $type == 'PMarks' || $type == 'EMarks') {

				if ($type == 'EMarks') {
					$this->New_EventM->InsertSubjectExtraMarks($Computer_code, $Enrollment, $UniversitySubjectCode, $CollegeSubjectCode, $Department, $BatchId, $Subject_type, $academic_session, $event_info_id, $value, $credit, $IP);
				} else {

					if ($value == '-1') {
						$this->New_EventM->InsertSubjectMarks1($Computer_code, $Enrollment, $UniversitySubjectCode, $CollegeSubjectCode, $Department, $BatchId, $Subject_type, $academic_session, $event_info_id, $co, $value, 0, $IP);
					} else {

						$this->New_EventM->InsertSubjectMarks($Computer_code, $Enrollment, $UniversitySubjectCode, $CollegeSubjectCode, $Department, $BatchId, $Subject_type, $academic_session, $event_info_id, $co, $value, $credit, $IP);

						$student_marks = $this->New_EventM->GetSubjectMarks($Computer_code, $Enrollment, $UniversitySubjectCode, $CollegeSubjectCode, $Department, $BatchId, $Subject_type, $academic_session, $event_info_id);

						if ($student_marks[0]['co1'] == -1)
							$co1 = 0;
						else
							$co1 = $student_marks[0]['co1'];

						if ($student_marks[0]['co2'] == -1)
							$co2 = 0;
						else
							$co2 = $student_marks[0]['co2'];

						if ($student_marks[0]['co3'] == -1)
							$co3 = 0;
						else
							$co3 = $student_marks[0]['co3'];

						if ($student_marks[0]['co4'] == -1)
							$co4 = 0;
						else
							$co4 = $student_marks[0]['co4'];

						if ($student_marks[0]['co5'] == -1)
							$co5 = 0;
						else
							$co5 = $student_marks[0]['co5'];

						$total_marks = $co1 + $co2 + $co3 + $co4 + $co5;

						$this->New_EventM->UpdateSubjectTotalMarks($Computer_code, $Enrollment, $UniversitySubjectCode, $CollegeSubjectCode, $Department, $BatchId, $Subject_type, $academic_session, $event_info_id, $total_marks, $IP);

					}

				}



				return 1;
			}


			// elseif ($type == 'TMarks' || $type == 'PMarks' || $type == 'EMarks') {

			// 	$this->New_EventM->InsertSubjectMarks($Computer_code, $Enrollment, $UniversitySubjectCode, $CollegeSubjectCode, $Department, $BatchId, $Subject_type, $academic_session,$event_info_id, $co1, $co2, $co3, $co4, $co5, $total_marks, $credit, $IP);
			// 	return 1;
			// }


		} elseif (!empty($check[0])) {

			if ($type == 'TCredit' || $type == 'PCredit' || $type == 'ECredit') {

				$this->New_EventM->UpdateSubjectCredit($Computer_code, $Enrollment, $UniversitySubjectCode, $CollegeSubjectCode, $Department, $BatchId, $Subject_type, $academic_session, $value, $IP, $event_info_id);
				return 1;

			} elseif ($type == 'TMarks' || $type == 'PMarks' || $type == 'EMarks') {

				if ($type == 'EMarks') {
					$this->New_EventM->UpdateSubjectExtraMarks($Computer_code, $Enrollment, $UniversitySubjectCode, $CollegeSubjectCode, $Department, $BatchId, $Subject_type, $academic_session, $event_info_id, $value, $credit, $IP);
				} else {

					if ($value == '-1') {
						$this->New_EventM->UpdateSubjectMarks1($Computer_code, $Enrollment, $UniversitySubjectCode, $CollegeSubjectCode, $Department, $BatchId, $Subject_type, $academic_session, $event_info_id, $co, $value, $credit, $IP);
					} else {
						$this->New_EventM->UpdateSubjectMarks($Computer_code, $Enrollment, $UniversitySubjectCode, $CollegeSubjectCode, $Department, $BatchId, $Subject_type, $academic_session, $event_info_id, $co, $value, $IP);

						$student_marks = $this->New_EventM->GetSubjectMarks($Computer_code, $Enrollment, $UniversitySubjectCode, $CollegeSubjectCode, $Department, $BatchId, $Subject_type, $academic_session, $event_info_id);

						if ($student_marks[0]['co1'] == -1)
							$co1 = 0;
						else
							$co1 = $student_marks[0]['co1'];

						if ($student_marks[0]['co2'] == -1)
							$co2 = 0;
						else
							$co2 = $student_marks[0]['co2'];

						if ($student_marks[0]['co3'] == -1)
							$co3 = 0;
						else
							$co3 = $student_marks[0]['co3'];

						if ($student_marks[0]['co4'] == -1)
							$co4 = 0;
						else
							$co4 = $student_marks[0]['co4'];

						if ($student_marks[0]['co5'] == -1)
							$co5 = 0;
						else
							$co5 = $student_marks[0]['co5'];


						$total_marks = $co1 + $co2 + $co3 + $co4 + $co5;

						$this->New_EventM->UpdateSubjectTotalMarks($Computer_code, $Enrollment, $UniversitySubjectCode, $CollegeSubjectCode, $Department, $BatchId, $Subject_type, $academic_session, $event_info_id, $total_marks, $IP);
					}



				}


				if ($UpdateCredit == 1) {

					// $this->New_EventM->UpdateSubjectCredit($Computer_code, $Enrollment, $UniversitySubjectCode, $CollegeSubjectCode, $Department, $BatchId, $Subject_type, $academic_session, $credit, $IP);
				}
				return 1;
			}
			// elseif ($type == 'TMarks' || $type == 'PMarks' || $type == 'EMarks') {

			// 	$this->New_EventM->UpdateSubjectMarks($Computer_code, $Enrollment, $UniversitySubjectCode, $CollegeSubjectCode, $Department, $BatchId, $Subject_type, $academic_session, $co1, $co2, $co3, $co4, $co5, $total_marks, $IP);

			// 	if($UpdateCredit == 1){

			// 		// $this->New_EventM->UpdateSubjectCredit($Computer_code, $Enrollment, $UniversitySubjectCode, $CollegeSubjectCode, $Department, $BatchId, $Subject_type, $academic_session, $credit, $IP);
			// 	}
			// 	return 1;
			// }
		}


	}

	/****************************************** function for Re-Exam Grade containing '*' **********************************************************************************/
	function SubmitReExamResult()
	{

		// print_r($_GET);
// die();

		$Computer_code = $_POST['Computer_code'];
		$Enrollment = $_POST['Enrollment_no'];
		$UniversitySubjectCode = $_POST['UniversitySubjectCode'];
		$CollegeSubjectCode = $_POST['CollegeSubjectCode'];
		$Department = $_POST['Department'];
		$BatchId = $_POST['BatchId'];
		$type = $_POST['type'];
		$toggle = $_POST['toggle'];

		$academic_session = $_SESSION['user']['academic_id'];


		if ($toggle == 'true') {
			$check = $this->New_EventM->CheckToggle($Computer_code, $Enrollment, $Department, $BatchId, $academic_session, $UniversitySubjectCode, $CollegeSubjectCode, $type);

			if (empty($check)) {
				$this->New_EventM->UpdateToggleON($Computer_code, $Enrollment, $Department, $BatchId, $academic_session, $UniversitySubjectCode, $CollegeSubjectCode, $type);
			}

		} elseif ($toggle == 'false') {
			$this->New_EventM->UpdateToggleOFF($Computer_code, $Enrollment, $Department, $BatchId, $academic_session, $UniversitySubjectCode, $CollegeSubjectCode, $type);
		}

	}

	public function lock_sessional_faculty($section, $subject, $event_category)
	{

		$row = $this->session->userdata('user');

		$computer_code = $row['computer_code'];
		$academic_session = $row['current_session_id'];
		$department = $row['department_id'];
		$section = $section;
		$subject = $subject;
		$event_category = $event_category;

		// echo "<pre>";
		// print_r($event_category);
		// die();

		$this->New_EventM->insert_faculty_lock_status($computer_code, $department, $academic_session, $section, $event_category);

		$this->session->set_flashdata('faculty_lock', 'Sessional Locked Successfully');

		redirect('New_Events/sub_events');



	}

	public function lock_endsem($section, $subject, $event_category, $lock_type)
	{

		$row = $this->session->userdata('user');

		$computer_code = $row['computer_code'];
		$academic_session = $row['current_session_id'];
		$department = $row['department_id'];
		$batch_id = $section;
		$subject = $subject;
		$event_category = $event_category;

		// echo "<pre>";
		// print_r($event_category);
		// die();
		if ($lock_type == "marks") {
			$check = $this->New_EventM->get_faculty_lock_status_endsem($batch_id, $computer_code, $academic_session, $department);
			if (empty($check)) {
				$this->New_EventM->insert_endsem_marks_lock($computer_code, $department, $academic_session, $batch_id, $event_category);
			} else {
				$this->New_EventM->update_endsem_marks_lock($computer_code, $department, $academic_session, $batch_id, $event_category);
			}
		} else if ($lock_type == "grade") {
			$check = $this->New_EventM->get_faculty_lock_status_endsem($batch_id, $computer_code, $academic_session, $department);
			if (empty($check)) {
				$this->New_EventM->insert_endsem_grade_lock($computer_code, $department, $academic_session, $batch_id, $event_category);
			} else {
				$this->New_EventM->update_endsem_grade_lock($computer_code, $department, $academic_session, $batch_id, $event_category);
			}
		}

		$this->session->set_flashdata('faculty_lock', 'EndSem Locked Successfully');

		redirect('New_Events/sub_events');

	}


	public function lock_grade_range($batch_id, $department, $college_subject_code, $university_subject_code, $type)
	{

		$row = $this->session->userdata('user');

		$faculty_computer_code = $row['computer_code'];
		$academic_session = $row['current_session_id'];

		$IP = $this->input->ip_address();

		$data['grades'] = $this->New_EventM->FeedGrade($faculty_computer_code, $department, $batch_id, $college_subject_code, $university_subject_code, $type, $academic_session);
		$grade1 = $data['grades'][0]['grade1'];
		$grade2 = $data['grades'][0]['grade2'];
		$grade3 = $data['grades'][0]['grade3'];
		$grade4 = $data['grades'][0]['grade4'];
		$grade5 = $data['grades'][0]['grade5'];
		$grade6 = $data['grades'][0]['grade6'];

		$data['StudentList'] = $this->New_EventM->student_list_sheet_array($batch_id, $academic_session);
		// echo "<pre>";
		// print_r($data['StudentList']);
		// die();
		if ($type == 'T') {
			$event_info_id = $this->Mod_Common->selectData($fields = '*', 'event_info', $condition = array('section' => $batch_id, 'subject' => $college_subject_code, 'event_category' => 9), $limit = '', $start = '')[0]->event_info_id;
		} else {
			$event_info_id = $this->Mod_Common->selectData($fields = '*', 'event_info', $condition = array('section' => $batch_id, 'subject' => $college_subject_code, 'event_category' => 10), $limit = '', $start = '')[0]->event_info_id;
		}

		$i = 0;
		foreach ($data['StudentList'] as $v) {

			$temp = $this->New_EventM->GetStudentData($v['computer_code'], $v['enrollment_no'], $university_subject_code, $college_subject_code, $batch_id, $academic_session, $type, $event_info_id);

			$sessional = 0;
			if ($type == 'P') {
				$labwork = $this->New_EventM->fetch_eventmarks(8, $v['computer_code'], $academic_session, $faculty_computer_code, $batch_id);
				if (!empty($labwork)) {

					$total_labwork = 0;
					foreach ($labwork as $lab) {
						$total_labwork += $lab['marks'];
					}
					$sessional = $total_labwork;
				} else {
					$lab_marks = '';
				}
			} else {
				$mst_marks = $this->New_EventM->fetch_eventmarks(6, $v['computer_code'], $academic_session, $faculty_computer_code, $batch_id);

				$mst1 = 0;
				$mst2 = 0;
				foreach ($mst_marks as $m) {
					if ($m['event_name'] == 'MST1') {
						$mst1 += $m['marks'];
					} else if ($m['event_name'] == 'MST2') {
						$mst2 += $m['marks'];
					}
				}

				$sessional += $mst1 + $mst2;

				$ha1 = 0;
				$ha2 = 0;
				$ha3 = 0;
				$ha4 = 0;
				$ha5 = 0;

				$ha_marks = $this->New_EventM->fetch_eventmarks(7, $v['computer_code'], $academic_session, $faculty_computer_code, $batch_id);

				foreach ($ha_marks as $h) {
					if ($h['event_name'] == 'H1') {
						$ha1 += $h['marks'];
					} else if ($h['event_name'] == 'H2') {
						$ha2 += $h['marks'];
					} else if ($h['event_name'] == 'H3') {
						$ha3 += $h['marks'];
					} else if ($h['event_name'] == 'H4') {
						$ha4 += $h['marks'];
					} else if ($h['event_name'] == 'H5') {
						$ha5 += $h['marks'];
					}

				}

				$sessional += $ha1 + $ha2 + $ha3 + $ha4 + $ha5;

			}

			if (empty($temp)) {
				$total_marks = $sessional;
				$credit = $this->New_EventM->GetSubjectCredit($university_subject_code, $college_subject_code, $department, $academic_session, $type, $batch_id)[0]['credit'];
			} else {
				$total_marks = $temp[0]['total_marks'] + $sessional;
				$credit = $temp[0]['earn_credit'];
			}
			if ($total_marks >= $grade1) {
				$grade = 'A+';
			} else if ($total_marks < $grade1 && $total_marks >= $grade2) {
				$grade = 'A';
			} else if ($total_marks < $grade2 && $total_marks >= $grade3) {
				$grade = 'B+';
			} else if ($total_marks < $grade3 && $total_marks >= $grade4) {
				$grade = 'B';
			} else if ($total_marks < $grade4 && $total_marks >= $grade5) {
				$grade = 'C+';
			} else if ($total_marks < $grade5 && $total_marks >= $grade6) {
				$grade = 'C';
			} else if ($total_marks < $grade6 && $total_marks >= 35) {
				$grade = 'D';
			} else {
				$grade = 'F';
			}
			if ($temp[0]['total_marks'] == '-1') {
				$grade = 'F';
				$credit = 0;
			}

			if (empty($temp)) {
				$this->New_EventM->InsertSubjectGrade($v['computer_code'], $v['enrollment_no'], $university_subject_code, $college_subject_code, $department, $batch_id, $type, $academic_session, $event_info_id, $credit, $grade, $IP);
			} else {
				$this->New_EventM->UpdateSubjectGrade($v['computer_code'], $v['enrollment_no'], $university_subject_code, $college_subject_code, $department, $batch_id, $type, $academic_session, $event_info_id, $credit, $grade, $IP);
			}

			$i++;
		}

		$department_id = $row['department_id'];
		$this->New_EventM->update_grade_range_lock($faculty_computer_code, $department_id, $academic_session, $batch_id);
		$this->session->set_flashdata('grade_range_success', 'Grade Range Locked Successfully');


		redirect('New_Events/sub_events');

	}

}