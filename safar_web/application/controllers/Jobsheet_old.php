<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *  Article Controller
 */
class Jobsheet extends CI_Controller
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

        $data['data'] = $this->crud->get_records('job_sheet');
        $data['article'] = $this->crud->get_records('article');
        $data['color'] = $this->crud->get_records('color');
        // echo "<pre>";print_r($data['data']); die();
        $this->load->view('jobsheet/list', $data);
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

        $data['article_id'] = $temp[0];
        // $data['name'] = $temp[1];
        $color = $this->input->post('color');
        $temp = explode('~', $color);
        $data['color_id'] = $temp[0];
        $job_type=$this->input->post('job_type');
        $temp = explode('~', $job_type);
        $data['job_type'] = $temp[0];
    
          // $data['color'] = $temp[1];
        $data['size'] = $this->input->post('size');

        $data['no_of_pairs'] = $this->input->post('no_of_pairs');

        $this->crud->insert('job_sheet', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success text-uppercase text-center mx-auto" style="width: 40%;">Record has been added successfully.</div>');
        
        redirect(base_url('/jobsheet'));
    }
    public function edit($id)
    {
        $data['data'] = $this->crud->find_record_by_id('job_sheet', $id);
        // Return data as JSON
        echo json_encode($data['data']);
    }
    public function update($id)
    {
       
        $article = $this->input->post('article');
        $temp = explode('~', $article);

        $data['article_id'] = $temp[0];
        // $data['name'] = $temp[1];
        $color = $this->input->post('color');
        $temp = explode('~', $color);
        $data['color_id'] = $temp[0];
        // $data['color'] = $temp[1];
        $job_type=$this->input->post('job_type');
        $temp = explode('~', $job_type);
        $data['job_type'] = $temp[0];
        $data['size'] = $this->input->post('size');

        $data['no_of_pairs'] = $this->input->post('no_of_pairs');


        $this->crud->update('job_sheet', $data, $id);


        $this->session->set_flashdata('message', '<div class="alert alert-info text-uppercase text-center mx-auto" style="width: 40%;">Record has been updated successfully.</div>');
        redirect(base_url('/jobsheet'));
    }
    public function delete($id)
    {
        $this->crud->delete('job_sheet', $id);
        $this->session->set_flashdata('message', '<div class="alert alert-danger text-uppercase text-center mx-auto" style="width: 40%;">Record has been deleted successfully.</div>');
        redirect(base_url('/jobsheet'));
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
    public function generate_jobsheet($id)
    {
        // echo "<pre>"; print_r($data['jobsheet']); die();
        $this->load->library('ciqrcode');
        $data['jobsheet'] = $this->crud->find_record_by_id('job_sheet',$id);
        $data['article'] = $this->crud->find_record_by_id('article',$data['jobsheet']->article_id);
        $data['color'] = $this->crud->find_record_by_id('color',$data['jobsheet']->color_id);
        $data['job_type'] = $this->JobsheetM->get_jobtype_dept('department',$data['jobsheet']->job_type);
        // echo "<pre>";print_r($data['job_type']); die();
        // Check if there are job sheets
        if (!empty($data['jobsheet'])) {
            // $Data = ''; // Initialize an empty string to store concatenated data
            // //  data from all job sheets
            //          $Data .= "ID: {$data['jobsheet']->id}, Job Type: {$data['jobsheet']->job_type}, Article ID: {$data['jobsheet']->article_id} - {$data['article']->name}, Color ID: {$data['jobsheet']->color_id} - {$data['color']->color}, No of Pairs: {$data['jobsheet']->no_of_pairs}, Size: {$data['jobsheet']->size}, Date: {$data['jobsheet']->issue_date}, Remark: {$data['jobsheet']->remark}\n";
            //           // Append job sequence data
            //     $Data .= "Department:\n";
            //     foreach ($data['job_type'] as $job) {
            //         $Data .= "{$job['dept_id']}-{$job['dept_name']},\n";
            //     }
            $qr_data = array(
                'job_id'=>$data['jobsheet']->id,
                'job_type'=>$data['jobsheet']->job_type,
                'article_id'=>$data['jobsheet']->article_id,
                'article_name'=>$data['article']->name,
                'color_id'=>$data['jobsheet']->color_id,
                'color_name'=>$data['color']->color,
                'no_of_pairs'=>$data['jobsheet']->no_of_pairs,
                'size'=>$data['jobsheet']->size,
                'date'=>$data['jobsheet']->issue_date,
                'remark'=>$data['jobsheet']->remark,
                'jobs'=>$data['job_type'],
            );
            $Data = json_encode($qr_data);
            // Generate QR code for the  data
            $params['data'] = $Data;
            $params['level'] = 'H';
            $params['size'] = 5;
            $timestamp = time(); // Get the current Unix timestamp
            $data['date']=date('d-m-Y',$timestamp);
            $params['savename'] = FCPATH . 'uploads/qrcode/' . $timestamp . '.png'; // Include timestamp in filename
            $this->ciqrcode->generate($params);
            $qrCodePath = base_url() . 'uploads/qrcode/' . $timestamp . '.png';
            $data['qrCodePath'] = $qrCodePath;
        }
        // Assign QR code URL to all job sheets
        $this->load->view('jobsheet/generate_jobsheet', $data);
    }
    public function delete_all_jobsheet()
    {
        $this->JobsheetM->delete_all_jobsheet();
        $this->session->set_flashdata('message', '<div class="alert alert-danger text-uppercase text-center mx-auto" style="width: 40%;">All Records deleted successfully.</div>');
        redirect(base_url('/label'));
    }
}