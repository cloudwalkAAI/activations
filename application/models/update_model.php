<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Update_model extends CI_Model
{
    public function __construct() {
        parent::__construct ();

    }

//    transfered to custom_model
//    function update_info( $a ){
//
//        $data_update = array(
//            'role_type'     => $a['sel_role_u'],
//            'first_name'    => $a['inp_firstname_u'],
//            'middle_name'   => $a['inp_midname_u'],
//            'sur_name'      => $a['inp_lastname_u'],
//            'email'         => $a['inp_email_u'],
//            'birth_date'    => $a['datepicker_emp_u'],
//            'department'    => $a['sel_dept_u'],
//            'position'      => $a['sel_pos_u'],
//            'status'        => $a['sel_status_u']
//        );
//        $this->db->where('emp_id', $a['uid']);
//        $this->db->update('employee_list', $data_update);
//
//        if( $this->db->affected_rows() > 0 ){
//            return 1;
//        }else{
//            return 0;
//        }
//    }
//
//    function update_user_account( $a ){
//        $data = array(
//            'first_name'       => $a['prof_fname'],
//            'middle_name'         => $a['prof_mname'],
//            'sur_name'      => $a['prof_lname'],
//            'contact_nos'      => $a['ta_contact']
//        );
//
//        $this->db->where('emp_id', $this->session->userdata('sess_id'));
//        $this->db->update('employee_list', $data);
//
//        return $this->db->affected_rows();
//    }

//transfered to custom_model
//    function upd_client( $a ){
//        $data = array(
//            'company_name'      => $a['inp_companyname_u'],
//            'contact_person'    => $a['inp_contactperson_u'],
//            'contact_number'    => $a['inp_contactnumber_u'],
//            'birth_date'        => $a['inp_birthday_u'],
//            'email'             => $a['inp_email_u']
//        );
//
//        $this->db->where( 'client_id', $a['hid_client_id'] );
//        $this->db->update( 'clients', $data );
//
//        return $this->db->affected_rows();
//    }

    function upd_pass( $a ){

        $query = $this->db->get_where( 'employee_list', array( 'id' => $a['user_id'] ) );
        if ($query->num_rows() > 0) {
            $row = $query->row();
            if (isset($row)) {
                if( md5($row->email) == $a['user_code'] ){
                    $data = array(
                        'emp_pass' => md5( $a['npass'] )
                    );

                    $this->db->where( 'id', $a['user_id'] );
                    $this->db->update( 'employee_list', $data );
                    return 'Password Changed';
                }else{
                    return 'Invalid code!';
                }
            }
        }else{
            return 'not registered';
        }

    }

    function upd_pass_set( $a ){

        $query = $this->db->get_where( 'employee_list', array( 'id' => $a['user_id'] ) );
        if ($query->num_rows() > 0) {
            $row = $query->row();
            if (isset($row)) {
//                if( md5($row->email) == $a['user_code'] ){
                    $data = array(
                        'emp_pass' => md5( $a['npass'] )
                    );

                    $this->db->where( 'id', $a['user_id'] );
                    $this->db->update( 'employee_list', $data );
                    return 'Password Changed';
//                }else{
//                    return 'Invalid code!';
//                }
            }
        }else{
            return 'not registered';
        }

    }

    function upd_pass_prof( $a ){
        $data = array(
            'emp_pass' => md5( $a['npass'] )
        );

        $this->db->where( 'emp_id', $this->session->userdata( 'sess_id' ) );
        $this->db->update( 'employee_list', $data );

        if( $this->db->affected_rows() > 0 ){
            return 'changed';
        }else{
            return 'failed';
        }
    }
//transfered to custom_model
//    function update_profile( $a = null ){
//        if($a == null){
//            $data = array(
//                'img_loc' => $a
//            );
//            $this->db->where( 'emp_id', $this->session->userdata('sess_id') );
//            $this->db->update( 'employee_list', $data );
//        }
//    }
//
//    public function test(){
//        return 'test1';
//    }
}