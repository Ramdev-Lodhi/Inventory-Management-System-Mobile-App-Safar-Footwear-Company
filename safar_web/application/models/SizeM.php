<?php

/**
 * Size Model
 */
class SizeM extends CI_Model
{ 
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	public function get_all()
	{
        $sql = "SELECT article_size.id,article.name,article_color.color,article_size.size
        FROM article_size
        JOIN article ON article.id = article_size.article_id
        JOIN article_color ON article_color.id = article_size.article_color_id;";
		$query = $this->db->query($sql);
        return $query->result_array();
	}

}