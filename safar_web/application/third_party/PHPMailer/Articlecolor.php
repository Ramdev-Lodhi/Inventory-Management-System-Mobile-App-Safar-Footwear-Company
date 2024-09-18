<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *  Articlecolor Controller
 */
class Articlecolor extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('uid'))
		redirect('signin');
		$this->load->model('colorM');
		$this->load->model('crud');
	}

	public function index()
	{
		$data['data'] = $this->colorM->get_all('article_color');
		// echo "<pre>";
		// print_r($data);
		// die();
		$this->load->view('articlecolor/list', $data);
	}


	public function create()
	{
		$data['article'] = $this->crud->get_records('article');
		$this->load->view('articlecolor/create',$data);
	}


	public function store()
	{
		$data['article_id'] = $this->input->post('a_id');
		$data['color'] = $this->input->post('color');
		$data['c_photo'] = $this->input->post('c_photo');
		$this->crud->insert('article_color', $data);
		$this->session->set_flashdata('message', '<div class="alert alert-success">Record has been saved successfully.</div>');
		redirect(base_url('/articlecolor'));
	}

	public function edit($id)
	{
		$data['data'] = $this->crud->find_record_by_id('article_color', $id);
		$this->load->view('articlecolor/edit', $data);
	}

	public function update($id)
	{
		$data['a_id'] = $this->input->post('a_id');
		$data['color'] = $this->input->post('color');
		$data['c_photo'] = $this->input->post('c_photo');
		$this->crud->update('article_color', $data, $id);
		$this->session->set_flashdata('message', '<div class="alert alert-success">Record has been updated successfully.</div>');
		redirect(base_url('/articlecolor'));
	}

	public function delete($id)
	{
		$this->crud->delete('article_color', $cid);
		$this->session->set_flashdata('message', '<div class="alert alert-success">Record has been deleted successfully.</div>');
		redirect(base_url('/articlecolor'));
	}
}