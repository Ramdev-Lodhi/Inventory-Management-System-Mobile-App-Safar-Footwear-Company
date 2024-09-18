<?php
defined('BASEPATH') or exit('No direct script access allowed');


class New_EventSheets extends CI_Controller
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
		$this->load->model('Mod_Common');
		$this->load->model('New_EventM');
		// $this->load->model('AttendanceM');


	}

	public function index()
	{

		redirect('FacultyCommon');
	}


	//       $university_sub_Code= $this->New_EventM->get_univ_code($batch_id,$clg_sub_code,$batch);
	// $univ = $university_sub_Code[0];
	// $university_sub_code= implode(" ", $univ );

	// $subject_scheme_id=$this->New_EventM->get_scheme_id($clg_sub_code,$university_sub_code);
	//    echo "<pre>";
	// print_r($subject_scheme_id );die();
	// $subject_events = array();
	// $scheme_id=$subject_scheme_id[0]['scheme_id']; 

	// $subject_events_new = $this->New_EventM->scheme_join($scheme_id );
	// echo "<pre>";
	// print_r( $subject_events_new );die();
	// $data['event_category_id']= $this->New_EventM->get_event_id();

	// function objectToArray ($object) {
	// 	if(!is_object($object) && !is_array($object)){
	// 		return $object;
	// 	}
	// 	return array_map('objectToArray', (array) $object);
	// }
	// $data['subject_events'] = objectToArray($subject_events);
	// 	echo "<pre>";
	// print_r($data['subject_events']);die();	
	// $temp=array();
	// $i=0;

	public function rgpv_backup_list_practical($batch_id, $clg_sub_code, $batch)
	{
		$academic_session = $_SESSION['user']['current_session_id'];
		$faculty_computer_code = $_SESSION['user']['computer_code'];
		$data['event_category_id'] = 8;
		$data['student_list'] = $this->New_EventM->student_list_sheet_array($batch_id, $academic_session);
		// echo "<pre>";print_r($data); die();
		$data['max_marks'] = $this->New_EventM->getMaxMarks($clg_sub_code, $academic_session, $batch_id);
		// $clg_sub_code = urldecode($clg_sub_code);
		// $data['event_info_id'] = $this->Mod_Common->selectData($fields='*', 'event_info' , $condition=array('event_category'=>8, 'section'=>$section, 'subject'=>$subject), $limit='',$start='');
		$temp = array();
		$i = 0;

		// $temp=$this->New_EventM->fetch_count($data['event_category_id'],$academic_session,$faculty_computer_code,$batch_id);

		// $data['count']=$temp[0]['count'];
		$data['event_info_id'] = $this->New_EventM->practical_event_details($batch_id, $clg_sub_code, 8, $faculty_computer_code, $academic_session);
		$event_info_id = $data['event_info_id'][0]['event_info_id'];

		$data['sub_events'] = $this->New_EventM->fetch_practical_detail($event_info_id);
		$data['practical'] = array();
		$i = 0;
		foreach ($data['sub_events'] as $s) {
			$co = $s['co'];
			$data['practical'][$i] = $this->New_EventM->getPracticalForCO($event_info_id, $co);
			$i++;
		}
		// echo "<pre>";
		// print_r($data['student_list']);
		// die();
		$data['stu_p_marks'] = array();
		$j = 0;
		foreach ($data['student_list'] as $student) {
			$computer_code = $student['computer_code'];
			$total_marks = 0;
			$k = 0;
			foreach ($data['sub_events'] as $s) {
				$marks = $this->New_EventM->fetch_practical_marks($s['event_data_id'], $computer_code);
				if (!empty($marks)) {
					$data['student_list'][$j]['marks'][$k] = $marks[0];
					$total_marks += $marks[0]['marks'];
				} else {
					$data['student_list'][$j]['marks'][$k] = "";
				}
				$k++;
			}

			$data['student_list'][$j]['total_marks'] = $total_marks;

			$j++;
		}

		// echo "<pre>";
		// 	print_r($data['student_list']);
		// 	die();
		$data['section'] = $batch_id;
		$data['subject'] = $clg_sub_code;
		// $data['attendence']=$this->getStudentsAttendence($section,$subject);
		$data['semester_details'] = $this->New_EventM->semester_details($batch_id);
		$specialization = $data['semester_details'][0]->specialization;
		if ($specialization != 0) {
			$specialization_name = $this->New_EventM->get_specialization_name($specialization);
			$data['specialization'] = $specialization_name[0]['name'];
		}
		// echo "<pre>";
		// print_r($data['semester_details']);
		// die();

		if ($specialization == 0) {
			$this->load->view('new_event_sheets/rgpv_backup_common_practical', $data);
		} else {
			$this->load->view('new_event_sheets/rgpv_backup_common_practical_mtech', $data);
		}



	}


















	public function rgpv_backup_list($batch_id, $clg_sub_code, $batch)
	{
		//  $clg_sub_code = urldecode($clg_sub_code);
		$data['event_category_id'] = $this->New_EventM->get_event_id();
		// echo "<pre>";
		// print_r($data['event_category_id']);
		// die();
		$academic_session = $_SESSION['user']['current_session_id'];
		$faculty_computer_code = $_SESSION['user']['computer_code'];

		// $data['subject_events'] =$this->New_EventM->
		$temp = array();
		$i = 0;
		foreach ($data['event_category_id'] as $key) {
			$temp = $this->New_EventM->fetch_count($key['event_category_id'], $academic_session, $faculty_computer_code, $batch_id);

			$data['event_category_id'][$i]['count'] = $temp[0]['count'];

			$i++;
		}


		$data['student_marks'] = array();

		// $data['sub_events'] = $this->New_EventM->fetch_detail($academic_session,$faculty_computer_code,$batch_id);

		// echo "<pre>";
		// print_r($data['event_category_id']);
		// die();
		// $i=0;
		// foreach ($data['event_category_id'] as $key) {
		// $data['event_marks'][$i] = $this->New_EventM->fetch_eventmarks($key['event_category_id'],$academic_session,$faculty_computer_code,$batch_id);
		// $i++;
		// }

		$event_name_array = array();
		$event_name_array[0] = "MST1";
		$event_name_array[1] = "MST2";

		$event_name_array[2] = "H1";
		$event_name_array[3] = "H2";
		$event_name_array[4] = "H3";
		$event_name_array[5] = "H4";
		$event_name_array[6] = "H5";

		$data['section'] = $batch_id;
		$data['subject'] = $clg_sub_code;
		// $data['attendence']=$this->getStudentsAttendence($section,$subject);
		$data['semester_details'] = $this->New_EventM->semester_details($batch_id);
		$data['student_list'] = $this->New_EventM->student_list_sheet($batch_id, $academic_session);
		// echo "<pre>";
		// print_r($data['student_list']);
		// die();
		$j = 0;
		foreach ($data['student_list'] as $student) {
			$computer_code = $student->computer_code;
			$enrollment_no = $student->enrollment_no;
			$student_name = $student->student_name;
			$data['student_marks'][$j]['computer_code'] = $computer_code;
			$data['student_marks'][$j]['enrollment_no'] = $enrollment_no;
			$data['student_marks'][$j]['student_name'] = $student_name;
			$i = 0;
			$total = 0;
			$mst_total = 0;
			$ha_total = 0;
			foreach ($event_name_array as $key) {
				$marks = $this->New_EventM->fetch_eventmarks_new($key, $computer_code, $academic_session, $faculty_computer_code, $batch_id);
				// echo "<pre>";
				// print_r($marks);
				// die();
				if (!empty($marks)) {
					if ($key == "MST1" || $key == "MST2") {
						$mst_total += $marks[0]['marks'];
						$total += $marks[0]['marks'];
					} else {
						$ha_total += $marks[0]['marks'];
						$total += $marks[0]['marks'];
					}
					$data['student_marks'][$j][$key] = $marks[0]['marks'];
				} else {
					$data['student_marks'][$j][$key] = "";
				}
			}
			$data['student_marks'][$j]['MST_Total'] = $mst_total;
			$data['student_marks'][$j]['HA_Total'] = $ha_total;
			$data['student_marks'][$j]['Total'] = $total;
			$j++;
		}

		$specialization = $data['semester_details'][0]->specialization;
		if ($specialization != 0) {
			$specialization_name = $this->New_EventM->get_specialization_name($specialization);
			$data['specialization'] = $specialization_name[0]['name'];
		}

		$data['section'] = $batch_id;
		$data['subject'] = $clg_sub_code;
		//   echo "<pre>";
		//   print_r($data['student_marks']);
		//   die();
		if ($specialization == 0) {
			$this->load->view('new_event_sheets/rgpv_backup_common', $data);
		} else {
			$this->load->view('new_event_sheets/rgpv_backup_common_mtech', $data);
		}

		//****************************************************************************************************************************


	}



	// *****************  EndSem Sheets *********************************************

	public function rgpv_endsem_theory($batch_id, $clg_sub_code, $batch)
	{
		$row = $this->session->userdata('user');
		$academic_session = $_SESSION['user']['current_session_id'];
		$academic_session_name = $_SESSION['user']['current_session'];
		$faculty_computer_code = $_SESSION['user']['computer_code'];
		$data['event_category_id'] = 9;
		$data['StudentList'] = $this->New_EventM->student_list_sheet_array($batch_id, $academic_session);

		$data['event_info'] = $this->Mod_Common->selectData($fields = '*', 'event_info', $condition = array('section' => $batch_id, 'subject' => $clg_sub_code, 'event_category' => 9), $limit = '', $start = '');
		$data['event_info_id'] = $data['event_info'][0]->event_info_id;
		$data['subject_detail'] = $this->New_EventM->GetSubjectDetails($batch_id, $clg_sub_code, $academic_session);

		$Type = 'T';

		$Subject = $data['subject_detail'][0]['subject_name'];
		$UniversitySubjectCode = $data['subject_detail'][0]['university_sub_code'];
		$CollegeSubjectCode = $data['subject_detail'][0]['clg_sub_code'];
		$Department = $data['subject_detail'][0]['department'];
		$specialization = $data['subject_detail'][0]['specialization'];
		$course = $data['subject_detail'][0]['course'];

		$BatchId = $batch_id;
		$batch_name = $this->New_EventM->batch_name($batch_id);
		$BatchName = $batch_name[0]['batch'];
		$department_name = $this->New_EventM->department_name($Department);
		$DepartmentName = $department_name[0]['name'];
		// print_r($DepartmentName);
		// die();
		$Semester = $data['StudentList'][0]['semester'];

		$department = $row['department_id'];

		$check = $this->New_EventM->get_faculty_lock_status_endsem($batch_id, $faculty_computer_code, $academic_session, $department);
		if (!empty($check)) {
			$endsem_lock_grade = $check[0]['lock_grade'];
		} else {
			$endsem_lock_grade = 0;
		}
		// print_r($check);
		// die();
		$data['extra'] = array('Subject' => $Subject, 'Type' => $Type, 'UniversitySubjectCode' => $UniversitySubjectCode, 'CollegeSubjectCode' => $CollegeSubjectCode, 'Department' => $Department, 'BatchId' => $BatchId, 'Semester' => $Semester, 'BatchName' => $BatchName, 'Session' => $academic_session_name, 'DepartmentName' => $DepartmentName, 'Course' => $course, 'EndSemGradeLock' => $endsem_lock_grade);


		$data['SubjectMaxMarks'] = $this->New_EventM->GetSubjectMaxMarks($UniversitySubjectCode, $CollegeSubjectCode, $Type, $Department, $BatchId);

		$data['SubjectMaxMarks'][0]['total_marks'] = $data['SubjectMaxMarks'][0]['end_sem'] + $data['SubjectMaxMarks'][0]['mst'] + $data['SubjectMaxMarks'][0]['assignment'];

		$data['student_mst_marks'] = array();
		$i = 0;
		foreach ($data['StudentList'] as $v) {

			$temp = $this->New_EventM->GetStudentData($v['computer_code'], $v['enrollment_no'], $UniversitySubjectCode, $CollegeSubjectCode, $BatchId, $academic_session, $Type, $data['event_info_id']);

			//********************************************************************************************************************************************
			//  		echo "<pre>";
			// print_r($temp);
			// die();

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
			// $mst = 	round(($mst1+$mst2)/2);
			$mst = ($mst1 + $mst2);


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
			// $ha = round(($ha1 + $ha2 + $ha3 + $ha4 + $ha5)/5);
			$ha = ($ha1 + $ha2 + $ha3 + $ha4 + $ha5);


			//********************************************************************************************************************************************

			if (!empty($temp[0])) {

				$data['StudentList'][$i]['co1'] = $temp[0]['co1'];
				$data['StudentList'][$i]['co2'] = $temp[0]['co2'];
				$data['StudentList'][$i]['co3'] = $temp[0]['co3'];
				$data['StudentList'][$i]['co4'] = $temp[0]['co4'];
				$data['StudentList'][$i]['co5'] = $temp[0]['co5'];
				$data['StudentList'][$i]['endsem'] = $temp[0]['total_marks'];
				$data['StudentList'][$i]['credit'] = $temp[0]['earn_credit'];
				$data['StudentList'][$i]['mst'] = $mst;
				$data['StudentList'][$i]['quiz'] = $ha;
				if ($temp[0]['total_marks'] == '-1') {
					$data['StudentList'][$i]['TotalMarks'] = $ha + $mst;
				} else {
					$data['StudentList'][$i]['TotalMarks'] = $temp[0]['total_marks'] + $ha + $mst;
				}

				$data['StudentList'][$i]['Grade'] = $temp[0]['grade'];


				// $data['StudentList'][$i]['TCredit'] = $temp[0]['earn_credit'];

			} else {

				$data['StudentList'][$i]['co1'] = '';
				$data['StudentList'][$i]['co2'] = '';
				$data['StudentList'][$i]['co3'] = '';
				$data['StudentList'][$i]['co4'] = '';
				$data['StudentList'][$i]['co5'] = '';
				$data['StudentList'][$i]['credit'] = '';
				$data['StudentList'][$i]['endsem'] = '';
				$data['StudentList'][$i]['mst'] = '';
				$data['StudentList'][$i]['quiz'] = '';
				$data['StudentList'][$i]['TotalMarks'] = '';
				$data['StudentList'][$i]['Grade'] = '';


				// $data['StudentList'][$i]['TCredit'] = '';
			}


			$i++;
		}


		//  	echo "<pre>";
		// print_r($data['StudentList']);
		// die();

		// $this->load->view('new_template/faculty_common');
		if ($specialization == 0) {
			$this->load->view('new_event_sheets/endsem_theory_sheet', $data);
		} else {
			$specialization_name = $this->New_EventM->get_specialization_name($specialization);
			$data['specialization'] = $specialization_name[0]['name'];
			$this->load->view('new_event_sheets/endsem_theory_sheet_mtech', $data);
		}

		// $this->load->view('new_template/new_footer');

	}

	public function rgpv_endsem_practical($batch_id, $clg_sub_code, $batch)
	{
		$row = $this->session->userdata('user');
		$academic_session = $_SESSION['user']['current_session_id'];
		$academic_session_name = $_SESSION['user']['current_session'];
		$faculty_computer_code = $_SESSION['user']['computer_code'];
		$data['event_category_id'] = 10;
		$data['StudentList'] = $this->New_EventM->student_list_sheet_array($batch_id, $academic_session);

		$data['event_info'] = $this->Mod_Common->selectData($fields = '*', 'event_info', $condition = array('section' => $batch_id, 'subject' => $clg_sub_code, 'event_category' => 10), $limit = '', $start = '');
		$data['event_info_id'] = $data['event_info'][0]->event_info_id;
		$data['subject_detail'] = $this->New_EventM->GetSubjectDetails($batch_id, $clg_sub_code, $academic_session);

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
		$specialization = $data['subject_detail'][0]['specialization'];
		$course = $data['subject_detail'][0]['course'];
		$BatchId = $batch_id;
		$batch_name = $this->New_EventM->batch_name($batch_id);
		$BatchName = $batch_name[0]['batch'];
		$department_name = $this->New_EventM->department_name($Department);
		$DepartmentName = $department_name[0]['name'];

		$Semester = $data['StudentList'][0]['semester'];
		$department = $row['department_id'];

		$check = $this->New_EventM->get_faculty_lock_status_endsem($batch_id, $faculty_computer_code, $academic_session, $department);
		if (!empty($check)) {
			$endsem_lock_grade = $check[0]['lock_grade'];
		} else {
			$endsem_lock_grade = 0;
		}
		$data['extra'] = array('Subject' => $Subject, 'Type' => $Type, 'UniversitySubjectCode' => $UniversitySubjectCode, 'CollegeSubjectCode' => $CollegeSubjectCode, 'Department' => $Department, 'BatchId' => $BatchId, 'Semester' => $Semester, 'BatchName' => $BatchName, 'Session' => $academic_session_name, 'DepartmentName' => $DepartmentName, 'Course' => $course, 'EndSemGradeLock' => $endsem_lock_grade);


		$data['SubjectMaxMarks'] = $this->New_EventM->GetSubjectMaxMarks($UniversitySubjectCode, $CollegeSubjectCode, $Type, $Department, $BatchId);

		$data['SubjectMaxMarks'][0]['total_marks'] = $data['SubjectMaxMarks'][0]['end_sem'] + $data['SubjectMaxMarks'][0]['labwork_sessional'];

		if ($Type == 'P') {

			$i = 0;
			foreach ($data['StudentList'] as $v) {

				$temp = $this->New_EventM->GetStudentData($v['computer_code'], $v['enrollment_no'], $UniversitySubjectCode, $CollegeSubjectCode, $BatchId, $academic_session, $Type, $data['event_info_id']);

				//********************************************************************************************************************************************


				$labwork = $this->New_EventM->fetch_eventmarks(8, $v['computer_code'], $academic_session, $faculty_computer_code, $BatchId);

				// echo "<pre>";
				// print_r($labwork);
				// die();		

				if (!empty($labwork)) {

					$total_labwork = 0;
					foreach ($labwork as $lab) {

						$total_labwork += $lab['marks'];

					}
					$lab_marks = $total_labwork;
					// $avg = $total_labwork/count($labwork);

					// $lab_marks = round($avg * 4);

				} else {

					$lab_marks = '';
				}

				//********************************************************************************************************************************************

				if (!empty($temp[0])) {
					$data['StudentList'][$i]['co1'] = $temp[0]['co1'];
					$data['StudentList'][$i]['co2'] = $temp[0]['co2'];
					$data['StudentList'][$i]['co3'] = $temp[0]['co3'];
					$data['StudentList'][$i]['co4'] = $temp[0]['co4'];
					$data['StudentList'][$i]['co5'] = $temp[0]['co5'];
					$data['StudentList'][$i]['credit'] = $temp[0]['earn_credit'];
					$data['StudentList'][$i]['endsem'] = $temp[0]['total_marks'];
					$data['StudentList'][$i]['labsessional'] = $lab_marks;

					if ($temp[0]['total_marks'] == '-1') {
						$data['StudentList'][$i]['TotalMarks'] = $lab_marks;
					} else {
						$data['StudentList'][$i]['TotalMarks'] = $temp[0]['total_marks'] + $lab_marks;
					}

					$data['StudentList'][$i]['Grade'] = $temp[0]['grade'];


					// $data['StudentList'][$i]['TCredit'] = $temp[0]['earn_credit'];

				} else {
					$data['StudentList'][$i]['co1'] = '';
					$data['StudentList'][$i]['co2'] = '';
					$data['StudentList'][$i]['co3'] = '';
					$data['StudentList'][$i]['co4'] = '';
					$data['StudentList'][$i]['co5'] = '';

					$data['StudentList'][$i]['endsem'] = '';
					$data['StudentList'][$i]['credit'] = '';
					$data['StudentList'][$i]['labsessional'] = '';
					$data['StudentList'][$i]['TotalMarks'] = '';
					$data['StudentList'][$i]['Grade'] = '';


					// $data['StudentList'][$i]['TCredit'] = '';
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
					$data['StudentList'][$i]['credit'] = $temp[0]['earn_credit'];
					$data['StudentList'][$i]['endsem'] = $temp[0]['total_marks'];
					$data['StudentList'][$i]['labsessional'] = $lab_marks;

					if ($temp[0]['total_marks'] == '-1') {
						$data['StudentList'][$i]['TotalMarks'] = $lab_marks;
					} else {
						$data['StudentList'][$i]['TotalMarks'] = $temp[0]['total_marks'] + $lab_marks;
					}

					$data['StudentList'][$i]['Grade'] = $temp[0]['grade'];


					// $data['StudentList'][$i]['TCredit'] = $temp[0]['earn_credit'];

				} elseif ($data['SubjectMaxMarks'][0]['end_sem'] == 0) {
					$data['StudentList'][$i]['credit'] = $temp[0]['earn_credit'];
					$data['StudentList'][$i]['endsem'] = '';
					$data['StudentList'][$i]['labsessional'] = $lab_marks;
					$data['StudentList'][$i]['TotalMarks'] = $lab_marks;
					$data['StudentList'][$i]['Grade'] = $temp[0]['grade'];
				} else {
					$data['StudentList'][$i]['credit'] = '';
					$data['StudentList'][$i]['endsem'] = '';
					$data['StudentList'][$i]['labsessional'] = '';
					$data['StudentList'][$i]['TotalMarks'] = '';
					$data['StudentList'][$i]['Grade'] = '';


					// $data['StudentList'][$i]['TCredit'] = '';
				}


				$i++;
			}
		}

		// 	echo "<pre>";
		// print_r($data['StudentList']);
		// die();

		if ($Type == 'P') {

			if ($specialization == 0) {
				$this->load->view('new_event_sheets/endsem_practical_sheet', $data);
			} else {
				$specialization_name = $this->New_EventM->get_specialization_name($specialization);
				$data['specialization'] = $specialization_name[0]['name'];
				$this->load->view('new_event_sheets/endsem_practical_sheet_mtech', $data);
			}
			// $this->load->view('new_template/faculty_common');

			// $this->load->view('new_template/new_footer');

		} else if ($Type == 'E') {

			if ($specialization == 0) {
				$this->load->view('new_event_sheets/endsem_extra_sheet', $data);
			} else {
				$specialization_name = $this->New_EventM->get_specialization_name($specialization);
				$data['specialization'] = $specialization_name[0]['name'];
				$this->load->view('new_event_sheets/endsem_extra_sheet_mtech', $data);
			}
			// $this->load->view('new_template/faculty_common');

			// $this->load->view('new_template/new_footer');

		}


	}

	public function fill_marks_combined_pa($section, $subject, $event_info_id)
	{
		$row = $this->session->userdata('user');
		$academic_session = $_SESSION['user']['current_session_id'];
		$data['student_list'] = $this->New_EventM->student_list_sheet($section, $academic_session);
		$data['event_info_id'] = $this->Mod_Common->selectData($fields = '*', 'event_info', $condition = array('event_category' => 8, 'section' => $section, 'subject' => $subject), $limit = '', $start = '');
		$event_info_id = $data['event_info_id'][0]->event_info_id;
		$data['event_data'] = $this->Mod_Common->selectData($fields = '*', 'event_data', $condition = array('event_info' => $event_info_id));

		$data['practical'] = array();
		for ($i = 1; $i <= 5; $i++) {
			$co = "CO" . $i;
			$data['practical'][$i] = $this->New_EventM->getPracticalForCO($event_info_id, $co);
		}
		$this->load->view('new_template/faculty_common');
		$this->load->view('new_event_sheets/new_fill_marks_combined_pa', $data);
		$this->load->view('new_template/new_footer');

	}
	public function sessional_practical_sheet_blank($batch_id, $clg_sub_code, $batch,$subject_name){
		$subjects_name = urldecode($subject_name);
		$data['subject_name'] = str_replace('%20', ' ', $subjects_name);

		// echo "<pre>"; print_r($subject_name); die(); 
		$academic_session = $_SESSION['user']['current_session_id'];
		$faculty_computer_code = $_SESSION['user']['computer_code'];
		$data{'department_name'} = $_SESSION['user']['department_name'];
		$data['sem'] = $_SESSION['user']['semester_array'];
		$data['clg_sub_code']=$clg_sub_code;
		$data['event_category_id'] = 8;
		$data['student_list'] = $this->New_EventM->student_list_sheet_array($batch_id, $academic_session);
		// echo "<pre>";print_r($data); die();
		// $this->load->view('new_template/faculty_common');
		$this->load->view('new_event_sheets/sessional_practical_blank',$data);
		// $this->load->view('new_template/new_footer');

	}



}