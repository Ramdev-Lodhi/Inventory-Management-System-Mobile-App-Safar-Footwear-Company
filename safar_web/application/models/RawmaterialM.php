<?php

/**
 * Stock Model
 */
class RawmaterialM extends CI_Model
{ 
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

     
    public function insert_product_image($id, $file_name)
	{
        $sql = "UPDATE `raw_material2` SET photo = '$file_name' WHERE `id` = $id";
		$query = $this->db->query($sql);
        return;
	}
    public function get_color_by_articleId($article_id){
        $sql = "SELECT color.color, color.id  FROM color, category, article WHERE article.id = $article_id and article.category = category.id and category.id = color.category_id";
        $query = $this->db->query($sql);
        return $query->result_array(); 
    }

    public function get_less_rawmaterial1()
    {
        //$aql=" SELECT id , name , quantity,threshold FROM `raw_material1` WHERE quantity < threshold UNION ALL SELECT id , name , quantity,threshold FROM `raw_material2` WHERE quantity < threshold";
        $sql="SELECT id , name , quantity,threshold FROM `raw_material1` WHERE quantity < threshold";
        return $this->db->query($sql)->result_array();
    }
    public function get_less_rawmaterial2()
    {
        $sql=" SELECT id , name , quantity,threshold FROM `raw_material2` WHERE quantity < threshold";
        return $this->db->query($sql)->result_array();
    }
}