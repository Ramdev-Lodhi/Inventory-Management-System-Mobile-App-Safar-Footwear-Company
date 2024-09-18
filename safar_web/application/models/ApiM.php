<?php

/**
 * Stock Model
 */
class ApiM extends CI_Model
{ 
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    public function login($email,$pass){
        $sql = "SELECT * from tblusers where Email = '$email' and Password = '$pass'";
        $query = $this->db->query($sql);
        return $query->result_array();
    } 
	public function get_inwardId_by_qrId($qr_id)
	{
        $sql = "SELECT id
        FROM outter_box_inward
       WHERE qr_id = '$qr_id'";
		$query = $this->db->query($sql);
        return $query->result_array();
	}

    public function get_updated_records(){
        $sql = "SELECT obx.id as id, article.id as article_id, article_color.id as color_id, obx.size, obx.no_of_pairs, obx.godown_id FROM outter_box_inward as obx, article, article_color WHERE obx.status='pending' and article.name = obx.a_name and article.id = article_color.id and article_color.color = obx.a_color";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function update_status($id){
        $sql = "UPDATE `outter_box_inward` SET `status`='success' where `id` = $id ";
        $query = $this->db->query($sql);
        return;
    }

    public function get_package_size($size){
        $sql = "SELECT * FROM package_size WHERE `size` = '$size'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_size_id_by_size($size,$article_id,$color_id){
        $sql = "SELECT id FROM article_size WHERE `article_id` = '$article_id' and `article_color_id`=$color_id and  `size` in ($size )";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_stock_detail($size_id){
        $sql = "SELECT * FROM stock WHERE `size_id`= $size_id";
        $query = $this->db->query($sql);
        return $query->result_array(); 
    }

    public function get_colors(){
        $sql = "SELECT distinct color FROM article_color";
        $query = $this->db->query($sql);
        return $query->result(); 
    }

    public function update_records($size_id, $godown_id,$no_of_pairs, $change_by){
        if($godown_id == 1){
            $sql = "UPDATE `stock` SET `pairs_in_g1`=`pairs_in_g1`+$no_of_pairs where `size_id` = $size_id ";
        }else{
            $sql = "UPDATE `stock` SET `pairs_in_g2`=$no_of_pairs where `size_id` = $size_id ";
        }
        
        $query = $this->db->query($sql);
        return;
    }

    public function update_jobsheet_success($job_id, $dept_id, $no_of_pairs, $weight, $damage,$status){
        
        $sql = "UPDATE `job_status` SET `pairs_qty_dispatched`=$no_of_pairs, `pairs_damage` = $damage,`sack_weight_dispatched` = $weight,`status`='$status' where `jobsheet_id` = $job_id and `dept_id` =$dept_id ";
        // print_r($sql);die();
        $query = $this->db->query($sql);
        return;
    }
    public function update_jobsheet($job_id, $dept_id, $no_of_pairs, $weight, $damage,$status,$datedispatched){
        
        $sql = "UPDATE `job_status` SET `pairs_qty_dispatched`=$no_of_pairs, `pairs_damage` = $damage,`sack_weight_dispatched` = $weight,`status`='$status', `dept_dispatched_date`='$datedispatched' where `jobsheet_id` = $job_id and `dept_id` =$dept_id ";
        // print_r($sql);die();
        $query = $this->db->query($sql);
        return;
    }

    public function insert_records($size_id, $godown_id,$no_of_pairs, $change_by){
    
        if($godown_id == 1){
            $sql = "INSERT INTO `stock` (size_id,pairs_in_g1,pairs_in_g2,change_by) VALUES ($size_id, $no_of_pairs, 0, '$change_by'";
        }else{
            $sql = "INSERT INTO `stock` (size_id,pairs_in_g1,pairs_in_g2,change_by) VALUES ($size_id, 0, $no_of_pairs, '$change_by')";
        }
        // print_r($sql);die();
        $query = $this->db->query($sql);
        return;
    }

    public function check_inwards($qr_id){
        $sql = "SELECT id FROM outter_box_inward WHERE `qr_id`= '$qr_id'";
        $query = $this->db->query($sql);
        return $query->result_array(); 
    }
    public function check_outwards($inward_id){
        $sql = "SELECT id FROM outter_box_outward WHERE `inward_id`= $inward_id";
        $query = $this->db->query($sql);
        return $query->result_array(); 
    }


    public function get_jobsheet_status($job_id){
        $sql = "SELECT * FROM job_status WHERE `jobsheet_id`= $job_id AND `status`='success' ";
        $query = $this->db->query($sql);
        return $query->result_array(); 
    }

    public function check_jobsheet($job_id, $dept_id){
        $sql = "SELECT * FROM job_status WHERE `jobsheet_id`= $job_id and `dept_id` = $dept_id";
        $query = $this->db->query($sql);
        return $query->result_array(); 
    }
    public function get_godown_stock_articles_first()
    {
        $sql = "SELECT distinct a_id, a_name,quality FROM outter_box_inward WHERE id NOT IN (SELECT inward_id FROM outter_box_outward) and quality='first' order by a_id";
        // print_r($sql);
        // die();
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function get_godown_stock_articles_second()
    {
        $sql = "SELECT distinct a_id, a_name,quality FROM outter_box_inward WHERE id NOT IN (SELECT inward_id FROM outter_box_outward) and quality='SECOND'order by a_id";
        // print_r($sql);
        // die();
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function get_stock_category($a_id)
    {
        $sql = "SELECT distinct article.category, category.name FROM article,category where  category.id=article.category and article.id = $a_id order by category.id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function get_jobsheet()
    {
        $sql= "SELECT article_id , payment_status,status from job_sheet ";
        return $this->db->query($sql)->result_array();
    } 


}