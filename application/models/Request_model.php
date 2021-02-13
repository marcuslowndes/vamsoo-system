<?php

// Accesses request table and requesttype table
class Request_Model extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
	
	public function get_requests($id = FALSE){
		if($id === FALSE){
			$query = $this->db->get('request');
			return $query->result_array();
		}

		$query = $this->db->get_where('request', array('Event_Id' => $id));
		return $query->row_array();
	}
	
	public function get_requesttype($id = FALSE){
		if($id === FALSE){
			$query = $this->db->get('requesttype');
			return $query->result_array();
		}

		$query = $this->db->get_where('requesttype', array('Venue_Id' => $id));
		return $query->row_array();
	}

	public function new_request(
		$card_id, $venue_id, $request_type, $request_timestamp, $authorisation
	){
		$data = array(
			'Card_Id' => $card_id,
			'Venue_Id' => $venue_id,
			'Request_Type_Id' => $request_type,
			'Timestamp' => $request_timestamp,
			'Authorisation' => $authorisation
		);
		return $this->db->insert('request', $data);
	}
	
}