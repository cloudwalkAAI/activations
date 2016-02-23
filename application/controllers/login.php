<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
    }

    function verification(){
        if($this->session->userdata('sess_id')){
            $this->validatelogin( '' );
        }else{
            $response = $this->login_model->checkuser( $this->input->post() );
            if($response == 'registered'){
                $this->validatelogin( '?inc=0' );
            }else{
                $this->validatelogin( '?inc=1' );
            }
        }
    }

    function validatelogin( $a ){
        redirect(base_url().$a);
    }
}