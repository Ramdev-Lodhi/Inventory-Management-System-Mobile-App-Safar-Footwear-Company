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
		if (!$this->session->userdata('uid'))
			redirect('signin');
		$this->load->model('crud');
		$this->load->model('LabelM');
	}

	public function index()
	{

		$data['article'] = $this->crud->get_records_for_select('article','name');
		$data['data'] = $this->crud->get_records('outter_box_inward');
		// echo "<pre>";
		// print_r($data);
		// die();
		$this->load->view('inward/list', $data);
	}
	public function store()
	{
		
		$article = $this->input->post('article');
		$temp = explode('~', $article);
		$data['a_id'] = $temp[0];
		$data['quality'] = $this->input->post('quality');
		$data['a_name'] = $temp[1];
		$color = $this->input->post('color');
		$temp = explode('~', $color);
		$data['a_color_id'] = $temp[0];
		$data['a_color'] = $temp[1];
		$data['size'] = $this->input->post('size');
		$data['no_of_pairs'] = $this->input->post('no_of_pairs');
		$data['godown_id']=$this->input->post('godown_id');
		$data['status']=$this->input->post('status');
		$label_id=$this->input->post('label_id')	;
		$label_type = $this->input->post('label_type');
		$data['qr_id'] = date('d-m-Y') . '-' . $label_id. '~' . $data['a_id'] . '~' . $data['a_name'] . '~' . $data['size'] . '~' . $data['a_color_id'] . '~' . $data['a_color'] . '~' .$data['no_of_pairs'] . '~' . $data['quality'] . '~' . $label_type;
		
		// 	echo "<pre>";
		// print_r($data);
		// die();
			$this->crud->insert('outter_box_inward', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success text-uppercase text-center mx-auto" style="width: 40%;">Record has been added successfully.</div>');
		
		redirect(base_url('/inward'));
	}
	public function edit($id){
		// $data['article'] = $this->crud->get_records('article');
        $data['da'] = $this->crud->find_record_by_id('outter_box_inward', $id);
	
        echo json_encode($data);
	}
	public function update($id)
    {
        // print_r($id);
        // print_r($_POST); die();
		$article = $this->input->post('article');
		$temp = explode('~', $article);
		$data['a_id'] = $temp[0];
		$data['quality'] = $this->input->post('quality');
		$data['a_name'] = $temp[1];
		$color = $this->input->post('color');
		$temp = explode('~', $color);
		$data['a_color_id'] = $temp[0];
		$data['a_color'] = $temp[1];
		$data['size'] = $this->input->post('size');
		$data['no_of_pairs'] = $this->input->post('no_of_pairs');
		if($data['quality']=='first'){
			$data['godown_id']=$this->input->post('godown_id');
			$data['status']=$this->input->post('status');
			$label_id=$this->input->post('label_id')	;
			
		}else{
			
			$data['godown_id']=$this->input->post('godown_id_b');
			$data['status']=$this->input->post('status_b');
			$label_id=$this->input->post('label_id_b')	;
		}
		$label_type = $this->input->post('label_type');
		$data['qr_id'] = date('d-m-Y') . '-' . $label_id. '~' . $data['a_id'] . '~' . $data['a_name'] . '~' . $data['size'] . '~' . $data['a_color_id'] . '~' . $data['a_color'] . '~' .$data['no_of_pairs'] . '~' . $data['quality'] . '~' . $label_type;

        $this->crud->update('outter_box_inward', $data, $id);
        $this->session->set_flashdata('message', '
        <div class="alert alert-info text-uppercase text-center mx-auto" style="width: 40%;">
            Record has been updated successfully.
        </div>
    ');
        redirect(base_url('/inward'));
    }

	public function delete($id)
    {
        $this->crud->delete('outter_box_inward', $id);
        $this->session->set_flashdata('message', '<div class="alert alert-danger text-uppercase text-center mx-auto" style="width: 40%;">Record has been deleted successfully.</div>');
        redirect(base_url('/inward'));
    }


    public function get_size_by_articleId($article_id)
    {

        $size = $this->LabelM->get_size_by_articleId($article_id);
        $size_options = "";
        foreach ($size as $s) {
            $size_options = $size_options . '<option value="' . $s['size'] . '">' . $s['size'] . '</option>';
        }

        echo '<select name="size" style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black;" id="size">
		' . $size_options . '</select>';
    }
    public function get_size_by_edit_articleId($article_id, $si)
    {
        $size = $this->LabelM->get_size_by_articleId($article_id);
        $size_options = "";
        foreach ($size as $s) {
            $selected = ($s['size'] == $si) ? 'selected' : ''; // Check if size matches $si
            $size_options .= '<option value="' . $s['size'] . '" ' . $selected . '>' . $s['size'] . '</option>';
        }

        echo '<select name="size" style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black;" id="size">
        ' . $size_options . '</select>';
    }
    public function get_color_by_articleId($article_id)
    {
        $color = $this->LabelM->get_color_by_articleId($article_id);
        $color_options = "";
        foreach ($color as $s) {
            $color_options = $color_options . '<option value="' . $s['id'] . '~' . $s['color'] . '">' . $s['color'] . '</option>';
        }
        echo '<select name="color" style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black;" id="color">
		' . $color_options . '</select>';
    }
    public function get_color_by_edit_articleId($article_id, $co_id)
    {

        $color = $this->LabelM->get_color_by_articleId($article_id);

        $color_options = "";

        foreach ($color as $s) {
            $selected = ($s['id'] == $co_id) ? 'selected' : ''; // Check if id matches $color
            $color_options .= '<option value="' . $s['id'] . '~' . $s['color'] . '" ' . $selected . '>' . $s['color'] . '</option>';
        }
        echo '<select name="color" style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black;" id="color">
    ' . $color_options . '</select>';
    }

    public function get_no_of_pairs_by_articleId($article_id)
    {
        $no_of_pairs = $this->LabelM->get_no_of_pairs_by_articleId($article_id);
        $no_of_pairs_options = "";
        foreach ($no_of_pairs as $s) {
            if ($s['no_of_pairs_box'] != 0) {
                $no_of_pairs_options = $no_of_pairs_options . '<option value="' . $s['no_of_pairs_box'] . '">' . $s['no_of_pairs_box'] . '</option>';
            }
            if ($s['no_of_pairs_loose'] != 0) {
                $no_of_pairs_options = $no_of_pairs_options . '<option value="' . $s['no_of_pairs_loose'] . '">' . $s['no_of_pairs_loose'] . '</option>';
            }

        }
        echo '<select name="no_of_pairs" style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black;" id="color">
		' . $no_of_pairs_options . '</select>';
    }

}