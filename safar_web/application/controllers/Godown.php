<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *  Articlecolor Controller
 */
class Godown extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('uid'))
			redirect('signin');
		$this->load->model('colorM');
		$this->load->model('crud');
	}

	public function index()
	{
		$data['data'] = $this->crud->get_records('godown');
		// $data['category'] = $this->crud->get_records('godown');
		$this->load->view('godown/list', $data);
	}

	public function store()
	{


		$data['name'] = $this->input->post('godown');
		$this->crud->insert('godown', $data);
		$this->session->set_flashdata('message', '<div class="alert alert-success  text-uppercase text-center mx-auto" style="width: 40%;"">Record has been saved successfully.</div>');
		redirect(base_url('/godown'));
	}

	public function edit($id)
	{
		$data['data'] = $this->crud->find_record_by_id('godown', $id);
		// $this->load->view('articlegodown/edit', $data);
		echo json_encode($data['data']);
	}

	public function update($id)
	{

		$data['name'] = $this->input->post('godown');

		$this->crud->update('godown', $data, $id);
		$this->session->set_flashdata('message', '<div class="alert alert-info text-uppercase text-center mx-auto" style="width: 40%;"">Record has been updated successfully.</div>');
		redirect(base_url('/godown'));
	}

	public function delete($id)
	{
		$this->crud->delete('godown', $id);
		$this->session->set_flashdata('message', '<div class="alert alert-danger text-uppercase text-center mx-auto" style="width: 40%;"">Record has been deleted successfully.</div>');
		redirect(base_url('/godown'));
	}
}