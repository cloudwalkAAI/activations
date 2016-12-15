<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Filter extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    function get_locations()
    {
        $result = $this->db->get('cmtuva_location_list');

        echo json_encode($result->result_array());
    }

    function get_categories()
    {
        $term = $this->input->get('term');
        $this->db->distinct('category');
        $this->db->select('category');
        $this->db->where('category !=', '');
        $this->db->like('category', $term);
        $queryCateg = $this->db->get('cmtuva_location_list');
        $resultCateg = $queryCateg->result_array();

        echo json_encode($resultCateg);
    }

    function get_subCategories()
    {
        $category = $this->input->get('category');
        $term = $this->input->get('term');
        $this->db->distinct('subcategory');
        $this->db->select('subcategory');
        if($category) $this->db->where('category' , $category);
        $this->db->where('subcategory !=', '');
        $this->db->like('subcategory', $term);
        $queryCateg = $this->db->get('cmtuva_location_list');
        $resultCateg = $queryCateg->result_array();

        echo json_encode($resultCateg);
    }



}