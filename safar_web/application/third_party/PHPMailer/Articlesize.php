<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *  Articlesize Controller
 */
class Articlesize extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('uid'))
		redirect('signin');
		$this->load->model('SizeM');
		$this->load->model('crud');
	}

	public function index()
	{

		$data['data'] = $this->SizeM->get_all();
		// echo "<pre>";
		// print_r($data);
		// die();
		$this->load->view('articlesize/list', $data);
	}


	public function create()
	{
		$data['type'] = $this->crud->get_records('type');
		$data['category'] = $this->crud->get_records('category');
		$this->load->view('articlesize/create',$data);
	}


	public function store()
	{
		$data['name'] = $this->input->post('name');
		$data['type'] = $this->input->post('type');
		$data['category'] = $this->input->post('category');
		$data['mrp'] = $this->input->post('mrp');
		$data['package_box'] = $this->input->post('package_box');
		$data['package_loose'] = $this->input->post('package_loose');
		$data['no_of_pairs_box'] = $this->input->post('no_of_pairs_box');
		$data['no_of_pairs_loose'] = $this->input->post('no_of_pairs_loose');
		$data['photo'] = $this->input->post('photo');
		$data['is_active'] = $this->input->post('is_active');	
		$this->crud->insert('articlesize', $data);
		$this->session->set_flashdata('message', '<div class="alert alert-success">Record has been saved successfully.</div>');
		redirect(base_url('/articlesize'));
	}

	public function edit($id)
	{
		$data['data'] = $this->crud->find_record_by_id('article', $id);
		$this->load->view('articlesize/edit', $data);
	}

	public function update($id)
	{
		$data['id'] = $this->input->post('id');
		$data['name'] = $this->input->post('name');
		$data['type'] = $this->input->post('type');
		$data['category'] = $this->input->post('category');
		$data['mrp'] = $this->input->post('mrp');
		$data['package_box'] = $this->input->post('package_box');
		$data['package_loose'] = $this->input->post('package_loose');
		$data['no_of_pairs_box'] = $this->input->post('no_of_pairs_box');
		$data['no_of_pairs_loose'] = $this->input->post('no_of_pairs_loose');
		$data['photo'] = $this->input->post('photo');
		$data['is_active'] = $this->input->post('is_active');	
		$this->crud->update('articlesize', $data, $id);
		$this->session->set_flashdata('message', '<div class="alert alert-success">Record has been updated successfully.</div>');
		redirect(base_url('/articlesize'));
	}

	public function delete($id)
	{
		$this->crud->delete('articlesize', $a_id);
		$this->session->set_flashdata('message', '<div class="alert alert-success">Record has been deleted successfully.</div>');
		redirect(base_url('/articlesize'));
	}
}