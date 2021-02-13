<?php

// Accesses event table, cardevent table, venue table and area table
class Event_Model extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
	
	public function get_events($id = FALSE){
		if($id === FALSE){
			$query = $this->db->get('event');
			return $query->result_array();
		}

		$query = $this->db->get_where('event', array('Event_Id' => $id));
		return $query->row_array();
	}
	
	public function get_venues($id = FALSE){
		if($id === FALSE){
			$query = $this->db->get('venue');
			return $query->result_array();
		}

		$query = $this->db->get_where('venue', array('Venue_Id' => $id));
		return $query->row_array();
	}
	
	public function get_areas($id = FALSE){
		if($id === FALSE){
			$query = $this->db->get('area');
			return $query->result_array();
		}

		$query = $this->db->get_where('area', array('Area_Id' => $id));
		return $query->row_array();
	}
	
	public function get_cardevents($id = FALSE){
		if($id === FALSE){
			$query = $this->db->get('cardevent');
			return $query->result_array();
		}

		$query = $this->db->get_where('cardevent', array('Card_Event_Id' => $id));
		return $query->row_array();
	}

	public function new_cardevent($card_id, $event_id){
		$data = array(
			'Card_Id' => $card_id,
			'Event_Id'  => $event_id
		);
		return $this->db->insert('cardevent', $data);
	}
	public function delete_cardevent_row($id){
	    $this->db->delete('cardevent', array('Card_Event_Id' => $id));
	}

}