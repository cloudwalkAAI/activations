<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
    public function __construct()
    {
        parent::__construct ();
        $this->load->model('insert_model');
        $this->load->model('custom_model');
        $this->load->model('get_model');
    }

//    function test_result(){
//        echo $this->update_model->test();
//    }

    function index()
    {
		$data['active_menu'] = 'settings';
		$data['active_submenu'] = null;
	   if( $this->session->userdata('sess_id') ){
            $data_profile['data_prof'] = $this->get_model->emp_info( $this->session->userdata('sess_id') );
            $data_profile['jo_counts'] = $this->get_model->emp_jo_count( $this->session->userdata('sess_id') );
            $data_profile['last_task'] = $this->get_model->emp_last_task_off( $this->session->userdata('sess_id') );
            $data_profile['current_task'] = $this->get_model->emp_last_task( $this->session->userdata('sess_id') );
            $data_profile['jolist'] = $this->get_model->get_ae_jo( $this->session->userdata('sess_id') );
            $data['navigator'] = $this->load->view('nav', $data, TRUE);
            $data['content'] = $this->load->view('profile_view', $data_profile, TRUE);
            $this->load->view('master_page', $data);
        }else{
            redirect( base_url() );
        }
    }

    function upload_img(){
        $target_dir = "assets/img/profile/";
        $target_file = $target_dir . basename($_FILES["upload_file"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["upload_file"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["upload_file"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
//            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["upload_file"]["tmp_name"], $target_file)) {
//                echo "The file ". basename( $_FILES["upload_file"]["name"]). " has been uploaded.";
                $this->custom_model->update_profile( $_FILES["upload_file"]["name"], $this->input->post('uid') );

                echo $target_dir.basename( $_FILES["upload_file"]["name"]);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

}