<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emp extends CI_Controller{

    public function __construct() {
        parent::__construct ();
        $this->load->model('insert_model');
        $this->load->model('get_model');
        $this->load->model('custom_model');
        $this->load->library('pagination');
        $this->load->library('table');
    }

    public function index(){
		$data['active_menu'] = 'emp';
		$data['active_submenu'] = 'clients';
        if( $this->session->userdata('sess_id') ){
            $data_a['emp_list'] = $this->get_model->get_emp_list();
            $data_a['departments'] = $this->get_model->get_departments();
            $data_a['pos'] = $this->get_model->get_positions();
            $data['navigator'] = $this->load->view('nav', $data, TRUE);
            $data['content'] = $this->load->view('employee_view', $data_a, TRUE);
            $this->load->view('master_page', $data);
        }else{
            redirect( base_url() );
        }
    }
	
	public function addEmployee(){
		$data_a['active_menu'] = 'emp';
		$data_a['active_submenu'] = 'clients';
		$data_a['emp_list'] = $this->get_model->get_emp_list();
		$data_a['departments'] = $this->get_model->get_departments();
		$data_a['pos'] = $this->get_model->get_positions();
		$data['navigator'] = $this->load->view('nav', $data_a, TRUE);
		$data['content'] = $this->load->view('employee_edit', null, TRUE);
		$this->load->view('master_page', $data);	
	}
	
	function edit($eid=null){
		$data['active_menu'] = 'emp';
		$data['active_submenu'] = 'clients';
		if( $this->session->userdata('sess_id') ){
			if(!empty($eid)){
				$data['eid'] = $eid;
				$data_a['emp_list'] = $this->get_model->get_emp_list();
				$data_a['departments'] = $this->get_model->get_departments();
				$data_a['pos'] = $this->get_model->get_positions();
				$data['navigator'] = $this->load->view('nav', $data, TRUE);
				$data['content'] = $this->load->view('employee_edit', $data_a, TRUE);
				$this->load->view('master_page', $data);
			}else{
				redirect('emp');
			}
        }else{
            redirect( base_url() );
        }
	}

    function add_emp(){
        $insid = $this->insert_model->add_employee( $this->input->post() );
        if( $insid != 'exist' ){
            echo $this->get_model->get_employee_full_info( $insid );
        }else{
            echo 'exist';
        }

    }

    function emp_details(){
        echo $this->get_model->get_employee_info( $this->input->post('usersid') );
    }

    function update_details(){
        // print_r($this->input->post());
		$p = $this->custom_model->update_info( $this->input->post() );

        // if( $p == 1 ){
            // echo $this->get_model->get_emp_list_full();
        // }else{
            // return false;
        // }
    }

    function update_profile(){
        $this->custom_model->update_user_account( $this->input->post() );
        $load_profile = $this->get_model->emp_info( $this->session->userdata('sess_id') );
        echo $load_profile;
    }

    function load_client_info(){
        $client = $this->get_model->get_client_info( $this->input->post('setupid') );
        $cbrand = $this->get_model->get_client_brand( $this->input->post('setupid') );
        array_push($client, $cbrand);
        echo json_encode($client);
    }

    function update_client(){
        echo $this->custom_model->upd_client( $this->input->post() );
    }
}