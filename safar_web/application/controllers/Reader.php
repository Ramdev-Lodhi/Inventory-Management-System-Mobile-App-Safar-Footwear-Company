<?php
defined( 'BASEPATH' ) or exit( 'No direct script access allowed' );
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

class Reader extends CI_Controller
 {

    function __construct()
 {
        parent::__construct();
        if ( !$this->session->userdata( 'uid' ) )
        redirect( 'signin' );
        $this->load->model( 'crud' );
        $this->load->model( 'ReaderM' );
        $this->load->library( 'my_email' );

    }

    public function index()
 {

        // $data[ 'data' ] = $this->crud->get_records( 'raw_material1' );

        // echo '<pre>';

        $this->load->view( 'reader/list' );
    }


    public function insert_ajax() {
        try {
            // Retrieve data from POST request
            $qrCodes = $this->input->post( 'qrCodes' );
            $barcodes = $this->input->post( 'barcodes' );

            $table = 'production';
            // Replace with your actual table name
            $data = array();
            $result = false;

            foreach ( $qrCodes as $q ) {
                $data[ 'qrcode' ] = $q;
                foreach ( $barcodes as $b ) {
                    $data[ 'barcode' ] = $b;
                    $qrdata = explode( '~', $b );
                    $article_id = $qrdata[0];
                    $article_name=$this->crud->find_record_by_id('article',$article_id);
                    $data[ 'article_name' ] = $article_name->name;
                    $data[ 'color' ] = $qrdata[1];
                    $data[ 'size' ] = $qrdata[2];
                    $result = $this->ReaderM->insert( $table, $data );
                    if ( !$result ) {
                        echo 'Failed to insert data.';
                        return;
                    }
                }
            }
            // Send JSON response back to the JavaScript
            $response = array( 'status' => 'success', 'message' => 'Data inserted successfully' );
            echo json_encode( $response );
        } catch ( Exception $e ) {
            // Log the error or send an appropriate error response
            $response = array( 'status' => 'error', 'message' => $e->getMessage() );
            echo json_encode( $response );
        }
    }

 
    public function check_internet() {
        $sCheckHost = "www.google.com";
        $is_connected = (bool) @fsockopen($sCheckHost, 80, $ierrno, $errstr, 5);
        echo json_encode(['connected' => $is_connected]);
    }
     public function status(){
        
        $data[ 'data' ] = $this->ReaderM->get_records( 'production' );
        // echo"<pre>"; print_r($data); die();
        $this->load->view( 'reader/status/list',$data);
     }
     public function view_status($qr_id)
     {
        $decoded_id = urldecode($qr_id); 

        // echo"<pre>"; print_r($decoded_id); die();

         $data = $this->ReaderM->get_status_details($decoded_id);
         $tBodyData = ''; // Initialize an empty string to store tbody data
 $i=1;
         foreach ($data as $item) {
             $tBodyData .= '<tr align="center">';
             $tBodyData .= '<td>' . $i. '</td>';
             $tBodyData .= '<td>' . $item['article_name'] . '</td>';
             $tBodyData .= '<td>' . $item['color'] . '</td>';
             $tBodyData .= '<td>' . $item['size'] . '</td>';
             $tBodyData .= '<td>' . $item['barcode'] . '</td>';
             $tBodyData .= '</tr>';
             $i++;
         }
 
         echo $tBodyData; // Echo only the tbody data
     }

}