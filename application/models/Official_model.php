<?php

// Accesses official table and title table
class Official_Model extends CI_Model{
	public function __construct(){
		$this->load->database();
	}

	//get official data from officials table
	public function get_officials($id = FALSE){
		//if no variable is passed in, return whole table
		if($id === FALSE){
			$query = $this->db->get('official');
			return $query->result_array();
		}
		//else return row for specific ID
		$query = $this->db->get_where('official', array('Official_Id' => $id));
		return $query->row_array();
	}

	//check is official with forename AND surname ius already in DB
	public function check_official_exists($forename, $surname){
		// get any row(s) in official table where the forename AND surname match params
		$query = $this->db->get_where('official', array(
			'Forename' => $forename, 'Surname' => $surname
		));
		// if the resulting array is empty, return true
		if (is_null($query->row_array())){
			return true;
		} else{
			return false;
		}
	}

	public function add_official($forename, $surname, $title, $role) {
		$data = array(
			'Forename' => $forename,
			'Surname'  => $surname,
			'Title_Id' => $title,
			'Role_Id'  => $role
		);
		return $this->db->insert('official', $data);
	}
	
	public function get_titles($id = FALSE){
		if($id === FALSE){
			$query = $this->db->get('title');
			return $query->result_array();
		}

		$query = $this->db->get_where('title', array('Title_Id' => $id));
		return $query->row_array();
	}

	public function change_official_title($id) {
		if ($this->input->post('title') != 'Select a Title') {
			$this->db->where('Official_Id', $id);
			$this->db->update('official', array(
				'Title_Id' => $this->input->post('title')
			));
			return TRUE;
		}
		return FALSE;
	}

	public function change_official_forename($id) {
		if ($this->input->post('forename') != NULL) {
			$this->db->where('Official_Id', $id);
			$this->db->update('official', array(
				'Forename' => $this->input->post('forename')
			));
			return TRUE;
		}
		return FALSE;
	}

	public function change_official_surname($id) {
		if ($this->input->post('surname') != NULL) {
			$this->db->where('Official_Id', $id);
			$this->db->update('official', array(
				'Surname' => $this->input->post('surname')
			));
			return TRUE;
		}
		return FALSE;
	}
}