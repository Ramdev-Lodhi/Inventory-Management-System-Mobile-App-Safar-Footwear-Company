<?php
class AttendanceYCM extends CI_Model
{

  public function __construct()
  {

    parent::__construct();

    $this->CompCode = $_SESSION['user']['computer_code']; //fetch from session
    $this->academic_id = $_SESSION['user']['academic_id']; //fetch session id from  session



  }

  public function helloModel()
  {
    echo "model working";
    die();
  }
  //functions  daveloped during year coordinator attendence system davelopement  
// public function selectClasses()
//   {
//     //echo "call h_assigned_subjects_to_faculty($this->CompCode,".$_SESSION['user']['current_session_id'].")"; die();
//   @mysqli_next_result($this->db->conn_id);
//   return $this->db->query("call h_assigned_subjects_to_faculty($this->CompCode,".$_SESSION['user']['current_session_id'].")")->result_array();
//   }
  public function getDepartmentName($department_id)
  {
    $query = "SELECT `name` FROM department where id=$department_id";

    $result = $this->db->query($query);

    return $result->result_array()[0]['name'];
  }
  public function getStudent($comp_code)
  {

    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("SELECT distinct computer_code,enrollment_no,student_name,lab_group_name from student_college_info_new where computer_code=$comp_code  ")->result_array();

  }
  public function get_student_list($home_dept, $semester, $academic_session, $specialization)
  {
    $query = "SELECT distinct computer_code,enrollment_no,student_name,student_session,academic_session,semester,home_dept FROM student_college_info_new where home_dept = $home_dept and semester = $semester and academic_session=$academic_session and specialization=$specialization order by student_name";
    // print_r($query);
    // die();
    $result = $this->db->query($query);

    return $result->result_array();

  }


  public function get_year($computer_code, $current_session)
  {
    $query = "SELECT * FROM year_coordinator where faculty_computer_code = $computer_code and academic_session = $current_session and specialization=0";
    $result = $this->db->query($query);

    return $result->result_array();

  }

  public function get_year_mtech($computer_code, $current_session)
  {
    $query = "SELECT * FROM year_coordinator where faculty_computer_code = $computer_code and academic_session = $current_session and specialization!=0";
    $result = $this->db->query($query);

    return $result->result_array();

  }

  public function getInvidualAttendence($comp, $data)
  {
    //echo "call h_assigned_subjects_to_faculty($this->CompCode,".$_SESSION['user']['current_session_id'].")"; die();
    @mysqli_next_result($this->db->conn_id);
    $data = $this->db->query("call h_get_student_attendence_invidual_by_date($comp,'" . $data['from_date'] . "','" . $data['to_date'] . "')")->result_array();
    @mysqli_next_result($this->db->conn_id);
    return $data;
  }


  public function insertCumulativeAttendence($computer_code, $semester, $home_dept, $academic_session, $student_attendance, $total_attendance, $cumulative_attendance)
  {
    //echo "call h_assigned_subjects_to_faculty($this->CompCode,".$_SESSION['user']['current_session_id'].")"; die();
    @mysqli_next_result($this->db->conn_id);
    $this->db->query(" INSERT INTO `cumulative_attendance` (`computer_code`, `semester`, `department`, `academic_session`,`student_attendance`,`total_attendance`, `cumulative_attendance`) VALUES ($computer_code,$semester,$home_dept,$academic_session,$student_attendance,$total_attendance,$cumulative_attendance)");
  }
  public function insertCalculatedCumulativeAttendence($computer_code, $semester, $home_dept, $academic_session, $remedial, $student_attendance, $total_attendance, $cumulative_attendance)
  {
    //echo "call h_assigned_subjects_to_faculty($this->CompCode,".$_SESSION['user']['current_session_id'].")"; die();
    @mysqli_next_result($this->db->conn_id);
    $this->db->query(" INSERT INTO `cumulative_attendance` (`computer_code`, `semester`, `department`, `academic_session`,`remedial`,`student_attendance`,`total_attendance`, `cumulative_attendance`) VALUES ($computer_code,$semester,$home_dept,$academic_session,$remedial,$student_attendance,$total_attendance,$cumulative_attendance)");
  }

  public function getCumulativeAttendence($computer_code, $academic_session)
  {
    @mysqli_next_result($this->db->conn_id);
    $data = $this->db->query("SELECT * from `cumulative_attendance` where computer_code=$computer_code and academic_session=$academic_session")->result_array();
    @mysqli_next_result($this->db->conn_id);
    return $data;
  }


  public function updateCumulativeAttendance($computer_code, $academic_session, $student_attendance, $total_attendance, $cumulative_attendance)
  {
    @mysqli_next_result($this->db->conn_id);
    $this->db->query("UPDATE cumulative_attendance SET total_attendance=$total_attendance,student_attendance=$student_attendance,cumulative_attendance=$cumulative_attendance where computer_code=$computer_code and academic_session=$academic_session");
    return 1;
  }
  public function updateCalculatedCumulativeAttendance($computer_code, $semester, $home_dept, $academic_session, $remedial, $student_attendance, $total_attendance, $cumulative_attendance)
  {
    @mysqli_next_result($this->db->conn_id);
    $this->db->query("UPDATE cumulative_attendance SET remedial=$remedial, total_attendance=$total_attendance,student_attendance=$student_attendance,cumulative_attendance=$cumulative_attendance where computer_code=$computer_code and semester=$semester and department=$home_dept and academic_session=$academic_session");
    return 1;
  }


  public function updateRemedials($computer_code, $academic_session)
  {
    @mysqli_next_result($this->db->conn_id);
    $this->db->query("UPDATE cumulative_attendance SET remedial=remedial+1,cumulative_attendance=cumulative_attendance+2 where computer_code=$computer_code  and academic_session=$academic_session");
    return 1;
  }

  public function deleteRemedials($computer_code, $academic_session)
  {
    @mysqli_next_result($this->db->conn_id);
    $this->db->query("UPDATE cumulative_attendance SET remedial=remedial-1,cumulative_attendance=cumulative_attendance-2 where computer_code=$computer_code  and academic_session=$academic_session");
    return 1;
  }



  public function fillAttendenceLoadInfo($class_subject_id)
  {
    @mysqli_next_result($this->db->conn_id);
    $data['topics'] = $this->db->query("call h_get_topic_from_class_subject_id($class_subject_id)")->result_array();
    @mysqli_next_result($this->db->conn_id);
    $data['lecture_types'] = $this->db->query("call h_get_lecture_types()")->result_array();
    @mysqli_next_result($this->db->conn_id);
    $data['time_slots'] = $this->db->query("call h_get_time_slots()")->result_array();
    @mysqli_next_result($this->db->conn_id);
    $data['lect_cat'] = $this->db->query("call h_get_lect_cat($class_subject_id)")->result_array();
    @mysqli_next_result($this->db->conn_id);

    return $data;
  }
  public function getStudents($class_subject_id, $batch)
  {
    @mysqli_next_result($this->db->conn_id);
    if ($batch == 3) {
      return $this->db->query("call h_get_students_by_class_subject_id($class_subject_id)")->result_array();
    }
    if ($batch == 1) {
      $batch = "'A'";
    } else {
      $batch = "'B'";
    }

    return $this->db->query("call h_get_students_by_class_subject_id_by_batch($class_subject_id,$batch)")->result_array();
  }


  //submitting attendence
  public function submitAttendence($data)
  {

    extract($data);
    //Add topic if not present  
    if ($topic_id == 0) {
      @mysqli_next_result($this->db->conn_id);
      $subject_id = $this->db->query(" call h_get_subject_code_by_class_subject_id($class_subject_id) ")->result_array()[0]['college_subject_code'];
      @mysqli_next_result($this->db->conn_id);
      $topic_manually = str_replace("'", "\'", $topic_manually);
      $topic_manually = str_replace('"', '\"', $topic_manually);
      $subject_id = "'" . $subject_id . "'";

      //  echo "call h_add_topic($subject_id,$topic_manually)";


      $topic_id = $this->db->query(" call h_add_topic($subject_id,'" . $topic_manually . "') ")->result_array()[0]['LAST_INSERT_ID()'];
      //  die();
    }
    @mysqli_next_result($this->db->conn_id);


    //getting students
    $students = $this->getStudents($class_subject_id, $batch);



    //main attendence entry logic
    $date = "'" . $date . "'";
    if ($batch == 1) {
      $batch = "'A'";
    } elseif ($batch == 2) {
      $batch = "'B'";

    } elseif ($batch == 3) {
      $batch = "'AB'";
    }

    if ($lecture_type == 1)
      goto theory_logic;

    $this->db->trans_start(); # Starting Transaction
    $this->db->trans_strict(FALSE);



    foreach ($time_slots as $key => $time_slot) {

      $time_slots_final .= $time_slot . ",";

    }

    @mysqli_next_result($this->db->conn_id);



    $this->db->query("
INSERT INTO `attend_info_" . $this->academic_id . "` (`attend_info`, `class_subject_id`, `faculty_computer_code`, `date`, `lecture_type`, `time_slot_id`, `topic`, `lab_group`) VALUES (NULL,$class_subject_id, $this->CompCode, $date,$lecture_type , '" . $time_slots_final . "', $topic_id, $batch)");
    $attend_info_id = $this->db->insert_id();





    //$attendence_data[][];

    foreach ($students as $key1 => $value1) {

      if (in_array($value1['computer_code'], $computer_code)) {

        $attendence_data[] = array(
          'student_computer_code' => $value1['computer_code'],
          'attend_info' => $attend_info_id,

        );

      }


    }
    @mysqli_next_result($this->db->conn_id);
    $this->db->insert_batch('attend_record_' . $this->academic_id, $attendence_data);
    end:
    $attend_info_id = 0;
    unset($attendence_data);



    $this->db->trans_complete(); # Completing transaction

    if ($this->db->trans_status() === FALSE) {
      # Something went wrong.
      $this->db->trans_rollback();
      return FALSE;
    } else {
      # Everything is Perfect. 
      # Committing data to the database.
      $this->db->trans_commit();
      return TRUE;
    }
    return TRUE;

    foreach ($variable as $key => $value) {
      # code...
    }


    theory_logic:

    $this->db->trans_start(); # Starting Transaction
    $this->db->trans_strict(FALSE);


    foreach ($time_slots as $key => $time_slot) {
      @mysqli_next_result($this->db->conn_id);
      $this->db->query("
INSERT INTO `attend_info_" . $this->academic_id . "` (`attend_info`, `class_subject_id`, `faculty_computer_code`, `date`, `lecture_type`, `time_slot_id`, `topic`, `lab_group`) VALUES (NULL,$class_subject_id, $this->CompCode, $date,$lecture_type , '" . $time_slot . ",', $topic_id, $batch)");
      $attend_info_id = $this->db->insert_id();


      foreach ($students as $key1 => $value1) {

        if (in_array($value1['computer_code'], $computer_code)) {

          $attendence_data[] = array(
            'student_computer_code' => $value1['computer_code'],
            'attend_info' => $attend_info_id,

          );

        }


      }
      @mysqli_next_result($this->db->conn_id);
      $this->db->insert_batch('attend_record_' . $this->academic_id, $attendence_data);

      $attend_info_id = 0;
      unset($attendence_data);
    } // end foreach for theory




    $this->db->trans_complete(); # Completing transaction

    if ($this->db->trans_status() === FALSE) {
      # Something went wrong.
      $this->db->trans_rollback();
      return FALSE;
    } else {
      # Everything is Perfect. 
      # Committing data to the database.
      $this->db->trans_commit();
      return TRUE;
    }


  }
  public function modifyAttendence($class_section_id)
  {
    @mysqli_next_result($this->db->conn_id);
    $data['main_infos'] = $this->db->query("select attend_info.attend_info,attend_info.date,attend_info.lecture_type,attend_info.time_slot_id,topic.topic_name,attend_info.lab_group from attend_info_" . $this->academic_id . " attend_info,topic WHERE attend_info.class_subject_id=$class_section_id and topic.topic_id=attend_info.topic
 order by attend_info.attend_info desc")->result_array();

    foreach ($data['main_infos'] as $key => $value) {

      @mysqli_next_result($this->db->conn_id);
      $data['counts'][$value['attend_info']] = $this->db->query("select count(*) as total from attend_record_" . $this->academic_id . " attend_record where attend_record.attend_info=" . $value['attend_info'])->result_array()[0]['total'];
      # code...
    }

    @mysqli_next_result($this->db->conn_id);
    $data['lecture_types'] = $this->getLectureTypes();

    @mysqli_next_result($this->db->conn_id);
    $data['time_slots'] = $this->timeSlots();


    return $data;
  }

  public function timeSlots()
  {
    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("call h_get_time_slots()")->result_array();

  }
  public function viewAttendenceForUpdate($attend_info_id, $lab_group, $class_subject_id)
  {
    @mysqli_next_result($this->db->conn_id);
    if ($lab_group == "AB") {
      $data['students'] = $this->db->query("call h_get_students_by_class_subject_id($class_subject_id)")->result_array();

    } else {

      $data['students'] = $this->db->query("call h_get_students_by_class_subject_id_by_batch($class_subject_id,'" . $lab_group . "')")->result_array();

    }
    @mysqli_next_result($this->db->conn_id);

    $data['attended'] = $this->db->query("select * from attend_record_$this->academic_id where attend_info=$attend_info_id")->result_array();
    return $data;
    // return $this->db->query("call h_get_filled_attendence_record($attend_info_id)")->result_array();


  }

  public function updateAttendence($attend_info_id, $student_computer_code, $attend)
  {

    @mysqli_next_result($this->db->conn_id);
    if ($attend == 0) {
      $this->db->query("delete from attend_record_$this->academic_id where attend_info=$attend_info_id and student_computer_code=$student_computer_code");
    } else {
      $this->db->query("insert into attend_record_$this->academic_id (`student_computer_code`,`attend_info`) values ($student_computer_code,$attend_info_id)");

    }

    // $this->db->query("call h_update_attendence_record($attend_info_id,$student_computer_code,$attend)");
    return 1;

  }

  /*  
   public function  getAttendenceDatesAllTypes($class_subject_id,$data)
   {
   
   @mysqli_next_result($this->db->conn_id);
   //return $this->db->query("call h_get_attendence_dates($class_subject_id,$data['from_date'],$data['to_date'])")->result_array();
   
   }
 */
  //for selected lectrue type

  public function getAttendenceDatesLectureTypes($class_subject_id, $from_date, $to_date, $lecture_types)
  {
    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("SELECT attend_info.*  from attend_info_$this->academic_id attend_info where  attend_info.class_subject_id=$class_subject_id and (attend_info.date BETWEEN  '" . $from_date . "' and '" . $to_date . "' ) and attend_info.lecture_type in (" . $lecture_types . ") order by attend_info.attend_info asc")->result_array();
  }
  //for attendence record set
  public function getAttendenceRecordSet($attend_infos)
  {
    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("SELECT * from attend_record_$this->academic_id where attend_info in (" . $attend_infos . ")")->result_array();
  }
  public function getLectureTypes()
  {
    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("call h_get_lecture_types()")->result_array();

  }

  public function getAllStudents($section_id)
  {

    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("call h_get_all_students_by_section_id($section_id)")->result_array();

  }

  public function getAllStudents1($section_id)
  {

    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("call h_get_all_students_by_section_id1($section_id)")->result_array();

  }

  public function getAllStudents2($section_id)
  {

    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("call h_get_all_students_by_section_id_for_students($section_id)")->result_array();

  }

  public function getAllAttendence($class_subject_id)
  {


    @mysqli_next_result($this->db->conn_id);

    return $this->db->query("SELECT  attend_info.class_subject_id,attend_info.lecture_type,attend_info.lab_group,count(*) as total FROM attend_info_$this->academic_id  attend_info where  attend_info.class_subject_id = '" . $class_subject_id . "' and attend_info.lecture_type!=3 group by attend_info.class_subject_id,attend_info.lab_group")->result_array();

  }



  public function getAllStudentAttendence($class_subject_ids)
  {


    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("SELECT attend_record.student_computer_code,attend_info.lecture_type,attend_info.class_subject_id,COUNT(*) as total FROM attend_info_$this->academic_id attend_info,attend_record_$this->academic_id attend_record where attend_info.class_subject_id in (" . $class_subject_ids . ") and attend_info.attend_info=attend_record.attend_info group by attend_record.student_computer_code,attend_info.lecture_type,attend_info.class_subject_id")->result_array();

  }
  // public function getAllStudentAttendenceDateWise($class_subject_ids,$to_date,$from_date)
// {


  //      @mysqli_next_result($this->db->conn_id);
//  return $this->db->query("SELECT attend_record.student_computer_code,attend_info.lecture_type,attend_info.class_subject_id,COUNT(*) as total FROM attend_info_$this->academic_id attend_info,attend_record_$this->academic_id attend_record where attend_info.class_subject_id in (".$class_subject_ids.") and ( attend_info.date  between '".$to_date."' and '".$from_date."' )  and attend_info.attend_info=attend_record.attend_info group by attend_record.student_computer_code,attend_info.lecture_type,attend_info.class_subject_id")->result_array();

  // }

  public function getAllStudentAttendenceDateWise($comp_code, $batch_id, $to_date, $from_date)
  {


    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("SELECT attend_record_new.student_computer_code,attend_info_new.lecture_type,attend_info_new.batch_id, count(*) as total FROM attend_info_new,attend_record_new where attend_info_new.batch_id=$batch_id and attend_info_new.attend_info=attend_record_new.attend_info and attend_record_new.student_computer_code=$comp_code and ( attend_info_new.date  between '" . $to_date . "' and '" . $from_date . "' ) group by attend_info_new.lecture_type")->result_array();

  }

  public function getCombinedAttendenceHeaderData($class_subject_ids)
  {


    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("SELECT  attend_info.class_subject_id,attend_info.lecture_type,attend_info.lab_group,count(*) as total FROM attend_info_$this->academic_id  attend_info where attend_info.class_subject_id in (" . $class_subject_ids . ") and attend_info.lecture_type!=3 group by attend_info.class_subject_id,attend_info.lab_group")->result_array();

  }
  // public function getCombinedAttendenceHeaderDataByDate($class_subject_ids,$to_date,$from_date)
// {
//      @mysqli_next_result($this->db->conn_id);

  //  return $this->db->query("SELECT  attend_info.class_subject_id,attend_info.lecture_type,attend_info.lab_group,count(*) as total FROM attend_info_$this->academic_id  attend_info where  attend_info.class_subject_id in (".$class_subject_ids.") and (attend_info.date between  '".$to_date."' and '".$from_date."' ) and attend_info.lecture_type!=3 group by attend_info.class_subject_id,attend_info.lab_group")->result_array();

  // }

  public function getCombinedAttendenceHeaderDataByDate($batch_id, $to_date, $from_date, $lab_group)
  {
    @mysqli_next_result($this->db->conn_id);

    return $this->db->query("SELECT  attend_info_new.batch_id,attend_info_new.lab_group,count(*) as total FROM attend_info_new where batch_id=$batch_id and lab_group='$lab_group' and attend_info_new.lecture_type !=3 and attend_info_new.date between  '" . $to_date . "' and '" . $from_date . "' group by attend_info_new.lab_group ")->result_array();

  }

  /********************************************separate view for attendance of students***************************************/
  public function getTotalTheoryAttendence($computer_code, $batch_id, $to_date, $from_date, $academic_session)
  {
    @mysqli_next_result($this->db->conn_id);

    return $this->db->query("SELECT  attend_info_new.batch_id,attend_info_new.lab_group,count(*) as total FROM attend_info_new, attend_record_new where batch_id=$batch_id  and attend_info_new.academic_session=$academic_session and attend_info_new.lecture_type =1 and attend_info_new.attend_info=attend_record_new.attend_info and attend_record_new.student_computer_code=$computer_code and attend_info_new.date between  '" . $to_date . "' and '" . $from_date . "' group by attend_info_new.lab_group ")->result_array();

  }

  public function getTotalPracticalAttendence($computer_code, $batch_id, $to_date, $from_date, $lab_group, $academic_session)
  {
    @mysqli_next_result($this->db->conn_id);

    return $this->db->query("SELECT  attend_info_new.batch_id,attend_info_new.lab_group,count(*) as total FROM attend_info_new, attend_record_new where batch_id=$batch_id and attend_info_new.academic_session=$academic_session and lab_group='$lab_group' and attend_info_new.lecture_type =2 and attend_info_new.attend_info=attend_record_new.attend_info and attend_record_new.student_computer_code=$computer_code and attend_info_new.date between  '" . $to_date . "' and '" . $from_date . "' group by attend_info_new.lab_group ")->result_array();

  }

  public function getTotalCBSAttendence($computer_code, $batch_id, $to_date, $from_date, $academic_session)
  {
    @mysqli_next_result($this->db->conn_id);

    return $this->db->query("SELECT  attend_info_new.batch_id,attend_info_new.lab_group,count(*) as total FROM attend_info_new, attend_record_new where batch_id=$batch_id  and attend_info_new.academic_session=$academic_session and attend_info_new.lecture_type =5 and attend_info_new.attend_info=attend_record_new.attend_info and attend_record_new.student_computer_code=$computer_code and attend_info_new.date between  '" . $to_date . "' and '" . $from_date . "' group by attend_info_new.lab_group ")->result_array();

  }

  public function getTotalTutorialAttendence($computer_code, $batch_id, $to_date, $from_date, $academic_session)
  {
    @mysqli_next_result($this->db->conn_id);

    return $this->db->query("SELECT  attend_info_new.batch_id,attend_info_new.lab_group,count(*) as total FROM attend_info_new,attend_record_new where batch_id=$batch_id and attend_info_new.academic_session=$academic_session and attend_info_new.lecture_type=4 and attend_info_new.attend_info=attend_record_new.attend_info and attend_record_new.student_computer_code=$computer_code and attend_info_new.date between  '" . $to_date . "' and '" . $from_date . "' group by attend_info_new.lab_group ")->result_array();

  }

  public function getTheoryAttendence($comp_code, $batch_id, $to_date, $from_date, $academic_session)
  {


    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("SELECT attend_record_new.student_computer_code,attend_info_new.lecture_type,attend_info_new.batch_id, count(*) as total FROM attend_info_new,attend_record_new where attend_info_new.academic_session=$academic_session and attend_info_new.batch_id=$batch_id and attend_info_new.lecture_type=1 and  attend_record_new.attend=1 and attend_info_new.attend_info=attend_record_new.attend_info and attend_record_new.student_computer_code=$comp_code and ( attend_info_new.date  between '" . $to_date . "' and '" . $from_date . "' ) group by attend_info_new.lecture_type")->result_array();

  }
  public function getPracticalAttendence($comp_code, $batch_id, $to_date, $from_date, $lab_group, $academic_session)
  {


    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("SELECT attend_record_new.student_computer_code,attend_info_new.lecture_type,attend_info_new.batch_id, count(*) as total FROM attend_info_new,attend_record_new where attend_info_new.academic_session=$academic_session and attend_info_new.batch_id=$batch_id and attend_info_new.lab_group='$lab_group' and attend_info_new.lecture_type =2 and  attend_record_new.attend=1 and  attend_info_new.attend_info=attend_record_new.attend_info and attend_record_new.student_computer_code=$comp_code and ( attend_info_new.date  between '" . $to_date . "' and '" . $from_date . "' ) group by attend_info_new.lecture_type")->result_array();

  }
  public function getCBSAttendence($comp_code, $batch_id, $to_date, $from_date, $academic_session)
  {


    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("SELECT attend_record_new.student_computer_code,attend_info_new.lecture_type,attend_info_new.batch_id, count(*) as total FROM attend_info_new,attend_record_new where attend_info_new.academic_session=$academic_session and attend_info_new.batch_id=$batch_id and attend_info_new.lecture_type=5 and  attend_record_new.attend=1 and attend_info_new.attend_info=attend_record_new.attend_info and attend_record_new.student_computer_code=$comp_code and ( attend_info_new.date  between '" . $to_date . "' and '" . $from_date . "' ) group by attend_info_new.lecture_type")->result_array();

  }
  public function getTutorialAttendence($comp_code, $batch_id, $to_date, $from_date, $academic_session)
  {


    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("SELECT attend_record_new.student_computer_code,attend_info_new.lecture_type,attend_info_new.batch_id, count(*) as total FROM attend_info_new,attend_record_new where attend_info_new.academic_session=$academic_session and attend_info_new.batch_id=$batch_id and attend_info_new.lecture_type=4 and  attend_record_new.attend=1 and attend_info_new.attend_info=attend_record_new.attend_info and attend_record_new.student_computer_code=$comp_code and ( attend_info_new.date  between '" . $to_date . "' and '" . $from_date . "' ) group by attend_info_new.lecture_type")->result_array();

  }

  public function getTotalStudentMST($computer_code, $batch_id, $academic_session)
  {
    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("SELECT count(*) as total_mst from attend_info_new, attend_record_new where attend_info_new.academic_session=$academic_session and attend_info_new.batch_id=$batch_id and attend_info_new.lecture_type=3 and attend_info_new.attend_info=attend_record_new.attend_info and attend_record_new.student_computer_code=$computer_code")->result_array()[0]['total_mst'];

  }
  public function getmst($computer_code, $batch_id, $to_date, $from_date, $academic_session)
  {
    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("SELECT count(*) as mst from attend_info_new,attend_record_new where attend_info_new.academic_session=$academic_session and attend_info_new.batch_id=$batch_id and attend_info_new.lecture_type=3 and attend_info_new.attend_info=attend_record_new.attend_info and attend_record_new.student_computer_code=$computer_code and attend_record_new.attend=1 and  ( attend_info_new.date  between '" . $to_date . "' and '" . $from_date . "' ) ")->result_array();

  }

  /************************************************************************************************************************* */

  public function getCombinedAttendenceHeaderDataByDatemst($class_subject_ids, $to_date, $from_date)
  {
    @mysqli_next_result($this->db->conn_id);

    return $this->db->query("SELECT  attend_info.class_subject_id,attend_info.lecture_type,attend_info.lab_group,count(*) as total FROM attend_info_$this->academic_id  attend_info where  attend_info.class_subject_id = '$class_subject_ids' and (attend_info.date between  '" . $to_date . "' and '" . $from_date . "' ) and attend_info.lecture_type!=3 group by attend_info.class_subject_id,attend_info.lab_group")->result_array();

  }
  public function getAllAttendenceDateWise($class_subject_id, $lecture_type, $lab_group, $to_date, $from_date)
  {

    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("call h_get_subjects_attencdence_for_section_date_wise(" . $class_subject_id . "," . $lecture_type . ",'" . $lab_group . "','" . $to_date . "','" . $from_date . "')")->result_array()[0]['total'];


  }







  public function getTotalMst($section_id, $to_date, $from_date)
  {
    @mysqli_next_result($this->db->conn_id);
    // echo "call h_get_total_mst_attendence('".$section_id."','".$from_date."','".$to_date."')";
    // die();
    return $this->db->query("call h_get_total_mst_attendence(" . $section_id . ",'" . $to_date . "','" . $from_date . "')")->result_array()[0]['total_mst'];

  }

  // public function getTotalMst1($section_id)
// {
//     @mysqli_next_result($this->db->conn_id);
//  return $this->db->query("SELECT count(*) as total_mst from class_subject,attend_info_$this->academic_id attend_info where  class_subject.section_id=$section_id and attend_info.class_subject_id=class_subject.class_subject_id and  attend_info.lecture_type=3")->result_array()[0]['total_mst'];

  // }

  public function getTotalMst1($batch_id)
  {
    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("SELECT count(*) as total_mst from attend_info_new where  attend_info_new.batch_id=$batch_id and attend_info_new.lecture_type=3")->result_array()[0]['total_mst'];

  }

  public function getTotalOther($faculty_computer_code, $academic_session)
  {
    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("SELECT SUM(lecture_type_other.lecture_weight) as  total_other_weight FROM attend_info_other,lecture_type_other WHERE attend_info_other.academic_session=$academic_session and attend_info_other.lecture_type=lecture_type_other.lecture_type_other_id and attend_info_other.faculty_comp_code = $faculty_computer_code and lecture_type_other.lecture_type_other_id!=10")->result_array()[0]['total_other_weight'];

  }

  // public function getTotalOtherByDate($section_id,$to_date,$from_date)
// {
//     @mysqli_next_result($this->db->conn_id);
//  return $this->db->query("SELECT SUM(lecture_type_other.lecture_weight) as  total_other_weight FROM attend_info_other_$this->academic_id attend_info_other,lecture_type_other WHERE attend_info_other.lecture_type=lecture_type_other.lecture_type_other_id and (attend_info_other.date between  '".$to_date."' and '".$from_date."' )   and lecture_type_other.lecture_type_other_id!=10 and attend_info_other.batch_id= $section_id")->result_array()[0]['total_other_weight'];

  // }

  public function getTotalOtherByDate($faculty_computer_code, $computer_code, $to_date, $from_date, $academic_session)
  {
    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("SELECT SUM(lecture_type_other.lecture_weight) as  total_other_weight FROM attend_info_other,attend_record_other, lecture_type_other WHERE attend_info_other.academic_session=$academic_session and attend_info_other.lecture_type=lecture_type_other.lecture_type_other_id and attend_info_other.faculty_comp_code = $faculty_computer_code and attend_record_other.student_computer_code=$computer_code and attend_record_other.attend_info_other_id = attend_info_other.attend_info_other_id and (attend_info_other.date between  '" . $to_date . "' and '" . $from_date . "' )   and attend_info_other.lecture_type!=10")->result_array()[0]['total_other_weight'];

  }

  public function getMstAttendence($section_id)
  {

    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("call h_get_mst_attendence($section_id)")->result_array();

  }


  public function getMstAttendence1($section_id, $from_date, $to_date)
  {

    @mysqli_next_result($this->db->conn_id);
    //echo "call h_get_mst_attendence1($section_id,'$from_date','$to_date')";

    return $this->db->query("call h_get_mst_attendence1($section_id,'$from_date','$to_date')")->result_array();

  }

  public function getOtherAttendence($computer_code, $academic_session)
  {

    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("SELECT SUM(lecture_type_other.lecture_weight) as total_attend FROM attend_info_other,attend_record_other,lecture_type_other where attend_info_other.academic_session=$academic_session and lecture_type_other.lecture_type_other_id=attend_info_other.lecture_type and attend_info_other.attend_info_other_id = attend_record_other.attend_info_other_id and attend_record_other.student_computer_code = $computer_code  AND lecture_type_other.lecture_type_other_id!=10 ")->result_array()[0]['total_attend'];

  }

  //******************************************sectionwisegetOtherAttendenceByDate*********************************************/
// public function getOtherAttendenceByDate($section_id,$to_date,$from_date)
// {

  //       @mysqli_next_result($this->db->conn_id);
//   return $this->db->query("SELECT attend_record_other.student_computer_code as computer_code,SUM(lecture_type_other.lecture_weight) as total_attend FROM attend_info_other_$this->academic_id attend_info_other,attend_record_other_$this->academic_id attend_record_other,lecture_type_other where  attend_record_other.attend_info_other_id=attend_info_other.attend_info_other_id and lecture_type_other.lecture_type_other_id=attend_info_other.lecture_type and  ( attend_info_other.date BETWEEN  '".$to_date."' and '".$from_date."' )  AND lecture_type_other.lecture_type_other_id!=10 AND attend_info_other.section_id=$section_id GROUP BY attend_record_other.student_computer_code")->result_array();

  // }

  public function getOtherAttendenceByDate($computer_code, $to_date, $from_date, $academic_session)
  {

    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("SELECT SUM(lecture_type_other.lecture_weight) as total_attend FROM attend_info_other,attend_record_other,lecture_type_other where attend_info_other.academic_session=$academic_session and lecture_type_other.lecture_type_other_id=attend_info_other.lecture_type and attend_info_other.attend_info_other_id = attend_record_other.attend_info_other_id and attend_record_other.student_computer_code = $computer_code  AND attend_info_other.lecture_type!=10 and attend_record_other.attend=1 and ( attend_info_other.date BETWEEN  '" . $to_date . "' and '" . $from_date . "' ) ")->result_array();

  }


  public function getTotalRemedials($batch_id)
  {
    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("SELECT count(*) as total_remedials FROM attend_info_other_$this->academic_id attend_info_other where attend_info_other.batch_id=$batch_id and attend_info_other.lecture_type=10")->result_array()[0]['total_remedials'];

  }

  public function getTotalRemedialsByDate($faculty_computer_code, $computer_code, $to_date, $from_date, $academic_session)
  {
    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("SELECT count(*) as total_remedials FROM attend_info_other, attend_record_other where attend_info_other.academic_session=$academic_session and  attend_info_other.faculty_comp_code = $faculty_computer_code and attend_record_other.student_computer_code=$computer_code and attend_record_other.attend_info_other_id = attend_info_other.attend_info_other_id and ( attend_info_other.date BETWEEN  '" . $to_date . "' and '" . $from_date . "' ) and attend_info_other.lecture_type=10")->result_array()[0]['total_remedials'];

  }

  public function getRemedialsAttendence($computer_code, $academic_session)
  {

    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("SELECT attend_record_other.student_computer_code as computer_code,COUNT(*) as total_attend FROM attend_info_other, attend_record_other,lecture_type_other where  attend_record_other.attend_info_other_id=attend_info_other.attend_info_other_id and lecture_type_other.lecture_type_other_id=attend_info_other.lecture_type and attend_record_other.student_computer_code = $computer_code AND lecture_type_other.lecture_type_other_id=10  GROUP BY attend_record_other.student_computer_code")->result_array()[0]['total_attend'];

  }

  //***********************************************************sectionwise getRemedialsAttendenceByDate*********************************************/
// public function getRemedialsAttendenceByDate($batch_id,$to_date,$from_date)
// {

  //       @mysqli_next_result($this->db->conn_id);
//   return $this->db->query("SELECT attend_record_other.student_computer_code as computer_code,COUNT(*) as total_attend FROM attend_info_other_$this->academic_id attend_info_other,attend_record_other_$this->academic_id attend_record_other,lecture_type_other where  attend_record_other.attend_info_other_id=attend_info_other.attend_info_other_id and lecture_type_other.lecture_type_other_id=attend_info_other.lecture_type  and (attend_info_other.date between  '".$to_date."' and '".$from_date."' ) AND lecture_type_other.lecture_type_other_id=10 AND attend_info_other.batch_id=$batch_id GROUP BY attend_record_other.student_computer_code")->result_array();

  // }

  public function getRemedialsAttendenceByDate($computer_code, $to_date, $from_date, $academic_session)
  {
    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("SELECT attend_record_other.student_computer_code as computer_code,COUNT(*) as total_attend FROM attend_info_other, attend_record_other,lecture_type_other where  attend_record_other.attend_info_other_id=attend_info_other.attend_info_other_id and attend_info_other.academic_session=$academic_session and lecture_type_other.lecture_type_other_id=attend_info_other.lecture_type and attend_record_other.student_computer_code = $computer_code and attend_record_other.attend=1 and (attend_info_other.date between  '" . $to_date . "' and '" . $from_date . "' ) AND attend_info_other.lecture_type=10  GROUP BY attend_record_other.student_computer_code")->result_array();
  }
  //functions for coordinator
  public function selectClassesForCoodinator()
  {
    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("call h_get_class_subjects_for_coordinator($this->CompCode," . $_SESSION['user']['current_session_id'] . ")")->result_array();
  }
  public function selectClassesForHODFull($section_id)
  {
    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("call h_get_class_subjects_for_hod_full($section_id)")->result_array();
  }

  public function selectClassesForHOD()
  {
    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("call h_get_class_subjects_for_hod($this->CompCode," . $_SESSION['user']['current_session_id'] . ")")->result_array();
  }

  public function selectClassesForPrincipal($dept_id)
  {
    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("call h_get_class_subjects_for_pricipal($dept_id)")->result_array();
  }


  // public function  getAllSubjectsForClass($section_id)
//   {
//   @mysqli_next_result($this->db->conn_id);

  //   return    $this->db->query("call h_get_subjects_for_sections($section_id)")->result_array();
//   }

  public function getAllSubjectsForClass($computer_code, $semester, $academic_session, $home_dept, $specialization)
  {
    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("SELECT subject_batch.*,student_college_info_new.student_name,student_college_info_new.lab_group_name from subject_batch,student_college_info_new,subject_new where student_college_info_new.computer_code=$computer_code and student_college_info_new.semester=$semester and student_college_info_new.academic_session=$academic_session and student_college_info_new.home_dept=$home_dept and subject_batch.specialization=$specialization and student_college_info_new.specialization=$specialization and student_college_info_new.batch_id=subject_batch.batch_id and student_college_info_new.academic_session=subject_batch.academic_session_id and student_college_info_new.semester=subject_batch.semester and subject_batch.clg_sub_code=subject_new.clg_sub_code and subject_batch.university_sub_code=subject_new.university_sub_code and subject_batch.department=subject_new.department")->result_array();
  }

  public function getLectureWeightOther($lecture_type_other_id)
  {
    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("SELECT lecture_weight from lecture_type_other where lecture_type_other_id=$lecture_type_other_id")->result_array();
  }


  public function getLectureWeight($lecture_type_id)
  {
    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("SELECT weight from lecture_type where lecture_id=$lecture_type_id")->result_array();
  }

  public function getOtherLectureTypes()
  {
    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("SELECT * from lecture_type_other")->result_array();
  }

  public function submitOtherAttendence($data)
  {
    // print_r($data);die();
    extract($data);
    $students = $this->get_student_list($home_dept, $semester, $academic_session, $specialization);
    // print_r($students);
// die();
// $i=0; foreach ($students as $key1 => $value1) {
//   // print_r($computer_code[$i]);

    //   // print_r($value1['computer_code']);
//           if($value1['computer_code']==$computer_code[$i]){

    //                       $attendence_data[] = array(
//                                   'student_computer_code' => $value1['computer_code'] ,
//                                   'attend_info_other_id' => $attend_info_id
//                                   );
//           }
//           $i++;
//        }print_r($attendence_data);
//        echo "<br>";
//       //  print_r($value1['computer_code']); 
//        die();
    @mysqli_next_result($this->db->conn_id);
    $date = "'" . $date . "'";
    @mysqli_next_result($this->db->conn_id);
    /*

     if($this->db->query("call h_check_other_attendence_already_filled($section_id,$lecture_type,$date)")->num_rows())
            {
               
             die("<script>alert('Attendence allready filled for any of the slot');window.location.href='".base_url()."/AttendenceSC/selectClassesForCoodinator';</script>");
               
            }*/
    $this->db->trans_start(); # Starting Transaction
    $this->db->trans_strict(FALSE);
    @mysqli_next_result($this->db->conn_id);
    $reason = str_replace("'", "", $reason);
    $reason = str_replace('"', '', $reason);
    $this->db->query("INSERT INTO `attend_info_other` ( `faculty_comp_code`,  `lecture_type`, `date`,`reason`,`academic_session`,`specialization`) VALUES ($this->CompCode ,$lecture_type , $date,'" . $reason . "',$this->academic_id,$specialization)");
    $attend_info_id = $this->db->insert_id();
    //  print_r($reason);die();
    foreach ($students as $key1 => $value1) {
      // print_r($computer_code[$i]);
      // echo "<br>";
      // print_r($value1['computer_code']);
      if (in_array($value1['computer_code'], $computer_code)) {

        $attendence_data[] = array(
          'student_computer_code' => $value1['computer_code'],
          'attend_info_other_id' => $attend_info_id,
          'attend' => 1
        );
      }
      // $i++;
    } //die();
// print_r($attendence_data);die();
    @mysqli_next_result($this->db->conn_id);
    // $this->db->set($attendence_data);
    $this->db->insert_batch("attend_record_other", $attendence_data);


    $this->db->trans_complete(); # Completing transaction

    if ($this->db->trans_status() === FALSE) {
      # Something went wrong.
      $this->db->trans_rollback();
      return FALSE;
    } else {
      # Everything is Perfect. 
      # Committing data to the database.
      $this->db->trans_commit();
      return TRUE;
    }
  }

  public function deleteAttendence($attend_info)
  {
    @mysqli_next_result($this->db->conn_id);

    if ($this->db->query("DELETE from attend_info_$this->academic_id where attend_info=$attend_info") && $this->db->query("delete from attend_record_$this->academic_id where attend_info=$attend_info"))
      return 1;
    else
      return 0;


  }

  public function getSubjectPrintDetails($class_subject_id)
  {
    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("call h_get_subject_print_details(" . $class_subject_id . ")")->result_array();


  }

  public function printCombinedPrintDetails($section_id)
  {
    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("call h_get_details_for_combined_attendence_print($section_id)")->result_array();
  }
  public function getClassSubId($section_id, $sub_clg_code)
  {
    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("call h_get_class_subject_id($section_id,'" . $sub_clg_code . "')")->result_array();
  }

  public function viewOtherAttendence($specialization, $faculty_computer_code, $academic_session)
  {


    @mysqli_next_result($this->db->conn_id);
    // return $this->db->query("SELECT attend_info_other.*,lecture_type_other.lecture_type,(SELECT count(*) from attend_record_other_$this->academic_id attend_record_other where attend_record_other.attend_info_other_id=attend_info_other.attend_info_other_id ) as total_present from attend_info_other_".$this->academic_id." attend_info_other,lecture_type_other WHERE lecture_type_other.lecture_type_other_id=attend_info_other.lecture_type order by attend_info_other.attend_info_other_id DESC")->result_array();

    return $this->db->query("SELECT attend_info_other.*,lecture_type_other.lecture_type,(SELECT count(*) from  attend_record_other where attend_record_other.attend_info_other_id=attend_info_other.attend_info_other_id ) as total_present from attend_info_other,lecture_type_other WHERE attend_info_other.academic_session=$this->academic_id and lecture_type_other.lecture_type_other_id=attend_info_other.lecture_type and attend_info_other.specialization=$specialization and attend_info_other.faculty_comp_code=$faculty_computer_code order by attend_info_other.attend_info_other_id DESC")->result_array();


    // @mysqli_next_result($this->db->conn_id);
    // return $this->db->query("SELECT attend_info_other.*,lecture_type_other.lecture_type,(SELECT count(*) from attend_record_other_$this->academic_id attend_record_other where attend_record_other.attend_info_other_id=attend_info_other.attend_info_other_id ) as total_present from attend_info_other_".$this->academic_id." attend_info_other,lecture_type_other WHERE attend_info_other.batch_id=$class_section_id and lecture_type_other.lecture_type_other_id=attend_info_other.lecture_type order by attend_info_other.attend_info_other_id DESC")->result_array();




    // @mysqli_next_result($this->db->conn_id);
    // return $this->db->query(" SELECT attend_info_other.*,lecture_type_other.lecture_type as lecture,(SELECT count(*) from attend_record_other where attend_record_other.attend_info_other_id=attend_info_other.attend_info_other_id and  attend_record_other.attend=1 ) as total_present FROM attend_info_other,lecture_type_other  where attend_info_other.lecture_type=lecture_type_other.lecture_type_other_id and  attend_info_other.batch_id=h_section_id order BY attend_info_other.attend_info_other_id DESC")->result_array();
  }


  public function deleteOtherAttendence($attend_info_other)
  {
    @mysqli_next_result($this->db->conn_id);

    $this->db->query("DELETE from attend_info_other  where attend_info_other.attend_info_other_id=$attend_info_other");
    @mysqli_next_result($this->db->conn_id);
    $this->db->query("DELETE from attend_record_other  where attend_record_other.attend_info_other_id=$attend_info_other");
    return 1;


  }


  public function viewOtherAttendenceForUpdate($attend_info_id, $home_dept, $semester, $academic_session, $specialization)
  {

    @mysqli_next_result($this->db->conn_id);
    // $data['students']=$this->db->query("call h_get_all_students_by_section_id($class_section_id)")->result_array();
    $data['students'] = $this->db->query("SELECT distinct computer_code,enrollment_no,student_name,student_session,academic_session,semester,home_dept FROM student_college_info_new where home_dept = $home_dept and semester = $semester and academic_session=$academic_session and specialization=$specialization order by student_name")->result_array();
    // print_r($this->db->query);die();
    @mysqli_next_result($this->db->conn_id);
    $data['attended'] = $this->db->query("SELECT attend_record_other.student_computer_code from attend_record_other where attend_record_other.attend_info_other_id=$attend_info_id")->result_array();
    return $data;
  }


  public function updateOtherAttendence($attend_info_id, $student_computer_code, $attend)
  {
    @mysqli_next_result($this->db->conn_id);
    if ($attend == 0) {
      $this->db->query("delete from attend_record_other where attend_info_other_id=$attend_info_id and student_computer_code=$student_computer_code");
    } else {
      $this->db->query("insert into attend_record_other (`student_computer_code`,`attend_info_other_id`) values ($student_computer_code,$attend_info_id)");

    }
    return 1;
  }




  public function getDepartments()
  {
    //echo "call h_assigned_subjects_to_faculty($this->CompCode,".$_SESSION['user']['current_session_id'].")"; die();
    @mysqli_next_result($this->db->conn_id);
    return $this->db->query("call h_get_all_departments()")->result_array();
  }


  public function get_semester($year)
  {
    $query = "SELECT sem_id FROM semester where active=1 and `year`=$year";
    // print_r($query);
    // die();
    $result = $this->db->query($query);

    return $result->result_array();

  }
  public function get_attend_details($attend_info_other)
  {

    $query = "SELECT * FROM attend_info_other where attend_info_other_id = $attend_info_other";

    $result = $this->db->query($query);

    return $result->result_array();

  }
  public function get_student_details($attend_info_other)
  {

    $query = "SELECT student_computer_code as computer_code FROM attend_record_other where attend_info_other_id = $attend_info_other and attend=1";

    $result = $this->db->query($query);

    return $result->result_array();

  }

  public function getTotalAttendence($batch_id, $academic_session, $lab_group, $type)
  {
    @mysqli_next_result($this->db->conn_id);
    if ($type == 'T' || $type == 'MCT') {
      $total_theory = $this->db->query("SELECT count(*) as total FROM attend_info_new where batch_id=$batch_id  and attend_info_new.academic_session=$academic_session and attend_info_new.lecture_type in (1,4,5) group by attend_info_new.lab_group ")->result_array()[0]['total'];
      $total_practical = 0;
      $total_mst = $this->db->query("SELECT count(*) as total_mst from attend_info_new where attend_info_new.academic_session=$academic_session and attend_info_new.batch_id=$batch_id and attend_info_new.lecture_type=3")->result_array()[0]['total_mst'];
    } else if ($type == 'P' || $type == 'MCP') {
      $total_theory = 0;
      $total_practical = $this->db->query("SELECT count(*) as total FROM attend_info_new where batch_id=$batch_id and attend_info_new.academic_session=$academic_session and lab_group='$lab_group' and attend_info_new.lecture_type =2 group by attend_info_new.lab_group ")->result_array()[0]['total'];
      $total_mst = $this->db->query("SELECT count(*) as total_mst from attend_info_new where attend_info_new.academic_session=$academic_session and attend_info_new.batch_id=$batch_id and attend_info_new.lecture_type=3")->result_array()[0]['total_mst'];
    } else {
      $total_theory = 0;
      $total_practical = 0;
      $total_mst = 0;
    }


    $total_attendance = $total_theory + $total_practical + $total_mst * 4;
    return $total_attendance;
  }

  public function getAttendence($computer_code, $batch_id, $academic_session, $lab_group, $type)
  {
    @mysqli_next_result($this->db->conn_id);
    if ($type == 'T' || $type == 'MCT') {
      $theory = $this->db->query("SELECT count(*) as total FROM attend_info_new,attend_record_new where attend_info_new.academic_session=$academic_session and attend_info_new.batch_id=$batch_id and attend_info_new.lecture_type in (1,4,5) and  attend_record_new.attend=1 and attend_info_new.attend_info=attend_record_new.attend_info and attend_record_new.student_computer_code=$computer_code group by attend_info_new.lecture_type")->result_array()[0]['total'];
      $practical = 0;
      $mst = $this->db->query("SELECT count(*) as mst from attend_info_new,attend_record_new where attend_info_new.academic_session=$academic_session and attend_info_new.batch_id=$batch_id and attend_info_new.lecture_type=3 and attend_info_new.attend_info=attend_record_new.attend_info and attend_record_new.student_computer_code=$computer_code and attend_record_new.attend=1")->result_array()[0]['mst'];

    } else if ($type == 'P' || $type == 'MCP') {
      $theory = 0;
      $practical = $this->db->query("SELECT count(*) as total FROM attend_info_new,attend_record_new where attend_info_new.academic_session=$academic_session and attend_info_new.batch_id=$batch_id and attend_info_new.lab_group='$lab_group' and attend_info_new.lecture_type =2 and  attend_record_new.attend=1 and  attend_info_new.attend_info=attend_record_new.attend_info and attend_record_new.student_computer_code=$computer_code group by attend_info_new.lecture_type")->result_array()[0]['total'];
      $mst = $this->db->query("SELECT count(*) as mst from attend_info_new,attend_record_new where attend_info_new.academic_session=$academic_session and attend_info_new.batch_id=$batch_id and attend_info_new.lecture_type=3 and attend_info_new.attend_info=attend_record_new.attend_info and attend_record_new.student_computer_code=$computer_code and attend_record_new.attend=1")->result_array()[0]['mst'];

    } else {
      $total_theory = 0;
      $total_practical = 0;
      $total_mst = 0;
    }

    $attendance = $theory + $practical + $mst * 4;
    return $attendance;
  }
  public function get_student_list_new($home_dept, $semester, $academic_session, $specialization)
  {
    return $this->db->query("SELECT distinct computer_code,enrollment_no,student_name,student_session,academic_session,semester,home_dept FROM student_college_info_new where home_dept = $home_dept and semester = $semester and academic_session=$academic_session and specialization=$specialization order by student_name")->result_array();
  }
  // Functions for Cumulative Attendance - 

  // get total attendance excluding others - 
  public function getTotalAttendance($computer_code, $academic_session)
  {

    return $this->db->query("SELECT DISTINCT count(attend_record_new.`attend_record_id`) as total_attendance  FROM `attend_record_new`,`attend_info_new` WHERE attend_record_new.`student_computer_code` = $computer_code and attend_record_new.attend_info = attend_info_new.attend_info and attend_info_new.academic_session = $academic_session")->result()[0]->total_attendance;

  }
  // get total student attendance excluding others - 
  public function getStudentAttendance($computer_code, $academic_session)
  {

    return $this->db->query("SELECT DISTINCT count(attend_record_new.`attend_record_id`) as total_attendance  FROM `attend_record_new`,`attend_info_new` WHERE attend_record_new.`student_computer_code` = $computer_code and attend_record_new.attend_info = attend_info_new.attend_info and attend_info_new.academic_session = $academic_session and attend_record_new.attend=1")->result()[0]->total_attendance;

  }

  // get total other attendance - 
  public function getTotalOtherAttendance($computer_code, $academic_session)
  {

    return $this->db->query("SELECT DISTINCT count(attend_record_other.attend_record_other_id)*lecture_type_other.lecture_weight as total_other FROM `attend_record_other`,`attend_info_other`,`lecture_type_other` WHERE attend_record_other.`student_computer_code` = $computer_code and attend_info_other.attend_info_other_id = attend_record_other.attend_info_other_id and attend_info_other.academic_session = $academic_session and lecture_type_other.lecture_type_other_id = attend_info_other.lecture_type and attend_info_other.lecture_type != 10")->result()[0]->total_other;

  }

  // get total student other attendance - 
  public function getStudentOther($computer_code, $academic_session)
  {

    return $this->db->query("SELECT DISTINCT SUM(lecture_type_other.lecture_weight) as total_other FROM `attend_record_other`,`attend_info_other`,`lecture_type_other` WHERE attend_record_other.`student_computer_code` = $computer_code and attend_info_other.attend_info_other_id = attend_record_other.attend_info_other_id and attend_info_other.academic_session = $academic_session and lecture_type_other.lecture_type_other_id = attend_info_other.lecture_type and attend_info_other.lecture_type != 10 and attend_record_other.attend=1")->result()[0]->total_other;

  }

  // get student remedial attendance - 
  public function getStudentRemedial($computer_code, $academic_session)
  {

    return $this->db->query("SELECT DISTINCT count(attend_record_other.attend_record_other_id) as remedials FROM `attend_record_other`,`attend_info_other` WHERE attend_record_other.`student_computer_code` = $computer_code and attend_info_other.attend_info_other_id = attend_record_other.attend_info_other_id and attend_info_other.academic_session = $academic_session and attend_info_other.lecture_type = 10 and attend_record_other.attend=1")->result()[0]->remedials;

  }

  public function getOtherAttendanceDetails($attend_info_other)
  {
    return $this->db->query("SELECT lecture_type_other.lecture_weight, attend_info_other.lecture_type FROM `attend_info_other`,`lecture_type_other` WHERE attend_info_other.attend_info_other_id = $attend_info_other and attend_info_other.lecture_type = lecture_type_other.lecture_type_other_id")->result_array()[0];
  }
  public function get_tiemstamp($home_dept, $semester, $current_session_id, $specialization)
  {
    return $this->db->query("SELECT timestamp FROM `cumulative_attendance` WHERE department = $home_dept and semester = $semester and academic_session=$current_session_id ")->result_array()[0];
  }
}
