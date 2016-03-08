<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
    }
	
	public function index(){
		$this->form_validation->set_rules('username', 'Username', 'callback_username_check');		
		if ($this->form_validation->run() == FALSE){
			$data['homepage']=true;
            $data['content']=$this->load->view('login_view', $data, TRUE);
            $this->load->view('master_page', $data);
		}else{
			redirect(base_url());
		}
	}
	
	function username_check($str){
		$response = $this->login_model->checkuser( $this->input->post() );
		if ($response == 'registered'){
			return TRUE;
		}else{
			$this->form_validation->set_message('username_check', 'Invalid Login Details.');
			return FALSE;
		}
	}
}