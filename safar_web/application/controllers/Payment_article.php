<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *  Article Controller
 */
class Payment_article extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('uid'))
            redirect('signin');
        $this->load->model('crud');
        $this->load->model('JobsheetM');


    }
    public function index()
    {

        $data['data'] = $this->crud->get_records('payment_article');
        $data['contractor'] = $this->crud->get_records('contractor_details');
        $data['article'] = $this->crud->get_records_for_select('article','name');
        $data['category'] = $this->crud->get_records_for_select('category','name');
        $data['color'] = $this->crud->get_records('color');
        $data['dept'] = $this->crud->get_records('department');
        // echo "<pre>";print_r($data['data']); die();
        $this->load->view('payment_article/list', $data);
    }
    public function get_size_by_articleId($article_id)
    {

        $size = $this->JobsheetM->get_size_by_articleId($article_id);
        $size_options = "";
        foreach ($size as $s) {
            $size_options = $size_options . '<option value="' . $s['size'] . '">' . $s['size'] . '</option>';
        }

        echo '<select name="size" style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black;" id="size">
		' . $size_options . '</select>';
    }
    public function get_color_by_articleId($article_id)
    {
        $color = $this->JobsheetM->get_color_by_articleId($article_id);
        $color_options = "";
        foreach ($color as $s) {
            $color_options = $color_options . '<option value="' . $s['id'] . '~' . $s['color'] . '">' . $s['color'] . '</option>';
        }
        echo '<select name="color" style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black;" id="color">
		' . $color_options . '</select>';
    }
    public function store()
    {
        $article = $this->input->post('article');
        $temp = explode('~', $article);
        $data['a_id'] = $temp[0];
        $data['a_name'] = $temp[1];
        $contractor = $this->input->post('contractor');
        $temp = explode('~', $contractor); 
        $data['contractor_name'] = $temp[0];
        $color = $this->input->post('color');
        $temp = explode('~', $color);
        $data['a_color'] = $temp[0];
        $data['size'] = $this->input->post('size');
        $data['Store'] = $this->input->post('store');
        $data['Cutting'] = $this->input->post('cutting');
        $data['Printing'] = $this->input->post('printing');
        $data['Embossing'] = $this->input->post('embossing');
        $data['Stiching'] = $this->input->post('stiching');
        $data['Pioring'] = $this->input->post('pioring');
        $data['Production'] = $this->input->post('production');
        $data['Trimming'] = $this->input->post('trimming');
        $data['Sorting'] = $this->input->post('sorting');
        $data['Packazing'] = $this->input->post('packazing');

        $this->crud->insert('payment_article', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success text-uppercase text-center mx-auto" style="width: 40%;">Record has been added successfully.</div>');
        
        redirect(base_url('/payment_article'));
    }
    public function edit($id)
    {
        $data['data'] = $this->crud->find_record_by_id('payment_article', $id);
        $data['category'] = $this->crud->get_records_for_select('category','name');
        // Return data as JSON
        echo json_encode($data['data']);
    }
    public function update($id)
    {

        $article = $this->input->post('article');
        $temp = explode('~', $article);
        $data['a_id'] = $temp[0];
        $data['a_name'] = $temp[1];
        $contractor = $this->input->post('contractor');
        $temp = explode('~', $contractor); 
        $data['contractor_name'] = $temp[0];
        $color = $this->input->post('color');
        $temp = explode('~', $color);
        $data['a_color'] = $temp[0];
        $data['size'] = $this->input->post('size');
        $data['Store'] = $this->input->post('store');
        $data['Cutting'] = $this->input->post('cutting');
        $data['Printing'] = $this->input->post('printing');
        $data['Embossing'] = $this->input->post('embossing');
        $data['Stiching'] = $this->input->post('stiching');
        $data['Pioring'] = $this->input->post('pioring');
        $data['Production'] = $this->input->post('production');
        $data['Trimming'] = $this->input->post('trimming');
        $data['Sorting'] = $this->input->post('sorting');
        $data['Packazing'] = $this->input->post('packazing');
        $this->crud->update('payment_article', $data, $id);


        $this->session->set_flashdata('message', '<div class="alert alert-info text-uppercase text-center mx-auto" style="width: 40%;">Record has been updated successfully.</div>');
        redirect(base_url('/payment_article'));
    }
    public function delete($id)
    {
        $this->crud->delete('payment_article', $id);
        $this->session->set_flashdata('message', '<div class="alert alert-danger text-uppercase text-center mx-auto" style="width: 40%;">Record has been deleted successfully.</div>');
        redirect(base_url('/payment_article'));
    }
    public function get_color_by_edit_articleId($article_id, $co_id)
    {
        $color = $this->JobsheetM->get_color_by_articleId($article_id);
        $color_options = "";

        foreach ($color as $s) {
            $selected = ($s['id'] == $co_id) ? 'selected' : ''; // Check if id matches $color
            $color_options .= '<option value="' . $s['id'] . '~' . $s['color'] . '" ' . $selected . '>' . $s['color'] . '</option>';
        }
        echo '<select name="color" style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black;" id="color">
    ' . $color_options . '</select>';
    }
    public function get_size_by_edit_articleId($article_id, $si)
    {
        $size = $this->JobsheetM->get_size_by_articleId($article_id);
        $size_options = "";
        foreach ($size as $s) {
            $selected = ($s['size'] == $si) ? 'selected' : ''; // Check if size matches $si
            $size_options .= '<option value="' . $s['size'] . '" ' . $selected . '>' . $s['size'] . '</option>';
        }
        echo '<select name="size" style="padding:10px 10px;display:block;width:100%;border-radius:10px;color:black;" id="size">
        ' . $size_options . '</select>';
    }
   
}