<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

class Rawmaterial extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('uid'))
			redirect('signin');
		$this->load->model('crud');
		$this->load->model('RawmaterialM');
		$this->load->library('my_email');

	}
	public function index()
	{

		$data['data'] = $this->crud->get_records('raw_material1');

		// echo "<pre>";print_r($data); die();

		$this->load->view('rawmaterial/list', $data);
	}
	public function store()
	{

		$data['name'] = $this->input->post('name');
		$data['quantity'] = $this->input->post('quantity');
		$data['threshold'] = $this->input->post('threshold');
		$data['unit'] = $this->input->post('unit');
		$this->crud->insert('raw_material1', $data);
		$this->session->set_flashdata('message', '<div class="alert alert-success text-uppercase text-center mx-auto" style="width: 40%;">Record has been added successfully.</div>');

		redirect(base_url('/rawmaterial'));
	}
	public function edit($id)
	{
		$data['data'] = $this->crud->find_record_by_id('raw_material1', $id);
		// Return data as JSON
		echo json_encode($data['data']);
	}
	public function update($id)
	{

		$data['name'] = $this->input->post('name');
		$data['quantity'] = $this->input->post('quantity');
		$data['threshold'] = $this->input->post('threshold');
		$data['unit'] = $this->input->post('unit');

		$this->crud->update('raw_material1', $data, $id);


		$this->session->set_flashdata('message', '<div class="alert alert-info text-uppercase text-center mx-auto" style="width: 40%;">Record has been updated successfully.</div>');
		redirect(base_url('/rawmaterial'));
	}
	public function delete($id)
	{
		$this->crud->delete('raw_material1', $id);
		$this->session->set_flashdata('message', '<div class="alert alert-danger text-uppercase text-center mx-auto" style="width: 40%;">Record has been deleted successfully.</div>');
		redirect(base_url('/rawmaterial'));
	}

	/**Raw Material2 Start */

	public function raw_material2()
	{

		$data['data'] = $this->crud->get_records('raw_material2');
		$data['category'] = $this->crud->get_records('category');
		// echo "<pre>";print_r($data); die();
		$this->load->view('raw_material2/list', $data);
	}
	public function raw_material2_store()
	{
		// echo "<pre>";print_r($_FILES['product-image']); die();
		$data['name'] = $this->input->post('name');
		$data['sub_name'] = $this->input->post('sub_name');
		$data['category'] = $this->input->post('category');
		$data['color'] = $this->input->post('color');
		$data['design'] = $this->input->post('design');
		$data['size'] = $this->input->post('size');
		$data['thickness'] = $this->input->post('thickness');
		$data['quantity'] = $this->input->post('quantity');
		$data['threshold'] = $this->input->post('threshold');
		$data['unit'] = $this->input->post('unit');
		$this->crud->insert('raw_material2', $data);
		$raw_id = $this->db->insert_id();
		if (!empty($_FILES['product-image'])) {
			$i = 0;
			foreach ($_FILES['product-image']['tmp_name'] as $file_tmp) {

				if (!empty($file_tmp)) {
					$file_name = "/uploads/Product_Images/" . $raw_id . '-' . $_FILES['product-image']['name'][$i];
					$location = pathinfo(pathinfo(__DIR__, PATHINFO_DIRNAME), PATHINFO_DIRNAME);
					$file_location = $location . "/" . $file_name;

					if (!is_dir('uploads/Product_Images')) {
						mkdir("uploads/Product_Images", 0777, true);
					}

					if (move_uploaded_file($file_tmp, $file_location)) {
						chmod($file_location, 0777);
						$this->RawmaterialM->insert_product_image($raw_id, $file_name);
					}
				}
				$i++;
			}
		}
		$this->session->set_flashdata('message', '<div class="alert alert-success text-uppercase text-center mx-auto" style="width: 40%;">Record has been added successfully.</div>');

		redirect(base_url('/rawmaterial/raw_material2'));
	}
	public function raw_material2_edit($id)
	{
		$data['data'] = $this->crud->find_record_by_id('raw_material2', $id);
		// Return data as JSON
		echo json_encode($data['data']);
	}
	public function raw_material2_update($id)
	{

		$data['name'] = $this->input->post('name');
		$data['sub_name'] = $this->input->post('sub_name');
		$data['category'] = $this->input->post('category');
		$data['color'] = $this->input->post('color');
		$data['design'] = $this->input->post('design');
		$data['size'] = $this->input->post('size');
		$data['thickness'] = $this->input->post('thickness');
		$data['quantity'] = $this->input->post('quantity');
		$data['threshold'] = $this->input->post('threshold');
		$data['unit'] = $this->input->post('unit');

		$this->crud->update('raw_material2', $data, $id);
		if (!empty($_FILES['product-image'])) {
			$i = 0;
			foreach ($_FILES['product-image']['tmp_name'] as $file_tmp) {

				if (!empty($file_tmp)) {
					$file_name = "/uploads/Product_Images/" . $id . '-' . $_FILES['product-image']['name'][$i];
					// print_r($file_tmp);
					// die();
					$location = pathinfo(pathinfo(__DIR__, PATHINFO_DIRNAME), PATHINFO_DIRNAME);
					$file_location = $location . "/" . $file_name;

					if (!is_dir('uploads/Product_Images')) {
						mkdir("uploads/Product_Images", 0777, true);
					}

					if (move_uploaded_file($file_tmp, $file_location)) {
						chmod($file_location, 0777);
						$this->RawmaterialM->insert_product_image($id, $file_name);
					}
				}
				$i++;
			}
		}

		$this->session->set_flashdata('message', '<div class="alert alert-info text-uppercase text-center mx-auto" style="width: 40%;">Record has been updated successfully.</div>');
		redirect(base_url('/rawmaterial/raw_material2'));
	}
	public function raw_material2_delete($id)
	{
		$this->crud->delete('raw_material2', $id);
		$this->session->set_flashdata('message', '<div class="alert alert-danger text-uppercase text-center mx-auto" style="width: 40%;">Record has been deleted successfully.</div>');
		redirect(base_url('/rawmaterial/raw_material2'));
	}
	/**Raw Material2 End */
	/**Raw Material Required Per Article Start */
	public function material_required()
	{
		$data['article'] = $this->crud->get_records_for_select('article', 'name');
		$data['category'] = $this->crud->get_records_for_select('category','name');
		$data['data'] = $this->crud->get_records('material_required');
		$this->load->view('material_required/list', $data);
	}

	public function get_color_by_articleId($article_id)
	{
		$color = $this->RawmaterialM->get_color_by_articleId($article_id);
		$color_options = "";
		foreach ($color as $s) {
			$color_options = $color_options . '<option value="' . $s['id'] . '~' . $s['color'] . '">' . $s['color'] . '</option>';
		}
		echo '<select name="color" style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black;" id="color">
		' . $color_options . '</select>';
	}
	public function get_color_by_edit_articleId($article_id, $co_id)
	{

		$color = $this->RawmaterialM->get_color_by_articleId($article_id);

		$color_options = "";

		foreach ($color as $s) {
			$selected = ($s['id'] == $co_id) ? 'selected' : ''; // Check if id matches $color
			$color_options .= '<option value="' . $s['id'] . '~' . $s['color'] . '" ' . $selected . '>' . $s['color'] . '</option>';
		}
		echo '<select name="color" style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black;" id="color">
    ' . $color_options . '</select>';
	}
	public function material_required_store()
	{
		$article = $this->input->post('article');
		$temp = explode('~', $article);
		$data['a_id'] = $temp[0];
		$data['a_name'] = $temp[1];
		$color = $this->input->post('color');
		$temp = explode('~', $color);
		$data['a_color_id'] = $temp[0];
		$data['color'] = $temp[1];

		$data['polyurethane'] = $this->input->post('Polyurethane');
		$data['isocyanates'] = $this->input->post('Isocyanates');
		$data['catalysts'] = $this->input->post('Catalysts');
		$data['rising_chemical'] = $this->input->post('rising_chemical');
		$data['skin_chemical'] = $this->input->post('skin_chemical');
		$data['releasing_agent'] = $this->input->post('releasing_agent');
		$data['mcl'] = $this->input->post('MCL');
		$data['elfi_glue'] = $this->input->post('ELFI_GLUE');
		$data['pvc_bags'] = $this->input->post('PVC_BAGS');
		$data['lifter'] = $this->input->post('LIFTER');
		$data['butter_paper'] = $this->input->post('BUTTER_PAPER');
		$data['ld_bags'] = $this->input->post('LD_BAGS');
		$data['outter_label'] = $this->input->post('OUTTER_LABEL');
		$data['inner_label'] = $this->input->post('INNER_LABEL');
		$data['rexine'] = $this->input->post('REXINE');
		$this->crud->insert('material_required', $data);
		$this->session->set_flashdata('message', '<div class="alert alert-success text-uppercase text-center mx-auto" style="width: 40%;">Record has been added successfully.</div>');

		redirect(base_url('/rawmaterial/material_required'));
	}
	public function material_required_edit($id)
	{
		$data['data'] = $this->crud->find_record_by_id('material_required', $id);
		// Return data as JSON
		echo json_encode($data['data']);
	}
	public function material_required_update($id)
	{
		$article = $this->input->post('article');
		$temp = explode('~', $article);
		$data['a_id'] = $temp[0];
		$data['a_name'] = $temp[1];
		$color = $this->input->post('color');
		$temp = explode('~', $color);
		$data['a_color_id'] = $temp[0];
		$data['color'] = $temp[1];

		$data['polyurethane'] = $this->input->post('Polyurethane');
		$data['isocyanates'] = $this->input->post('Isocyanates');
		$data['catalysts'] = $this->input->post('Catalysts');
		$data['rising_chemical'] = $this->input->post('rising_chemical');
		$data['skin_chemical'] = $this->input->post('skin_chemical');
		$data['releasing_agent'] = $this->input->post('releasing_agent');
		$data['mcl'] = $this->input->post('MCL');
		$data['elfi_glue'] = $this->input->post('ELFI_GLUE');
		$data['pvc_bags'] = $this->input->post('PVC_BAGS');
		$data['lifter'] = $this->input->post('LIFTER');
		$data['butter_paper'] = $this->input->post('BUTTER_PAPER');
		$data['ld_bags'] = $this->input->post('LD_BAGS');
		$data['outter_label'] = $this->input->post('OUTTER_LABEL');
		$data['inner_label'] = $this->input->post('INNER_LABEL');
		$data['rexine'] = $this->input->post('REXINE');
		$this->crud->update('material_required', $data, $id);
		$this->session->set_flashdata('message', '<div class="alert alert-success text-uppercase text-center mx-auto" style="width: 40%;">Record has been added successfully.</div>');

		redirect(base_url('/rawmaterial/material_required'));
	}
	public function material_required_delete($id)
	{
		$this->crud->delete('material_required', $id);
		$this->session->set_flashdata('message', '<div class="alert alert-danger text-uppercase text-center mx-auto" style="width: 40%;">Record has been deleted successfully.</div>');
		redirect(base_url('/rawmaterial/material_required'));
	}
	/**Raw Material Required Per Article End */

	public function less_rawmaterial()
	{
		$data['less_rawmaterial1'] = $this->RawmaterialM->get_less_rawmaterial1();
		$data['less_rawmaterial2'] = $this->RawmaterialM->get_less_rawmaterial2();
		$data['supplier1'] = $this->crud->get_records('supplier_detail1');
		$data['supplier2'] = $this->crud->get_records('supplier_detail2');
		// echo"<pre>";
		// print_r($data);
		// die();
		$this->load->view('rawmaterial_details/view', $data);
	}
	public function send_email()
	{
		$sub='Welcome to Safar Footwear Supplier Portal!';
		$message='Dear
		<p>We are delighted to inform you that you have been successfully added to the Safar Footwear Portal!</p>
		<p>Welcome aboard, and thank you for being a valued partner in the Safar Footwear journey!</p>
		<h4>Best regards,</h4>
		<h4>Ranjan Bagga</h4>
		<h4>Safar Footwear</h4>';
		foreach ($_POST['suppliers'] as $sup) {
			$this->my_email->send_mail($sup,$sub,$message);
		}
		$this->session->set_flashdata('message', '<div class="alert alert-success text-uppercase text-center mx-auto" style="width: 40%;">Email Sent  successfully.</div>');
		redirect(base_url('rawmaterial/less_rawmaterial'));
	}
}