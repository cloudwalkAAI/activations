<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C extends CI_Controller{
    public function __construct() {
        parent::__construct ();
        $this->load->model('update_model');
        $this->load->model('get_model');
    }

    public function index(){
        $data_cp['cp'] = $this->input->get('p');
        $data_cp['iddata'] = $this->input->get('i');
        $data_cp['change_pass'] = $this->get_model->check_account( $this->input->get('p'), $this->input->get('i') );
        $data['navigator'] = '';
        $data['content'] = $this->load->view('change_password', $data_cp, TRUE);
        $this->load->view('master_page', $data);
    }

    function cpass(){
        if( $this->input->post( 'npass' ) == $this->input->post( 'repass' ) ){
            $result = $this->update_model->upd_pass( $this->input->post() );
            $data_cp['qresult'] = $result;
            $data['navigator'] = '';
            $data['content'] = $this->load->view( 'password_result', $data_cp, TRUE );
            $this->load->view('master_page', $data);
        }else{
            redirect( base_url().'c?p='.$this->input->post('user_code').'&i='.$this->input->post('user_id').'&inv=1' );
        }
    }

    function cpass_pv(){
//        npass = old password
//        repass = new password

        $res = $this->get_model->get_curp( $this->input->post( 'oldpass' ) );
        if( $res == 'r' ){
            if( $this->input->post( 'npass' ) == $this->input->post( 'repass' ) ){
                echo $result = $this->update_model->upd_pass_prof( $this->input->post() );
            }
        }else{
            echo 'pinc';
        }
    }

    function set_cpass(){
        $result = $this->update_model->upd_pass_set( $this->input->post() );
        echo $result;
    }
}