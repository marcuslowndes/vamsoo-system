<?php

class Requests extends CI_Controller{
    public function index(){
        // check user is logged in
        if(!$this->session->userdata('logged_in')){
            redirect('users/login');
        }

        $data['title'] = 'Pending Requests';
        $data['requests'] = $this->request_model->get_requests();
        $data['cards'] = $this->card_model->get_cards();
        $data['officials'] = $this->official_model->get_officials();
        $data['official_titles'] = $this->official_model->get_titles();
        $data['events'] = $this->event_model->get_events();
        $data['venues'] = $this->event_model->get_venues();
        $data['areas'] = $this->event_model->get_areas();

        $this->load->view('templates/header');
        $this->load->view('requests/index', $data);
        $this->load->view('templates/footer');
    }

    public function add(){
        // check user is logged in
        if(!$this->session->userdata('logged_in')){
            redirect('users/login');
        }

        $data['title'] = 'Pending Requests';
        $data['requests'] = $this->request_model->get_requests();
        $data['cards'] = $this->card_model->get_cards();
        $data['cardevents'] = $this->event_model->get_cardevents();
        $data['officials'] = $this->official_model->get_officials();
        $data['official_titles'] = $this->official_model->get_titles();
        $data['events'] = $this->event_model->get_events();
        $data['venues'] = $this->event_model->get_venues();
        $data['areas'] = $this->event_model->get_areas();

        $data['title'] = 'Request To Enter Venue';
        $data['function'] = 'requests/add';

        $this->form_validation->set_rules('date', 'Date', 'required|callback_check_valid_date_format');
        $this->form_validation->set_rules('time', 'Time', 'required|callback_check_valid_time_format');

        if($this->form_validation->run() === FALSE){
            $this->load->view('templates/header');
            $this->load->view('templates/form_open', $data);
            $this->load->view('requests/new_request', $data);
            $this->load->view('templates/form_close', $data);
            $this->load->view('templates/footer');
        } else {
            $official_id = $this->input->post('official');
            $venue_id = $this->input->post('venue');
            $request_type = $this->input->post('request');
            $request_day = $this->input->post('date');
            $request_time = $this->input->post('time');

            // turn day/time into timestamp
            $request_datetime = $request_day." ".$request_time;
            date_default_timezone_set('Europe/London');
            $request_timestamp = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $request_datetime)));

            // get the posted officials's card id
            if($official_id != 0){
              foreach ($data['cards'] as $card) {
                foreach ($data['officials'] as $official) {
                  if( $official['Official_Id'] == $card['Official_Id']
                        && $card['Official_Id'] == $official_id ){
                    
                    // AUTHORISE/REJECT card's request
                    $request_not_past_card_expiry_date = $this->check_requestdate_before_expirydate(
                        $request_timestamp, $card['Expiry_Date']
                    );
                    $valid_card_status = $this->check_valid_card_status($card['Status_Id']);

                    // Check card has authorisation to venue's events
                    // loop through events for the venue id
                    $card_is_authorised = FALSE;

                    foreach($data['events'] as $event){
                      if ($event['Venue_Id'] == $venue_id){
                        // loop thorugh cardevents for the card id AND event id
                        foreach ($data['cardevents'] as $authorisation) {
                          if( $authorisation['Card_Id'] == $card['Card_Id']
                                && $authorisation['Event_Id'] == $event['Event_Id'] ){
                            $card_is_authorised = TRUE;
                          }
                        }
                      }
                    }

                    // Get official name
                    foreach ($data['venues'] as $venue){
                        if ($venue_id == $venue['Venue_Id']){
                            $venue_name = $venue['Venue_Name'];
                        }
                    }

                    //IF card not expired/cancelled and has relevent authorisation to venue's events, set authorisation to false 
                    if( $request_not_past_card_expiry_date && $valid_card_status && $card_is_authorised ){
                        $authorisation = 1;
                        $this->session->set_flashdata('user_success', 'Access to venue has been approved.');
                    } else {
                        $authorisation = 0;
                        $this->session->set_flashdata('user_failed', 'Access to venue has been denied.');
                    }

                    // Create request and enter authorisation
                    $this->request_model->new_request(
                        $card['Card_Id'],
                        $venue_id,
                        $request_type,
                        $request_timestamp,
                        $authorisation
                    );

                    redirect('requests');
                  }
                }
              }
            } else {
                redirect('officials/add');
            }
        }

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
        $this->form_validation->set_message('check_valid_date_format', "<p style='color:red;'>Please enter a valid date format.</p>");
        $date_array = $this->date_format($date);
        return checkdate(
            $date_array['month'],
            $date_array['day'],
            $date_array['year']
        );
    }

    public function time_format($time){
        $minute = (int) substr($time, 3, 2);
        $hour = (int) substr($time, 0, 2);
        return array(
            'hour' => $hour,
            'minute'  => $minute
        );
    }

    public function check_valid_time_format($time){
        $this->form_validation->set_message('check_valid_time_format', "<p style='color:red;'>Please enter a valid time format.</p>");
        $time_array = $this->time_format($time);
        if ($time_array['hour'] <= 23 && $time_array['minute'] <= 59){
            return TRUE;
        }
        return FALSE;
    }

    public function check_requestdate_before_expirydate($requestdate, $expirydate){
        //date_default_timezone_set('Europe/London');
        if (strtotime(str_replace('-', '/', $expirydate))
                > strtotime(str_replace('-', '/', $requestdate))){
            return TRUE;
        }
        return FALSE;
    }

    public function check_valid_card_status($status_id){
        if ($status_id == 1){
            return TRUE;
        }
        return FALSE;
    }
}