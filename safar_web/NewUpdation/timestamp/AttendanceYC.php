<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AttendanceYC extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		error_reporting(0);
		$this->load->library('session');
		$row = $this->session->userdata('user');

		if (empty($row['computer_code'])) {
			redirect(base_url('Login'));
		}
		$this->load->model('AttendanceYCM');


	}


	// functions  daveloped during subject coordinator attendence system davelopement	

	public function index()
	{

		$this->load->library('session');
		$row = $this->session->userdata('user');
		$faculty_computer_code = $row['computer_code'];
		$current_session_id = $row['current_session_id'];

		$data = $this->AttendanceYCM->get_year($faculty_computer_code, $current_session_id);
		// $sem = $this->AttendanceYCM->get_semester($data[0]['year']);
		$specialization = 0;
		$home_dept = $data[0]['dept_id'];
		$semester = $row['semester_array'][$data[0]['year'] - 1];
		$data['student_list'] = $this->AttendanceYCM->get_student_list($home_dept, $semester, $current_session_id, $specialization);
		$data['timestamp']=$this->AttendanceYCM->get_tiemstamp($home_dept, $semester, $current_session_id, $specialization);
    
		// if($current_session_id % 2 == 0){
		// 	$to_date = 2022-01-01;
		// 	$mydate=getdate(date("U"));
		// 	$from_date = $mydate['year']."-".$mydate['mon']."-".$mydate['mday'];	
		// }
		// elseif($current_session_id % 2 != 0){
		// 	$to_date = 2022-07-01;
		// 	$mydate=getdate(date("U"));
		// 	$from_date = $mydate['year']."-".$mydate['mon']."-".$mydate['mday'];	
		// }

		for ($i = 0; $i < sizeof($data['student_list']); $i++) {
			$computer_code = $data['student_list'][$i]['computer_code'];
			$semester = $data['student_list'][$i]['semester'];
			$home_dept = $data['student_list'][$i]['home_dept'];
			$academic_session = $data['student_list'][$i]['academic_session'];
			// $data['student_list'][$i]['total_percentage'] = $this->CumulativeAttendence($computer_code,$to_date,$from_date,$semester,$academic_session,$home_dept);
		}

		$data['specialization'] = $specialization;
		$data['department'] = $home_dept;
		$data['semester'] = $semester;
		$data['academic_session'] = $current_session_id;

		$this->load->view('new_template/faculty_common');
		$this->load->view('attendanceYC/view_classes', $data);
		$this->load->view('new_template/new_footer');
	}

	public function mtech()
	{

		$this->load->library('session');
		$row = $this->session->userdata('user');
		$faculty_computer_code = $row['computer_code'];
		$current_session_id = $row['current_session_id'];

		$data = $this->AttendanceYCM->get_year_mtech($faculty_computer_code, $current_session_id);
		$specialization = $data[0]['specialization'];
		// $sem = $this->AttendanceYCM->get_semester($data[0]['year']);
		$home_dept = $data[0]['dept_id'];
		$semester = $row['semester_array'][$data[0]['year'] - 1];
		$data['student_list'] = $this->AttendanceYCM->get_student_list($home_dept, $semester, $current_session_id, $specialization);

		// if($current_session_id % 2 == 0){
		// 	$to_date = 2022-01-01;
		// 	$mydate=getdate(date("U"));
		// 	$from_date = $mydate['year']."-".$mydate['mon']."-".$mydate['mday'];	
		// }
		// elseif($current_session_id % 2 != 0){
		// 	$to_date = 2022-07-01;
		// 	$mydate=getdate(date("U"));
		// 	$from_date = $mydate['year']."-".$mydate['mon']."-".$mydate['mday'];	
		// }

		for ($i = 0; $i < sizeof($data['student_list']); $i++) {
			$computer_code = $data['student_list'][$i]['computer_code'];
			$semester = $data['student_list'][$i]['semester'];
			$home_dept = $data['student_list'][$i]['home_dept'];
			$academic_session = $data['student_list'][$i]['academic_session'];
			// $data['student_list'][$i]['total_percentage'] = $this->CumulativeAttendence($computer_code,$to_date,$from_date,$semester,$academic_session,$home_dept);
		}

		$data['specialization'] = $specialization;

		$this->load->view('new_template/faculty_common');
		$this->load->view('attendanceYC/view_classes', $data);
		$this->load->view('new_template/new_footer');
	}


	public function view_attendence()
	{

		$data['computer_code'] = $_POST['computer_code'];
		$data['semester'] = $_POST['semester'];
		$data['academic_session'] = $_POST['academic_session'];
		$data['home_dept'] = $_POST['home_dept'];
		$data['specialization'] = $_POST['specialization'];

		$this->load->view('new_template/faculty_common');
		$this->load->view('attendanceYC/view_attendance', $data);
		$this->load->view('new_template/new_footer');
	}

	public function getAllStudents()
	{
		// $data=$this->AttendanceYCM->getAllStudents1();

		$this->load->library('session');
		$row = $this->session->userdata('user');
		$faculty_computer_code = $row['computer_code'];
		$current_session_id = $row['current_session_id'];

		$data1 = $this->AttendanceYCM->get_year($faculty_computer_code, $current_session_id);
		$specialization = 0;
		$home_dept = $data1[0]['dept_id'];
		// $sem = $this->AttendanceYCM->get_semester($data1[0]['year']);
		$semester = $row['semester_array'][$data1[0]['year'] - 1];
		$data = $this->AttendanceYCM->get_student_list($home_dept, $semester, $current_session_id, $specialization);

		// echo "<pre>";
		// print_r($data);die();

		echo '<tbody>';
		foreach ($data as $key => $value) {
			echo '<tr>
         			<td><input type="checkbox" name="computer_code[]" id="' . $value['computer_code'] . '" value="' . $value['computer_code'] . '" /></td>
         			<td  ><label for="' . $value['computer_code'] . '" >' . $value['enrollment_no'] . '</label></td>
         			<td>' . $value['student_name'] . '</td>
         			
         		</tr>';

		}

	}

	public function getAllStudents_mtech()
	{
		// $data=$this->AttendanceYCM->getAllStudents1();

		$this->load->library('session');
		$row = $this->session->userdata('user');
		$faculty_computer_code = $row['computer_code'];
		$current_session_id = $row['current_session_id'];

		$data1 = $this->AttendanceYCM->get_year_mtech($faculty_computer_code, $current_session_id);
		$specialization = $data1[0]['specialization'];
		$home_dept = $data1[0]['dept_id'];
		// $sem = $this->AttendanceYCM->get_semester($data1[0]['year']);

		$semester = $row['semester_array'][$data1[0]['year'] - 1];
		$data = $this->AttendanceYCM->get_student_list($home_dept, $semester, $current_session_id, $specialization);

		// echo "<pre>";
		// print_r($data);die();

		echo '<tbody>';
		foreach ($data as $key => $value) {
			echo '<tr>
         			<td><input type="checkbox" name="computer_code[]" id="' . $value['computer_code'] . '" value="' . $value['computer_code'] . '" /></td>
         			<td  ><label for="' . $value['computer_code'] . '" >' . $value['enrollment_no'] . '</label></td>
         			<td>' . $value['student_name'] . '</td>
         			
         		</tr>';

		}

	}


















	public function takeOtherAttendence($specialization)
	{
		$specialization = base64_decode($specialization);
		//   echo "<pre>";
		//   print_r($specialization);
		//   die();
		//$data=$this->AttendanceYCM->fillAttendenceLoadInfo($class_subject_id);

		$this->load->library('session');
		$row = $this->session->userdata('user');
		$faculty_computer_code = $row['computer_code'];
		$current_session_id = $row['current_session_id'];
		// print_r($current_session_id);
		// die();
		if ($specialization == 0) {
			$data1 = $this->AttendanceYCM->get_year($faculty_computer_code, $current_session_id);
		} else {
			$data1 = $this->AttendanceYCM->get_year_mtech($faculty_computer_code, $current_session_id);
		}
		// echo "<pre>";
		// print_r($data1);
		// die();
		// $sem = $this->AttendanceYCM->get_semester($data1[0]['year']);
		$data['home_dept'] = $data1[0]['dept_id'];
		$data['semester'] = $row['semester_array'][$data1[0]['year'] - 1];
		// print_r($data['semester']);
		// die();
		$data['academic_session'] = $current_session_id;
		$data['lecture_type'] = $this->AttendanceYCM->getOtherLectureTypes();
		$data['specialization'] = $specialization;
		//   $data['section_id']=$section_id;
		if ($specialization == 0) {
			$this->load->view('new_template/faculty_common');
			$this->load->view('attendanceYC/fillOtherAttendence', $data);
			$this->load->view('new_template/new_footer');

		} else {
			$this->load->view('new_template/faculty_common');
			$this->load->view('attendanceYC/fillOtherAttendence_mtech', $data);
			$this->load->view('new_template/new_footer');

		}


	}















	public function submitOtherAttendence()
	{
		$result = $this->AttendanceYCM->submitOtherAttendence($_POST);

		if (!$result) {
			echo "<script>alert('Something Went Wrong');</script>";
		} else {
			$department = $_POST['home_dept'];
			$semester = $_POST['semester'];
			$academic_session = $_POST['academic_session'];
			$lecture_type = $_POST['lecture_type'];
			$lectureWeight = $this->AttendanceYCM->getLectureWeightOther($lecture_type);
			$lecture_weight = $lectureWeight[0]['lecture_weight'];
			$students = $_POST['computer_code'];
			$specialization = $_POST['specialization'];
			if ($lecture_type == '10') {
				foreach ($students as $s) {
					$computer_code = $s;
					$this->AttendanceYCM->updateRemedials($computer_code, $academic_session);
				}
			} else {
				// $all_students = $this->AttendanceYCM->get_student_list($department, $semester, $academic_session, $specialization);
				foreach ($students as $s) {
					$computer_code = $s;
					$check = $this->AttendanceYCM->getCumulativeAttendence($computer_code, $academic_session);

					if (empty($check)) {
						// insertquery -

						$student_attendance = $lecture_weight;
						$total_attendance = $lecture_weight;
						$cumulative_attendence = ($student_attendance / $total_attendance) * 100;
						$cumulative_attendence += $check[0]['remedial'] * 2;
						$this->AttendanceYCM->insertCumulativeAttendence($computer_code, $semester, $department, $academic_session, $student_attendance, $total_attendance, $cumulative_attendence);

					} else {


						$student_attendance = $check[0]['student_attendance'];
						$total_attendance = $check[0]['total_attendance'];
						$student_attendance += $lecture_weight;
						$total_attendance += $lecture_weight;
						$cumulative_attendence = ($student_attendance / $total_attendance) * 100;
						$cumulative_attendence += $check[0]['remedial'] * 2;
						$this->AttendanceYCM->updateCumulativeAttendance($computer_code, $academic_session, $student_attendance, $total_attendance, $cumulative_attendence);

					}

				}
			}

			if ($specialization == 0) {
				redirect(base_url() . "AttendanceYC/");
			} else {
				redirect(base_url() . "AttendanceYC/mtech");
			}

		}


	}











	public function view_student_attendance()
	{
		// echo "<pre>";
// print_r($_POST);
// die();
		extract($_POST);


		switch ($action) {
			case 'combined_attendence':
				$this->viewCombinedAttendenceDateWise($computer_code, $to_date, $from_date, $semester, $academic_session, $home_dept, $specialization);
				break;

			case 'combined_attendence_print':
				$this->printCombinedAttendence($computer_code, $to_date, $from_date, $semester, $academic_session, $home_dept);
				break;

			case 'office_attendence':
				$this->printOfficeAttendence($computer_code, $to_date, $from_date, $semester, $academic_session, $home_dept);
				break;

			default:
				# code...
				break;
		}


	}



















	public function viewCombinedAttendenceDateWise($computer_code, $to_date, $from_date, $semester, $academic_session, $home_dept, $specialization)
	{

		$faculty_computer_code = $_SESSION['user']['computer_code'];
		$student = $this->AttendanceYCM->getStudent($computer_code);

		// $lab_group = $student[0]['lab_group_name'];

		$data['all_subjects'] = $this->AttendanceYCM->getAllSubjectsForClass($computer_code, $semester, $academic_session, $home_dept, $specialization);

		$data['mst'] = 0;
		$data['other'] = 0;
		$data['remedial'] = 0;
		if (!empty($data['all_subjects'])) {
			for ($i = 0; $i < count($data['all_subjects']); $i++) {

				$batch_id = $data['all_subjects'][$i]['batch_id'];
				$lab_group = $data['all_subjects'][$i]['lab_group_name'];
				// ************ Theory attendance ********************************
				$total_theory_attendence = $this->AttendanceYCM->getTotalTheoryAttendence($computer_code, $batch_id, $to_date, $from_date, $academic_session);
				if (empty($total_theory_attendence[0]['total'])) {
					$data['all_subjects'][$i]['total_theory'] = 0;
				} else {
					$data['all_subjects'][$i]['total_theory'] = $total_theory_attendence[0]['total'];
				}
				$total_theory += $data['all_subjects'][$i]['total_theory'];

				$theory_attendence = $this->AttendanceYCM->getTheoryAttendence($computer_code, $batch_id, $to_date, $from_date, $academic_session);
				if (empty($theory_attendence[0]['total'])) {
					$data['all_subjects'][$i]['theory'] = 0;
				} else {
					$data['all_subjects'][$i]['theory'] = $theory_attendence[0]['total'];
				}
				$theory += $data['all_subjects'][$i]['theory'];
				// ************************************************************************

				// ************ Practical attendance ********************************

				$total_practical_attendence = $this->AttendanceYCM->getTotalPracticalAttendence($computer_code, $batch_id, $to_date, $from_date, $lab_group, $academic_session);
				if (empty($total_practical_attendence[0]['total'])) {
					$data['all_subjects'][$i]['total_practical'] = 0;
				} else {
					$data['all_subjects'][$i]['total_practical'] = $total_practical_attendence[0]['total'];
				}
				$total_practical += $data['all_subjects'][$i]['total_practical'];

				$practical_attendence = $this->AttendanceYCM->getPracticalAttendence($computer_code, $batch_id, $to_date, $from_date, $lab_group, $academic_session);
				// echo "<pre>";
				// print_r($practical_attendence);
				// die();
				if (empty($practical_attendence[0]['total'])) {
					$data['all_subjects'][$i]['practical'] = 0;
				} else {
					$data['all_subjects'][$i]['practical'] = $practical_attendence[0]['total'];
				}
				$practical += $data['all_subjects'][$i]['practical'];

				// ************************************************************************

				// ************ CBS attendance ********************************

				$total_cbs_attendence = $this->AttendanceYCM->getTotalCBSAttendence($computer_code, $batch_id, $to_date, $from_date, $academic_session);
				if (empty($total_cbs_attendence[0]['total'])) {
					$data['all_subjects'][$i]['total_cbs'] = 0;
				} else {
					$data['all_subjects'][$i]['total_cbs'] = $total_cbs_attendence[0]['total'];
				}
				$total_cbs += $data['all_subjects'][$i]['total_cbs'];

				$cbs_attendence = $this->AttendanceYCM->getCBSAttendence($computer_code, $batch_id, $to_date, $from_date, $academic_session);
				if (empty($cbs_attendence[0]['total'])) {
					$data['all_subjects'][$i]['cbs'] = 0;
				} else {
					$data['all_subjects'][$i]['cbs'] = $cbs_attendence[0]['total'];
				}
				$cbs += $data['all_subjects'][$i]['cbs'];

				// ************************************************************************

				// ************ CBS attendance ********************************		


				$total_tutorial_attendence = $this->AttendanceYCM->getTotalTutorialAttendence($computer_code, $batch_id, $to_date, $from_date, $academic_session);
				if (empty($total_tutorial_attendence[0]['total'])) {
					$data['all_subjects'][$i]['total_theototal_tutorialry'] = 0;
				} else {
					$data['all_subjects'][$i]['total_tutorial'] = $total_tutorial_attendence[0]['total'];
				}
				$total_tutorial += $data['all_subjects'][$i]['total_tutorial'];

				$tutorial_attendence = $this->AttendanceYCM->getTutorialAttendence($computer_code, $batch_id, $to_date, $from_date, $academic_session);
				if (empty($tutorial_attendence[0]['total'])) {
					$data['all_subjects'][$i]['tutorial'] = 0;
				} else {
					$data['all_subjects'][$i]['tutorial'] = $tutorial_attendence[0]['total'];
				}
				$tutorial += $data['all_subjects'][$i]['tutorial'];

				$total_mst = $this->AttendanceYCM->getTotalStudentMST($computer_code, $batch_id, $academic_session);
				$data['total_mst'] += $total_mst;
				$mst = $this->AttendanceYCM->getmst($computer_code, $batch_id, $to_date, $from_date, $academic_session);
				$data['mst'] += $mst[0]['mst'];

			}
		}


		// ************ Other attendance ********************************	
		$other_attendence = $this->AttendanceYCM->getOtherAttendenceByDate($computer_code, $to_date, $from_date, $academic_session);
		// $data['total_other'] = $this->AttendanceYCM->getTotalOtherByDate($faculty_computer_code, $computer_code, $to_date, $from_date, $academic_session);

		if (empty($other_attendence[0]['total_attend'])) {
			$data['other'] = 0;
			$data['total_other'] = 0;
		} else {
			$data['other'] = $other_attendence[0]['total_attend'];
			$data['total_other'] = $other_attendence[0]['total_attend'];
		}
		// ************************************************************************

		// ************ Remedial attendance ********************************		
		// $data['total_remedial'] = $this->AttendanceYCM->getTotalRemedialsByDate($faculty_computer_code, $computer_code, $to_date, $from_date, $academic_session);
		$remedial_attendence = $this->AttendanceYCM->getRemedialsAttendenceByDate($computer_code, $to_date, $from_date, $academic_session);
		// $data['remedial']=$remedial_attendence[0]['total_attend'];
		if (empty($remedial_attendence[0]['total_attend'])) {
			$data['remedial'] = 0;
			$data['total_remedial'] = 0;
		} else {
			$data['remedial'] = $remedial_attendence[0]['total_attend'];
			$data['total_remedial'] = $remedial_attendence[0]['total_attend'];
		}
		// ************************************************************************

		// ************ Total attendance ********************************	
		$data['attendence'] = $theory + $practical + $cbs + $tutorial + $data['other'] + $data['mst'];
		$data['total_attendence'] = $total_theory + $total_practical + $total_cbs + $total_tutorial + $data['total_other'] + $data['total_mst'];
		$data['total_percentage'] = round((($theory + $practical + $cbs + $tutorial + $data['other'] + $data['mst']) / ($total_theory + $total_practical + $total_cbs + $total_tutorial + $data['total_other'] + $data['total_mst'])) * 100) + $data['remedial'] * 2;
		// ************************************************************************
		// $this->AttendanceYCM->get($faculty_computer_code,$to_date,$from_date);
		$this->load->view('attendanceYC/view_combined_attendence_new', $data);

	}













	public function printOfficeAttendence($section_id, $to_date, $from_date)
	{


		$section_id = base64_decode($section_id);
		$data['details'] = $this->AttendanceYCM->printCombinedPrintDetails($section_id)[0];
		$all_subjects = $this->AttendanceYCM->getAllSubjectsForClass($section_id);

		//logic for creating table head
		if (!empty($all_subjects))
			foreach ($all_subjects as $key => $value) {

				$class_subject_ids .= "," . $value['class_subject_id'];
			}

		$header_data = $this->AttendanceYCM->getCombinedAttendenceHeaderDataByDate(substr($class_subject_ids, 1), $to_date, $from_date); //excluding mst remedials and othersonly of theory,tutorials ,practicals and cbs -- theory tutorial and cbs are counted in theory on AB lab group


		foreach ($header_data as $key => $value) {

			$table_header[$value['class_subject_id']][$value['lab_group']] = $value['total'];
		}

		foreach ($all_subjects as $key => $value) {

			$table_header[$value['class_subject_id']]['subject_name'] = $value['subject_name'];
			$table_header[$value['class_subject_id']]['type'] = $value['type'];
		}
		//getting all students attendence with all subject at a time 
		$data_all = $this->AttendanceYCM->getAllStudentAttendenceDateWise(substr($class_subject_ids, 1), $to_date, $from_date);

		foreach ($data_all as $key => $value) {
			$students_data[$value['student_computer_code']][$value['class_subject_id']][$value['lecture_type']] = $value['total'];
		}
		unset($data_all);

		// echo json_encode($students_data);die();
		$students = $this->AttendanceYCM->getAllStudents($section_id);
		foreach ($students as $key => $value) {
			$student_coll[$value['computer_code']]['name'] = $value['student_name'];
			$student_coll[$value['computer_code']]['lab_group'] = $value['lab_group_name'];
			$student_coll[$value['computer_code']]['uno'] = $value['uno'];
		}

		$other_attendence = $this->AttendanceYCM->getOtherAttendenceByDate($section_id, $to_date, $from_date);
		foreach ($other_attendence as $key => $value) {
			$student_other[$value['computer_code']] = $value['total_attend'];

		}
		// echo json_encode($other_attendence);die();

		$remedial_attendence = $this->AttendanceYCM->getRemedialsAttendenceByDate($section_id, $to_date, $from_date);

		foreach ($remedial_attendence as $key => $value) {
			$student_remedial[$value['computer_code']] = $value['total_attend'];

		}


		$data['total_remeditotal_other_weightals'] = $this->AttendanceYCM->getTotalRemedialsByDate($section_id, $to_date, $from_date);
		$data['student_remedial'] = $student_remedial;
		$data['table_header'] = $table_header;
		$data['students_data'] = $students_data;
		$data['students_other_data'] = $student_other;
		$data['students'] = $student_coll;
		$data['total_other_weight'] = $this->AttendanceYCM->getTotalOtherByDate($section_id, $to_date, $from_date);
		$data['total_mst'] = $this->AttendanceYCM->getTotalMst1($section_id);


		$this->load->view('attendanceYC/print_office_attendence', $data);

	}


















	public function viewOtherAttendence($specialization)
	{
		// $class_section_id=base64_decode($class_section_id);
		$specialization = base64_decode($specialization);
		$this->load->library('session');
		$row = $this->session->userdata('user');
		$faculty_computer_code = $row['computer_code'];
		$current_session_id = $row['current_session_id'];

		if ($specialization == 0) {
			$data1 = $this->AttendanceYCM->get_year($faculty_computer_code, $current_session_id);
		} else {
			$data1 = $this->AttendanceYCM->get_year_mtech($faculty_computer_code, $current_session_id);
		}

		// $sem = $this->AttendanceYCM->get_semester($data1[0]['year']);
		$data['home_dept'] = $data1[0]['dept_id'];
		$data['semester'] = $row['semester_array'][$data1[0]['year'] - 1];
		$data['academic_session'] = $current_session_id;
		$data['specialization'] = $specialization;

		$data['info'] = $this->AttendanceYCM->viewOtherAttendence($specialization, $faculty_computer_code, $data['academic_session']);
		// $data['class_section_id']=$class_section_id;
		$this->load->view('new_template/faculty_common');
		$this->load->view('attendanceYC/other_attendences_list', $data);
		$this->load->view('new_template/new_footer');
	}






	public function deleteOtherAttendence($attend_info_other, $home_dept, $semester, $academic_session, $specialization)
	{
		// $class_section_id=base64_decode($class_section_id);
		$attend_info_other = base64_decode($attend_info_other);
		$department = base64_decode($home_dept);
		$semester = base64_decode($semester);
		$academic_session = base64_decode($academic_session);
		$specialization = base64_decode($specialization);
		$attend_details = $this->AttendanceYCM->get_attend_details($attend_info_other);
		$students = $this->AttendanceYCM->get_student_details($attend_info_other);
		// echo "<pre>";
		// print_r($department);
		// die();
		$lecture_type = $attend_details[0]['lecture_type'];
		$lectureWeight = $this->AttendanceYCM->getLectureWeightOther($lecture_type);
		$lecture_weight = $lectureWeight[0]['lecture_weight'];
		if ($lecture_type == '10') {
			foreach ($students as $s) {
				$computer_code = $s['computer_code'];
				$this->AttendanceYCM->deleteRemedials($computer_code, $academic_session);
			}
		} else {

			foreach ($students as $s) {
				$computer_code = $s['computer_code'];
				$check = $this->AttendanceYCM->getCumulativeAttendence($computer_code, $academic_session);

				$student_attendance = $check[0]['student_attendance'];
				$total_attendance = $check[0]['total_attendance'];
				$student_attendance -= $lecture_weight;
				$total_attendance -= $lecture_weight;
				$cumulative_attendence = ($student_attendance / $total_attendance) * 100;
				$cumulative_attendence += $check[0]['remedial'] * 2;
				// print_r($student_attendance);
				// echo "<br>";
				// print_r($total_attendance);
				// echo "<br>";
				// print_r($cumulative_attendence);
				// echo "<br>";
				// die();
				$this->AttendanceYCM->updateCumulativeAttendance($computer_code, $academic_session, $student_attendance, $total_attendance, $cumulative_attendence);
			}
		}


		$result = $this->AttendanceYCM->deleteOtherAttendence($attend_info_other);
		if (!$result) {
			"<script>alert('Something Went Wrong');</script>";
		} else {
			redirect(base_url() . "AttendanceYC/viewOtherAttendence/" . base64_encode($specialization));
		}
	}






	public function viewOtherAttendenceForUpdate($attend_info_id, $home_dept, $semester, $academic_session, $specialization)
	{
		$attend_info_id = base64_decode($attend_info_id);
		$home_dept = base64_decode($home_dept);
		$semester = base64_decode($semester);
		$academic_session = base64_decode($academic_session);
		$specialization = base64_decode($specialization);
		// $class_section_id=base64_decode($class_section_id);
		$data['data'] = $this->AttendanceYCM->viewOtherAttendenceForUpdate($attend_info_id, $home_dept, $semester, $academic_session, $specialization);
		//   echo "<pre>";
		//   print_r($data['data']);
		//   die();
		$data['attend_info_id'] = $attend_info_id;
		// 
		$this->load->view('new_template/faculty_common');
		//	$this->load->view('attendenceN/modifyPage',$data);
		$this->load->view('attendanceYC/viewOtherAttendence', $data);
		$this->load->view('new_template/new_footer');
	}




	public function updateOtherAttendence($attend_info_id, $computer_code, $attend)
	{
		$academic_session = $_SESSION['user']['academic_id'];
		echo $this->AttendanceYCM->updateOtherAttendence($attend_info_id, $computer_code, $attend);

		$other_attendance = $this->AttendanceYCM->getOtherAttendanceDetails($attend_info_id);
		$check = $this->AttendanceYCM->getCumulativeAttendence($computer_code, $academic_session);


		if ($other_attendance['lecture_type'] == 10) {

			if ($attend == 1) {
				$this->AttendanceYCM->updateRemedials($computer_code, $academic_session);
			} else {
				$this->AttendanceYCM->deleteRemedials($computer_code, $academic_session);
			}

		} else {
			if ($attend == 1) {

				$student_attendance = $check[0]['student_attendance'];
				$total_attendance = $check[0]['total_attendance'];
				$student_attendance += $other_attendance['lecture_weight'];
				$total_attendance += $other_attendance['lecture_weight'];
				$cumulative_attendence = ($student_attendance / $total_attendance) * 100;
				$cumulative_attendence += $check[0]['remedial'] * 2;
				$this->AttendanceYCM->updateCumulativeAttendance($computer_code, $academic_session, $student_attendance, $total_attendance, $cumulative_attendence);

			} else {

				$student_attendance = $check[0]['student_attendance'];
				$total_attendance = $check[0]['total_attendance'];
				$student_attendance -= $other_attendance['lecture_weight'];
				$total_attendance -= $other_attendance['lecture_weight'];
				$cumulative_attendence = ($student_attendance / $total_attendance) * 100;
				$cumulative_attendence += $check[0]['remedial'] * 2;
				$this->AttendanceYCM->updateCumulativeAttendance($computer_code, $academic_session, $student_attendance, $total_attendance, $cumulative_attendence);

			}
		}

	}





	//principal 
	public function selectClassesPrincipal()
	{
		// echo $_POST['dept_id'];die();
		$data['classes'] = $this->AttendanceYCM->selectClassesForPrincipal($_POST['dept_id']);
		// print_r($data['classes']);die();
		$this->load->view('new_template/faculty_common');
		$this->load->view('attendanceYC/hod_view_classes', $data);
		$this->load->view('new_template/new_footer');

	}





	public function selectDepartmentPrincipal()
	{
		$data['departments'] = $this->AttendanceYCM->getDepartments();
		$this->load->view('new_template/faculty_common');
		$this->load->view('attendanceYC/principal_view_classes', $data);
		$this->load->view('new_template/new_footer');

	}


















	public function calculateCumulativeAttendence($department, $semester, $specialization, $academic_session)
	{

		$this->load->library('session');
		$row = $this->session->userdata('user');

		$data['department'] = $this->AttendanceYCM->getDepartmentName($department);
		$data['semester'] = $semester;
		$data['exam_session'] = $row['current_session'];

		$data['student_list'] = $this->AttendanceYCM->get_student_list_new($department, $semester, $academic_session, $specialization);

		$i = 0;
		foreach ($data['student_list'] as $s) {
			$computer_code = $s['computer_code'];
			$department = $s['home_dept'];
			// echo $computer_code;
			// echo "<br>";
			$total_attendance = $this->AttendanceYCM->getTotalAttendance($computer_code, $academic_session);
			$student_attendance = $this->AttendanceYCM->getStudentAttendance($computer_code, $academic_session);
			// $total_other = $this->AttendanceYCM->getTotalOtherAttendance($computer_code, $academic_session);
			$student_other = $this->AttendanceYCM->getStudentOther($computer_code, $academic_session);
			$remedial = $this->AttendanceYCM->getStudentRemedial($computer_code, $academic_session);
			$student_attendance_total = $student_attendance + $student_other;
			$total_student_attendance = $total_attendance + $student_other;
			$data['student_list'][$i]['attendance'] = $total_attendance;
			$data['student_list'][$i]['student'] = $student_attendance;
			$data['student_list'][$i]['other'] = $student_other;
			$data['student_list'][$i]['student_other'] = $student_other;
			$data['student_list'][$i]['remedial'] = $remedial;
			$data['student_list'][$i]['total_attendance'] = $total_student_attendance;
			$data['student_list'][$i]['student_attendance'] = $student_attendance_total;
			if ($total_student_attendance == 0 || $student_attendance_total == 0) {
				$data['student_list'][$i]['total_percentage'] = 0 + $remedial * 2;
			} else {

				$data['student_list'][$i]['total_percentage'] = round((($student_attendance + $student_other) / ($total_attendance + $student_other)) * 100 + $remedial * 2);
			}
			// echo "Total Attendance - ".$total_attendance;
			// echo "<br>";
			// echo "Student Attendance - ".$student_attendance;
			// echo "<br>";
			// echo "Total Other - ".$total_other;
			// echo "<br>";
			// echo "Student Attendance - ".$student_other;
			// echo "<br>";
			// echo "Remedial Attendance - ".$remedial;
			// echo "<br>";
			// $data['student_list'][$i]['total_percentage'] = $this->CumulativeAttendence($computer_code,$academic_session);
			// $data['student_list'][$i]['total_percentage'] = $this->CumulativeAttendence($computer_code,$to_date,$from_date,$semester,$academic_session,$department,$specialization);
			// echo $computer_code;
			// echo "<br>";
			// echo $semester;
			// echo "<br>";
			// echo $department;
			// echo "<br>";
			// echo $academic_session;
			// echo "<br>";
			$check = $this->AttendanceYCM->getCumulativeAttendence($computer_code, $academic_session);

			if (!empty($check)) {

				$this->AttendanceYCM->updateCalculatedCumulativeAttendance($computer_code, $semester, $department, $academic_session, $remedial, $student_attendance_total, $total_student_attendance, $data['student_list'][$i]['total_percentage']);
			} else {
				$this->AttendanceYCM->insertCalculatedCumulativeAttendence($computer_code, $semester, $department, $academic_session, $remedial, $student_attendance_total, $total_student_attendance, $data['student_list'][$i]['total_percentage']);
			}

			$i++;
		}


		// echo "<pre>";
		// print_r($data);
		// die();
		//   $this->load->view('new_template/faculty_common');
		$this->load->view('attendanceYC/view_cumulative_attendence', $data);
		//   $this->load->view('new_template/new_footer');
	}





















	public function viewCumulativeAttendence($specialization)
	{
		$this->load->library('session');
		$row = $this->session->userdata('user');

		$faculty_computer_code = $row['computer_code'];
		$current_session_id = $row['current_session_id'];
		if ($specialization == 0) {
			$data = $this->AttendanceYCM->get_year($faculty_computer_code, $current_session_id);
		} else {
			$data = $this->AttendanceYCM->get_year_mtech($faculty_computer_code, $current_session_id);
		}

		// $sem = $this->AttendanceYCM->get_semester($data[0]['year']);
		$home_dept = $data[0]['dept_id'];
		$semester = $row['semester_array'][$data[0]['year'] - 1];
		$data['student_list'] = $this->AttendanceYCM->get_student_list($home_dept, $semester, $current_session_id, $specialization);

		$data['department'] = $row['department_name'];
		$data['semester'] = $semester;
		$data['exam_session'] = $row['current_session'];

		// if($current_session_id % 2 == 0){
		// 	$to_date = 2022-01-01;
		// 	$mydate=getdate(date("U"));
		// 	$from_date = $mydate['year']."-".$mydate['mon']."-".$mydate['mday'];	
		// }
		// elseif($current_session_id % 2 != 0){
		// 	$to_date = 2022-07-01;
		// 	$mydate=getdate(date("U"));
		// 	$from_date = $mydate['year']."-".$mydate['mon']."-".$mydate['mday'];	
		// }

		$cumulative_attendence = array();
		for ($i = 0; $i < sizeof($data['student_list']); $i++) {
			$computer_code = $data['student_list'][$i]['computer_code'];
			$semester = $data['student_list'][$i]['semester'];
			$home_dept = $data['student_list'][$i]['home_dept'];
			$academic_session = $data['student_list'][$i]['academic_session'];
			$cumulative_attendence = $this->AttendanceYCM->getCumulativeAttendence($computer_code, $academic_session);
			if (!empty($cumulative_attendence)) {
				$data['student_list'][$i]['total_percentage'] = $cumulative_attendence[0]['cumulative_attendance'];
			} else {
				$data['student_list'][$i]['total_percentage'] = 0;
			}
		}

		//   echo "<pre>";
		//   print_r($data['student_list']);
		//   die();
		$data['date'] = $cumulative_attendence[0]['date'];
		//   $this->load->view('new_template/faculty_common');
		$this->load->view('attendanceYC/view_cumulative_attendence', $data);
		//   $this->load->view('new_template/new_footer');
	}


	// ************************** Cummulative Attendence *****************************

	public function CumulativeAttendence($computer_code, $semester, $academic_session, $home_dept, $specialization)
	{

		$faculty_computer_code = $_SESSION['user']['computer_code'];

		$data['all_subjects'] = $this->AttendanceYCM->getAllSubjectsForClass($computer_code, $semester, $academic_session, $home_dept, $specialization);

		$data['mst'] = 0;
		$data['other'] = 0;
		$data['remedial'] = 0;
		$data['total'] = 0;
		$attendence = 0;
		if (!empty($data['all_subjects'])) {
			for ($i = 0; $i < count($data['all_subjects']); $i++) {

				$batch_id = $data['all_subjects'][$i]['batch_id'];
				$type = $data['all_subjects'][$i]['type'];
				$lab_group = $data['all_subjects'][$i]['lab_group_name'];

				$total_attendance = $this->AttendanceYCM->getTotalAttendence($batch_id, $academic_session, $lab_group, $type);
				$data['total'] += $total_attendance;

				$attend = $this->AttendanceYCM->getAttendence($computer_code, $batch_id, $academic_session, $lab_group, $type);
				$attendence += $attend;
			}
		}

		// // ************ Other attendance ********************************	
		$data['total_other'] = $this->AttendanceYCM->getTotalOther($faculty_computer_code, $academic_session);
		$data['other'] = $this->AttendanceYCM->getOtherAttendence($computer_code, $academic_session);
		$data['remedial'] = $this->AttendanceYCM->getRemedialsAttendence($computer_code, $academic_session);
		// ************************************************************************

		// ************ Total attendance ********************************	
		$data['attendence'] = $attendence + $data['other'];
		$data['total_attendence'] = $data['total'] + $data['total_other'];
		$data['total_percentage'] = round(($data['attendence'] / $data['total_attendence']) * 100) + $data['remedial'] * 2;
		// ************************************************************************
		// echo $data['attendence'];
		// echo "<br>";
		// echo $data['total_attendence'];
		// echo "<br>";
		// echo $data['total_percentage'];
		// die();
		return ($data['total_percentage']);

	}


	// ****************************************************************************************************************







}

?>