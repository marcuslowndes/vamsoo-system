<?php

// Accesses sport table, role table and wsgb table
class Sport_Model extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
	
	public function get_sports($id = FALSE){
		if($id === FALSE){
			$query = $this->db->get('sport');
			return $query->result_array();
		}

		$query = $this->db->get_where('sport', array('Sport_Id' => $id));
		return $query->row_array();
	}

	public function add_sport($sportname, $gender_id, $wsgb_name, $start_date, $end_date) {
		$wsgb = $this->get_wsgb_from_name($wsgb_name);
		$wsgb_id = $wsgb['WSGB_Id'];
		date_default_timezone_set('Europe/London');
		$data = array(
			'Sport_Name'	=> $sportname,
			'Gender_Id'		=> $gender_id,
			'WSGB_Id'		=> $wsgb_id,
			'Start_Date' 	=> date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $start_date))),
			'End_Date'		=> date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $end_date)))
		);
		return $this->db->insert('sport', $data);
	}

	public function get_sport_from_name($sport_name){
		$query = $this->db->get_where('sport', array('Sport_Name' => $sport_name));
		return $query->row_array();
	}

	public function check_gendered_sport_exists($sportname, $gender) {
		$query = $this->db->get_where('sport', array(
			'Sport_Name' => $sportname, 'Gender_Id' => $gender
		));
		if ( is_null($query->row_array()) ){
			return true;
		} else{
			return false;
		}
	}
	
	public function get_roles($id = FALSE){
		if($id === FALSE){
			$query = $this->db->get('role');
			return $query->result_array();
		}

		$query = $this->db->get_where('role', array('Role_Id' => $id));
		return $query->row_array();
	}

	public function add_role($rolename, $sportname){
		$sport = $this->get_sport_from_name($sportname);
		$sport_id = $sport['Sport_Id'];

		$data = array(
			'Role_Name'	=> $rolename,
			'Sport_Id'	=> $sport_id,
		);
		return $this->db->insert('role', $data);
	}

	public function get_role_from_name($rolename){
		$query = $this->db->get_where('role', array('Role_Name' => $rolename));
		return $query->row_array();
	}

	public function check_wsgb_exists($wsgb_name){
		$query = $this->db->get_where('wsgb', array('WSGB_Name' => $wsgb_name));

		if (is_null($query->row_array())){
			return true;
		} else{
			return false;
		}
	}

	public function add_wsgb($wsgb_name){
		//if (!$this->check_wsgb_exists($wsgb_name)){
			$data = array('WSGB_Name' => $wsgb_name);
		//}
		return $this->db->insert('wsgb', $data);
	}

	public function get_wsgb_from_name($wsgb_name){
		$query = $this->db->get_where('wsgb', array('WSGB_Name' => $wsgb_name));
		return $query->row_array();
	}
}