<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *  Article Controller
 */
class Category extends CI_Controller
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

		$data['data'] = $this->crud->get_records('category');
		// echo "<pre>";print_r($data); die();
		$this->load->view('category/list',$data);
	}
	public function store()
	{
		$data['name'] = $this->input->post('name');

		$this->crud->insert('category', $data);
		$this->session->set_flashdata('message', '<div class="alert alert-success text-uppercase text-center mx-auto" style="width: 40%;">Record has been saved successfully.</div>');
		redirect(base_url('/category'));
	}
	public function edit($id){
		$data['update'] = $this->crud->find_record_by_id('category', $id);
    // Return data as JSON
    echo json_encode($data['update']);
	}
	public function update($id)
	{
		// $data['id'] = $this->input->post('id');
		$data['name'] = $this->input->post('name');
	
		$this->crud->update('category', $data, $id);
	
		
		$this->session->set_flashdata('message', '<div class="alert alert-info text-uppercase text-center mx-auto" style="width: 40%;">Record has been updated successfully.</div>');
		redirect(base_url('/category'));
	}
	public function delete($id)
	{
		$this->crud->delete('category', $id);
		$this->session->set_flashdata('message', '<div class="alert alert-danger text-uppercase text-center mx-auto" style="width: 40%;">Record has been deleted successfully.</div>');
		redirect(base_url('/category'));
	}
}