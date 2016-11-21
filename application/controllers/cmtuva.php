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
        $target_dir = '';
        $target_file = '';
        $name_space = '';

        if( $this->get_model->check_item( $this->input->post() ) <= 0){

            if (!empty($_FILES['inp_upload_cmtuva']['name'])) {

                $target_dir = "assets/uploads/cmtuva/";
                $target_file = $target_dir . basename($_FILES["inp_upload_cmtuva"]["name"]);

                $name_space = str_replace(" ", "_", $_FILES["inp_upload_cmtuva"]["tmp_name"]);

                move_uploaded_file($name_space, $target_file);
            }else{
                $target_file = null;
            }

            echo $this->insert_model->add_venue( $this->input->post(), $target_file );
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

    function ac_category(){
        $this->db->select('category');
        $this->db->from('cmtuva_location_list');
        $this->db->where("( category LIKE '%".$this->input->get('term')."%')");
        $this->db->group_by('category');
        $query = $this->db->get();
        foreach($query->result() as $row){
            $data[] = $row->category;
        }
        echo json_encode($data);
    }

    function AC_SubCategory(){
        $this->db->select('subcategory');
        $this->db->from('cmtuva_location_list');
        $this->db->where("( subcategory LIKE '%".$this->input->get('term')."%')");
        $this->db->group_by('subcategory');
        $query = $this->db->get();
        foreach($query->result() as $row){
            $data[] = $row->subcategory;
        }
        echo json_encode($data);
    }

    function AC_Area(){
        $this->db->select('area');
        $this->db->from('cmtuva_location_list');
        $this->db->where("( area LIKE '%".$this->input->get('term')."%')");
        $this->db->group_by('area');
        $query = $this->db->get();
        foreach($query->result() as $row){
            $data[] = $row->area;
        }
        echo json_encode($data);
    }

    function AC_SubArea(){
        $this->db->select('sub_Area');
        $this->db->from('cmtuva_location_list');
        $this->db->where("( sub_Area LIKE '%".$this->input->get('term')."%')");
        $this->db->group_by('sub_Area');
        $query = $this->db->get();
        foreach($query->result() as $row){
            $data[] = $row->sub_Area;
        }
        echo json_encode($data);
    }

    function AC_Venue(){
        $this->db->select('venue');
        $this->db->from('cmtuva_location_list');
        $this->db->where("( venue LIKE '%".$this->input->get('term')."%')");
        $this->db->group_by('venue');
        $query = $this->db->get();
        foreach($query->result() as $row){
            $data[] = $row->venue;
        }
        echo json_encode($data);
    }

    /*AE CMTUVA End*/
}