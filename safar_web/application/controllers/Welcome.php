<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	//Validating login
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('uid'))
			redirect('signin');
		$this->load->model('crud');
		$this->load->model('ChartM');
	}
	public function index()
	{
		$userfname = $this->session->userdata('fname');
		$godown_stock = array();
		$category_counts_first = array();
		$category_counts_second = array();

		// Get articles with quality 'first'
		$articles_first = $this->ChartM->get_godown_stock_articles_first();
		// Get articles with quality 'second'
		$articles_second = $this->ChartM->get_godown_stock_articles_second();
		// Process articles with quality 'first'
		$i = 0;
		foreach ($articles_first as $a) {
			// $godown_stock[$i]['quality'] = $a['quality'];
			$category = $this->ChartM->get_stock_category($a['a_id']);
			foreach ($category as $cat) {
				// $godown_stock[$i]['category'] = $cat['category'];
				if (isset($category_counts_first[$cat['category']])) {
					$category_counts_first[$cat['category']]['count']++;
				} else {
					$category_counts_first[$cat['category']] = array('category_id' => $cat['category'], 'count' => 1, 'name' => $cat['name']);
				}
			}
			$i++;
		}
		// Process articles with quality 'second'
		foreach ($articles_second as $a) {
			// $godown_stock[$i]['quality'] = $a['quality'];
			$category = $this->ChartM->get_stock_category($a['a_id']);
			foreach ($category as $cat) {
				// $godown_stock[$i]['category'] = $cat['category'];
				if (isset($category_counts_second[$cat['category']])) {
					$category_counts_second[$cat['category']]['count']++;
				} else {
					$category_counts_second[$cat['category']] = array('category_id' => $cat['category'], 'count' => 1 , 'name' => $cat['name']);
				}
			}
			$i++;
		}

		$data['category_counts_first'] = array_values($category_counts_first);
		$data['category_counts_second'] = array_values($category_counts_second);
		$data['job'] = $this->ChartM->get_jobsheet();
		$data['rawmaterial'] = $this->ChartM->get_less_rawmaterial();
			// echo"<pre>";print_r($category_counts_first);
			// die();
		$this->load->view('dashboard', $data);
	}

	public function subdata($id, $quality)
	{
		$godown_stock = array();
		if ($quality == 'FIRST') {
			$articles = $this->ChartM->get_chart_articles_first();
		} else {
			$articles = $this->ChartM->get_chart_articles_second();
		}
		$i = 0;
		foreach ($articles as $a) {
			$godown_stock[$i]['article_name'] = $a['a_name'];
			$godown_stock[$i]['quality'] = $a['quality'];
			$color = $this->ChartM->get_godown_stock_color($a['a_id']);
			$category = $this->ChartM->get_godown_stock_category($a['a_id']);
			$k = 0;
			foreach ($category as $cat) {
				$godown_stock[$i]['category'] = $cat['category'];
				$j = 0;
				foreach ($color as $c) {
					$godown_stock[$i]['color'][$j]['color_name'] = $c['a_color'];
					$size = $this->ChartM->get_godown_stock_size($a['a_id'], $c['a_color_id'],$a['quality']);
					foreach ($size as $s) {
						$godown_stock[$i]['color'][$j]['size_name'] = $s['size'];
						$quantity_in_g1 = $this->ChartM->get_godown_stock_quantity_g1($a['a_id'], $c['a_color_id'], $s['size'],$a['quality']);
						$quantity_in_g2 = $this->ChartM->get_godown_stock_quantity_g2($a['a_id'], $c['a_color_id'], $s['size'],$a['quality']);
						if (!empty($quantity_in_g1 || $quantity_in_g2)) {
							$godown_stock[$i]['color'][$j]['quantity_in_g'] = $quantity_in_g1[0]['count'] + $quantity_in_g2[0]['count'];
						}
					}
					$j++;
				}
				$k++;
			}
			$i++;
		}
		echo json_encode($godown_stock);
	}
}
