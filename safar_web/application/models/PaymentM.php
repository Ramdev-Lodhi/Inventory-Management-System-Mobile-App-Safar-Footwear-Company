<?php

/**
 * Stock Model
 */
class PaymentM extends CI_Model
{ 
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

     
    public function get_size_by_articleId($article_id){
        $sql = "SELECT package_size.size  FROM package_size JOIN article ON article.id = $article_id and article.category = package_size.category_id";
        $query = $this->db->query($sql);
        return $query->result_array(); 
    }

    public function get_color_by_articleId($article_id){
        $sql = "SELECT color.color, color.id  FROM color, category, article WHERE article.id = $article_id and article.category = category.id and category.id = color.category_id";
        $query = $this->db->query($sql);
        return $query->result_array(); 
    }
}