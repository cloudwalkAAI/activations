<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jo extends CI_Controller{

    public function __construct() {
        parent::__construct ();
//        $this->load->model('login_model');
        $this->load->model('insert_model');
        $this->load->model('get_model');
        $this->load->helper('download');
//        $this->load->library('pagination');
//        $this->load->library('table');
    }

    public function index(){
        if( $this->session->userdata('sess_dept') == '2' ){
            $arr = $this->get_model->get_ae_jo( $this->input->get('id') );
        }else{
            $arr = $this->get_model->get_ae_jo();
        }

        if( $this->session->userdata('sess_id') ){
//            if( $arr ){
                $data_a['jo_list'] = $arr;
                $data_a['client_list'] = $this->get_model->get_client_list();
                $data['navigator'] = $this->load->view('nav', NULL, TRUE);
                $data['content'] = $this->load->view('ae/jo_list_view', $data_a, TRUE);
                $this->load->view('master_page', $data);
//            }else{
//                $data['navigator'] = $this->load->view('nav', NULL, TRUE);
//                $data['content'] = $this->load->view('invalid', NULL, TRUE);
//                $this->load->view('master_page', $data);
//            }
        }else{
            redirect(base_url());
        }
    }

    function add_client(){
        $insid = $this->insert_model->insert_client( $this->input->post() );
        echo $this->get_model->get_added_client( $insid );
    }

    function load_brand(){
        echo $this->get_model->get_brand_list( $this->input->post( 'cid' ) );
    }

    function add_jo(){
        $insid = $this->insert_model->insert_jo( $this->input->post() );
        echo $this->get_model->get_ae_jo_w( $insid );
    }

    /*for loading a JO*/
    function in(){
        if( $this->session->userdata('sess_id') ){
            $data_a['departments'] = $this->get_model->get_departments();
            $data_a['jo_details'] = $this->get_model->get_ae_jo_w( $this->input->get('a') );
            $data_a['mom_dates'] = $this->get_model->get_mom_date_list( $this->input->get('a') ); //date/*mmm*/
            $data_a['setup_dates'] = $this->get_model->get_setup_date_list( $this->input->get('a') ); //date/*mmm*/
            $data_a['mvrf_dates'] = $this->get_model->get_mvrf_dates_list( $this->input->get('a') ); //date
            $data_a['other_dates'] = $this->get_model->get_other_dates_list( $this->input->get('a') ); //date
            $data_mom['mom_details'] = $this->get_model->get_last_mom( $this->input->get('a') );
            $data_a['mom'] = $this->load->view('mom', $data_mom, TRUE);
            $data_a['detail_dates'] = $this->get_model->get_detail_dates_list( $this->input->get('a') ); //date
            $data_a['ed_details'] = $this->get_model->get_last_ed( $this->input->get('a') );
            $data_a['eda_table'] = $this->get_model->get_ada_table( $this->input->get('a') );
            $data_a['req_table'] = $this->get_model->get_req_table( $this->input->get('a') );
            $data_a['event_details'] = $this->load->view('event_details', $data_a, TRUE);
//            $data_task[''];
            $data_a['emp_task'] = $this->load->view('emp_tasks', $data_a, TRUE);
            $data_project['attachment_list'] = $this->get_model->get_list_attachment( $this->input->get('a') );
            $data_a['project_attachments'] = $this->load->view('project_attachments', $data_project, TRUE);
            $data_setup['setup_details'] = $this->get_model->get_last_setup( $this->input->get('a') );
            $data_a['setup_details'] = $this->load->view('setup_details', $data_setup, TRUE);
            $data_mvrf['mvrf_details'] = $this->get_model->get_last_mvrf( $this->input->get('a') );
            $data_a['mvrf_view'] = $this->load->view('mvrf_view', $data_mvrf, TRUE);
            $data_a['other_details'] = $this->get_model->get_last_other( $this->input->get('a') );
            $data_a['reference'] = $this->load->view('reference_view', NULL, TRUE);
            $data_a['comments'] = $this->load->view('comments_view', NULL, TRUE);
            $data['navigator'] = $this->load->view('nav', NULL, TRUE);
            $data['content'] = $this->load->view('ae/jo_in', $data_a, TRUE);
            $this->load->view('master_page', $data);
        }else{
            redirect(base_url());
        }
    }

    function jo_save(){
        if( $this->session->userdata('sess_id') ){
            echo $this->insert_model->save_mom( $this->input->post() );
        }
    }

    function jo_other(){
//        print_r($this->input->post());
        if( $this->session->userdata('sess_id') ){
            echo $this->insert_model->save_other( $this->input->post() );
        }
    }

    function jo_setup(){
//        print_r($this->input->post());
        if( $this->session->userdata('sess_id') ){
            echo $this->insert_model->save_setup( $this->input->post() );
        }
    }

    function jo_save_ed(){
//        print_r( $this->input->post() );
        if( $this->session->userdata('sess_id') ){
            echo $this->insert_model->save_ed( $this->input->post() );
        }
    }

    function jo_mvrf(){
//        print_r($this->input->post());
        if( $this->session->userdata('sess_id') ){
            echo $this->insert_model->save_mvrf( $this->input->post() );
        }
    }

    function gminutes(){
        if( $this->session->userdata('sess_id') ){
            echo $this->get_model->get_mimutes( $this->input->post( 'moid' ) );
        }
    }

    function edgminutes(){
        if( $this->session->userdata('sess_id') ){
            echo $this->get_model->get_mimutes_ed( $this->input->post( 'edid' ) );
        }
    }

    function setupgminutes(){
        if( $this->session->userdata('sess_id') ){
            echo $this->get_model->get_mimutes_setup( $this->input->post( 'setupid' ) );
        }
    }

    function mvrfminutes(){
        if( $this->session->userdata('sess_id') ){
            echo $this->get_model->get_mimutes_mvrf( $this->input->post( 'mvrfid' ) );
        }
    }

    function attached(){
        $target_dir = "assets/uploads/";
        $target_file = $target_dir . basename($_FILES["inp_file_attachments"]["name"]);
        move_uploaded_file($_FILES["inp_file_attachments"]["tmp_name"], $target_file);

        echo $this->insert_model->save_attachment( $this->input->post(), $target_file );
    }

    function production(){
        $data['navigator'] = $this->load->view('nav', NULL, TRUE);
        $data['content'] = $this->load->view('production', NULL, TRUE);
        $this->load->view('master_page', $data);
    }
    function mvrf(){
        $data['navigator'] = $this->load->view('nav', NULL, TRUE);
        $data['content'] = $this->load->view('mvrf', NULL, TRUE);
        $this->load->view('master_page', $data);
    }
    function setup(){
        $data['navigator'] = $this->load->view('nav', NULL, TRUE);
        $data['content'] = $this->load->view('Setup', NULL, TRUE);
        $this->load->view('master_page', $data);
    }
    function activations(){
        $data['navigator'] = $this->load->view('nav', NULL, TRUE);
        $data['content'] = $this->load->view('Activations', NULL, TRUE);
        $this->load->view('master_page', $data);
    }
    function instore(){
        $data['navigator'] = $this->load->view('nav', NULL, TRUE);
        $data['content'] = $this->load->view('instore', NULL, TRUE);
        $this->load->view('master_page', $data);
    }
    function motm(){
        $data['navigator'] = $this->load->view('nav', NULL, TRUE);
        $data['content'] = $this->load->view('motm', NULL, TRUE);
        $this->load->view('master_page', $data);
    }
    function bd(){
        $data['navigator'] = $this->load->view('nav', NULL, TRUE);
        $data['content'] = $this->load->view('bd', NULL, TRUE);
        $this->load->view('master_page', $data);
    }
    function ppld(){
        $data['navigator'] = $this->load->view('nav', NULL, TRUE);
        $data['content'] = $this->load->view('ppld', NULL, TRUE);
        $this->load->view('master_page', $data);
    }
    function wrd(){
        $data['navigator'] = $this->load->view('nav', NULL, TRUE);
        $data['content'] = $this->load->view('wrd', NULL, TRUE);
        $this->load->view('master_page', $data);
    }
    function iped(){
        $data['navigator'] = $this->load->view('nav', NULL, TRUE);
        $data['content'] = $this->load->view('iped', NULL, TRUE);
        $this->load->view('master_page', $data);
    }
    function fped(){
        $data['navigator'] = $this->load->view('nav', NULL, TRUE);
        $data['content'] = $this->load->view('fped', NULL, TRUE);
        $this->load->view('master_page', $data);
    }
    function clients(){
        if( $this->session->userdata('sess_id') ) {
            $data_client['client_list'] = $this->get_model->get_load_client_list();
            $data['navigator'] = $this->load->view('nav', NULL, TRUE);
            $data['content'] = $this->load->view('clients', $data_client, TRUE);
            $this->load->view('master_page', $data);
        }else{
            redirect(base_url());
        }
    }

    function references(){

        $data['navigator'] = $this->load->view('nav', NULL, TRUE);
        $data['content'] = $this->load->view('references', NULL, TRUE);
        $this->load->view('master_page', $data);
    }
    //Templates
    function tmplbid(){
        $data = file_get_contents("assets/materials/aai_bid.jpg"); // Read the file's contents
        $name = 'aai_bid.jpg';
        force_download($name, $data);
    }
    function tmplfpe(){
        $data = file_get_contents("assets/materials/final_post_evaluation.jpg"); // Read the file's contents
        $name = 'final_post_evaluation.jpg';
        force_download($name, $data);
    }
    function tmplweeklyreport(){
        $data = file_get_contents("assets/materials/weekly_report.jpg"); // Read the file's contents
        $name = 'weekly_report.jpg';
        force_download($name, $data);
    }
    function tmplpreprod(){
        $data = file_get_contents("assets/materials/preprod.jpg"); // Read the file's contents
        $name = 'preprod.jpg';
        force_download($name, $data);
    }

    //References
    function refproduction(){
        $data = file_get_contents("assets/materials/samples/MaterialandProductionChecklist.xls"); // Read the file's contents
        $name = 'MaterialandProductionChecklist.xls';
        force_download($name, $data);
    }
    function refmrf(){
        $data = file_get_contents("assets/materials/samples/MRF.doc"); // Read the file's contents
        $name = 'MRF.doc';
        force_download($name, $data);
    }

    function jo_save_ed_details(){
        if( $this->session->userdata('sess_id') ) {
            echo $this->insert_model->save_ed_animation( $this->input->post() );
        }
    }

    function reload_ada_table(){
        echo $this->get_model->get_ada_table( $this->input->post() );
    }

    function jo_save_req(){
        if( $this->session->userdata('sess_id') ) {
            echo $this->insert_model->save_ed_req( $this->input->post() );
        }
    }

    function reload_req_table(){
        echo $this->get_model->get_req_table( $this->input->post() );
    }
}