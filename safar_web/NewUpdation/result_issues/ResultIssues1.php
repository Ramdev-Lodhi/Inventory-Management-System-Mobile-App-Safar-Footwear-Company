<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ResultIssues1 extends CI_Controller {
	function __construct() {
        parent::__construct();     
        $this->load->model('ResultIssuesM');           
    }
  public function index()
  {
    $academic_session = ($this->session->userdata('user'))['academic_id'];

    $data['subjects'] = $this->ResultIssuesM->fetch_subjects($academic_session);
    // echo "<pre>";
    // var_dump($data);
    // die();
    $this->load->view('new_template/faculty_common');
		$this->load->view('result_issues1.php',$data);
		$this->load->view('new_template/new_footer');
  }
  public function result_issues2($depts = null, $specil = null)
  {
    $academic_session = ($this->session->userdata('user'))['academic_id'];
    // print_r($_SESSION);
    // die();
    $data['subjects'] = $this->ResultIssuesM->fetch_subjects2($academic_session,$depts, $specil);
    $data['subjects1'] = $this->ResultIssuesM->fetch_subjects3($academic_session,$depts, $specil);
    echo json_encode($data);

  }
}




