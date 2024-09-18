<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
/**
 *  Label Controller
 */
class Label extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('uid'))
            redirect('signin');
        $this->load->model('crud');
        $this->load->model('LabelM');
        //include modal.php in views
        // $this->inc['modal'] = $this->load->view('modal', '', true);
    }

    public function index()
    {
        $data['article'] = $this->crud->get_records_for_select('article','name');
        $data['label'] = $this->crud->get_records('label');
        $data['category'] = $this->crud->get_records_for_select('category','name');
        // $data['data'] = $this->crud->find_record_by_id('label',$id);
        $this->load->view('label/list', $data);
    }

    public function download_selected_labels() {
        // Suppress deprecated notices
        error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
    
        // Clear output buffer to avoid any previous output
        ob_clean();
        ob_start();
    
        $label_ids = json_decode($this->input->post('label_ids'));
    
        if (empty($label_ids)) {
            $this->session->set_flashdata('message', 'No labels selected for download.');
            redirect('label');
        }
    
        $labels = $this->LabelM->get_labels_by_ids($label_ids);
    
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Labels');
    
        // Set header row
        $sheet->setCellValue('A1', 'Label Type');
        $sheet->setCellValue('B1', 'Quality');
        $sheet->setCellValue('C1', 'Article');
        $sheet->setCellValue('D1', 'Size');
        $sheet->setCellValue('E1', 'Color');
        $sheet->setCellValue('F1', 'No. of Pairs');
        $sheet->setCellValue('G1', 'Qr-Code');
    
        // Add data rows
        $row = 2;
        foreach ($labels as $label) {
            $sheet->setCellValue('A' . $row, $label->label_type);
            $sheet->setCellValue('B' . $row, $label->quality);
            $sheet->setCellValue('C' . $row, $label->name);
            $sheet->setCellValue('D' . $row, $label->size);
            $sheet->setCellValue('E' . $row, $label->color);
            $sheet->setCellValue('F' . $row, $label->no_of_pairs);
            $qrdata = date('d-m-Y') . '-' . $label->id . '~' . $label->article_id . '~' . $label->name . '~' . $label->size . '~' . $label->article_color_id . '~' . $label->color . '~' . $label->no_of_pairs . '~' . $label->quality . '~' . $label->label_type;
    
            $sheet->setCellValue('G' . $row, $qrdata);
            $row++;
        }
    
        // Download file
        $filename = 'Outer Label' .  '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
    
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        
        // Ensure no further output is sent after the file is generated
        ob_end_flush();
        exit;
    }
    
    public function generate_label()
    {
        $this->load->library('ciqrcode');

        $data['label'] = $this->crud->get_records('label');
        $i = 0;
        foreach ($data['label'] as $d) {
            $qrdata = date('d-m-Y') . '-' . $d->id . '~' . $d->article_id . '~' . $d->name . '~' . $d->size . '~' . $d->article_color_id . '~' . $d->color . '~' . $d->no_of_pairs . '~' . $d->quality . '~' . $d->label_type;
            $params['data'] = $qrdata;
            $params['level'] = 'H';
            $params['size'] = 5;
            $params['savename'] = FCPATH . 'uploads/qrcode/' . $qrdata . '.png';
            $this->ciqrcode->generate($params);

            $data['label'][$i]->qrcode = base_url() . 'uploads/qrcode/' . $qrdata . '.png';
            $i++;
        }
        $this->load->view('label/generate_label', $data);
    }


    public function create()
    {
        $data['article'] = $this->crud->get_records_for_select('article','name');
$data['category'] = $this->crud->get_records_for_select('category','name');
        $this->load->view('label/create', $data);
    }

    public function get_color_by_article_id($article_id)
    {
        $color = $this->LabelM->get_color_by_article_id($article_id);
    }

    public function store()
    {

        // print_r($_POST);
        // die();
        $no_of_boxes = $this->input->post('no_of_boxes');
        $article = $this->input->post('article');
        $temp = explode('~', $article);
        if (sizeof($temp) == 2 && !empty($no_of_boxes)) {
            $data['article_id'] = $temp[0];
            $data['quality'] = $this->input->post('quality');
            $data['name'] = $temp[1];
            $color = $this->input->post('color');
            $temp = explode('~', $color);
            $data['article_color_id'] = $temp[0];
            $data['color'] = $temp[1];

            // if ($data['quality'] == "first") {
            // } else {
            //     $data['color'] = $color;

            // }
            $data['label_type'] = $this->input->post('label_type');
            $data['size'] = $this->input->post('size');

            $data['no_of_pairs'] = $this->input->post('no_of_pairs');

            for ($i = 0; $i < $no_of_boxes; $i++) {
                $this->crud->insert('label', $data);
            }
            $this->session->set_flashdata('message', '<div class="alert alert-success text-uppercase text-center mx-auto" style="width: 40%;">Record has been added successfully.</div>');
        }
        redirect(base_url('/label'));
    }

    public function edit($id)
    {
        $data['article'] = $this->crud->get_records_for_select('article','name');
        $data['da'] = $this->crud->find_record_by_id('label', $id);
        echo json_encode($data);
        // $this->view('label/list', $data);
        // Return data as JSON
    }


    public function update($id)
    {
        // print_r($id);
        // print_r($_POST); die();
        $data['label_type'] = $this->input->post('label_type');
        $article = $this->input->post('article');
        $temp = explode('~', $article);
        $data['article_id'] = $temp[0];
        $data['name'] = $temp[1];
        $data['size'] = $this->input->post('size');
        $data['quality'] = $this->input->post('quality');
        $color = $this->input->post('color');
        $temp = explode('~', $color);
        $data['article_color_id'] = $temp[0];
        $data['color'] = $temp[1];
        $data['no_of_pairs'] = $this->input->post('no_of_pairs');
        $this->crud->update('label', $data, $id);
        $this->session->set_flashdata('message', '
        <div class="alert alert-info text-uppercase text-center mx-auto" style="width: 40%;">
            Record has been updated successfully.
        </div>
    ');
        redirect(base_url('/label'));
    }

    public function delete($id)
    {
        $this->crud->delete('label', $id);
        $this->session->set_flashdata('message', '<div class="alert alert-danger text-uppercase text-center mx-auto" style="width: 40%;">Record has been deleted successfully.</div>');
        redirect(base_url('/label'));
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

    public function delete_all_labels()
    {
        $this->LabelM->delete_all_labels();
        $this->session->set_flashdata('message', '<div class="alert alert-danger text-uppercase text-center mx-auto" style="width: 40%;">All Records deleted successfully.</div>');
        redirect(base_url('/label'));
    }
    public function qrcode_link($id){

        $label = $this->crud->find_record_by_id('label',$id);

        $i = 0;
 
            $qrdata = date('d-m-Y') . '-' . $label->id . '~' . $label->article_id . '~' . $label->name . '~' . $label->size . '~' . $label->article_color_id . '~' . $label->color . '~' . $label->no_of_pairs . '~' . $label->quality . '~' . $label->label_type;
         
            print_r($qrdata);
            die();
        echo json_encode($qrdata);
    }
}
