<?php

// Accesses card table and status table
class Card_Model extends CI_Model{
	public function __construct(){
		$this->load->database();
	}

	public function get_cards($id = FALSE){
		if($id === FALSE){
			$query = $this->db->get('card');
			return $query->result_array();
		}

		$query = $this->db->get_where('card', array('Card_Id' => $id));
		return $query->row_array();
	}

	public function new_card($official_id, $status, $expiry_date){
		date_default_timezone_set('Europe/London');
		$data = array(
			'Official_Id' => $official_id,
			'Status_Id'  => $status,
			'Expiry_Date' => date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $expiry_date)))
		);
		return $this->db->insert('card', $data);
	}

	public function get_status($id){
		$query = $this->db->get_where('status', array('Status_Id' => $id));
		return $query->row_array();
	}

	public function change_official_cardstatus($id) {
		if ($this->input->post('status') != 'Change Status') {
			$this->db->where('Official_Id', $id);
			$this->db->update('card', array(
				'Status_Id' => $this->input->post('status')
			));
			return TRUE;
		}
		return FALSE;
	}
}