<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cal extends CI_Controller {

    function display($year = null, $month = null){
    $this->load->model('Cal_model');
    $data['calendar'] = $this->cal_model->generate($year, $month);

    $this->load->view('cal', $data);
}

}
