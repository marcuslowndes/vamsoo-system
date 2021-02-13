<?php

class Officials extends CI_Controller{
    public function index(){
        // check user is logged in
        if(!$this->session->userdata('logged_in')){
            redirect('users/login');
        }

        $data['title'] = 'All Officials';
        $data['officials'] = $this->official_model->get_officials();
        $data['cards'] = $this->card_model->get_cards();
        $data['official_titles'] = $this->official_model->get_titles();
        $data['roles'] = $this->sport_model->get_roles();
        $data['sports'] = $this->sport_model->get_sports();

        $this->load->view('templates/header');
        $this->load->view('officials/index', $data);
        $this->load->view('templates/footer');
    }


    //Any automated stuff, such as expiring cards that are past sport end date, etc, go in this function
  /*  public function automate(){

        // Update expiry date against sport end date for every card here


        // Automate expire card if current date past expiry date here
    }*/


    public function card($id = NULL){
        // check user is logged in
        if(!$this->session->userdata('logged_in')){
            redirect('users/login');
        }

        //get card data from id
        $data['card'] = $this->card_model->get_cards($id);

        //get official data
        $officials = $this->official_model->get_officials();
        foreach($officials as $official){
            if($data['card']['Official_Id'] == $official['Official_Id']){
                $official_id = $official['Official_Id'];
            }
        }
        if(!isset($official_id)){
            show_404();
        }

        $data['official'] = $this->official_model->get_officials($official_id);

        // get title
        $title_id = $data['official']['Title_Id'];
        $data['official_titles'] = $this->official_model->get_titles($title_id);

        // get status
        $status_id = $data['card']['Status_Id'];
        $data['card_status'] = $this->card_model->get_status($status_id);

        // get role
        $role_id = $data['official']['Role_Id'];
        $data['role'] = $this->sport_model->get_roles($role_id);

        //get sport from role
        $sport_id = $data['role']['Sport_Id'];
        $data['sport'] = $this->sport_model->get_sports($sport_id);
    	
        $data['title'] = "Official ID Card";


        // Set up edit form
        $this->form_validation->set_rules('forename', 'Forename','trim|max_length[32]');
        $this->form_validation->set_rules('surname', 'Surname', 'trim|max_length[32]');

        //check if form edited
        if($this->form_validation->run() === FALSE){
            $this->load->view('templates/header');
            $this->load->view('officials/card', $data);
            $this->load->view('templates/footer');

           /* $this->session->set_flashdata('user_warning', 'Please make an edit before clicking submit.');
            redirect('officials/'.$id);*/
        } else {
            $edit1 = $this->official_model->change_official_forename($id);
            $edit2 = $this->official_model->change_official_surname($id);
            $edit3 = $this->official_model->change_official_title($id);
            $edit4 = $this->card_model->change_official_cardstatus($id);

            if ($edit1||$edit2||$edit3||$edit4){
                $this->session->set_flashdata('user_success', 'You have successfully updated the Official.');
            } else {
                $this->session->set_flashdata('user_warning', 'Please make an edit before clicking submit.');
            }
            redirect('officials/'.$id);
        }
    }

    //Add A New Official
    public function add(){
        // check user is logged in
        if(!$this->session->userdata('logged_in')){
            redirect('users/login');
        }

        // only accessible for admins/managers?

        $data['title'] = 'Add a New Official';
        $data['sports'] = $this->sport_model->get_sports();
        $data['roles'] = $this->sport_model->get_roles();
        $data['function'] = 'officials/add';

        $add_data = array(
            'add_title' => "",
            'add_forename' => "",
            'add_surname' => "",
            'add_sport' => "",
            'add_role' => ""
        );
        $data['add_data'] = $add_data;
        $data['add_new_sport'] = FALSE;

        $this->form_validation->set_rules('title', 'Title', 'required|callback_check_valid_title');
        $this->form_validation->set_rules('forename', 'Forename','required|trim|max_length[32]');
        $this->form_validation->set_rules('surname', 'Surname', 'required|trim|max_length[32]');
        $this->form_validation->set_rules('sport', 'Sport', 'callback_check_valid_sport');

        
        if($this->form_validation->run() === FALSE){
            //starting form view
            $this->load->view('templates/header');
            $this->load->view('templates/form_open', $data);
            $this->load->view('officials/add/new_official', $data);
            $this->load->view('templates/form_close', $data);
            $this->load->view('templates/footer');
        } else {
            $add_data = array(
                'add_title'     => $this->input->post('title'),
                'add_forename'  => $this->input->post('forename'),
                'add_surname'   => $this->input->post('surname'),
                'add_sport'     => $this->input->post('sport')
            );
            $data['add_data'] = $add_data;

            // if "Add New Sport" is submitted:
            if($add_data['add_sport'] == 0){

                // set_rules not used for new sport form (callback validation doesn't work and required handled by HTML/JS)

                $rolename = $this->input->post('rolename');
                $sportname = $this->input->post('sportname');
                $gender_id = $this->input->post('gender');
                $wsgb_name = $this->input->post('wsgb');
                $sport_startdate = $this->input->post('startdate');
                $sport_enddate = $this->input->post('enddate');

                /* Check if new sport and role is added and if so validate and insert  official, 
                 * sport and role into database (rolename is unique to new sport view)
                 */
                if ($rolename != "" && $sportname != "") { 

                    //input validation
                    $valid_gender = $this->check_valid_gender($gender_id);
                    $valid_sport_startdate = $this->check_valid_date_format($sport_startdate);
                    $valid_sport_enddate = $this->check_valid_date_format($sport_enddate);
                    $startdate_after_enddate = $this->check_startdate_before_enddate($sport_startdate, $sport_enddate);

                    //If valid data types entered
                    if ( $valid_gender && $valid_sport_startdate && $valid_sport_enddate && $startdate_after_enddate ){ 

                        //duplicate validation
                        $official_exists = $this->official_model->check_official_exists(
                            $add_data['add_forename'], $add_data['add_surname']
                        );
                        $gendered_sport_exists = $this->sport_model->check_gendered_sport_exists($sportname, $gender_id);
                        $wsgb_exists = $this->sport_model->check_wsgb_exists($wsgb_name);

                        //If official/gendered sport/WSGB don't already exist in DB, insert them and initialise ID card
                        if( $official_exists && $gendered_sport_exists && $wsgb_exists ) {

                            $this->sport_model->add_wsgb($wsgb_name);

                            $this->sport_model->add_sport(
                                $sportname, $gender_id, $wsgb_name,
                                $sport_startdate, $sport_enddate
                            );

                            $this->sport_model->add_role($rolename, $sportname);

                            $role = $this->sport_model->get_role_from_name($rolename);
                            $role_id = $role['Role_Id'];

                            $this->official_model->add_official(
                                $add_data['add_forename'],
                                $add_data['add_surname'],
                                $add_data['add_title'],
                                $role_id
                            );

                            // get new official id
                            $officials = $this->official_model->get_officials();
                            foreach($officials as $official){
                                if($official['Forename'] == $add_data['add_forename']
                                        && $official['Surname'] == $add_data['add_surname']){
                                    $official_id = $official['Official_Id'];
                                }
                            }
                            // initialise card as valid (1)
                            $this->card_model->new_card($official_id, 1, $sport_enddate);

                            // success - DB updated
                            $this->session->set_flashdata('user_success', 'You have added a new official, and their sport and role.');
                            redirect('officials');
                        }

                        //else failed - duplicate data
                        else{
                            $this->session->set_flashdata('user_failed', "Official, role, sport, or WSGB with that name already exists.");
                            redirect('officials/add');
                        }
                    }

                    // else invalid data types
                    else {
                        $this->session->set_flashdata('user_failed', "Invalid data entry. Didn't select a gender or inputed an invalid date format.");
                        $this->load_form_view('new_sport', TRUE, $data);
                    }
                }

                // Add view for new_sport to form
                else {
                    $this->load_form_view('new_sport', TRUE, $data);
                }
            }

            // Else (if a sport is selected):
            else { 
                $role_id = "";
                $role_id = $this->input->post('role');

                // Check if role is selected and if so insert official into database
                if ($role_id != "") { 

                    $official_exists = $this->official_model->check_official_exists(
                        $add_data['add_forename'], $add_data['add_surname']
                    );

                    //If official doesn't already exist in DB, insert official and initialise ID Card
                    if ( $official_exists != NULL ) {
                        $this->official_model->add_official(
                            $add_data['add_forename'],
                            $add_data['add_surname'],
                            $add_data['add_title'],
                            $role_id
                        );

                        // get new official id
                        $officials = $this->official_model->get_officials();
                        foreach($officials as $official){
                            if($official['Forename'] == $add_data['add_forename']
                                    && $official['Surname'] == $add_data['add_surname']){
                                $official_id = $official['Official_Id'];
                            }
                        }

                        // get sport end date from id
                        $sports = $this->sport_model->get_sports();
                        foreach ($sports as $sport) {
                            if ($sport['Sport_Id'] == $add_data['add_sport']){
                                $enddate = $sport['End_Date'];
                            }
                        }

                        // initialise card as valid (1) w/ sport-enddate as expiry date
                        $this->card_model->new_card($official_id, 1, $enddate);

                        $this->session->set_flashdata('user_success', 'You have added a new official.');
                        redirect('officials');
                    } 

                    // Else redirect
                    else { 
                        $this->session->set_flashdata('user_failed', 'Official with that forename and surname already exists.');
                        redirect('officials/add');
                    }
                }

                // Else: Add views for adding existing role to form
                else {
                    $this->form_validation->set_rules('role', 'Role', 'callback_check_valid_role');
                    $this->load_form_view('select_role', FALSE, $data);
                }
            }
        }
    }

    public function load_form_view($form_view, $new_sport, $data){
        $data['add_new_sport'] = $new_sport;
        $this->load->view('templates/header');
        $this->load->view('templates/form_open', $data);
        $this->load->view('officials/add/new_official', $data);
        $this->load->view('officials/add/'.$form_view, $data);
        $this->load->view('templates/form_close', $data);
        $this->load->view('templates/footer');
    }

    public function check_valid_title($title){
        $this->form_validation->set_message('check_valid_title', "<p style='color:red;'>Please select the official's title before clicking Submit.</p>");
        if ($title != 'Select a Title') {
            return TRUE;
        }
        return FALSE;
    }

    public function check_valid_sport($sport){
        $this->form_validation->set_message('check_valid_title', "<p style='color:red;'>Please select the official's sport before clicking Submit.</p>");
        if ($sport != 'Select a Sport') {
            return TRUE;
        }
        return FALSE;
    }

    public function check_valid_role($role){
        if ($role != 'Select a Role') {
            return TRUE;
        }
        return FALSE;
    }

    public function check_valid_gender($gender){
        if ($gender != 'Select a Gender') {
            return TRUE;
        }
        return FALSE;
    }

    public function date_format($date){
        $day = (int) substr($date, 6, 2);
        $month = (int) substr($date, 3, 2);
        $year = (int) substr($date, 0, 4);
        return array(
            'day'   => $day,
            'month' => $month,
            'year'  => $year
        );
    }

    public function check_valid_date_format($date){
        $date_array = $this->date_format($date);
        return checkdate(
            $date_array['month'],
            $date_array['day'],
            $date_array['year']
        );
    }

    public function check_startdate_before_enddate($startdate, $enddate){
        date_default_timezone_set('Europe/London');
        if (strtotime(str_replace('-', '/', $enddate))
                > strtotime(str_replace('-', '/', $startdate))){
            return TRUE;
        }
        return FALSE;
    }

}