<?php

class Users extends CI_Controller{
    public function register(){
        // check user is logged in
        if($this->session->userdata('logged_in')){
            redirect('officials');
        }

        // only accessible for admins/managers?

    	$data['title'] = 'Register A New Account';

        $this->form_validation->set_rules('username', 'Username', 'required|callback_check_username_exists');
    	$this->form_validation->set_rules('email', 'Email', 'required|callback_check_email_exists');
    	$this->form_validation->set_rules('password', 'Password', 'required');
    	$this->form_validation->set_rules('password2', 'Confirm Password', 'matches[password]');

    	if($this->form_validation->run() === FALSE){
    		$this->load->view('templates/header');
            $this->load->view('users/register', $data);
            $this->load->view('templates/footer');
    	} else {
    		$enc_password = md5($this->input->post('password'));
			$this->user_model->register($enc_password);

			$this->session->set_flashdata('user_registered', 'You are now registered and can log in.');

			redirect('users/login');
    	}
    }

    //check is username exists
    public function check_username_exists($username){
        $this->form_validation->set_message('check_username_exists', '<p style="color:red;">That username is already taken.</p>');

        if($this->user_model->check_username_exists($username)) {
            return true;
        } else {
            return false;
        }
    }


    //check is email exists
    public function check_email_exists($email){
        $this->form_validation->set_message('check_email_exists', '<p style="color:red;">The email entered already has an account associated with it.</p>');

        if($this->user_model->check_email_exists($email)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function login(){
        // check user is logged in
        if($this->session->userdata('logged_in')){// === TRUE){
            redirect('officials');
        }

        $data['title'] = 'Venue Access Management System
        For Olympic Officials';
        $data['subtitle'] = 'Sign In';

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if($this->form_validation->run() === FALSE){
            $this->load->view('templates/header');
            $this->load->view('users/login', $data);
            $this->load->view('templates/footer');
        } else {
            // login user
            $username = $this->input->post('username');
            $password = md5($this->input->post('password'));
            $user_id = $this->user_model->login($username, $password);

            if($user_id){
                //create user session
                $user_data = array(
                    'user_id' => $user_id,
                    'username' => $username,
                    'logged_in' => TRUE
                );
                $this->session->set_userdata($user_data);

                //message
                $this->session->set_flashdata('user_success', 'Welcome '.$username.'.');

                redirect('officials');
            } else{
                $this->session->set_flashdata('user_failed', 'Invalid log in, username or password not found.');

                redirect('users/login');
            }
        }
    }

    //user log out
    public function logout($data){
        //unset user session data 
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('username');

        //message
        $this->session->set_flashdata('user_warning', 'You are now logged out.');

        redirect("users/login");

    }
}