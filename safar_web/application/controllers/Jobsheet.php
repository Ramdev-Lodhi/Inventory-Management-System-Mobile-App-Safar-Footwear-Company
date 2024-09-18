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
        $data['contractor'] = $this->crud->get_records_for_select('contractor_details','contractor_name');
        $data['article'] = $this->crud->get_records_for_select('article','name');
        $data['category'] = $this->crud->get_records('category');
        $data['color'] = $this->crud->get_records('color');
        // echo "<pre>";print_r($data['contractor']); die();
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
        $contractor = $this->input->post('contractor');
        $temp = explode('~', $contractor);

        $data['contractor_name'] = $temp[0];
        // print_r($data['contractor_name']);
        // die();
        // $data['name'] = $temp[1];
        $color = $this->input->post('color');
        $temp = explode('~', $color);
        $data['color_id'] = $temp[0];
        $job_type = $this->input->post('job_type');
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
        $contractor = $this->input->post('contractor');
        $temp = explode('~', $contractor);

        $data['contractor_name'] = $temp[0];
        // $data['name'] = $temp[1];
        $color = $this->input->post('color');
        $temp = explode('~', $color);
        $data['color_id'] = $temp[0];
        // $data['color'] = $temp[1];
        $job_type = $this->input->post('job_type');
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
        $data['jobsheet'] = $this->crud->find_record_by_id('job_sheet', $id);
        $data['article'] = $this->crud->find_record_by_id('article', $data['jobsheet']->article_id);
        $data['category'] = $this->crud->find_record_by_id('category',$data['article']->category);
        $data['color'] = $this->crud->find_record_by_id('color', $data['jobsheet']->color_id);
        $data['job_type'] = $this->JobsheetM->get_jobtype_dept('department', $data['jobsheet']->job_type);
        // echo "<pre>";print_r($data['category']); die();
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



            // Created by Om Aditya Jain for efficient data parsing at app side
            $qr_data = array(
                'job_id' => $data['jobsheet']->id,
                'job_type' => $data['jobsheet']->job_type,
                'article_id' => $data['jobsheet']->article_id,
                'article_name' => $data['article']->name.'('.$data['category']->name.')',
                'color_id' => $data['jobsheet']->color_id,
                'color_name' => $data['color']->color,
                'no_of_pairs' => $data['jobsheet']->no_of_pairs,
                'size' => $data['jobsheet']->size,
                'date' => $data['jobsheet']->issue_date,
                'remark' => $data['jobsheet']->remark,
                'jobs' => $data['job_type'],
            );
            $Data = json_encode($qr_data);

            // Generate QR code for the  data
            $params['data'] = $Data;
            $params['level'] = 'H';
            $params['size'] = 5;
            $timestamp = time(); // Get the current Unix timestamp
            $data['date'] = date('d-m-Y', $timestamp);
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
    public function change_jobsheet_status()
    {
        if($_POST['toggle']=="true"){
			$data  = array('status' => 1);
		}else{
			$data  = array('status' => 0);
		}
        $this->crud->update('job_sheet', $data, $_POST['id']);

    }

    public function status()
    {
        $data['data'] = $this->JobsheetM->get_sequence('job_status');
        $data['dept'] = $this->crud->get_records('department');
        // Prepare a list of all departments with default status as null
        $allDepartments = [];
        foreach ($data['dept'] as $dept) {
            $allDepartments[] = [
                'dept_name' => $dept->dept_name,
                'status' => '-'
            ];
        }
        $groupedData = [];
        foreach ($data['data'] as $item) {
            // echo "<pre>";
            // print_r($item);
            $key = $item['jobsheet_id'] . '_' . $item['job_type'];
            if (!isset($groupedData[$key])) {
                // Initialize the departments array with all departments
                $groupedData[$key] = [
                    'jobsheet_id' => $item['jobsheet_id'],
                    'job_status' => $item['job'],
                    'job_type' => $item['job_type'],
                    'departments' => $allDepartments
                ];
            }
            // Find the department in the initialized array and update its status
            foreach ($groupedData[$key]['departments'] as &$department) {
                if ($department['dept_name'] == $item['dept_name']) {
                    $department['status'] = $item['status'];
                    break;
                }
            }
        }
        
        $data['status'] = array_values($groupedData);
        // echo"<pre>";print_r($groupedData);die();
        $this->load->view('jobsheet/status/list', $data);
    }


    public function view_status($id)
    {
        $data = $this->JobsheetM->get_status_details('job_status', $id);
        $tBodyData = ''; // Initialize an empty string to store tbody data
$i=1;
        foreach ($data as $item) {
            $tBodyData .= '<tr align="center">';
            $tBodyData .= '<td>' . $i. '</td>';
            $tBodyData .= '<td>' . $item['jobsheet_id'] . '</td>';
            $tBodyData .= '<td>' . $item['job_type'] . '</td>';
            $tBodyData .= '<td>' . $item['dept_id'] . '</td>';
            $tBodyData .= '<td>' . $item['dept_name'] . '</td>';
            $tBodyData .= '<td>' . $item['dept_recieved_date'] . '</td>';
            $tBodyData .= '<td>' . $item['dept_dispatched_date'] . '</td>';
            $tBodyData .= '<td>' . $item['pairs_damage'] . '</td>';
            $tBodyData .= '<td>' . $item['pairs_qty_dispatched'] . '</td>';
            // $tBodyData .= '<td>' . $item['pairs_qty_recieved'] . '</td>';
            // $tBodyData .= '<td>' . $item['sack_weight_recieved'] . '</td>';
            $tBodyData .= '<td>' . $item['sack_weight_dispatched'] . '</td>';
            $tBodyData .= '</tr>';
            $i++;
        }

        echo $tBodyData; // Echo only the tbody data
    }
    public function payment()
    {
        $data['article'] = $this->crud->get_records('article');
        $data['data'] = $this->JobsheetM->get_success_jobsheet();
        $total = array();
        $i = 0;
        foreach ($data['data'] as $job) {
            $total[$i]['article_id'] = $job['article_id'];
            $total[$i]['payment_status'] = $job['payment_status'];
            $total[$i]['id'] = $job['id'];
            $total[$i]['contractor_name'] = $job['contractor_name'];
            $total[$i]['color_id'] = $job['color_id'];
            $total[$i]['no_of_pairs'] = $job['no_of_pairs'];
            $amount = $this->JobsheetM->get_artile_payment($job['article_id']);
            // print_r($amount);
            if(!empty($amount)){
                $sum = 0;
                foreach ($amount[0] as $key => $value) {
                    if ($key != 'a_id') {
                        $sum += $value;
                    }
                }
    
                // Store the sum in the total array
                $total[$i]['amount'] = $sum;
    
            }else{
                $amount=0;
            }
            
            $i++;
        }
        $data['total'] = $total;
        // die();
        $this->load->view('jobsheet/payment/list', $data);
    }

    public function Payment_view($id, $a_id, $contractor, $color_id)
    {
        // print_r($a_id);
        // die();
        $data['data'] = $this->crud->find_record_by_id('job_sheet', $id);
        $data['contractor'] = $this->crud->find_record_by_id('contractor_details', $contractor);
        $data['color'] = $this->crud->find_record_by_id('color', $color_id);
        $data['amount'] = $this->JobsheetM->get_artile_payment($a_id);
        echo json_encode($data);

    }
    public function cahange_payment_status($id)
    {
        if ($_POST['payment'] == 1) {
            $this->JobsheetM->change_status_1($id,$_POST['date']);
        } else {
            $this->JobsheetM->change_status_0($id);

        }
        redirect(base_url('jobsheet/payment'));
    }

}