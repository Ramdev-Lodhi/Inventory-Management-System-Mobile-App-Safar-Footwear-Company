<?php

/**
 * Stock Model
 */
class JobsheetM extends CI_Model
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

    // public function get_no_of_pairs_by_articleId($article_id){
    //     $sql = "SELECT article.no_of_pairs_box, article.no_of_pairs_loose  FROM article WHERE article.id = $article_id and article.is_active=1";
    //     $query = $this->db->query($sql);
    //     return $query->result_array(); 
    // }

    public function delete_all_jobsheet(){
        $sql="DELETE FROM job_sheet";
        $query = $this->db->query($sql);
        return;
    }
    public function get_jobtype_dept($table,$type)
	{
       
            $result="SELECT *  FROM department WHERE `$type`=1";
            $query = $this->db->query($result);
        return $query->result_array(); 
		// $result = $this->db->get_where($table, ['1' => `$type`])->row();
		// return $result;
	}
    public function get_status_details($table,$jobsheet_id)
	{
       
            $result="SELECT *  FROM $table WHERE `jobsheet_id`=$jobsheet_id ";
            $query = $this->db->query($result);
        return $query->result_array(); 
		// $result = $this->db->get_where($table, ['1' => `$type`])->row();
		// return $result;
	}
    public function get_sequence()
    {
        $result = "SELECT  job_status.jobsheet_id , job_status.job_type,job_status.dept_name,job_status.status,job_sheet.status as job  from job_status ,job_sheet WHERE job_status.jobsheet_id = job_sheet.id;";
       $query= $this->db->query($result);
       return  $query->result_array();
    }
    public function get_success_jobsheet()
    {
        $sql = "SELECT * from job_sheet where status= 1 ";
        return $this->db->query($sql)->result_array();
    }
    public function get_artile_payment($a_id)
    {
        $sql = "SELECT a_id,Store,Cutting,Printing,Embossing,Stiching,Pioring,Production,Trimming,Sorting,Packazing from payment_article where a_id= $a_id ";
        return $this->db->query($sql)->result_array();
    }
    public function change_status_1($id,$date)
    {
        $sql = "UPDATE job_sheet SET payment_date = STR_TO_DATE('$date', '%Y-%m-%d'), payment_status = 1 WHERE id = $id";
        return $this->db->query($sql);
    }
    public function change_status_0($id)
    {
        $sql = "UPDATE job_sheet set payment_status=0 where id = $id";
        return $this->db->query($sql);
    }
}