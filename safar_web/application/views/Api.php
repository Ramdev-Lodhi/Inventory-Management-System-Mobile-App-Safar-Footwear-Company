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
	
}