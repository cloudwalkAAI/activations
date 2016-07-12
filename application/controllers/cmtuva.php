<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cmtuva extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('insert_model');
        $this->load->model('get_model');
        $this->load->model('custom_model');
    }

    /*CMTUVA Dashboard*/
    function add_location(){
        if( $this->get_model->check_item( $this->input->post() ) <= 0){
            echo $this->insert_model->add_venue( $this->input->post() );
        }
    }
    function edit_cmtuva(){
        echo $this->get_model->get_cmtuva_info( $this->input->post('venue_id') );
    }

    function update_information(){
        echo $this->custom_model->update_cmtuva($this->input->post());
    }

    function del_cmtuva(){
        $this->db->delete('cmtuva_location_list', array('location_id' => $this->input->post('venue_id')));
        echo 'cmt_'.$this->input->post('venue_id');
    }
    /*CMTUVA End Dashboard*/

    /*AE CMTUVA*/

    function load_areas(){
        echo $this->get_model->get_areas( $this->input->post('venue_name') );
    }

    function load_rate(){
        echo $this->get_model->get_areas_rate( $this->input->post('venue_id') );
    }

    function add_ae_location(){
        echo $this->insert_model->ins_ae_loc($this->input->post());
    }

    function edit_cmae(){
        echo $this->get_model->get_cmae( $this->input->post('cmae_id') );
    }

    function del_cmae(){
        $this->db->delete('cmtuva_ae_list', array('cmae_id' => $this->input->post('venue_id')));
        echo 'cmae_'.$this->input->post('venue_id');
    }

    function update_cmae(){
//        print_r($this->input->post());
        echo $this->custom_model->update_cmae($this->input->post());
    }

    /*AE CMTUVA End*/
}