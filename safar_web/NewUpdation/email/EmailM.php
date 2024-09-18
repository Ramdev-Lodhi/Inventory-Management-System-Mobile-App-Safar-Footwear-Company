<?php
class EmailM extends CI_Model {
    public function GetDepartment()
	{
		$query = "SELECT id, name FROM department WHERE core_dept = 1 and active = 1 ORDER BY name";

		$result = $this->db->query($query);
		return $result->result_array();
	}
    public function get_list_student($department,$semester)
    {
        $query ="SELECT temp_student_data.student_name , temp_student_data.enrollment_number , temp_student_data.computer_code FROM temp_student_data,assign_student WHERE temp_student_data.home_dept='$department' AND assign_student.semester=$semester AND temp_student_data.computer_code= assign_student.computer_code order by temp_student_data.student_name";
        // print_r($query);
        // die();
        $data=$this->db->query($query);
        return $data->result_array();
    }
    
public function get_active_session()
{
  $query = " SELECT * from academic_session WHERE active=1";
  $result = $this->db->query($query);
    return $result->result_array()[0]['academic_session_id'];

}
}
?>