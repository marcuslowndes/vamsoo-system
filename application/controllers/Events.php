<?php

class Events extends CI_Controller{
    public function index(){
        // check user is logged in
        if(!$this->session->userdata('logged_in')){
            redirect('users/login');
        }

        $data['title'] = 'All Events';
        $data['sports'] = $this->sport_model->get_sports();
        $data['events'] = $this->event_model->get_events();
        $data['venues'] = $this->event_model->get_venues();
        $data['areas'] = $this->event_model->get_areas();
        $data['cardevents'] = $this->event_model->get_cardevents();

        $this->load->view('templates/header');
        $this->load->view('events/index', $data);
        $this->load->view('templates/footer');
    }

   /* public function automate(){

    }*/

    public function authorisations($id){
        // check user is logged in
        if(!$this->session->userdata('logged_in')){
            redirect('users/login');
        }

        $data['cardevents'] = $this->event_model->get_cardevents();
        $data['event'] = $this->event_model->get_events($id);
        if(empty($data['event'])){
            redirect('events');
        }
        $data['cards'] = $this->card_model->get_cards();
        $data['officials'] = $this->official_model->get_officials();
        $data['official_titles'] = $this->official_model->get_titles();
        $data['roles'] = $this->sport_model->get_roles();
        $sportname = $this->get_gendered_sport_name(
            $this->sport_model->get_sports(),
            $data['event']['Sport_Id']
         );

        $data['title'] = "Authorised ID Cards for ".$sportname.' '.$data['event']['Event_Name'];

        $this->load->view('templates/header');
        $this->load->view('events/authorisations', $data);
        $this->load->view('templates/footer');

    }

    public function add_authorisation($id){
        // check user is logged in
        if(!$this->session->userdata('logged_in')){
            redirect('users/login');
        }

        $data['cardevents'] = $this->event_model->get_cardevents();
        $data['event'] = $this->event_model->get_events($id);
        if(empty($data['event'])){
            redirect('events');
        }
        $data['events'] = $this->event_model->get_events();
        $data['cards'] = $this->card_model->get_cards();
        $data['officials'] = $this->official_model->get_officials();
        $data['official_titles'] = $this->official_model->get_titles();
        $sportname = $this->get_gendered_sport_name(
            $this->sport_model->get_sports(),
            $data['event']['Sport_Id']
        );
        $data['title'] = 'Authorise An Official for '.$sportname.' '.$data['event']['Event_Name'];
        $data['function'] = 'events/add/'.$id;

        $this->form_validation->set_rules('official', 'Official', 'required|callback_check_valid_official');

        if($this->form_validation->run() === FALSE){
            //starting form view
            $this->load->view('templates/header');
            $this->load->view('templates/form_open', $data);
            $this->load->view('events/new_authorisation', $data);
            $this->load->view('templates/form_close', $data);
            $this->load->view('templates/footer');
        } else {
            $official_id = $this->input->post('official');
            // get the posted officials's card id
            if($official_id != 0){
              foreach ($data['cards'] as $card) {
                foreach ($data['officials'] as $official) {
                  if($official['Official_Id'] == $card['Official_Id']
                      && $card['Official_Id'] == $official_id){
                    
                    $this->event_model->new_cardevent($card['Card_Id'], $id);
                    $this->session->set_flashdata('user_success', 'You have added an authorisation for '.$sportname.' '.$data['event']['Event_Name'].'.');
                    redirect('events/authorisations/'.$id);
                  }
                }
              }
            } else {
                redirect('officials/add');
            }
        }
    }

    public function delete_authorisation($event_id, $cardevent_id = FALSE){
        $data['cardevent'] = $this->event_model->get_cardevents($cardevent_id);
        if(empty($data['cardevent'])){
            redirect('events');
        }

        $data['cardevents'] = $this->event_model->delete_cardevent_row($cardevent_id);
        $this->session->set_flashdata('user_success', 'You have deleted the authorisation.');
        redirect('events/authorisations/'.$event_id);
    }


    public function check_valid_official($event){
        $this->form_validation->set_message('check_valid_official', "<p style='color:red;'>Please select the official before clicking Submit.</p>");
        if ($event != 'Select an Event') {
            return TRUE;
        }
        return FALSE;
    }

    public function get_gendered_sport_name($sports, $sport_id){
        foreach ($sports as $sport) {
            if ($sport['Sport_Id'] == $sport_id){
                if ($sport['Gender_Id'] == 1) {
                    $gender = "Men's ";
                } else {
                    $gender = "Women's ";
                }
                return $gender.$sport['Sport_Name'];
            }
        }
    }
}