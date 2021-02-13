<?php

// Accesses users table
class User_Model extends CI_Model{
	public function register($enc_password){
		//generate username
		if ($this->input->post('isadmin') == "2") {
			$isadmin = "Manager";
		} elseif ($this->input->post('isadmin') == "3") {
			$isadmin = "Admin";
		} else {
			$isadmin = "Security";
		}

		// codeigniter automatically escapes any values passed in using the form methods and the $this->input->post() method
		$data = array(
			'username'		=> $this->input->post('username'),
			'email_address' => $this->input->post('email'),
			'password' 		=> $enc_password,
			'user_type' 	=> $isadmin
		);

		return $this->db->insert('users', $data);
	}

	//user log in
	public function login($username, $password){
		//validate using SQL
		$condition = "username =" . "'" . $username . "' AND " . "password =" . "'" . $password . "'";
		// codeigniter automatically escapes any values passed in using the form methods and the $this->input->post() method
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where($condition);
		$this->db->limit(1);
		$result = $this->db->get();

		if ($result->num_rows() == 1) {
			$row = $result->row_array();
			foreach($row as $key => $field) {
			   return $row[$key][0];
			}
		} else {
			return false;
		}
	}

	//check username exists
	public function check_username_exists($username){
		$query = $this->db->get_where('users', array('username' => $username));

		if (is_null($query->row_array())){
			return true;
		} else{
			return false;
		}
	}

	//check email exists
	public function check_email_exists($email){
		$query = $this->db->get_where('users', array('email_address' => $email));

		if (is_null($query->row_array())){
			return true;
		} else{
			return false;
		}
	}
}