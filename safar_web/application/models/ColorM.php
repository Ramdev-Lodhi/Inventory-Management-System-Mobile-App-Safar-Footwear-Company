<?php

/**
 * Color Model
 */
class ColorM extends CI_Model
{ 
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	public function get_all()
	{
        $sql = "SELECT *
        FROM article_color
        JOIN article ON article.id = article_color.article_id;";
		$query = $this->db->query($sql);
        return $query->result_array();
	}

}