<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
//        $this->load->library('calendar');
        $this->load->model('cal_model');
    }
    public function index($year = null, $month = null)
    {
        if( $this->session->userdata('sess_id') && ( $this->session->userdata('sess_status') != 'resigned') ){
            if (!$year){
                $year = date('Y');
            }
            if (!$month){
                $month = date('M');
            }

            if ($day = $this->input->post('day')){
                $this->cal_model->add_calendar_data(
                    "$year-$month-$day",
                    $this->input->post('data')

                );
            }
			$data['active_menu'] = 'dashboard';
            $data['active_submenu'] = null;
            $data['calendar'] = $this->cal_model->generate($year, $month);
            $data['navigator'] = $this->load->view('nav', $data, TRUE);
            $data['content'] = $this->load->view('ae/dashboard', $data, TRUE);

            $this->load->view('master_page', $data);
        }else{
            $param_get = $this->input->get('inc');
            if( $param_get ){
                $data['param_get'] = $param_get;
            }else{
                $data['param_get'] = null;
            }

            $data['homepage']=true;
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
