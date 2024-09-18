<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *  Article Controller
 */
class Article extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('uid'))
		redirect('signin');
		$this->load->model('crud');
		$this->load->model('ArticleM');
	}

	public function index()
	{
		$data['type'] = $this->crud->get_records('type');
		$data['category'] = $this->crud->get_records('category');
		$data['data'] = $this->crud->get_records('article');
		$this->load->view('article/list', $data);
	}
	
	
	public function create()
	{
		$data['type'] = $this->crud->get_records('type');
		$data['category'] = $this->crud->get_records('category');
		$this->load->view('article/create',$data);
	}
	
	
	public function store()
	{
		$data['name'] = $this->input->post('name');
		$data['type'] = $this->input->post('type');
		$data['category'] = $this->input->post('category');
		$data['mrp'] = $this->input->post('mrp');
		$data['package'] = $this->input->post('package');
		$data['no_of_pairs'] = $this->input->post('no_of_pairs');
		$data['is_active'] = $this->input->post('is_active');
		$this->crud->insert('article', $data);
		$article_id = $this->db->insert_id();
		if (!empty($_FILES['product-image'])) {
			$i = 0;
			foreach ($_FILES['product-image']['tmp_name'] as $file_tmp) {
				
				if (!empty($file_tmp)) {
					$file_name = "/uploads/Product_Images/" . $article_id.'-'. $_FILES['product-image']['name'][$i];
					$location = pathinfo(pathinfo(__DIR__, PATHINFO_DIRNAME), PATHINFO_DIRNAME);
					$file_location = $location . "/" . $file_name;
					
					if (!is_dir('uploads/Product_Images')) {
						mkdir("uploads/Product_Images", 0777, true);
					}
					
					if (move_uploaded_file($file_tmp, $file_location)) {
						chmod($file_location, 0777);
						$this->ArticleM->insert_product_image($article_id, $file_name);
					}
				}
				$i++;
			}
		}
		$this->session->set_flashdata('message', '<div class="alert alert-success text-uppercase text-center mx-auto" style="width: 40%;"">Record has been saved successfully.</div>');
		redirect(base_url('/article'));
	}
	
	public function edit($id)
{
    $data['update'] = $this->crud->find_record_by_id('article', $id);
    // Return data as JSON
    echo json_encode($data['update']);
}

	
	public function update($id)
	{
		$data['id'] = $this->input->post('id');
		$data['name'] = $this->input->post('name');
		$data['type'] = $this->input->post('type');
		$data['category'] = $this->input->post('category');
		$data['mrp'] = $this->input->post('mrp');
		$data['package'] = $this->input->post('package');
		$data['no_of_pairs'] = $this->input->post('no_of_pairs');
		$data['photo'] = $this->input->post('photo');
		$data['is_active'] = $this->input->post('is_active');	
		$this->crud->update('article', $data, $id);
		if (!empty($_FILES['product-image'])) {
			$i = 0;
			foreach ($_FILES['product-image']['tmp_name'] as $file_tmp) {
				
				if (!empty($file_tmp)) {
					$file_name = "/uploads/Product_Images/" . $id.'-'. $_FILES['product-image']['name'][$i];
					// print_r($file_tmp);
					// die();
					$location = pathinfo(pathinfo(__DIR__, PATHINFO_DIRNAME), PATHINFO_DIRNAME);
					$file_location = $location . "/" . $file_name;
					
					if (!is_dir('uploads/Product_Images')) {
						mkdir("uploads/Product_Images", 0777, true);
					}
					
					if (move_uploaded_file($file_tmp, $file_location)) {
						chmod($file_location, 0777);
						$this->ArticleM->insert_product_image($id, $file_name);
					}
				}
				$i++;
			}
		}
		$this->session->set_flashdata('message', '<div class="alert alert-info text-uppercase text-center mx-auto" style="width: 40%;"">Record has been updated successfully.</div>');
		redirect(base_url('/article'));
	}

	public function delete($id)
	{
		$this->crud->delete('article', $a_id);
		$this->session->set_flashdata('message', '<div class="alert alert-danger text-uppercase text-center mx-auto" style="width: 40%;"">Record has been deleted successfully.</div>');
		redirect(base_url('/article'));
	}
}