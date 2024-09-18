<?php

/**
 * 
 * Article Model
 */
class ArticleM extends CI_Model
{ 
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	public function insert_product_image($article_id, $file_name)
	{
        $sql = "UPDATE `article` SET photo = '$file_name' WHERE `id` = $article_id";
		$query = $this->db->query($sql);
        return;
	}

}