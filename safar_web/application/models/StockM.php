<?php

/**
 * Stock Model
 */
class StockM extends CI_Model
{ 
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	public function get_records()
	{
        $sql = "SELECT distinct article.name,article_size.size,article_color.color,stock.pairs_in_g1,stock.pairs_in_g2
        FROM stock,article_size, article_color, article where article_size.id = stock.size_id and article_color.id = article_size.article_color_id and article.id = article_size.article_id";
		$query = $this->db->query($sql);
        return $query->result_array();
	}

    public function get_updated_inward_records(){
        $sql = "SELECT DISTINCT * FROM outter_box_inward as inwards  WHERE inwards.status='pending'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    // public function get_updated_inward_records(){
    //     $sql = "SELECT inwards.id as id, article.id as article_id, article_color.id as color_id, inwards.size, inwards.no_of_pairs, inwards.godown_id FROM outter_box_inward as inwards, article, article_color WHERE inwards.status='pending' and article.name = inwards.a_name and article.id = article_color.id and article_color.color = inwards.a_color";
    //     $query = $this->db->query($sql);
    //     return $query->result_array();
    // }
    public function get_updated_outward_records(){
        $sql = "SELECT outwards.id as id, inwards.a_id, inwards.a_color_id, inwards.size, inwards.no_of_pairs, inwards.godown_id FROM outter_box_outward as outwards, outter_box_inward as inwards WHERE outwards.status='pending' and outwards.inward_id=inwards.id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    // public function get_updated_outward_records(){
    //     $sql = "SELECT outwards.id as id, article.id as article_id, article_color.id as color_id, inwards.size, inwards.no_of_pairs, inwards.godown_id FROM outter_box_outward as outwards, outter_box_inward as inwards, article, article_color WHERE outwards.status='pending' and outwards.inward_id=inwards.id and article.name = inwards.a_name and article.id = article_color.id and article_color.color = inwards.a_color";
    //     $query = $this->db->query($sql);
    //     return $query->result_array();
    // }

    public function update_inward_status($id){
        $sql = "UPDATE `outter_box_inward` SET `status`='success' where `id` = $id ";
        $query = $this->db->query($sql);
        return;
    }
    public function update_outward_status($id){
    
        $sql = "UPDATE `outter_box_outward` SET `status`='success' where `id` = $id ";
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

    public function update_inward_records($size_id, $godown_id,$no_of_pairs, $change_by){
        if($godown_id == 1){
            $sql = "UPDATE `stock` SET `pairs_in_g1`=`pairs_in_g1`+$no_of_pairs where `size_id` = $size_id ";
        }else{
            $sql = "UPDATE `stock` SET `pairs_in_g2`=`pairs_in_g2`+$no_of_pairs where `size_id` = $size_id ";
        }
        
        $query = $this->db->query($sql);
        return;
    }
    public function update_outward_records($size_id, $godown_id,$no_of_pairs, $change_by){
        if($godown_id == 1){
            $sql = "UPDATE `stock` SET `pairs_in_g1`=`pairs_in_g1`-$no_of_pairs where `size_id` = $size_id ";
        }else{
            $sql = "UPDATE `stock` SET `pairs_in_g2`=`pairs_in_g2`-$no_of_pairs where `size_id` = $size_id ";
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

    public function delete_stock_item($stock_id){
        $sql = "DELETE FROM `stock` WHERE id = $stock_id"; 
        $query = $this->db->query($sql);
        return;
    }
   

    public function get_godown_stock_articles()
	{
        $sql = "SELECT distinct a_id, a_name FROM outter_box_inward WHERE id NOT IN (SELECT inward_id FROM outter_box_outward)";
        // print_r($sql);
        // die();
		$query = $this->db->query($sql);
        return $query->result_array();
	}

    public function get_godown_stock_color($article_id)
	{
        $sql = "SELECT distinct a_color_id, a_color,quality FROM outter_box_inward where a_id = $article_id";
		$query = $this->db->query($sql);
        return $query->result_array();
	}

    public function get_godown_stock_size($article_id, $color_id,$quality)
	{
        $sql = "SELECT distinct `size` FROM outter_box_inward where a_id = $article_id and a_color_id = $color_id and  `quality`='$quality'";
		$query = $this->db->query($sql);
        return $query->result_array();
	}

    public function get_godown_stock_quantity_g1($article_id, $color_id, $size,$quality)
	{
        $sql = "SELECT count(id) as count FROM outter_box_inward where a_id = $article_id and a_color_id = $color_id and `size` = '$size' and  `quality`='$quality' and godown_id = 1 and id NOT IN (SELECT inward_id FROM outter_box_outward)";
		$query = $this->db->query($sql);
        return $query->result_array();
	}

    public function get_godown_stock_quantity_g2($article_id, $color_id, $size,$quality)
	{
        $sql = "SELECT count(id) as count FROM outter_box_inward where a_id = $article_id and a_color_id = $color_id and `size` = '$size' and  `quality`='$quality' and godown_id = 2 and id NOT IN (SELECT inward_id FROM outter_box_outward)";
		$query = $this->db->query($sql);
        return $query->result_array();
	}

    public function get_details($table,$article_id,$colorid,$size,$quality)
	{
       
            $result="SELECT id,qr_id  FROM $table WHERE `a_id`=$article_id and `a_color_id` =$colorid and `size` ='$size' and `quality` ='$quality' and id NOT IN (SELECT inward_id FROM outter_box_outward) ";
            $query = $this->db->query($result);
        return $query->result_array(); 
	}
}