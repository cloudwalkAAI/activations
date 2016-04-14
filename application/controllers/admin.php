<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('update_model');
        $this->load->model('get_model');
    }

    function upload_do(){
        $target_dir = "assets/uploads/do/";
        $target_file = $target_dir . basename($_FILES["do_file"]["name"]);

        $name_space = str_replace(" ", "_", $_FILES["do_file"]["tmp_name"]);
        echo $name_space;
//        move_uploaded_file($name_space, $target_file);
//
//        echo $this->update_model->upload_attachment( $this->input->post(), $target_file );
    }

//    function check_price(){
////        print_r( $this->input->post() );
//        echo $this->update_model->update_price( $this->input->post() );
//    }

    function del_do(){
        echo $this->update_model->del_do( $this->input->post() );
    }

    function del_bd(){
        echo $this->update_model->del_bd( $this->input->post() );
    }

    function del_ce(){
        echo $this->update_model->del_ce( $this->input->post() );
    }

    function del_paid(){
        echo $this->update_model->del_paid( $this->input->post() );
    }

    function upload_bill(){
        $target_dir = "assets/uploads/bill/";
        $target_file = $target_dir . basename($_FILES["bill_file"]["name"]);
        move_uploaded_file($_FILES["bill_file"]["tmp_name"], $target_file);

        echo $this->update_model->upload_attachment_bill( $this->input->post(), $target_file );
    }

    function upload_ce(){
        $target_dir = "assets/uploads/ce/";
        $target_file = $target_dir . basename($_FILES["ce_file"]["name"]);
        move_uploaded_file($_FILES["ce_file"]["tmp_name"], $target_file);

        echo $this->update_model->upload_attachment_ce( $this->input->post(), $target_file );
    }

    function upload_paid(){
        echo $this->update_model->upload_attachment_paid( $this->input->post() );
    }

    function remarks(){
        echo $this->update_model->update_price( $this->input->post() );
    }

    function transmittal(){
        echo $this->update_model->update_trans( $this->input->post() );
    }

    function cono(){
        echo $this->update_model->update_cono( $this->input->post() );
    }

    function payment(){
        echo $this->update_model->update_payment( $this->input->post() );
    }
}