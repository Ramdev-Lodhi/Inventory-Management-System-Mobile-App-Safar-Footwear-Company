<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *  Stock Controller
 */
class Stock extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('uid'))
		redirect('signin');
		$this->load->model('StockM');
		$this->load->model('crud');
	}

	public function index()
	{
		$data['data'] = $this->StockM->get_records('stock');
		$data['godown'] = $this->crud->get_records('godown');
		$this->load->view('stock/list', $data);
	}

	public function update_records(){

		$this->db->trans_start(); # Starting Transaction

		// add quantity from outter_box_inwards
		// get data
		$inwards_data = $this->StockM->get_updated_inward_records();
		$i=0;
		foreach($inwards_data as $d){
			// get size
			$package_size = $this->StockM->get_package_size($d['size']);
			$size_string = "";
			foreach($package_size as $p){
				foreach ($p as $key => $value) {

					if($value==1 && is_numeric($key)){
						if($size_string==""){
							$size_string=$size_string.$key;
						}else{
							$size_string=$size_string.",".$key;
						}
					}
				}
			}

			$size_id_array = $this->StockM->get_size_id_by_size($size_string,$d['a_id'], $d['a_color_id']);
			
			// update data
			foreach($size_id_array as $size){			
				$change_by = 'server';
				$stock = $this->StockM->get_stock_detail($size['id']);
				if(empty($stock)){
					// create stock record
					
					$this->StockM->insert_records($size['id'], $d['godown_id'],$d['no_of_pairs'], $change_by);
				}
				else{
					// update stock record
					$this->StockM->update_inward_records($size['id'], $d['godown_id'],$d['no_of_pairs'], $change_by);
				}
			}

			// change status from pending to success

			$this->StockM->update_inward_status($d['id']);

			$i++;
		}
		// *******************************************
		
		// substract quantity from outter_box_outwards
		// get data
		$outwards_data = $this->StockM->get_updated_outward_records();
		
		$i=0;
		foreach($outwards_data as $d){
			// get size
			$package_size = $this->StockM->get_package_size($d['size'])[0];
			$size_string = "";
			
			foreach ($package_size as $key => $value) {
				if($value==1 && is_numeric($key)){
					if($size_string==""){
						$size_string=$size_string.$key;
					}else{
						$size_string=$size_string.",".$key;
					}
				}
			}

			$size_id_array = $this->StockM->get_size_id_by_size($size_string,$d['a_id'], $d['a_color_id']);
		
			// update data
			foreach($size_id_array as $size){			
				$change_by = 'server';
				$stock = $this->StockM->get_stock_detail($size['id']);
				$total_quantity = $stock[0]['pairs_in_g1'] + $stock[0]['pairs_in_g2'];
				if($total_quantity - $d['no_of_pairs'] == 0){
					$this->StockM->delete_stock_item($stock[0]['id']);
				}else{
					// update stock record
					$this->StockM->update_outward_records($size['id'], $d['godown_id'],$d['no_of_pairs'], $change_by);
				}
				
				
			}

			// change status from pending to success

			$this->StockM->update_outward_status($d['id']);

			$i++;
		}

		$this->db->trans_complete(); # Completing transaction

		if ($this->db->trans_status() === FALSE) {
			# Something went wrong.
			$this->db->trans_rollback();
			$this->session->set_flashdata('message', '<div class="alert alert-danger">Something went wrong...</div>');
		redirect(base_url('stock'));
		} 
		else {
			# Everything is Perfect. 
			# Committing data to the database.
			$this->db->trans_commit();
			$this->session->set_flashdata('message', '<div class="alert alert-success">Records have been updated successfully.</div>');
		redirect(base_url('stock'));
		}
	

	}
	
	
}