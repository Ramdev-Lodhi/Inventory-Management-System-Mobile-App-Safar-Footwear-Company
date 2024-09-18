<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ReaderM extends CI_Model{
public function index(){
    
    // $result = $this->db->insert($table, $data);
    // return $result;
}

public function insert($table, $data)
{
    $result = $this->db->insert($table, $data);
    return $result;
}
public function get_records(){
    $result ="SELECT id,qrcode,timestamp FROM production  GROUP BY 
                qrcode";

    $query = $this->db->query($result);
    return $query->result_array(); 
}
public function get_status_details($qrcode){
    $result ="SELECT article_name,color,size,barcode FROM production Where qrcode='$qrcode'";
    $query = $this->db->query($result);
    // print_r($result);
    // die();
    return $query->result_array(); 
}

public function get_record_group_by(){
    $result ="  SELECT 
                qrcode,
                timestamp,
                CONCAT(
                    '[',
                    GROUP_CONCAT(
                        CONCAT(
                            '{\"barcode\":\"', barcode, '\", \"article_name\":\"', article_name, '\", \"color\":\"', color, '\", \"size\":', size, '}'
                        )
                    ),
                    ']'
                ) AS barcodes
            FROM 
                production
            GROUP BY 
                qrcode";

    $query = $this->db->query($result);
    $rows = $query->result_array();


    foreach ($rows as &$row) {
        $row['barcodes'] = json_decode($row['barcodes'], true);
    }
    return $rows; 
}
}