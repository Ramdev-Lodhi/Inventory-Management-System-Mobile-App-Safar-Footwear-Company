<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
/**
 *  Article Controller
 */
class Supplier extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('uid'))
			redirect('signin');
		$this->load->model('crud');
		$this->load->library('my_email');
	}
	public function index()
	{
		$data['supplier_details1'] = $this->crud->get_records('supplier_detail1');
		$data['supplier_details2'] = $this->crud->get_records('supplier_detail2');
		// $data['supplier_details'] = array_merge($supplier_details1, $supplier_details2);
		$data['category'] = $this->crud->get_records('category');
		$data['raw_material1'] = $this->crud->get_records('raw_material1');
		$data['raw_material2'] = $this->crud->get_records('raw_material2');
		// echo "<pre>";
		// print_r($data['supplier_details']); die();
		$this->load->view('supplier/list', $data);
	}

	public function store()
	{
		// print_r($_POST); die();
		$supplier_type = $this->input->post('supplier');
		$data['rawmaterial_id'] = $this->input->post('raw_material');
		$data['category_id'] = $this->input->post('category');
		$data['name'] = $this->input->post('name');
		$data['address'] = $this->input->post('address');
		$data['city'] = $this->input->post('city');
		$data['mobile_no'] = $this->input->post('mobile_no');
		$data['email'] = $this->input->post('email');
		$data['supplier'] = $this->input->post('supplier');

		$message='Dear ' .$data['name'].'
			<p>We are delighted to inform you that you have been successfully added to the Safar Footwear Portal!</p>

			<p>Welcome aboard, and thank you for being a valued partner in the Safar Footwear journey!</p>

			<h4>Best regards,</h4>
			<h4>Ranjan Bagga</h4>
			<h4>Safar Footwear</h4>';
			$sub="Welcome to Safar Footwear Supplier Portal!";
			$mail=$this->my_email->send_mail($data['email'],$sub,$message);
		if ($mail) {
			echo 'Email sent successfully.';
		} else {
			// show_error($this->email->print_debugger());
		}
		/**Email End */
		if ($supplier_type == 'first') {
			$this->crud->insert('supplier_detail1', $data);
		} else {
			$this->crud->insert('supplier_detail2', $data);

		}
		$this->session->set_flashdata('message', '<div class="alert alert-success text-uppercase text-center mx-auto" style="width: 40%;">Record has been saved successfully.</div>');
		redirect(base_url('/supplier'));

	}
	public function edit1($id)
	{
		$data['supplier_detail1'] = $this->crud->find_record_by_id('supplier_detail1', $id);
			echo json_encode($data['supplier_detail1']);

	}
	public function edit2($id)
	{
		$data['supplier_detail2'] = $this->crud->find_record_by_id('supplier_detail2', $id);
			echo json_encode($data['supplier_detail2']);

	}
	public function update($id)
	{

		// print_r($_POST); die();
		$supplier_type = $this->input->post('supplier_edit');
		$data['rawmaterial_id'] = $this->input->post('raw_material');
		$data['category_id'] = $this->input->post('category');
		$data['name'] = $this->input->post('name');
		$data['address'] = $this->input->post('address');
		$data['city'] = $this->input->post('city');
		$data['mobile_no'] = $this->input->post('mobile_no');
		$data['email'] = $this->input->post('email');
		$data['supplier'] = $this->input->post('supplier_edit');

		// if ($this->send_email($data['email'], $data['name'])) {
		// 	echo 'Email sent successfully.';
		// } else {
		// 	// show_error($this->email->print_debugger());
		// }
		// /**Email End */
		$table = ($supplier_type == 'first') ? 'supplier_detail1' : 'supplier_detail2';
		$this->crud->update($table, $data, $id);
		// if (!$check) {
		// 	$this->crud->insert($table, $data);
		// }



		$this->session->set_flashdata('message', '<div class="alert alert-info text-uppercase text-center mx-auto" style="width: 40%;">Record has been updated successfully.</div>');
		redirect(base_url('/supplier'));
	}
	public function delete($id, $supplier_type)
	{
		// print_r($id);die();
		$table = ($supplier_type == 'first') ? 'supplier_detail1' : 'supplier_detail2';
		$this->crud->delete($table, $id);
		$this->session->set_flashdata('message', '<div class="alert alert-danger text-uppercase text-center mx-auto" style="width: 40%;">Record has been deleted successfully.</div>');
		redirect(base_url('/supplier'));
	}
}