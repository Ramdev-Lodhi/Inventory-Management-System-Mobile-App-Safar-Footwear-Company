<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *  Article Controller
 */
class Package extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('uid'))
		redirect('signin');
		$this->load->model('crud');
	
	}
	public function index()
	{

		$data['data'] = $this->crud->get_records('package_size');
		$data['category'] = $this->crud->get_records('category');
		$this->load->view('package/list',$data);
	}
	
		public function store()
{
    $data['category_id'] = $this->input->post('category');
    $data['size'] = $this->input->post('size');  
    // Initialize all 1 to 13 columns with 0
    for ($i = 1; $i <= 13; $i++) {
        $data["`$i`"] = 0; 
    }
        $package_size = explode('x',$_POST['size']);
        // Set columns from start to end to 1
        for ($i = $package_size[0]; $i <= $package_size[1]; $i++) {
            $data["`$i`"] = 1;
        }
    $this->crud->insert('package_size', $data);
    $this->session->set_flashdata(
        'message',
        '<div class="alert alert-success text-uppercase text-center mx-auto" style="width: 40%;">Record has been saved successfully.</div>'
    );
    redirect(base_url('/package'));
}


	public function edit($id){
		$data['update'] = $this->crud->find_record_by_id('package_size', $id);
    // Return data as JSON
    echo json_encode($data['update']);
	}
	public function update($id)
	{
		$data['category_id'] = $this->input->post('category');
        $data['size'] = $this->input->post('size');  
    // Initialize all 1 to 13 columns with 0
    for ($i = 1; $i <= 13; $i++) {
        $data["`$i`"] = 0; 
    }
        $package_size = explode('x',$_POST['size']);
        // Set columns from start to end to 1
        for ($i = $package_size[0]; $i <= $package_size[1]; $i++) {
            $data["`$i`"] = 1;
        }
		$this->crud->update('package_size', $data, $id);
		$this->session->set_flashdata('message', '<div class="alert alert-info text-uppercase text-center mx-auto" style="width: 40%;">Record has been updated successfully.</div>');
		redirect(base_url('/package'));
	}
	public function delete($id)
	{
		$this->crud->delete('package_size', $id);
		$this->session->set_flashdata('message', '<div class="alert alert-danger text-uppercase text-center mx-auto" style="width: 40%;">Record has been deleted successfully.</div>');
		redirect(base_url('/package'));
	}
}