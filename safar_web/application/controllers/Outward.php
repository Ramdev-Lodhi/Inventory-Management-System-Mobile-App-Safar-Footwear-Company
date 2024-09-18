<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *  Outward Controller
 */
class Outward extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('uid'))
		redirect('signin');
		$this->load->model('crud');
		$this->load->model('LabelM');
	}

	public function index()
	{

		$data['data'] = $this->crud->get_records('outter_box_outward');
		// echo "<pre>";
		// print_r($data);
		// die();
		$this->load->view('outward/list', $data);
	}
	public function store()
	{
        $data['inward_id'] = $this->input->post('id');
		$inward_data = $this->crud->find_record_by_id('outter_box_inward',$data['inward_id']);
		// 		echo "<pre>";
		// print_r($inward_data);
		// die();
		if(!empty($inward_data)){
		
			$data['qr_id']=$inward_data->qr_id;
			$data['status']=$inward_data->status;
			$godown_id=$inward_data->godown_id;
			$size=$inward_data->size;
			$no_of_pairs=$inward_data->no_of_pairs;
			$check=$this->LabelM->check_outwards($data['inward_id']);
	
			if(!empty($check)){
				$this->session->set_flashdata('message', '<div class="alert alert-danger text-uppercase text-center mx-auto" style="width: 40%;">ID Already Exists </div>');
			}else{
				$id =  $this->crud->insert('outter_box_outward', $data);
				
				if($id){
					$this->session->set_flashdata('message', '<div class="alert alert-success text-uppercase text-center mx-auto" style="width: 40%;">Record has been added successfully.</div>');
				}else{
					$this->session->set_flashdata('message', '<div class="alert alert-danger text-uppercase text-center mx-auto" style="width: 40%;">Record has been not added.</div>');
				}
			}
		
		}else{
			$response = array('status'=>'404');
			
		}
       
        redirect(base_url('/outward'));
	}
	public function edit($id){
		$data['update'] = $this->crud->find_record_by_id('outter_box_outward', $id);
    // Return data as JSON
    echo json_encode($data['update']);
	}
	public function update($id)
	{
		$data['inward_id'] = $this->input->post('id');
		$inward_data = $this->crud->find_record_by_id('outter_box_inward',$data['inward_id']);
		$data['qr_id']=$inward_data->qr_id;
		$data['status']=$inward_data->status;
		$this->crud->update('outter_box_outward', $data, $id);
		$this->session->set_flashdata('message', '<div class="alert alert-info text-uppercase text-center mx-auto" style="width: 40%;">Record has been updated successfully.</div>');
		redirect(base_url('/outward'));
	}
	public function delete($id)
	{
		$this->crud->delete('outter_box_outward', $id);
		$this->session->set_flashdata('message', '<div class="alert alert-danger text-uppercase text-center mx-auto" style="width: 40%;">Record has been deleted successfully.</div>');
		redirect(base_url('/outward'));
	}
}