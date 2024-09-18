<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *  Inward Controller
 */
class Inward extends CI_Controller
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

		$data['data'] = $this->crud->get_records('outter_box_inward');
		// echo "<pre>";
		// print_r($data);
		// die();
		$this->load->view('inward/list', $data);
	}

}