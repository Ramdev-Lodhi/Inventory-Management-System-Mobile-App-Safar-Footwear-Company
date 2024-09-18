<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *  Label Controller
 */
class Api extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('crud');
		$this->load->model('ApiM');
	}

	public function index()
	{
		$response = array(
			'status'=>'200',
		);
		$json_data = json_encode($response);
        echo $json_data;
	}
	public function login()
	{
		$email = $_POST['email'];
		$pass = $_POST['pass'];
		$validate = $this->ApiM->login($email, $pass);
		if ($validate) {
			$this->session->set_userdata('name',$validate[0]['FirstName']);
			$this->session->set_userdata('role',$validate[0]['role']);
			$response = array(
				'status' => '200',
				'name' =>$this->session->userdata('name'),
				'role' =>$this->session->userdata('role'),
			);
		} else {
			$response = array(
				'status' => '500',
				'name' => ""
			);
		}
		$json_data = json_encode($response);
		echo $json_data;

	}
	
	public function chart_data(){
		$category_counts_first = array();
		$category_counts_second = array();

		// Get articles with quality 'first'
		$articles_first = $this->ApiM->get_godown_stock_articles_first();
		// Get articles with quality 'second'
		$articles_second = $this->ApiM->get_godown_stock_articles_second();
		$i = 0;
		foreach ($articles_first as $a) {
			$godown_stock[$i]['quality'] = $a['quality'];
			$category = $this->ApiM->get_stock_category($a['a_id']);
			foreach ($category as $cat) {
				$godown_stock[$i]['category'] = $cat['category'];
				if (isset($category_counts_first[$cat['category']])) {
					$category_counts_first[$cat['category']]['count']++;
				} else {
					$category_counts_first[$cat['category']] = array('category_id' => $cat['category'], 'count' => 1, 'name' => $cat['name']);
				}
			}
			$i++;
		}
		// Process articles with quality 'second'
		foreach ($articles_second as $a) {
			$godown_stock[$i]['quality'] = $a['quality'];
			$category = $this->ApiM->get_stock_category($a['a_id']);
			foreach ($category as $cat) {
				$godown_stock[$i]['category'] = $cat['category'];
				if (isset($category_counts_second[$cat['category']])) {
					$category_counts_second[$cat['category']]['count']++;
				} else {
					$category_counts_second[$cat['category']] = array('category_id' => $cat['category'], 'count' => 1 , 'name' => $cat['name']);
				}
			}
			$i++;
		}

		$data['category_counts_first'] = array_values($category_counts_first);
		$data['category_counts_second'] = array_values($category_counts_second);
		$data['jobsheet'] = $this->ApiM->get_jobsheet();
		echo json_encode($data);
	}

	public function insert_inwards($qr_id,$godown_id)
    {
		$qr_id = base64_decode(urldecode($qr_id));
        $data['qr_id'] = $qr_id;
		$temp = explode('~',$qr_id);
        $data['a_id'] = $temp[1];
        $data['a_name'] = $temp[2];
        $data['size']=$temp[3];
        $data['a_color_id'] = $temp[4];	
        $data['a_color'] = $temp[5];	
        $data['no_of_pairs'] = $temp[6];	
        $data['quality'] = $temp[7];	
		$data['godown_id'] = $godown_id;	
		$data['status']='pending';
		$data['created_on'] = date('Y-m-d H:i:s',time());
		$data['modified_on'] = date('Y-m-d H:i:s',time());
		
		$check = $this->ApiM->check_inwards($qr_id);
		if(!empty($check)){
			$response = array(
				'status'=>'409',
			);
		}else{
			$id = $this->crud->insert('outter_box_inward',$data);
			if($id){
				$response = array(
					'status'=>'200',
				);
			}else{
				$response = array(
					'status'=>'500',
				);
			}
		}
        
        $json_data = json_encode($response);
        echo $json_data;
    }
	
	public function insert_outwards($qr_id)
    {
		$qr_id = base64_decode(urldecode($qr_id));
        $data['qr_id'] = $qr_id;
		$inward_id = $this->ApiM->get_inwardId_by_qrId($qr_id);
		if(!empty($inward_id)){
			$temp = explode('~',$qr_id);	
			$data['inward_id'] = $inward_id[0]['id'];	
			$data['status']='pending';
			$check=$this->ApiM->check_outwards($data['inward_id']);
			if(!empty($check)){
				$response = array(
					'status'=>'409',
				);
			}else{
				$id = $this->crud->insert('outter_box_outward',$data);
				if($id){
					$response = array(
						'status'=>'200',
					);
				}else{
					$response = array(
						'status'=>'500',
					);
				}
			}
			
			$json_data = json_encode($response);
		}else{
			$response = array('status'=>'404');
			$json_data = json_encode($response);
		}
		
        echo $json_data;
    }
	
	public function get_jobsheet_status($job_id)
    {
		$job_details = $this->ApiM->get_jobsheet_status($job_id);
		if(!empty($job_details)){
			$response_data = array();
			foreach($job_details as $j){
				$response = array(
					"dept_id"=>$j['dept_id'],
					"dept_name"=>$j['dept_name'],
					"no_of_pairs"=>$j['pairs_qty_dispatched'],
					"weight"=>$j['sack_weight_dispatched'],
					"pairs_damage"=>$j['pairs_damage'],
				);
				array_push($response_data,$response);
			}
			$json_data = json_encode($response_data);
		}else{
			$response = array();
			$json_data = json_encode($response);
		}		
        echo $json_data;
    }
	
	public function submitJobsheet($job_id, $job_type, $job_list){
	
		$job_list = json_decode(base64_decode(urldecode($job_list)),true);

		$api_status = true;
	
		foreach($job_list['data'] as $j){
			$check = $this->ApiM->check_jobsheet($job_id, $j['id']);

			if(!empty($check)){
			if($check[0]['status'] == 'success'){
				$this->ApiM->update_jobsheet_success($job_id, $j['id'], $j['no_of_pairs'], $j['weight'], $j['damage'],$j['status']);
			}else{
				$this->ApiM->update_jobsheet($job_id, $j['id'], $j['no_of_pairs'], $j['weight'], $j['damage'],$j['status'],$j['datedispatched']);
			}
			}elseif($j['status'] == 'success'){
				$data['jobsheet_id'] = $job_id;
				$data['job_type'] = $job_type;
				$data['dept_id'] = $j['id'];
				$data['dept_name'] = $j['name'];
				$data['pairs_qty_dispatched'] = $j['no_of_pairs'];
				$data['pairs_damage'] = $j['damage'];
				$data['sack_weight_dispatched'] = $j['weight'];
				$data['status'] = $j['status'];
				$data['dept_recieved_date'] = $j['datereceived'];
				$data['dept_dispatched_date'] = $j['datedispatched'];
				$id = $this->crud->insert('job_status',$data);
				if(empty($id)){
					$api_status = false;
				}
			}else{
				$data['jobsheet_id'] = $job_id;
				$data['job_type'] = $job_type;
				$data['dept_id'] = $j['id'];
				$data['dept_name'] = $j['name'];
				$data['pairs_qty_dispatched'] = $j['no_of_pairs'];
				$data['pairs_damage'] = $j['damage'];
				$data['sack_weight_dispatched'] = $j['weight'];
				$data['status'] = $j['status'];
				$data['dept_recieved_date'] = $j['datereceived'];
				$data['dept_dispatched_date'] = 0000-00-00;
					$id = $this->crud->insert('job_status',$data);
				if(empty($id)){
					$api_status = false;
				}

			}
		}
		if($api_status){
			$response = array(
				'status'=>'200',
			);
		}else{
			$response = array(
				'status'=>'500',
			);
		}
        $json_data = json_encode($response);
        echo $json_data;
    
	}
}