<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Summary extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('email_model');
        $this->load->model('insert_model');
        $this->load->model('get_model');
        $this->load->model('cal_model');
        $this->load->model('del_model');
        $this->load->model('custom_model');
        $this->load->helper('download');
        $this->load->library('m_pdf');
//        $this->load->library('pagination');
//        $this->load->library('table');
    }

    function index(){

        $data['active_menu'] = 'in';
        $data['active_submenu'] = 'jo';

        $data_a['jo_list'] = $this->get_model->get_ae_jo( 0 );
        $data['navigator'] = $this->load->view('nav', $data, TRUE);
        $data['content'] = $this->load->view('ae/joSummary', $data_a, TRUE);
        $this->load->view('master_page', $data);
    }

    function view(){
        $data['active_menu'] = 'jo';
        $data['active_submenu'] = null;
        if( $this->session->userdata('sess_id') ){
            $data_a['departments'] = $this->get_model->get_departments();
            $data_a['jo_details'] = $this->get_model->get_ae_jo_w( $this->input->get('jo') );
            $data_a['mom_dates'] = $this->get_model->get_mom_date_list( $this->input->get('jo') ); //date/*mmm*/
            $data_a['setup_dates'] = $this->get_model->get_setup_date_list( $this->input->get('jo') ); //date/*mmm*/
            $data_a['mvrf_dates'] = $this->get_model->get_mvrf_dates_list( $this->input->get('jo') ); //date
            $data_a['other_dates'] = $this->get_model->get_other_dates_list( $this->input->get('jo') ); //date
            $data_mom['mom_details'] = $this->get_model->get_last_mom( $this->input->get('jo') );
            $data_a['mom'] = $this->load->view('summary/mom', $data_mom, TRUE);
            $data_a['detail_dates'] = $this->get_model->get_detail_dates_list( $this->input->get('jo') ); //date
            $data_a['ed_details'] = $this->get_model->get_last_ed( $this->input->get('jo') );
            $data_a['eda_table'] = $this->get_model->get_ada_table( $this->input->get('jo') );
            $data_a['req_table'] = $this->get_model->RequireTableNoEdit( $this->input->get('jo') );
            $data_a['event_details'] = $this->load->view('summary/event_details', $data_a, TRUE);
            $data_a['emp_task'] = $this->load->view('summary/tasks', $data_a, TRUE);
            $data_project['attachment_list'] = $this->get_model->get_list_attachment( $this->input->get('jo') );
            $data_a['project_attachments'] = $this->load->view('summary/attachments', $data_project, TRUE);
            $data_setup['setup_details'] = $this->get_model->get_last_setup( $this->input->get('jo') );
            $data_a['setup_details'] = $this->load->view('summary/setup_details', $data_setup, TRUE);
            $data_mvrf['mvrf_details'] = $this->get_model->get_last_mvrf( $this->input->get('jo') );
            $data_a['mvrf_view'] = $this->load->view('mvrf_view', $data_mvrf, TRUE);
            $data_a['other_details'] = $this->get_model->get_last_other( $this->input->get('jo') );
//            $data_a['reference'] = $this->load->view('reference_view', NULL, TRUE);
            $data_a['comments'] = $this->load->view('comments_view', NULL, TRUE);
            $data['navigator'] = $this->load->view('nav', $data, TRUE);
            $data['content'] = $this->load->view('ae/jopreview', $data_a, TRUE);
            $this->load->view('master_page', $data);
        }else{
            redirect(base_url());
        }
    }
}