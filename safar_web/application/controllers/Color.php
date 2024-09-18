<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *  Articlecolor Controller
 */
class Color extends CI_Controller
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
		$data['data'] = $this->crud->get_records('color');
		$data['category'] = $this->crud->get_records('category');
		$this->load->view('color/list', $data);
	}

	public function store()
	{

		$data['category_id'] = $this->input->post('category_id');
		$data['color'] = $this->input->post('color');
		$this->crud->insert('color', $data);
		$this->session->set_flashdata('message', '<div class="alert alert-success  text-uppercase text-center mx-auto" style="width: 40%;"">Record has been saved successfully.</div>');
		redirect(base_url('/color'));
	}

	public function edit($id)
	{
		$data['data'] = $this->crud->find_record_by_id('color', $id);
		// $this->load->view('articlecolor/edit', $data);
		echo json_encode($data['data']);
	}

	public function update($id)
	{
		$data['category_id'] = $this->input->post('category_id');
		$data['color'] = $this->input->post('color');

		$this->crud->update('color', $data, $id);
		$this->session->set_flashdata('message', '<div class="alert alert-info text-uppercase text-center mx-auto" style="width: 40%;"">Record has been updated successfully.</div>');
		redirect(base_url('/color'));
	}

	public function delete($id)
	{
		$this->crud->delete('color', $id);
		$this->session->set_flashdata('message', '<div class="alert alert-danger text-uppercase text-center mx-auto" style="width: 40%;"">Record has been deleted successfully.</div>');
		redirect(base_url('/color'));
	}
}