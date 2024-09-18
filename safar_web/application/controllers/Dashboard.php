<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *  Dashboard Controller
 */
class Dashboard extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('uid'))
		redirect('signin');
	}

	public function index()
	{
		$this->load->view('dashboard');
	}
}