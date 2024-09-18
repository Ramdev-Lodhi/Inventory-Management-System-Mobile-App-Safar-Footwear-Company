<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

class Email extends CI_Controller {
	function __construct() {
        parent::__construct();
        error_reporting(0);
		$this->load->library('PHPMailerConfig');
        $this->load->library('session');
		$row = $this->session->userdata('user');   
		
		if(empty($row['computer_code'])) 
		{
			redirect(base_url('Login'));
		}
		$this->load->model('EmailM');
		log_message('Debug','PHPMailer class is loaded');
		
	  }	

      public function index()
      {
		$data['department']=$this->EmailM->GetDepartment();
        $this->load->view('new_template/faculty_common');
		$this->load->view('Email/Email_send',$data);
        $this->load->view('new_template/new_footer');
      }
	  public function list_student()
      {
		$row = $this->session->userdata('user');
		$data['academic_session']=$row['current_session_id'];
		// echo"<pre>"; print_r($data['academic_session']); die();
		$department=$_POST['department'];
		$data['semester']=$_POST['semester'];
		// print_r($_POST); die();
		$data['list_student']=$this->EmailM->get_list_student($department,$data['semester']);
		$data['active_session']=$this->EmailM->get_active_session();
		// echo"<pre>"; print_r($data['list_student']); die();
		$data['department']=$this->EmailM->GetDepartment();
		$this->load->view('new_template/faculty_common');
		$this->load->view('Email/Email_send',$data);
        $this->load->view('new_template/new_footer');
      }
	  public function email()
      {
		$data['student_data']=$_POST['checkbox'];
	

			// print_r($data1);
			// die();
	// 	echo"<pre>";
		$this->load->view('new_template/faculty_common');
		$this->load->view('Email/EmailV',$data);
        $this->load->view('new_template/new_footer');
      }

	  public function email_send()
	  {
		$data=$_POST['email'];
		$data1=array();
		$i=0;
		foreach($data as $d )
		{
			list($email,$name)=explode(',',$d);
			$da['email'] =$email;
			$da['student_name'] =$name; 
	        array_push($data1,$da);
		}$i++;
	
		if ($data1){
			foreach($data1 as $email){
				$recipientEmail = $email['email'];   
				$recipientName = $email['student_name'];
				$subject = $_POST['subject'];
				$body = $_POST['textarea'];
				$result = $this->phpmailerconfig->sendEmail($recipientEmail, $recipientName, $subject, $body);
			if ($result === true) {
				$this->session->set_flashdata('email_send', 'Email Send  Successfully');
				// echo 'Email sent successfully';
			} else {
				$this->session->set_flashdata('email_send_fail', 'Email Send  failed, Resend......');	
			
				// echo $result;
			}
		}
			
		
	
		  redirect(base_url('Email'));
			
		  
		}
		
			
		}
			}
			// echo "<pre>";
			// print_r($recipientEmail);
		
			// die();
	
		


		


      ?>