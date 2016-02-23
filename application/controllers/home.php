<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('calendar');
    }
    public function index()
    {
        if( $this->session->userdata('sess_id') && ( $this->session->userdata('sess_status') != 'resigned') ){
            $data['navigator'] = $this->load->view('nav', NULL, TRUE);
            $data['content'] = $this->load->view('ae/dashboard', NULL, TRUE);

            $this->load->view('master_page', $data);
        }else{
            $param_get = $this->input->get('inc');
            if( $param_get ){
                $data['param_get'] = $param_get;
            }else{
                $data['param_get'] = null;
            }

            $data['content']=$this->load->view('login_view', $data, TRUE);
            $this->load->view('master_page', $data);
        }
    }

    function logout(){
        $user_data = $this->session->all_userdata();

        foreach ($user_data as $key => $value) {
            $this->session->unset_userdata($key);
        }

        $this->index();
    }

}
