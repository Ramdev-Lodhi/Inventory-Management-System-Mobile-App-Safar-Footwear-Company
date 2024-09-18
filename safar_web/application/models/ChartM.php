<?php
use LDAP\Result;

/**
 * 
 * Article Model
 */
class ChartM extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function get_godown_stock_articles_first()
    {
        $sql = "SELECT  a_id, a_name,quality FROM outter_box_inward WHERE id NOT IN (SELECT inward_id FROM outter_box_outward) and quality='first' order by a_id";
        // print_r($sql);
        // die();
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function get_godown_stock_articles_second()
    {
        $sql = "SELECT  a_id, a_name,quality FROM outter_box_inward WHERE id NOT IN (SELECT inward_id FROM outter_box_outward) and quality='SECOND'order by a_id";
        // print_r($sql);
        // die();
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function get_chart_articles_first()
    {
        $sql = "SELECT  a_id, a_name,quality FROM outter_box_inward WHERE id NOT IN (SELECT inward_id FROM outter_box_outward) and quality='first' order by a_id";
        // print_r($sql);
        // die();
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function get_chart_articles_second()
    {
        $sql = "SELECT  a_id, a_name,quality FROM outter_box_inward WHERE id NOT IN (SELECT inward_id FROM outter_box_outward) and quality='SECOND'order by a_id";
        // print_r($sql);
        // die();
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function get_godown_stock_category($a_id)
    {
        $sql = "SELECT distinct `category` FROM article where id = $a_id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function get_stock_category($a_id)
    {
        $sql = "SELECT distinct article.category, category.name FROM article,category where  category.id=article.category and article.id = $a_id order by category.id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_godown_stock_color($article_id)
    {
        $sql = "SELECT distinct a_color_id, a_color FROM outter_box_inward where a_id = $article_id";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_godown_stock_size($article_id, $color_id,$quality)
    {
        $sql = "SELECT distinct `size` FROM outter_box_inward where a_id = $article_id and a_color_id = $color_id and quality ='$quality'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_godown_stock_quantity_g1($article_id, $color_id, $size,$quality)
    {
        $sql = "SELECT count(id) as count FROM outter_box_inward where a_id = $article_id and a_color_id = $color_id and `size` = '$size'  and quality ='$quality' and godown_id = 1 and id NOT IN (SELECT inward_id FROM outter_box_outward)";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_godown_stock_quantity_g2($article_id, $color_id, $size,$quality)
    {
        $sql = "SELECT count(id) as count FROM outter_box_inward where a_id = $article_id and a_color_id = $color_id and `size` = '$size' and quality ='$quality' and godown_id = 2 and id NOT IN (SELECT inward_id FROM outter_box_outward)";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_jobsheet()
    {
        $sql= "SELECT article_id , payment_status,status from job_sheet ";
        return $this->db->query($sql)->result_array();
    } 
    public function get_less_rawmaterial()
    {
        $sql="SELECT id , name , quantity,threshold FROM `raw_material1` WHERE quantity < threshold UNION ALL SELECT id , name , quantity,threshold FROM `raw_material2` WHERE quantity < threshold";
        return $this->db->query($sql)->result_array();
    }
}