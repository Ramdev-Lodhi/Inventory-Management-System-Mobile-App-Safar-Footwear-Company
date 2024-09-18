<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	//Validating login
	function __construct(){
	parent::__construct();
	if(!$this->session->userdata('uid'))
	redirect('signin');
	$this->load->model('crud');
	$this->load->model('ChartM');
	}
	public function index(){
		$userfname=$this->session->userdata('fname');	
		$data['data'] = $this->crud->get_records('category');
		foreach($data['data'] as $count_data){

			$countdata = $this->ChartM->get_count($count_data->id);
			if (!empty($countdata)) {
                // Assuming get_count returns an object with 'count' and 'category'
                $da[] = array(
                    'count' => $countdata[0]['count'],
                    'category' => $count_data->id
                );
            }
		}
		$data['count']=$da;
		// print_r($data['coun']);
		// die();
		// $this->load->view('welcome',['firstname'=>$userfname]);
		$this->load->view('dashboard',$data);
		}
	
	public function subdata($id)
	{
		
		$sub=$this->ChartM->get_sub_data($id);
		// print_r($sub);
		echo json_encode($sub);
	}
}
