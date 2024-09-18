<?php

/**
 * Stock Model
 */
class LabelM extends CI_Model
{ 
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	public function get_records()
	{
        $sql = "SELECT article.name,article_size.size,article_color.color,stock.pairs_in_g1,stock.pairs_in_g2
        FROM stock
        JOIN article_size ON article_size.id = stock.size_id
        JOIN article_color ON article_color.id = article_size.id
        JOIN article ON article.id = article_color.id";
		$query = $this->db->query($sql);
        return $query->result_array();
	}
    public function get_labels_by_ids($label_ids) {
        $this->db->where_in('id', $label_ids);
        $query = $this->db->get('label');
        return $query->result();
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

    public function insert_records($size_id, $godown_id,$no_of_pairs, $change_by){
        if($godown_id == 1){
            $sql = "INSERT INTO `stock` (size_id,pairs_in_g1,pairs_in_g2,change_by) VALUES ($size_id, $no_of_pairs, 0, '$change_by')";
        }else{
            $sql = "INSERT INTO `stock` (size_id,pairs_in_g1,pairs_in_g2,change_by) VALUES ($size_id, 0, $no_of_pairs, '$change_by')";
        }
        
        $query = $this->db->query($sql);
        return;
    }

     
    public function get_size_by_articleId($article_id){
        $sql = "SELECT package_size.size  FROM package_size JOIN article ON article.id = $article_id and article.category = package_size.category_id";
        $query = $this->db->query($sql);
        return $query->result_array(); 
    }

    // public function get_color_by_articleId($article_id){
    //     $sql = "SELECT article_color.color, article_color.id  FROM article_color WHERE article_color.article_id = $article_id";
    //     $query = $this->db->query($sql);
    //     return $query->result_array(); 
    // }

    public function get_color_by_articleId($article_id){
        $sql = "SELECT color.color, color.id  FROM color, category, article WHERE article.id = $article_id and article.category = category.id and category.id = color.category_id";
        $query = $this->db->query($sql);
        return $query->result_array(); 
    }

    public function get_no_of_pairs_by_articleId($article_id){
        $sql = "SELECT article.no_of_pairs_box, article.no_of_pairs_loose  FROM article WHERE article.id = $article_id and article.is_active=1";
        $query = $this->db->query($sql);
        return $query->result_array(); 
    }

    public function delete_all_labels(){
        $sql="DELETE FROM label";
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
}