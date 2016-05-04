<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('ChikkaSMS');

        /*email*/
        // The mail sending protocol.
        $config['protocol'] = 'smtp';
        // SMTP Server Address for Gmail.
        $config['smtp_host'] = 'mail.cloudwalkdigital.com';
        // SMTP Port - the port that you is required
        $config['smtp_port'] = 26;
        // SMTP Username like. (abc@gmail.com)
        $config['smtp_user'] = 'roel.r@cloudwalkdigital.com';
        // SMTP Password like (abc***##)
        $config['smtp_pass'] = 'Cloud2468';
        $config['mailtype'] = 'html';
        // Load email library and passing configured values to email library
        $this->load->library('email', $config);
    }

    function creatives_task_notification_email( $joid = null ){
        $str_name = '';
        $str_email = '';
        $int_number = 0;
        $str_jo_id = '';
        $str_jo_name = '';

        $query_manager = $this->db->get_where('employee_list', array('department' => 10, 'position' => 1 ));
        foreach($query_manager->result() as $row_manager){
            $str_email = $row_manager->email;
            $int_number = $row_manager->contact_nos;
            $str_name = $query_manager->sur_name.', '.$query_manager->first_name.' '.$query_manager->middle_name;
        }

        $query_jo = $this->db->get_where( 'job_order_list', array( 'jo_id' => $joid ) );
        foreach($query_jo->result() as $row_jo){
            $str_jo_id = $row_jo->jo_number;
            $str_jo_name = $row_jo->project_name;
        }

        // Sender email address
        $this->email->from( 'roel.r@cloudwalkdigital.com' );
        // Receiver email address.for single email
//        $this->email->to( $str_email, $str_name);
        $this->email->to( 'roelrosil1705@gmail.com', $str_name);
        // Subject of email
        $this->email->subject($str_jo_name.'-('.$str_jo_id.')');
        // Message in email
        $this->email->message($str_jo_name.'-('.$str_jo_id.') Creative task done.');
        // It returns boolean TRUE or FALSE based on success or failure
        $this->email->send();

//        echo $this->email->print_debugger();
    }
}