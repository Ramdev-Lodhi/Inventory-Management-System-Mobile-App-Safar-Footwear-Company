<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *  GodownStock Controller
 */
class Godownstock extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('uid'))
		redirect('signin');
		$this->load->model('crud');
		$this->load->model('StockM');
	}

	public function index()
	{
		$godown_stock = array();
		$articles = $this->StockM->get_godown_stock_articles();
		$i=0;
		foreach($articles as $a){
			$godown_stock[$i]['article_name'] = $a['a_name'];
			$godown_stock[$i]['aid'] = $a['a_id'];				
			$color = $this->StockM->get_godown_stock_color($a['a_id']);
			$color_count = 0;
			$j=0;
			foreach($color as $c){
				$godown_stock[$i]['color'][$j]['color_name'] = $c['a_color'];
				$godown_stock[$i]['color'][$j]['color_id'] = $c['a_color_id'];
				$godown_stock[$i]['color'][$j]['quality'] = $c['quality'];
				$size = $this->StockM->get_godown_stock_size($a['a_id'],$c['a_color_id'],$c['quality']);
				$godown_stock[$i]['color'][$j]['size_count'] = sizeof($size);
				$color_count += sizeof($size);
				$k=0;
				foreach($size as $s){
					$godown_stock[$i]['color'][$j]['size'][$k]['size_name'] = $s['size'];
					$quantity_in_g1 = $this->StockM->get_godown_stock_quantity_g1($a['a_id'],$c['a_color_id'],$s['size'],$c['quality']);
					if(!empty($quantity_in_g1)){
						$godown_stock[$i]['color'][$j]['size'][$k]['quantity_in_g1'] = $quantity_in_g1[0]['count'];
					}else{
						$godown_stock[$i]['color'][$j]['size'][$k]['quantity_in_g1'] = 0;
					}
					$quantity_in_g2 = $this->StockM->get_godown_stock_quantity_g2($a['a_id'],$c['a_color_id'],$s['size'],$c['quality']);
					if(!empty($quantity_in_g2)){
						$godown_stock[$i]['color'][$j]['size'][$k]['quantity_in_g2'] = $quantity_in_g2[0]['count'];
					}else{
						$godown_stock[$i]['color'][$j]['size'][$k]['quantity_in_g2'] = 0;
					}
					$k++;
				}
				$j++;
			}
			$godown_stock[$i]['color_count'] = $color_count;
			$i++;
		}
		$data['data'] = $godown_stock;
		$this->load->view('godown_stock/list', $data);
	}

	public function view($article_id,$colorid,$size,$quality)
    {
        $data = $this->StockM->get_details('outter_box_inward', $article_id,$colorid,$size,$quality);
        $tBodyData = ''; // Initialize an empty string to store tbody data
$i=1;
        foreach ($data as $item) {
            $tBodyData .= '<tr align="center">';
            $tBodyData .= '<td>' . $item['id'] . '</td>';
            $tBodyData .= '<td>' . $item['qr_id'] . '</td>';
            $tBodyData .= '</tr>';
            $i++;
        }

        echo $tBodyData; // Echo only the tbody data
    }

}