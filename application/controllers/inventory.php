<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('insert_model');
        $this->load->model('get_model');
        $this->load->model('custom_model');
    }

    function load_qty(){
        echo $this->get_model->load_qty( $this->input->post() );
    }

    function deduct_item(){
        $arr_data = array();
        $arr_data['ori_tbl'] = $this->custom_model->deduct_item( $this->input->post() );
        $arr_data['deduct_tbl'] = $this->insert_model->deduct_item( $this->input->post() );
        echo json_encode($arr_data);
    }

    function save_item(){
//        print_r( $this->input->post() );
        echo $this->insert_model->add_item_to_inventory( $this->input->post() );
    }

    function return_item(){
//        print_r( $this->input->post() );
        echo $this->insert_model->return_item_to_inventory( $this->input->post() );
    }

    function load_add_inv(){
        echo $this->get_model->load_added_inventory( $this->input->post('jo_id') );
    }

    function update_added_item(){
        echo $this->custom_model->update_added_item( $this->input->post() );
    }

    function cm_approval(){
        echo $this->custom_model->update_cm_approval( $this->input->post() );
    }

    function cm_release(){
        echo $this->custom_model->update_cm_release( $this->input->post() );
    }
}