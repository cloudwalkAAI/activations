<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('update_model');
        $this->load->model('get_model');
    }

    function ckeditor_upload(){
        if (file_exists("images/" . $_FILES["upload"]["name"]))
        {
            echo $_FILES["upload"]["name"] . " already exists. ";
        }
        else
        {
            move_uploaded_file($_FILES["upload"]["tmp_name"],
                "assets/uploads/ckimages/" . $_FILES["upload"]["name"]);
            echo "Stored in: " . "images/" . $_FILES["upload"]["name"];

// Required: anonymous function reference number as explained above.
            $funcNum = $_GET['CKEditorFuncNum'] ;
// Optional: instance name (might be used to load a specific configuration file or anything else).
            $CKEditor = $_GET['CKEditor'] ;
// Optional: might be used to provide localized messages.
            $langCode = $_GET['langCode'] ;

// Check the $_FILES array and save the file. Assign the correct path to a variable ($url).
            $url = base_url("assets/uploads/ckimages"). '/' . $_FILES["upload"]["name"];
// Usually you will only assign something here if the file could not be uploaded.
            $message = '';

            echo "<script type='text/javascript'> window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
        }
    }
}