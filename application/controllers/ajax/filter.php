<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Filter extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('insert_model', 'put');
    }

    function save_locations()
    {
        echo $this->put->ins_ae_loc($this->input->post( ));
//        $inputAll = $this->input->post('dataPass');
//        print_r(json_decode($inputAll));
//        echo json_decode($inputAll);
    }

    function get_locations()
    {
        $result = $this->db->get('cmtuva_location_list')->result_array();

        echo json_encode($result);
    }

    function get_saved_locations($param) {
        $result = [];
        if($param) {
            $checkLocations = $this->db->get_where('cmtuva_ae_list',array('jo_id' => $param))->result_array();
            $location_ids = array_column($checkLocations, 'loc_id');
            if($location_ids)
            {
                $this->db->where_in('location_id', $location_ids);
                $this->db->select('*');
                $this->db->from('cmtuva_location_list');
                $this->db->join('cmtuva_ae_list', 'cmtuva_location_list.location_id = cmtuva_ae_list.loc_id');
                $result = $this->db->get()->result_array();
            } else {
                header("HTTP/1.1 404 Not Found");
                echo '404 MICINFO NOT FOUND :P';
                exit;
//                $result = $this->db->get('cmtuva_location_list')->result_array();
            }
        }

        echo json_encode($result);
    }

    function remove_location($id) {
        $this->db->delete('cmtuva_ae_list',array('cmae_id' => $id));
    }



}