<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *  Articlecolor Controller
 */
class Contractor extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('uid'))
			redirect('signin');
		$this->load->model('crud');
	}

	public function index()
	{
		$data['data'] = $this->crud->get_records('contractor_details');
		// $data['category'] = $this->crud->get_records('contractor');
		$this->load->view('contractor/list', $data);
	}

	public function store()
	{


		$data['contractor_name'] = $this->input->post('contractor');
		$this->crud->insert('contractor_details', $data);
		$this->session->set_flashdata('message', '<div class="alert alert-success  text-uppercase text-center mx-auto" style="width: 40%;"">Record has been saved successfully.</div>');
		redirect(base_url('/contractor'));
	}

	public function edit($id)
	{
		$data['data'] = $this->crud->find_record_by_id('contractor_details', $id);
		// $this->load->view('contractor_details/edit', $data);
		echo json_encode($data['data']);
	}

	public function update($id)
	{

		$data['contractor_name'] = $this->input->post('contractor');

		$this->crud->update('contractor_details', $data, $id);
		$this->session->set_flashdata('message', '<div class="alert alert-info text-uppercase text-center mx-auto" style="width: 40%;"">Record has been updated successfully.</div>');
		redirect(base_url('/contractor'));
	}

	public function delete($id)
	{
		$this->crud->delete('contractor_details', $id);
		$this->session->set_flashdata('message', '<div class="alert alert-danger text-uppercase text-center mx-auto" style="width: 40%;"">Record has been deleted successfully.</div>');
		redirect(base_url('/contractor'));
	}
}