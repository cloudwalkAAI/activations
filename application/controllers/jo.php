<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jo extends CI_Controller{

    public function __construct() {
        parent::__construct ();
//        $this->load->model('login_model');
        $this->load->model('insert_model');
        $this->load->model('get_model');
        $this->load->helper('download');
        $this->load->library('m_pdf');
//        $this->load->library('pagination');
//        $this->load->library('table');
    }

    public function index(){
		$data['active_menu'] = 'in';
		$data['active_submenu'] = 'jo';
//        if( $this->session->userdata('sess_dept') == '2' ){
//            $arr = $this->get_model->get_ae_jo( $this->input->get('id') );
//        }else{
            $arr = $this->get_model->get_ae_jo();
//        }

        if( $this->session->userdata('sess_id') ){
//            if( $arr ){
                $data_a['jo_list'] = $arr;
                $data_a['project_type'] = $this->get_model->get_project_type();
                $data_a['client_list'] = $this->get_model->get_client_list();
                $data['navigator'] = $this->load->view('nav', $data, TRUE);
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

    function add_pt(){
        $res = $this->insert_model->insert_protype( $this->input->post('pt_added') );
        if( $res != 'fail' ){
            echo $this->get_model->get_project_type();
        }
    }

    function add_client(){
        return $insid = $this->insert_model->insert_client( json_encode($this->input->post()) );
//        echo $this->get_model->get_added_client( $insid );
    }

    function load_brand(){
        echo $this->get_model->get_brand_list( $this->input->post( 'cid' ) );
    }

    function add_jo(){
//        print_r($this->input->post());
//        return false;
        $insid = $this->insert_model->insert_jo( $this->input->post() );
        echo $this->get_model->get_ae_jo_w( $insid );
    }
	
	function get_jo(){
		$joid = $this->input->post('joid');
		$data["joData"] = $this->get_model->get_ae_jo_w( $joid );
		$this->load->view("joeditmodal",$data);
	}

    /*for loading a JO*/
    function in(){
		$data['active_menu'] = 'jo';
		$data['active_submenu'] = null;
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
            $data['navigator'] = $this->load->view('nav', $data, TRUE);
            $data['content'] = $this->load->view('ae/jo_in', $data_a, TRUE);
            $this->load->view('master_page', $data);
        }else{
            redirect(base_url());
        }
    }

    function pdf_data(){
        return $this->input->get('jid');
    }

    function mpdf_ajax(){

        if( $this->session->userdata('sess_id') ){
            $str_req = json_encode( $this->input->post( 'pdf_ex' ) );
            echo $url = base_url( 'jo/mpdf?a='.$this->input->post('jid').'&b='.$this->input->post('jno').'&c='.$str_req );
        }else{
            redirect(base_url());
        }
    }

    function mpdf(){
//        print_r( $result_mom );
        $array_c = json_decode( $this->input->get('c') );
        $i = 0;

        $mpdf=new mPDF();
        $mpdf->SetDefaultFont('montserratr');
        $mpdf->defaultfooterline=0;
        $mpdf->SetFooter('{PAGENO}');

        foreach( $array_c as $row ){
            $i++;
            if( $row == "mom" ){
                $data_mom['jo_details'] = $this->get_model->get_ae_jo_w( $this->input->get('a') );
                $data_mom['result_mom'] = $this->get_model->get_last_mom( $this->input->get('a') );
                $page_mom = $this->load->view('pdf/mom', $data_mom, TRUE);
                $mpdf->WriteHTML($page_mom);

                if( ( count($array_c) > 1 ) && count($array_c) != $i ){
                    $mpdf->AddPage(); //add new page
                }

            }elseif( $row == "ed" ){
                $data_ed['req_table'] = $this->get_model->get_req_table_v2( $this->input->get('a') );
                $data_ed['eda_table'] = $this->get_model->get_ada_table_no_info( $this->input->get('a') );
                $data_ed['result_ed'] = $this->get_model->get_last_ed( $this->input->get('a') );
                $page_ed = $this->load->view('pdf/ed', $data_ed, TRUE);
                $mpdf->WriteHTML($page_ed);

                if( ( count($array_c) > 1 ) && count($array_c) != $i ){
                    $mpdf->AddPage(); //add new page
                }
            }elseif( $row == "pjat" ){
                $data_ed['attachment_list'] = $this->get_model->get_list_attachment( $this->input->get('a') );
                $page_ed = $this->load->view('pdf/proj_attachments', $data_ed, TRUE);
                $mpdf->WriteHTML($page_ed);

                if( ( count($array_c) > 1 ) && count($array_c) != $i ){
                    $mpdf->AddPage(); //add new page
                }
            }elseif( $row == "setup" ){
                $data_ed['setup_details'] = $this->get_model->get_last_setup( $this->input->get('a') );
                $page_ed = $this->load->view('pdf/setup', $data_ed, TRUE);
                $mpdf->WriteHTML($page_ed);

                if( ( count($array_c) > 1 ) && count($array_c) != $i ){
                    $mpdf->AddPage(); //add new page
                }
            }elseif( $row == "mvrf" ){
                $data_ed['mvrf_details'] = $this->get_model->get_last_mvrf( $this->input->get('a') );
                $page_ed = $this->load->view('pdf/mvrf', $data_ed, TRUE);
                $mpdf->WriteHTML($page_ed);

                if( ( count($array_c) > 1 ) && count($array_c) != $i ){
                    $mpdf->AddPage(); //add new page
                }
            }elseif( $row == "other" ){
                $data_ed['other_details'] = $this->get_model->get_last_other( $this->input->get('a') );
                $page_ed = $this->load->view('pdf/others', $data_ed, TRUE);
                $mpdf->WriteHTML($page_ed);

                if( ( count($array_c) > 1 ) && count($array_c) != $i ){
                    $mpdf->AddPage(); //add new page
                }
            }
//            elseif( $row == "jo_details" ){
//                $data_ed['eda_table'] = $this->get_model->get_ada_table_no_info( $this->input->get('a') );
//                $data_ed['jo_details'] = $this->get_model->get_ae_jo_w( $this->input->get('a') );
//                $page_ed = $this->load->view('pdf/jo_details', $data_ed, TRUE);
//                $mpdf->WriteHTML($page_ed);
//
//                if( ( count($array_c) > 1 ) && count($array_c) != $i ){
//                    $mpdf->AddPage(); //add new page
//                }
//            }
        }

        $mpdf->Output('job_order_no_'.$this->input->get('b').'.pdf','I');
        exit();
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
		$data['active_menu'] = 'in';
		$data['active_submenu'] = 'production';
        $data['navigator'] = $this->load->view('nav', $data, TRUE);
        $data['content'] = $this->load->view('production', NULL, TRUE);
        $this->load->view('master_page', $data);
    }
    function mvrf(){
		$data['active_menu'] = 'in';
		$data['active_submenu'] = 'mvrf';
        $data['navigator'] = $this->load->view('nav', $data, TRUE);
        $data['content'] = $this->load->view('mvrf', NULL, TRUE);
        $this->load->view('master_page', $data);
    }
    function setup(){
		$data['active_menu'] = 'in';
		$data['active_submenu'] = 'setup';
        $data['navigator'] = $this->load->view('nav', $data, TRUE);
        $data['content'] = $this->load->view('Setup', NULL, TRUE);
        $this->load->view('master_page', $data);
    }
    function activations(){
		$data['active_menu'] = 'in';
		$data['active_submenu'] = 'activations';
        $data['navigator'] = $this->load->view('nav', $data, TRUE);
        $data['content'] = $this->load->view('Activations', NULL, TRUE);
        $this->load->view('master_page', $data);
    }
    function instore(){
		$data['active_menu'] = 'in';
		$data['active_submenu'] = 'instore';
        $data['navigator'] = $this->load->view('nav', $data, TRUE);
        $data['content'] = $this->load->view('instore', NULL, TRUE);
        $this->load->view('master_page', $data);
    }
    function motm(){
		$data['active_menu'] = 'ex';
		$data['active_submenu'] = 'motm';
        $data['navigator'] = $this->load->view('nav', $data, TRUE);
        $data['content'] = $this->load->view('motm', NULL, TRUE);
        $this->load->view('master_page', $data);
    }
    function bd(){
		$data['active_menu'] = 'ex';
		$data['active_submenu'] = 'bd';
        $data['navigator'] = $this->load->view('nav', $data, TRUE);
        $data['content'] = $this->load->view('bd', NULL, TRUE);
        $this->load->view('master_page', $data);
    }
    function ppld(){
		$data['active_menu'] = 'ex';
		$data['active_submenu'] = 'ppld';
        $data['navigator'] = $this->load->view('nav', $data, TRUE);
        $data['content'] = $this->load->view('ppld', NULL, TRUE);
        $this->load->view('master_page', $data);
    }
    function wrd(){
		$data['active_menu'] = 'ex';
		$data['active_submenu'] = 'wrd';
        $data['navigator'] = $this->load->view('nav', $data, TRUE);
        $data['content'] = $this->load->view('wrd', NULL, TRUE);
        $this->load->view('master_page', $data);
    }
    function iped(){
		$data['active_menu'] = 'ex';
		$data['active_submenu'] = 'iped';
        $data['navigator'] = $this->load->view('nav', $data, TRUE);
        $data['content'] = $this->load->view('iped', NULL, TRUE);
        $this->load->view('master_page', $data);
    }

    function fped(){
		$data['active_menu'] = 'ex';
		$data['active_submenu'] = 'fped';
        $data['navigator'] = $this->load->view('nav', $data, TRUE);
        $data['content'] = $this->load->view('fped', NULL, TRUE);
        $this->load->view('master_page', $data);
    }

    function accounts(){
		$data['active_menu'] = 'ex';
		$data['active_submenu'] = 'accounts';
        if( $this->session->userdata('sess_dept') == 2 ){
            $data['disabler'] = 'display:none;';
        }
        $data['jolist'] = $this->get_model->accounts_jo( $data['disabler'] );
        $data['navigator'] = $this->load->view('nav', $data, TRUE);
        $data['content'] = $this->load->view('admin/accounts', NULL, TRUE);
        $this->load->view('master_page', $data);
    }

    function clients(){
		$data['active_menu'] = 'clients';
		$data['active_submenu'] = 'clients';
        if( $this->session->userdata('sess_id') ) {
            $data_client['client_list'] = $this->get_model->get_load_client_list();
            $data['navigator'] = $this->load->view('nav', $data, TRUE);
            $data['content'] = $this->load->view('clients', $data_client, TRUE);
            $this->load->view('master_page', $data);
        }else{
            redirect(base_url());
        }
    }

    function references(){
		$data['active_menu'] = 'references';
		$data['active_submenu'] = null;
        $data['navigator'] = $this->load->view('nav', $data, TRUE);
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

    function submit_date_calendar(){
        $result = $this->get_model->check_date( $this->input->post( 'deadline' ) );
        if ($result == 'notTaken' ) {
            $res = $this->insert_model->creative_update_calendar( $this->input->post() );
            if( $res > 0 ){
                echo $this->get_model->getlastinsertdate( $res );
            }else{
                echo $result;
            }
        }else{
            echo $result;
        }
    }

    function search_ae(){
        $query = $this->db->get_where( 'employee_list', array( 'emp_id' => $this->input->post('aeid'), 'department' => 2 ), 1, 0 );
        if ($query->num_rows() > 0){
            foreach( $query->result() as $row ){
                echo $row->sur_name.', '.$row->first_name.' '.$row->middle_name;
            }
        }
    }

    function share_jo(){
        $share_explode = array();
        $query = $this->db->get_where( 'job_order_list', array( 'jo_number' => $this->input->post('share_joid') ) );
        if ($query->num_rows() > 0){
            foreach( $query->result() as $row ){
                if( $row->shared_to == null ){
                    $data = array(
                        'shared_to' => $this->input->post( 'inp_ae_id' )
                    );
                }else{
                    $share_explode = explode( ',', $row->shared_to );
                    array_push($share_explode, $this->input->post( 'inp_ae_id' ) );
                    $data = array(
                        'shared_to' => implode(',',$share_explode)
                    );
                }
                $this->db->where( 'jo_number', $this->input->post( 'share_joid' ) );
                $this->db->update( 'job_order_list', $data );

                if( $this->db->affected_rows() > 0 ) {
                    echo $this->db->affected_rows();
                }
            }
        }
    }

}